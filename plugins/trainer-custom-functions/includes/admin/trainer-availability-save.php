<?php
function save_trainer_availability_data($post_id) {
    if (!isset($_POST['trainer_availability_nonce']) || 
        !wp_verify_nonce($_POST['trainer_availability_nonce'], 'save_trainer_availability')) {
        return;
    }

    // Save Trainer ID
    update_post_meta($post_id, 'trainer_id', sanitize_text_field($_POST['trainer_id']));

    // Save availability days & slots
    $availability = [];

    if (!empty($_POST['availability'])) {
        foreach ($_POST['availability'] as $dayData) {
            $day = sanitize_text_field($dayData['day']);
            if (!$day) continue;

            $slots = [];
            if (!empty($dayData['slots'])) {
                foreach ($dayData['slots'] as $slot) {
                    $slots[] = [
                        'from' => sanitize_text_field($slot['from']),
                        'to' => sanitize_text_field($slot['to']),
                    ];
                }
            }

            $availability[] = ['day' => $day, 'slots' => $slots];
        }
    }

    update_post_meta($post_id, 'trainer_availability', $availability);
}
