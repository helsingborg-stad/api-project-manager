<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5fb3dd484fcb4',
    'title' => __('Budget', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5fc0009408b9d',
            'label' => __('Estimated budget', 'api-project-manager'),
            'name' => 'estimated_budget',
            'type' => 'number',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => __('kr', 'api-project-manager'),
            'min' => '',
            'max' => '',
            'step' => '',
        ),
        1 => array(
            'key' => 'field_5fc000c308b9e',
            'label' => __('Cost so far', 'api-project-manager'),
            'name' => 'cost_so_far',
            'type' => 'number',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => __('kr', 'api-project-manager'),
            'min' => '',
            'max' => '',
            'step' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'project',
            ),
        ),
    ),
    'menu_order' => -999,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
}