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
        add_action('admin_menu', array($this, 'removeMetaBoxes'), 100);
        add_filter('post_row_actions', array($this, 'removeRowActions'), 10, 1);
        add_filter('page_row_actions', array($this, 'removeRowActions'), 10, 1);
        add_filter('acf/get_field_groups', array($this, 'removeMunicipioAcfGroups'), 100, 1);
    }

    public function removeMunicipioAcfGroups($groups)
    {
        $groupsToDisable = array(
            'group_56d83cff12bb3',  //Navigation settings
            'group_56c33cf1470dc'   //Display settings
        );

        $groups = array_map(function ($group) use ($groupsToDisable) {
            if (isset($group['key']) && in_array($group['key'], $groupsToDisable)) {
                $group['active'] = 0;
            }

            return $group;
        }, $groups);

        return $groups;
    }

    public function removeAdminMenuItems()
    {
        remove_menu_page('index.php');                      // Dashboard
        remove_menu_page('edit.php');                       // Posts
        remove_menu_page('edit.php?post_type=page');        // Pages
        remove_menu_page('nestedpages');                    // nestedpages
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
    public function removeMetaBoxes()
    {
        $screens = array('project', 'challenge');
        $metaBoxesToRemove = array(
            [
                'id' => 'slugdiv',
                'screens' => $screens,
                'context' => 'side'
            ],
            [
                'id' => 'pageparentdiv',
                'screens' => $screens,
                'context' => 'side'
            ],
            [
                'id' => 'lix-calculator',
                'screens' => $screens,
                'context' => 'advanced'
            ],
            [
                'id' => 'commentstatusdiv',
                'screens' => $screens,
                'context' => 'side'
            ],
            [
                'id' => 'commentsdiv',
                'screens' => $screens,
                'context' => 'side'
            ],
        );
        
        $metaBoxesToRemove  = apply_filters('ApiProjectManager/Theme/UI/removeMetaBoxes', $metaBoxesToRemove);

        if (!empty($metaBoxesToRemove)) {
            foreach ($metaBoxesToRemove as $metaBox) {
                remove_meta_box($metaBox['id'], $metaBox['screens'], $metaBox['context']);
            }
        }
    }
}
