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
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'status',
            'field_type' => 'radio',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        1 => array(
            'key' => 'field_5fb3d0a6b2bd8',
            'label' => __('Challenge', 'api-project-manager'),
            'name' => 'challenge',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'challenge',
            ),
            'taxonomy' => '',
            'allow_null' => 1,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
        ),
        2 => array(
            'key' => 'field_5fb3d0dbb2bd9',
            'label' => __('Category', 'api-project-manager'),
            'name' => 'challenge_category',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_5fb3d0a6b2bd8',
                        'operator' => '==empty',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'challenge_category',
            'field_type' => 'select',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 0,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        3 => array(
            'key' => 'field_5e8dce344f6b4',
            'label' => __('Owner (organisation)', 'api-project-manager'),
            'name' => 'organisation',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'organisation',
            'field_type' => 'select',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 0,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        4 => array(
            'key' => 'field_62162d6ece420',
            'label' => __('Participants', 'api-project-manager'),
            'name' => 'participants',
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
            'allow_null' => 1,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 0,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        5 => array(
            'key' => 'field_622efd1a5ee42',
            'label' => __('Operation', 'api-project-manager'),
            'name' => 'operation',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'operation',
            'field_type' => 'multi_select',
            'allow_null' => 0,
            'add_term' => 1,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        6 => array(
            'key' => 'field_5e8dd435ea9df',
            'label' => __('Partners', 'api-project-manager'),
            'name' => 'partner',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'partner',
            'field_type' => 'multi_select',
            'allow_null' => 0,
            'add_term' => 1,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        7 => array(
            'key' => 'field_6214b4a611d13',
            'label' => __('Expected Impact', 'api-project-manager'),
            'name' => 'expected_impact',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'expected-impact',
            'field_type' => 'select',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        8 => array(
            'key' => 'field_5e8dcdf152c5d',
            'label' => __('Sectors', 'api-project-manager'),
            'name' => 'sector',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'sector',
            'field_type' => 'multi_select',
            'allow_null' => 1,
            'add_term' => 1,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        9 => array(
            'key' => 'field_5e8d9d0289bc7',
            'label' => __('Technologies', 'api-project-manager'),
            'name' => 'technology',
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
            'field_type' => 'multi_select',
            'allow_null' => 1,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        10 => array(
            'key' => 'field_5e8dce65e835b',
            'label' => __('Global goal', 'api-project-manager'),
            'name' => 'global_goal',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'global_goal',
            'field_type' => 'multi_select',
            'allow_null' => 1,
            'add_term' => 1,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
        ),
        11 => array(
            'key' => 'field_60ba1a1941860',
            'label' => __('Platforms', 'api-project-manager'),
            'name' => 'platforms',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'platform',
            ),
            'taxonomy' => '',
            'allow_null' => 1,
            'multiple' => 1,
            'return_format' => 'id',
            'ui' => 1,
        ),
        12 => array(
            'key' => 'field_6213a7e057273',
            'label' => __('Innovation potential', 'api-project-manager'),
            'name' => 'innovation_potential',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'innovation-potential',
            'field_type' => 'checkbox',
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'object',
            'multiple' => 0,
            'allow_null' => 0,
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
    'menu_order' => 10,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}