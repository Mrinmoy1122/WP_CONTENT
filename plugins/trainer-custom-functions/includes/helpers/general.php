<?php
// Helper functions used across plugin

function trainer_log($data) {
    if (WP_DEBUG) {
        error_log(print_r($data, true));
    }
}
