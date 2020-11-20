<?php

namespace ApiProjectManager\PostTypes;

class Challenge
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
            'supports'           => array('title', 'author', 'revisions', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'       => true,
        );

        $restArgs = array(
          'exclude_keys' => array('author', 'acf', 'guid', 'link', 'template', 'meta', 'taxonomy', 'menu_order')
        );

        $postType = new \ApiProjectManager\Helper\PostType(
            'challenge',
            __('Challenge', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Challenges', APIPROJECTMANAGER_TEXTDOMAIN),
            $args,
            array(),
            $restArgs
        );

        // Category
        $postType->addTaxonomy(
            'challenge_category',
            __('Category', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Categories', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
              'hierarchical' => false,
              'show_ui' => true,
              'show_in_rest' => true,
              'show_in_quick_edit' => false,
              'meta_box_cb' => false,
            )
        );

        // Global goals
        $postType->addTaxonomy(
            'global_goal',
            __('Global goal', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Global goals', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            )
        );
    }
}
