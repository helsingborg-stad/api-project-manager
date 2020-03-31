<?php

namespace ApiProjectManager\PostTypes;

class Project
{
    public function __construct()
    {
        $args = array(
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array('title', 'editor', 'thumbnail')
        );
        $project = new \ApiProjectManager\Helper\PostType('project', $args);

        // $project->add_taxonomy(
        //     'status',
        //     array(
        //         'hierarchical'      => false,
        //         'show_ui'           => true,
        //         'show_admin_column' => true,
        //         'query_var'         => true,
        //         'meta_box_cb'       => false,
        //         )
        // );
    }
}
