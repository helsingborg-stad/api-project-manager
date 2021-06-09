<?php 



    'key' => 'group_60c05ed83a959',
    'title' => __('Platform Roadmap', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_60c05ed83d123',
            'label' => __('Roadmap', 'api-project-manager'),
            'name' => 'platform_roadmap',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => 'field_60c05ed83e1af',
            'min' => 0,
            'max' => 0,
            'layout' => 'row',
            'button_label' => '',
            'sub_fields' => array(
                0 => array(
                    'key' => 'field_60c05ed83e1af',
                    'label' => __('Title', 'api-project-manager'),
                    'name' => 'title',
                    'type' => 'text',
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
                    'append' => '',
                    'maxlength' => '',
                ),
                1 => array(
                    'key' => 'field_60c05f1b71add',
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
                    'display_format' => 'd/m/Y',
                    'return_format' => 'd/m/Y',
                    'first_day' => 1,
                ),
                2 => array(
                    'key' => 'field_60c05f0071adc',
                    'label' => __('Category', 'api-project-manager'),
                    'name' => 'category',
                    'type' => 'text',
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
                    'append' => '',
                    'maxlength' => '',
                ),
                3 => array(
                    'key' => 'field_60c05ed83e1bb',
                    'label' => __('Content', 'api-project-manager'),
                    'name' => 'content',
                    'type' => 'textarea',
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
                    'maxlength' => 200,
                    'rows' => '',
                    'new_lines' => '',
                ),
            ),
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'platform',
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
