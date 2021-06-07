<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5ec7baa64e985',
    'title' => __('Project Editor', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5ec7bacd0a6f9',
            'label' => __('Organisation', 'api-project-manager'),
            'name' => 'organisation',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'organisation',
            'field_type' => 'multi_select',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 0,
            'return_format' => 'id',
            'multiple' => 0,
        ),
        1 => array(
            'key' => 'field_76a1n2gkb',
            'label' => __('Platform', 'api-project-manager'),
            'name' => 'platform',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'platform',
            'field_type' => 'multi_select',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 0,
            'return_format' => 'id',
            'multiple' => 0,
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'user_role',
                'operator' => '==',
                'value' => 'project_editor',
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