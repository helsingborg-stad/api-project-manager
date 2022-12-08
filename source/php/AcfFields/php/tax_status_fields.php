<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5fb7d42342ff7',
    'title' => __('Status', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5fb7d4611f925',
            'label' => __('Progress value', 'api-project-manager'),
            'name' => 'progress_value',
            'aria-label' => '',
            'type' => 'range',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 0,
            'min' => -1,
            'max' => '',
            'step' => 1,
            'prepend' => '',
            'append' => __('%', 'api-project-manager'),
        ),
        1 => array(
            'key' => 'field_6391e4303f343',
            'label' => __('Requires "Lessons learned"', 'api-project-manager'),
            'name' => 'lessons_learned_is_obligatory',
            'aria-label' => '',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => __('The lessons learned field is obligatory when this status is active', 'api-project-manager'),
            'default_value' => 0,
            'ui_on_text' => __('Yes', 'api-project-manager'),
            'ui_off_text' => __('No', 'api-project-manager'),
            'ui' => 1,
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'taxonomy',
                'operator' => '==',
                'value' => 'status',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
));
}