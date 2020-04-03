<?php

namespace ApiProjectManager\Theme;

class Enqueue
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
    }

    /**
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('api-project-manager', APIPROJECTMANAGER_URL . '/assets/dist/' . \ApiProjectManager\Helper\CacheBust::name('css/admin.css'));
    }
}
