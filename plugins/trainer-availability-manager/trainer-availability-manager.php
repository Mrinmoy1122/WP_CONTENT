<?php
/**
 * Plugin Name: Trainer Availability
 * Description: Manage trainers’  availability and non-availability (exceptions).
 * Version: 1.0
 * Author: Mrinmoy
 */

if (!defined('ABSPATH')) exit;

// Include core classes
require_once plugin_dir_path(__FILE__) . 'includes/class-tam-db.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-tam-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Activation hook to create DB table
// register_activation_hook(__FILE__, ['TM_Trainer', 'create_table']);


// Initialize Admin
add_action('plugins_loaded', function() {
    new TAM_DB();
    new TAM_Admin();
});

// if (is_admin()) {
//     $tm_admin = new TM_Admin();
// }