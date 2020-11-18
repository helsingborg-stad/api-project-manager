<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5fb3dd484fcb4',
    'title' => __('Project investment', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5fb3dd4fb968f',
            'label' => __('Investment type', 'api-project-manager'),
            'name' => 'investment_type',
            'type' => 'checkbox',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '33',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'amount' => __('Amount (in kr)', 'api-project-manager'),
                'hours' => __('Hours', 'api-project-manager'),
            ),
            'allow_custom' => 0,
            'default_value' => array(
            ),
            'layout' => 'vertical',
            'toggle' => 0,
            'return_format' => 'value',
            'save_custom' => 0,
        ),
        1 => array(
            'key' => 'field_5fb3dee669135',
            'label' => __('Investment amount (in kr)', 'api-project-manager'),
            'name' => 'investment_amount',
            'type' => 'number',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_5fb3dd4fb968f',
                        'operator' => '==',
                        'value' => 'amount',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '33',
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
        2 => array(
            'key' => 'field_5fb3df5369136',
            'label' => __('Investment in hours', 'api-project-manager'),
            'name' => 'investment_hours',
            'type' => 'number',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_5fb3dd4fb968f',
                        'operator' => '==',
                        'value' => 'hours',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '33',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => __('hours', 'api-project-manager'),
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
    'menu_order' => 99999999,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}