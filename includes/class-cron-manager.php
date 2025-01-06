<?php

if (!defined('ABSPATH')) {
    exit;
}

class Cron_Manager {
    /**
     * Run a cron job immediately
     */
	public static function run_cron($hook, $timestamp) {
		if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'cron_action_nonce')) {
			wp_die(__('Security check failed.', 'cron-zombies'));
		}
	
		$cron_jobs = _get_cron_array();
	
		if (isset($cron_jobs[$timestamp][$hook])) {
			do_action($hook);
			echo '<div class="updated notice"><p>' . esc_html__('Cron job executed successfully.', 'cron-zombies') . '</p></div>';
		} else {
			echo '<div class="error notice"><p>' . esc_html__('Cron job not found.', 'cron-zombies') . '</p></div>';
		}
	}

	/**
	 * Delete a cron job
	 */
	public static function delete_cron($hook, $timestamp) {
		if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'cron_action_nonce')) {
			wp_die(__('Security check failed.', 'cron-zombies'));
		}
	
		if (wp_unschedule_event($timestamp, $hook)) {
			echo '<div class="updated notice"><p>' . esc_html__('Cron job deleted.', 'cron-zombies') . '</p></div>';
		} else {
			echo '<div class="error notice"><p>' . esc_html__('Failed to delete cron job.', 'cron-zombies') . '</p></div>';
		}
	}	
}
