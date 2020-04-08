<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5e8d9b68e7f35',
    'title' => __('Taxonomies', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5e8d9b71fc34b',
            'label' => __('Status', 'api-project-manager'),
            'name' => 'status',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'status',
            'field_type' => 'select',
            'allow_null' => 1,
            'add_term' => 1,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        1 => array(
            'key' => 'field_5e8d9d0289bc7',
            'label' => __('Technologies', 'api-project-manager'),
            'name' => 'technologies',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'technology',
            'field_type' => 'select',
            'allow_null' => 1,
            'add_term' => 1,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
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