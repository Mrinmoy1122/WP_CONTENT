<?php
/**
 * Plugin Name: Trainer Custom Functions
 * Description: Custom functionality for Trainer CPT (Availability, Unavailability, ACF tweaks)
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

// Define constants
define('TRAINER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TRAINER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include core CPTs
require_once TRAINER_PLUGIN_PATH . 'includes/trainer-cpt.php';
require_once TRAINER_PLUGIN_PATH . 'includes/trainer-availability.php';
require_once TRAINER_PLUGIN_PATH . 'includes/trainer-unavailability.php';

// Include helper functions
require_once TRAINER_PLUGIN_PATH . 'includes/helpers/general.php';

// Include ACF customizations
require_once TRAINER_PLUGIN_PATH . 'includes/acf/acf-customizations.php';
require_once TRAINER_PLUGIN_PATH . 'includes/acf/acf-availability-fields.php';
require_once TRAINER_PLUGIN_PATH . 'includes/acf/acf-unavailability-fields.php';

// Admin functions
require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-metaboxes.php';
require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-email.php';
require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-validation.php';
// require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-availability-metabox-ui.php';
require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-availability-save.php';


