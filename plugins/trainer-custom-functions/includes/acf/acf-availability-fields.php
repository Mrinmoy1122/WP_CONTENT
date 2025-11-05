<?php
if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_trainer_availability',
    'title' => 'Trainer Availability',
    'fields' => array(
        array(
            'key' => 'field_av_trainer',
            'label' => 'Trainer',
            'name' => 'trainer',
            'type' => 'post_object',
            'post_type' => array('trainer'),
            'required' => 1,
            'return_format' => 'id',
        ),
        array(
            'key' => 'field_av_days',
            'label' => 'Days & Slots',
            'name' => 'days',
            'type' => 'repeater',
            'required' => 1,
            'button_label' => 'Add Day',
            'sub_fields' => array(
                array(
                    'key' => 'field_av_day_name',
                    'label' => 'Day',
                    'name' => 'day_name',
                    'type' => 'select',
                    'choices' => array(
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ),
                    'required' => 1,
                ),
                array(
                    'key' => 'field_av_day_slots',
                    'label' => 'Time Slots',
                    'name' => 'slots',
                    'type' => 'repeater',
                    'required' => 1,
                    'button_label' => 'Add Slot',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_av_slot_start',
                            'label' => 'Start Time',
                            'name' => 'start_time',
                            'type' => 'time_picker',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'field_av_slot_end',
                            'label' => 'End Time',
                            'name' => 'end_time',
                            'type' => 'time_picker',
                            'required' => 1,
                        ),
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'trainer_availability',
            ),
        ),
    ),
));

endif;
