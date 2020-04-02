<?php

/**
 * Plugin Name:       API Project Manager
 * Plugin URI:        (#plugin_url#)
 * Description:       Creates WordPress Rest API endpoint for projects
 * Version:           1.0.0
 * Author:            Jonatan Hanson
 * Author URI:        (#plugin_author_url#)
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       api-project-manager
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('APIPROJECTMANAGER_PATH', plugin_dir_path(__FILE__));
define('APIPROJECTMANAGER_URL', plugins_url('', __FILE__));
define('APIPROJECTMANAGER_TEMPLATE_PATH', APIPROJECTMANAGER_PATH . 'templates/');
define('APIPROJECTMANAGER_TEXTDOMAIN', 'api-project-manager');

load_plugin_textdomain('api-project-manager', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once APIPROJECTMANAGER_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once APIPROJECTMANAGER_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new ApiProjectManager\Vendor\Psr4ClassLoader();
$loader->addPrefix('ApiProjectManager', APIPROJECTMANAGER_PATH);
$loader->addPrefix('ApiProjectManager', APIPROJECTMANAGER_PATH . 'source/php/');
$loader->register();

// Start application
new ApiProjectManager\App();
