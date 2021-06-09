<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_60c05db51b31d',
    'title' => __('Cover', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_60c05db51d4d8',
            'label' => __('Cover Image', 'api-project-manager'),
            'name' => 'cover_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'url',
            'preview_size' => '1536x1536',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        1 => array(
            'key' => 'field_60c05db51d4ed',
            'label' => __('Cover Image position X', 'api-project-manager'),
            'name' => 'cover_image_position_x',
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
            'default_value' => __('center', 'api-project-manager'),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
        ),
        2 => array(
            'key' => 'field_60c05db51d4f2',
            'label' => __('Cover Image position Y', 'api-project-manager'),
            'name' => 'cover_image_position_y',
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
            'default_value' => __('center', 'api-project-manager'),
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
                'value' => 'platform',
            ),
        ),
    ),
    'menu_order' => 10000,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}