<?php
/**
 * Plugin Name: Cron Zombies
 * Description: Manage, delete, and run WordPress cron jobs. Includes bulk delete and health checks.
 * Version: 1.0.0
 * Author: Noah Stewart
 * Text Domain: cron-zombies
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
require_once plugin_dir_path(__FILE__) . 'includes/class-cron-list-table.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-cron-manager.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-cron-zombies-admin.php';

// Initialize plugin
add_action('plugins_loaded', function () {
    Cron_Zombies_Admin::init();
});
