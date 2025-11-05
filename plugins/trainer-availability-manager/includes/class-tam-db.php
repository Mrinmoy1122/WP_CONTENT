<?php
if (!defined('ABSPATH')) exit;

class TAM_DB {

    public function __construct() {
        register_activation_hook(__FILE__, [$this, 'create_tables']);
    }

    public function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $availability_table = $wpdb->prefix . 'trainer_availability';
        $non_availability_table = $wpdb->prefix . 'trainer_non_availability';

        $sql = "
        CREATE TABLE IF NOT EXISTS $availability_table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            trainer_id INT NOT NULL,
            day_of_week VARCHAR(10) NOT NULL,
            from_time TIME NOT NULL,
            to_time TIME NOT NULL
        ) $charset_collate;

        CREATE TABLE IF NOT EXISTS $non_availability_table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            trainer_id INT NOT NULL,
            date DATE NOT NULL,
            is_full_day TINYINT(1) DEFAULT 0,
            unavailable_slots TEXT NULL
        ) $charset_collate;
        ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
