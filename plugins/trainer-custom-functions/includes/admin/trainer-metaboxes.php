<?php
// Hide unwanted meta boxes for trainer CPT
add_action('add_meta_boxes', function() {
    $screen = get_current_screen();
    if ($screen->post_type !== 'trainer') return;

    $remove_boxes = [
        'postexcerpt', 'trackbacksdiv', 'commentstatusdiv',
        'slugdiv', 'authordiv', 'commentsdiv'
    ];
    foreach ($remove_boxes as $box) {
        remove_meta_box($box, 'trainer', 'normal');
    }
}, 20);

// Add custom column for trainer email
add_filter('manage_trainer_posts_columns', function ($columns) {
    $columns['trainer_email'] = 'Email';
    return $columns;
});

add_action('manage_trainer_posts_custom_column', function ($column, $post_id) {
    if ($column === 'trainer_email') {
        echo esc_html(get_field('email', $post_id));
    }
}, 10, 2);
