<?php

namespace ApiProjectManager\Theme;

/**
 * Setup theme functionality suited for API
 */

class Setup
{
    public function __construct()
    {
        add_action('init', array($this, 'redirectToApi'));
        add_action('after_setup_theme', array($this, 'themeSupport'));
        add_filter('get_sample_permalink_html', array($this, 'replacePermalink'), 10, 5);
    }

    /**
     * Replaces permalink on edit post with API-url
     * @return string
     */
    public function replacePermalink($return, $post_id, $new_title, $new_slug, $post)
    {
        $postType = $post->post_type;
        $jsonUrl = get_rest_url(null, 'wp/v2/' . $postType) . '/';
        $apiUrl = $jsonUrl . $post_id;

        return '<strong>' . __('URL', 'event-manager') . ':</strong> <a href="' . $apiUrl . '" target="_blank">' . $apiUrl . '</a>';
    }

    /**
     * Force the usage of wordpress api
     * @return void
     */
    public function redirectToApi()
    {
        if (php_sapi_name() === 'cli') {
            return;
        }

        if (!is_admin() && strpos($this->currentUrl(), rtrim(rest_url(), "/")) === false && $this->currentUrl() == rtrim(home_url(), "/")) {
            wp_redirect(rest_url());
            exit;
        }
    }

    public function currentUrl()
    {
        $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $currentURL .= $_SERVER["SERVER_NAME"];

        if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
            $currentURL .= ":" . $_SERVER["SERVER_PORT"];
        }

        $currentURL .= $_SERVER["REQUEST_URI"];

        return rtrim($currentURL, "/");
    }

    /**
     * Add theme support
     */
    public function themeSupport()
    {
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('html5');
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'gallery',
                'link',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat'
            )
        );
    }
}