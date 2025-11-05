<?php
// Register Availability CPT
add_action('init', function () {
    register_post_type('trainer_availability', [
        'label' => 'Availability',
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=trainer',
        'supports' => ['title'],
        'menu_position' => 6,
    ]);
});

// Only load meta box code in admin
if (is_admin()) {
    // Include the meta box UI file where the function is defined
    require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-availability-metabox-ui.php';

    // Add the meta box
    add_action('add_meta_boxes', function () {
        add_meta_box(
            'trainer_availability_box',
            'Trainer Availability',
            'render_trainer_availability_metabox',
            'trainer_availability',
            'normal',
            'default'
        );
    });
}

// Include the save handler
require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-availability-save.php';
add_action('save_post_trainer_availability', 'save_trainer_availability_data');
