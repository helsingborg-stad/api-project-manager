<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5fbe2df2d16dc',
    'title' => __('Appearance', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5fbe2dfba3637',
            'label' => __('Theme Color', 'api-project-manager'),
            'name' => 'theme_color',
            'type' => 'select',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'purple' => __('Purple', 'api-project-manager'),
                'blue' => __('Blue', 'api-project-manager'),
                'green' => __('Green', 'api-project-manager'),
                'red' => __('Red', 'api-project-manager'),
            ),
            'default_value' => array(
                0 => __('purple', 'api-project-manager'),
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
        ),
        1 => array(
            'key' => 'field_5fc1838e39cba',
            'label' => __('Featured Image position X', 'api-project-manager'),
            'name' => 'featured_image_position_x',
            'type' => 'select',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'left' => __('Left', 'api-project-manager'),
                'center' => __('Center', 'api-project-manager'),
                'right' => __('Right', 'api-project-manager'),
            ),
            'default_value' => array(
                0 => __('center', 'api-project-manager'),
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
        ),
        2 => array(
            'key' => 'field_5fc1830739cb9',
            'label' => __('Featured Image position Y', 'api-project-manager'),
            'name' => 'featured_image_position_y',
            'type' => 'select',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'top' => __('Top', 'api-project-manager'),
                'center' => __('Center', 'api-project-manager'),
                'bottom' => __('Bottom', 'api-project-manager'),
            ),
            'default_value' => array(
                0 => __('center', 'api-project-manager'),
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'challenge',
            ),
        ),
    ),
    'menu_order' => 10000,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
}