<?php
// Send email when a new Trainer is published
add_action('wp_insert_post', function ($post_id, $post, $update) {
    if ($post->post_type !== 'trainer' || $update) return;

    $trainer_email = get_field('email', $post_id);
    if (empty($trainer_email) || !is_email($trainer_email)) return;

    $trainer_name = get_the_title($post_id);

    $subject = "Welcome, {$trainer_name}!";
    $message = "Hi {$trainer_name},\n\nYour trainer profile has been created successfully.\n\nBest,\n" . get_bloginfo('name');

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <no-reply@' . $_SERVER['SERVER_NAME'] . '>'
    ];

    wp_mail($trainer_email, $subject, $message, $headers);
}, 10, 3);
