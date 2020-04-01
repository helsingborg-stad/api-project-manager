<?php

namespace ApiProjectManager\PostTypes;

class Project
{
    public function __construct()
    {
        add_action('init', array($this, 'registerPostType'), 9);
    }

    public function registerPostType()
    {
        $args = array(
            'menu_icon'          => 'dashicons-portfolio',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array('title', 'revisions', 'editor', 'thumbnail'),
            'show_in_rest' => true,
        );

        $postType = new \ApiProjectManager\Helper\PostType(
            'project',
            __('Project', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Projects', APIPROJECTMANAGER_TEXTDOMAIN),
            $args
        );

        $postType->addTaxonomy(
            'status',
            __('Status', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Statuses', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical'      => false,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'meta_box_cb'       => false,
                )
        );
    }
}
