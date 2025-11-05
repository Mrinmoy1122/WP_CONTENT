<?php
if (!defined('ABSPATH')) exit;

class TAM_Admin
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function register_admin_menu()
    {
        add_menu_page(
            'Trainer Availability',
            'Trainer Availability',
            'manage_options',
            'tam_availability',
            [$this, 'render_availability_page'],
            'dashicons-calendar-alt',
            6
        );

        add_submenu_page(
            'tam_availability',
            'All Availabilities',
            'All Availabilities',
            'manage_options',
            'tam_availability_list',
            [$this, 'render_availability_list_page']
        );

        add_submenu_page(
            'tam_availability',
            'Non-Availability',
            'Non-Availability',
            'manage_options',
            'tam_non_availability',
            [$this, 'render_non_availability_page']
        );
        add_submenu_page(
            null,
            'Edit Availability',
            '',
            'manage_options',
            'tm_edit_availability',
            [$this, 'render_edit_availability_page']
        );
    }


    public function enqueue_assets($hook)
    {
        if (strpos($hook, 'tam_') === false) return;
        wp_enqueue_style('tam-admin-css', plugin_dir_url(__FILE__) . '../assets/css/admin.css');
        wp_enqueue_script('tam-admin-js', plugin_dir_url(__FILE__) . '../assets/js/admin.js', ['jquery'], false, true);
    }

    public function render_availability_page()
    {
        // When the admin submits the form
        if (!empty($_POST['tam_action']) && $_POST['tam_action'] === 'save_availability') {
            $this->handle_save_availability();
        }

        include plugin_dir_path(__FILE__) . '../templates/admin/manage-availability.php';
    }


    public function render_non_availability_page()
    {
        $trainers = tam_get_trainers();

        include plugin_dir_path(__FILE__) . '../templates/admin/manage-non-availability.php';
    }

    public function render_availability_list_page()
    {
        $availabilities = TM_Availability::get_all_grouped();
        include plugin_dir_path(__FILE__) . '../templates/admin/availability-list.php';
    }

    public function render_edit_availability_page()
    {
        $trainer_id = intval($_GET['trainer_id'] ?? 0);
        if (!$trainer_id) {
            wp_die('Invalid trainer ID.');
        }

        global $wpdb;
        $trainer = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}tm_trainers WHERE id = $trainer_id");
        $availabilities = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}tm_trainer_availability WHERE trainer_id = %d", $trainer_id));

        if (!empty($_POST['tm_action']) && $_POST['tm_action'] === 'update_availability') {
            $this->handle_update_availability($trainer_id);
        }

        include plugin_dir_path(__FILE__) . '../templates/admin/availability-edit.php';
    }
    private function handle_update_availability($trainer_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_trainer_availability';

        $wpdb->delete($table_name, ['trainer_id' => $trainer_id]);

        $days = $_POST['days'] ?? [];

        if (empty($days)) {
            echo '<div class="error"><p>No days or slots provided.</p></div>';
            return;
        }

        foreach ($days as $day) {
            $day_name = sanitize_text_field($day['day_name'] ?? '');
            $froms = $day['slots_from'] ?? [];
            $tos = $day['slots_to'] ?? [];

            $slots = [];
            foreach ($froms as $i => $from) {
                $from_time = sanitize_text_field($from);
                $to_time   = sanitize_text_field($tos[$i] ?? '');
                if ($from_time && $to_time) {
                    $slots[] = "$from_time-$to_time";
                }
            }

            if ($day_name && !empty($slots)) {
                $wpdb->insert($table_name, [
                    'trainer_id' => $trainer_id,
                    'day_name'   => $day_name,
                    'slots'      => maybe_serialize($slots),
                ]);
            }
        }

        echo '<div class="updated"><p>Trainer availability updated successfully.</p></div>';
    }



    private function handle_save_availability()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'trainer_availability';

        $trainer_id = intval($_POST['trainer_id'] ?? 0);
        $availability = $_POST['availability'] ?? [];

        if (!$trainer_id || empty($availability)) {
            echo '<div class="error"><p>Please select a trainer and add at least one day.</p></div>';
            return;
        }

        foreach ($availability as $dayData) {
            $day = sanitize_text_field($dayData['day']);
            foreach ($dayData['slots'] as $slot) {
                $from = sanitize_text_field($slot['from']);
                $to   = sanitize_text_field($slot['to']);
                if ($from && $to) {
                    $wpdb->insert($table, [
                        'trainer_id' => $trainer_id,
                        'day_of_week' => $day,
                        'from_time'   => $from,
                        'to_time'     => $to
                    ]);
                }
            }
        }

        wp_redirect(admin_url('admin.php?page=tam_availability_list&saved=1'));
        exit;
    }
}
