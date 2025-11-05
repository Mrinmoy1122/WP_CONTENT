<?php
// Hide 'Uncategorized' from Trainer ACF taxonomy field
add_filter('acf/prepare_field', function ($field) {
    if (get_post_type() !== 'trainer') return $field;
    if (!isset($field['taxonomy']) || $field['taxonomy'] !== 'product_cat') return $field;

    if (isset($field['choices']) && is_array($field['choices'])) {
        foreach ($field['choices'] as $term_id => $term_name) {
            if (strtolower($term_name) === 'uncategorized') {
                unset($field['choices'][$term_id]);
            }
        }
    }

    return $field;
});
