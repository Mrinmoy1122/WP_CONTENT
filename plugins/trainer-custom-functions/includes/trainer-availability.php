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

// Load admin files only in admin area
if (is_admin()) {

    // Include meta box UI
    require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-availability-metabox-ui.php';

    // Add meta box
    add_action('add_meta_boxes', function () {
        add_meta_box(
            'trainer_availability_box',
            'Trainer Availability',
            'render_trainer_availability_metabox', // function now exists
            'trainer_availability',
            'normal',
            'default'
        );
    });

    // Include save handler
    require_once TRAINER_PLUGIN_PATH . 'includes/admin/trainer-availability-save.php';
    add_action('save_post_trainer_availability', 'save_trainer_availability_data');
}
