<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_6214fca7b9225',
    'title' => __('Project meta', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_6214fc6377600',
            'label' => __('City wide Initiative', 'api-project-manager'),
            'name' => 'city_wide_initiative',
            'type' => 'true_false',
            'instructions' => '',
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
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
        1 => array(
            'key' => 'field_6214fc7e77601',
            'label' => __('Challenging The Core Business', 'api-project-manager'),
            'name' => 'challenging_the_core_business',
            'type' => 'true_false',
            'instructions' => '',
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
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
        2 => array(
            'key' => 'field_5e85b631d7f04',
            'label' => __('Internal Project', 'api-project-manager'),
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
    'menu_order' => -999,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}