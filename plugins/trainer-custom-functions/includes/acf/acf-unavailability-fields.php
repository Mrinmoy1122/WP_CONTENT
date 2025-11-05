<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_trainer_unavailability',
    'title' => 'Trainer Non-Availability',
    'fields' => array(
        array(
            'key' => 'field_unav_trainer',
            'label' => 'Trainer',
            'name' => 'trainer',
            'type' => 'post_object',
            'post_type' => array('trainer'),
            'required' => 1,
            'return_format' => 'id',
        ),
        array(
            'key' => 'field_unav_date',
            'label' => 'Date',
            'name' => 'date',
            'type' => 'date_picker',
            'required' => 1,
            'display_format' => 'Y-m-d',
            'return_format' => 'Y-m-d',
        ),
        array(
            'key' => 'field_unav_type',
            'label' => 'Unavailability Type',
            'name' => 'type',
            'type' => 'radio',
            'choices' => array(
                'full' => 'Full Day Off',
                'partial' => 'Partial Day Off',
            ),
            'layout' => 'horizontal',
            'required' => 1,
        ),
        array(
            'key' => 'field_unav_slots',
            'label' => 'Unavailable Slots',
            'name' => 'slots',
            'type' => 'repeater',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_unav_type',
                        'operator' => '==',
                        'value' => 'partial',
                    ),
                ),
            ),
            'button_label' => 'Add Slot',
            'sub_fields' => array(
                array(
                    'key' => 'field_unav_slot_start',
                    'label' => 'Start Time',
                    'name' => 'start_time',
                    'type' => 'time_picker',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_unav_slot_end',
                    'label' => 'End Time',
                    'name' => 'end_time',
                    'type' => 'time_picker',
                    'required' => 1,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'trainer_unavailability',
            ),
        ),
    ),
));

endif;
