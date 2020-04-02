<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5e85b62821647',
    'title' => __('Internal project', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5e85b631d7f04',
            'label' => '',
            'name' => 'internal_project',
            'type' => 'true_false',
            'instructions' => __('Select if this is an internal project.', 'api-project-manager'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => __('Yes', 'api-project-manager'),
            'ui_off_text' => __('No', 'api-project-manager'),
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
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}