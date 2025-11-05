<?php
if (!defined('ABSPATH')) exit;

function tam_get_trainers() {
    global $wpdb;
    return $wpdb->get_results("SELECT id, name FROM {$wpdb->prefix}trainers");
}

function tam_get_days_of_week() {
    return ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
}
