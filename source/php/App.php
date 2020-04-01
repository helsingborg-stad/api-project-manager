<?php

namespace ApiProjectManager;

class App
{
    public function __construct()
    {
        new Theme\Setup();
        new Theme\UI();

        new PostTypes\Project();

        // add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
        // add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    /**
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {
        wp_register_style('api-project-manager-css', APIPROJECTMANAGER_URL . '/dist/' . \ApiProjectManager\Helper\CacheBust::name('css/api-project-manager.css'));
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_register_script('api-project-manager-js', APIPROJECTMANAGER_URL . '/dist/' . \ApiProjectManager\Helper\CacheBust::name('js/api-project-manager.js'));
    }
}
