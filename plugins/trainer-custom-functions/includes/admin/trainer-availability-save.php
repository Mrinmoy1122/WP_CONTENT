<?php
function save_trainer_availability_data($post_id) {
    // Verify nonce
    if (!isset($_POST['trainer_availability_nonce']) || 
        !wp_verify_nonce($_POST['trainer_availability_nonce'], 'save_trainer_availability')) {
        return;
    }

    // Save Trainer ID
    $trainer_id = sanitize_text_field($_POST['trainer_id'] ?? '');
    update_post_meta($post_id, 'trainer_id', $trainer_id);

    // Save availability days & slots
    $availability = $_POST['availability'] ?? [];
    update_post_meta($post_id, 'trainer_availability', $availability);

    // Auto-generate a post title: "Trainer Name – First Day"
    if ($trainer_id) {
        $trainer_name = get_the_title($trainer_id);
        $first_day = $availability[0]['day'] ?? '';
        $post_title = $trainer_name . ($first_day ? " – $first_day" : "");

        // Update post title and slug
        wp_update_post([
            'ID' => $post_id,
            'post_title' => $post_title,
            'post_name' => sanitize_title($post_title),
        ]);
    }
}
add_action('save_post_trainer_availability', 'save_trainer_availability_data');

