<?php

namespace ApiProjectManager;

class Options
{
    public function __construct()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title' => _x('Project Manager settings', 'ACF', APIPROJECTMANAGER_TEXTDOMAIN),
                'menu_title' => _x('Options', 'Project Manager settings', APIPROJECTMANAGER_TEXTDOMAIN),
                'menu_slug' => 'project-options',
                'parent_slug' => 'edit.php?post_type=project',
                'capability' => 'manage_options'
            ));
        }

        // Acf setting: Google API key
        add_action('acf/init', array($this, 'acfGoogleKey'));
    }

    /**
     * ACF settings action
     * @return void
     */
    public function acfGoogleKey()
    {
        acf_update_setting('google_api_key', get_field('google_maps_api_key', 'option'));
    }
}
