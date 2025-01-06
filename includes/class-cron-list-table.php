<?php

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Cron_List_Table extends WP_List_Table {

    public function __construct() {
        parent::__construct(array(
            'singular' => 'cron_job',
            'plural'   => 'cron_jobs',
            'ajax'     => false
        ));
    }

    /**
     * Prepare the items for display
     */
    public function prepare_items() {
        $this->_column_headers = array(
            $this->get_columns(),
            array(),
            $this->get_sortable_columns()
        );

        $this->process_bulk_action();
        $this->items = $this->get_cron_jobs();
    }

    /**
     * Define the columns for the table
     */
    public function get_columns() {
        return array(
            'cb'         => '<input type="checkbox" />',
            'hook'       => __('Hook', 'cron-zombies'),
            'next_run'   => __('Next Run (UTC)', 'cron-zombies'),
            'recurrence' => __('Recurrence', 'cron-zombies'),
            'actions'    => __('Actions', 'cron-zombies')
        );
    }

    /**
     * Set sortable columns
     */
    public function get_sortable_columns() {
        return array(
            'hook'     => array('hook', false),
            'next_run' => array('next_run', false)
        );
    }

    /**
     * Get bulk actions for the table
     */
    protected function get_bulk_actions() {
        return array(
            'delete' => __('Delete Selected', 'cron-zombies')
        );
    }

    /**
     * Bulk action processing
     */
    protected function process_bulk_action() {
        if ('delete' === $this->current_action() && !empty($_POST['cron'])) {
            check_admin_referer('bulk-cron-action', '_cron_nonce');

            foreach ($_POST['cron'] as $cron_hook) {
                list($hook, $timestamp) = explode('|', $cron_hook);
                wp_unschedule_event($timestamp, $hook);
            }
            
            echo '<div class="updated notice"><p>' . __('Selected cron jobs deleted.', 'cron-zombies') . '</p></div>';
        }
    }

    /**
     * Fetch cron jobs
     */
    private function get_cron_jobs() {
        $cron_jobs = _get_cron_array();
        $output = array();

        foreach ($cron_jobs as $timestamp => $crons) {
            foreach ($crons as $hook => $details) {
                foreach ($details as $event) {
                    $output[] = array(
                        'hook'       => $hook,
                        'next_run'   => date('Y-m-d H:i:s', $timestamp),
                        'recurrence' => isset($event['schedule']) ? $event['schedule'] : __('One-time', 'cron-zombies'),
                        'timestamp'  => $timestamp
                    );
                }
            }
        }

        return $output;
    }

    /**
     * Checkbox column for bulk selection
     */
    protected function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="cron[]" value="%1$s|%2$s" />',
            esc_attr($item['hook']),
            esc_attr($item['timestamp'])
        );
    }

    /**
     * Actions column (Delete and Run Now)
     */
	public function column_actions($item) {
		$action_nonce = wp_create_nonce('cron_action_nonce');
	
		return sprintf(
			'<form method="post" style="display:inline;">
				<input type="hidden" name="cron_hook" value="%1$s">
				<input type="hidden" name="cron_timestamp" value="%2$d">
				<input type="hidden" name="_wpnonce" value="%3$s">
				<button type="submit" name="delete_cron" class="button button-small">%4$s</button>
				<button type="submit" name="run_cron" class="button button-small run-cron">%5$s</button>
			</form>',
			esc_attr($item['hook']),
			esc_attr($item['timestamp']),
			esc_attr($action_nonce),
			__('Delete', 'cron-zombies'),
			__('Run Now', 'cron-zombies')
		);
	}
	
    /**
     * Display default column content
     */
    public function column_default($item, $column_name) {
        return $item[$column_name];
    }
}
