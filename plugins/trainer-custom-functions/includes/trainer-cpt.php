<?php
// Register Trainer CPT
add_action('init', function () {
    register_post_type('trainer', [
        'label' => 'Trainers',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => ['title'],
        'menu_position' => 5,
    ]);
});

// Register Location CPT
add_action('init', function () {
    register_post_type('location', [
        'label' => 'Locations',
        'public' => true,
        'show_ui' => true,
        'supports' => ['title'],
    ]);
});
