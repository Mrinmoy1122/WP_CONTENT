<?php
/**
 * Validation for Trainer Availability & Unavailability
 */

add_action('acf/validate_save_post', function () {
    $post_type = get_post_type();

    // --- VALIDATE AVAILABILITY ---
    if ($post_type === 'trainer_availability') {
        $trainer_id = $_POST['acf']['field_av_trainer'] ?? null;
        $days = $_POST['acf']['field_av_days'] ?? [];

        if ($trainer_id && !empty($days)) {
            // Collect selected days in current form
            $current_days = [];
            foreach ($days as $d) {
                $day_name = $d['field_av_day_name'] ?? '';
                if (in_array($day_name, $current_days)) {
                    acf_add_validation_error('field_av_days', 'Duplicate day found in this availability entry.');
                }
                $current_days[] = $day_name;
            }

            // Check if trainer already has these days assigned in other posts
            $existing = new WP_Query([
                'post_type' => 'trainer_availability',
                'post_status' => 'any',
                'meta_query' => [
                    ['key' => 'trainer', 'value' => $trainer_id],
                ],
                'post__not_in' => [get_the_ID()],
            ]);

            if ($existing->have_posts()) {
                while ($existing->have_posts()) {
                    $existing->the_post();
                    $saved_days = get_field('days');
                    if ($saved_days) {
                        foreach ($saved_days as $sd) {
                            if (in_array($sd['day_name'], $current_days)) {
                                acf_add_validation_error('field_av_days', 'This trainer already has availability for one or more of these days.');
                            }
                        }
                    }
                }
                wp_reset_postdata();
            }
        }
    }

    // --- VALIDATE UNAVAILABILITY ---
    if ($post_type === 'trainer_unavailability') {
        $trainer_id = $_POST['acf']['field_unav_trainer'] ?? null;
        $date = $_POST['acf']['field_unav_date'] ?? null;

        if ($trainer_id && $date) {
            $existing = new WP_Query([
                'post_type' => 'trainer_unavailability',
                'post_status' => 'any',
                'meta_query' => [
                    ['key' => 'trainer', 'value' => $trainer_id],
                    ['key' => 'date', 'value' => $date],
                ],
                'post__not_in' => [get_the_ID()],
            ]);

            if ($existing->found_posts > 0) {
                acf_add_validation_error('field_unav_date', 'This trainer already has an unavailability set for that date.');
            }
        }
    }
});
