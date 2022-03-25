<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_6213918ce807a',
    'title' => __('Accounting', 'api-project-manager'),
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
                'width' => '',
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
            'key' => 'field_62138e1575c9a',
            'label' => __('Funds granted', 'api-project-manager'),
            'name' => 'funds_granted',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                0 => array(
                    'key' => 'field_62138eab75c9b',
                    'label' => __('Amount', 'api-project-manager'),
                    'name' => 'amount',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
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
                    'key' => 'field_62138efa75c9d',
                    'label' => __('Date', 'api-project-manager'),
                    'name' => 'date',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d',
                    'return_format' => 'Y-m-d',
                    'first_day' => 1,
                ),
                2 => array(
                    'key' => 'field_62138eeb75c9c',
                    'label' => __('Comment', 'api-project-manager'),
                    'name' => 'comment',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
        ),
        2 => array(
            'key' => 'field_621394116960a',
            'label' => __('Funds used', 'api-project-manager'),
            'name' => 'funds_used',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                0 => array(
                    'key' => 'field_621394126960b',
                    'label' => __('Amount', 'api-project-manager'),
                    'name' => 'amount',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
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
                    'key' => 'field_621394126960c',
                    'label' => __('Date', 'api-project-manager'),
                    'name' => 'date',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d',
                    'return_format' => 'Y-m-d',
                    'first_day' => 1,
                ),
                2 => array(
                    'key' => 'field_621394126960d',
                    'label' => __('Comment', 'api-project-manager'),
                    'name' => 'comment',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
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
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}