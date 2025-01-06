<?php

if (!defined('ABSPATH')) {
    exit;
}

class Cron_Zombies_Admin {

    const CAPABILITY = 'manage_cron_zombies';
    const MENU_SLUG  = 'cron-zombies';

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_admin_menu']);
        add_action('admin_init', [__CLASS__, 'add_capabilities']);
		add_action('admin_init', [__CLASS__, 'handle_actions']);
    }

    /**
     * Add Cron Zombies to the Tools menu
     */
    public static function add_admin_menu() {
        add_management_page(
            __('Cron Zombies', 'cron-zombies'),
            __('Cron Zombies', 'cron-zombies'),
            self::CAPABILITY,
            self::MENU_SLUG,
            [__CLASS__, 'render_page']
        );
    }

    /**
     * Grant the manage_cron_zombies capability to admins
     */
    public static function add_capabilities() {
        $role = get_role('administrator');
        if ($role && !$role->has_cap(self::CAPABILITY)) {
            $role->add_cap(self::CAPABILITY);
        }
    }

	/**
	 * Handle actions from the buttons
	 */
	public static function handle_actions() {
		if (!isset($_POST['cron_hook']) || !isset($_POST['cron_timestamp'])) {
			return;
		}
	
		$hook = sanitize_text_field($_POST['cron_hook']);
		$timestamp = intval($_POST['cron_timestamp']);
	
		if (isset($_POST['delete_cron'])) {
			Cron_Manager::delete_cron($hook, $timestamp);
		}
	
		if (isset($_POST['run_cron'])) {
			Cron_Manager::run_cron($hook, $timestamp);
		}
	}
	
    /**
     * Render the admin page
     */
    public static function render_page() {
        if (!current_user_can(self::CAPABILITY)) {
            wp_die(__('You do not have permission to access this page.', 'cron-zombies'));
        }

        if (!class_exists('Cron_List_Table')) {
            require_once plugin_dir_path(__FILE__) . 'class-cron-list-table.php';
        }

        $cron_table = new Cron_List_Table();
        $cron_table->prepare_items();

        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Cron Zombies', 'cron-zombies'); ?></h1>
            <p><?php esc_html_e('Manage, delete, and run WordPress cron jobs.', 'cron-zombies'); ?></p>
            <form method="post">
                <?php
                $cron_table->display();
                wp_nonce_field('bulk-cron-action', '_cron_nonce');
                ?>
            </form>
        </div>
        <?php
    }
}
