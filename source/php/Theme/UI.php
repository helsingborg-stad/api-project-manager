<?php

namespace ApiProjectManager\Theme;

/**
 * Cleaning up the wordpress api
 */

class UI
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'removeAdminMenuItems'), 100);
        add_action('wp_before_admin_bar_render', array($this, 'removeAdminBarItems'), 100);
        add_action('admin_menu', array($this, 'removeMetaBox'));
        add_filter('post_row_actions', array($this, 'removeRowActions'), 10, 1);
        add_filter('page_row_actions', array($this, 'removeRowActions'), 10, 1);
    }

    public function removeAdminMenuItems()
    {
        remove_menu_page('index.php');                      // Dashboard
        remove_menu_page('edit.php');                       // Posts
        remove_menu_page('edit.php?post_type=page');        // Pages
        remove_menu_page('edit-comments.php');              // Comments
        remove_menu_page('tools.php');                      // Tools
    }

    public function removeAdminBarItems()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('about');                // Remove the about WordPress link
        $wp_admin_bar->remove_menu('wporg');                // Remove the WordPress.org link
        $wp_admin_bar->remove_menu('documentation');        // Remove the WordPress documentation link
        $wp_admin_bar->remove_menu('support-forums');       // Remove the support forums link
        $wp_admin_bar->remove_menu('feedback');             // Remove the feedback link
        $wp_admin_bar->remove_menu('view-site');            // Remove the view site link
        $wp_admin_bar->remove_menu('updates');              // Remove the updates link
        $wp_admin_bar->remove_menu('comments');             // Remove the comments link
        $wp_admin_bar->remove_menu('new-content');          // Remove the content link
    }

    /**
     * Remove view/preview post link from admin ui
     * @param   array $actions Default actions
     * @return  array          Modified actions
     */
    public function removeRowActions($actions)
    {
        unset($actions['inline hide-if-no-js']);
        unset($actions['view']);

        return $actions;
    }

    // Remove Permalink meta box on edit posts
    public function removeMetaBox()
    {
        remove_meta_box('slugdiv', array('project'), 'normal');
    }
}
