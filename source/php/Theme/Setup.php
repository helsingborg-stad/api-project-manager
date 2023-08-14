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
        add_filter('post_updated_messages', array($this, 'postPublishedMsg'));
        add_action('rest_api_init', array($this, 'disableRestApi'), 11);
        add_filter('wp_insert_post_data', array($this, 'forceTitleGeneratedSlug'), 99, 2);
    }

    public function forceTitleGeneratedSlug($data, $postArr)
    {
        $allowedPostTypes = array('project', 'challenge');
        if (!in_array($data['post_status'], array('draft', 'pending', 'auto-draft')) && in_array($data['post_type'], $allowedPostTypes)) {
            $data['post_name'] = sanitize_title($data['post_title']);
        }

        return $data;
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

    /**
     * Update admin notice messages. Removes public links.
     * @return array
     */
    public function postPublishedMsg($messages)
    {
        foreach ($messages as $key => $value) {
            $messages['post'][1] = __('Post updated.', APIPROJECTMANAGER_TEXTDOMAIN);
            $messages['post'][6] = __('Post published.', APIPROJECTMANAGER_TEXTDOMAIN);
            $messages['post'][8] = __('Post submitted.', APIPROJECTMANAGER_TEXTDOMAIN);
            $messages['post'][10] = __('Post draft updated.', APIPROJECTMANAGER_TEXTDOMAIN);
        }

        return $messages;
    }

    public function disableRestApi()
    {
        global $wp_post_types;

        $post_types = array('post', 'page', 'comments');

        foreach ($post_types as $post_type) {
            if (isset($wp_post_types[$post_type]) && is_object($wp_post_types[$post_type])) {
                $wp_post_types[$post_type]->show_in_rest = false;
            }
        }
    }
}
