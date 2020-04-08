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
            'supports'           => array('title', 'author', 'revisions', 'editor', 'thumbnail', 'themes'),
            'show_in_rest'       => true,
        );

        $restArgs = array(
          'exclude_keys' => array('author', 'acf', 'guid', 'link', 'template', 'meta', 'taxonomy', 'menu_order')
        );

        $postType = new \ApiProjectManager\Helper\PostType(
            'project',
            __('Project', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Projects', APIPROJECTMANAGER_TEXTDOMAIN),
            $args,
            array(),
            $restArgs
        );

        // Statuses
        $postType->addTaxonomy(
            'status',
            __('Status', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Statuses', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
              'hierarchical' => false,
              'show_ui' => true,
              'show_in_rest' => true,
              'show_in_quick_edit' => false,
              'meta_box_cb' => false,
            )
        );

        // Technologies
        $postType->addTaxonomy(
            'technology',
            __('Technology', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Technologies', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
              'hierarchical' => false,
              'show_ui' => true,
              'show_in_rest' => true,
              'show_in_quick_edit' => false,
              'meta_box_cb' => false,
            )
        );

        // Sectors
        $postType->addTaxonomy(
            'sector',
            __('Sector', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Sectors', APIPROJECTMANAGER_TEXTDOMAIN),
            array('hierarchical' => true)
        );

        // Organisations
        $postType->addTaxonomy(
            'organisation',
            __('Organisation', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Organisations', APIPROJECTMANAGER_TEXTDOMAIN),
            array('hierarchical' => true)
        );

        // Global goals
        $postType->addTaxonomy(
            'global_goal',
            __('Global goal', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Global goals', APIPROJECTMANAGER_TEXTDOMAIN),
            array('hierarchical' => true)
        );

        // Categories
        $postType->addTaxonomy(
            'category',
            __('Category', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Categories', APIPROJECTMANAGER_TEXTDOMAIN),
            array('hierarchical' => true)
        );
    }
}
