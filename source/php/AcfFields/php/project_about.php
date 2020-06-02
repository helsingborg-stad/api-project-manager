<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5ec3d447df4ae',
    'title' => __('About the project', 'api-project-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_5ec3d5649134a',
            'label' => __('What?', 'api-project-manager'),
            'name' => 'project_what',
            'type' => 'wysiwyg',
            'instructions' => __('What are we telling - pick up a core sentence and use it as a preamble', 'api-project-manager'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ),
        1 => array(
            'key' => 'field_5ec3d5889134b',
            'label' => __('Why?', 'api-project-manager'),
            'name' => 'project_why',
            'type' => 'wysiwyg',
            'instructions' => __('Why is it good - what is the benefit / what need is addressed and what is new with the solution.', 'api-project-manager'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ),
        2 => array(
            'key' => 'field_5ec3d5969134c',
            'label' => __('How?', 'api-project-manager'),
            'name' => 'project_how',
            'type' => 'wysiwyg',
            'instructions' => __('How do we solve this - what kind of solutions are we testing', 'api-project-manager'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
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
    'menu_order' => -9999999,
    'position' => 'acf_after_title',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
        0 => 'the_content',
    ),
    'active' => 1,
    'description' => '',
));
}