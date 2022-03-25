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
if (!defined('WPINC')) {
    die;
}

define('APIPROJECTMANAGER_PATH', plugin_dir_path(__FILE__));
define('APIPROJECTMANAGER_URL', plugins_url('', __FILE__));
define('APIPROJECTMANAGER_TEXTDOMAIN', 'api-project-manager');

load_plugin_textdomain('api-project-manager', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once APIPROJECTMANAGER_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once APIPROJECTMANAGER_PATH . 'Public.php';
if (file_exists(APIPROJECTMANAGER_PATH . 'vendor/autoload.php')) {
    require_once APIPROJECTMANAGER_PATH . 'vendor/autoload.php';
}

// Acf auto import and export
add_action('plugins_loaded', function () {
    $acfExportManager = new \AcfExportManager\AcfExportManager();
    $acfExportManager->setTextdomain(APIPROJECTMANAGER_TEXTDOMAIN);
    $acfExportManager->setExportFolder(APIPROJECTMANAGER_PATH . 'source/php/AcfFields/');
    $acfExportManager->autoExport(array(
        'project' => 'group_5e859cc1f2e8e',
        'project_internal' => 'group_5e85b62821647',
        'project_settings' => 'group_5e8d8de5b9d01',
        'project_taxonomies' => 'group_5e8d9b68e7f35',
        'project_about' => 'group_5ec3d447df4ae',
        'project_editor' => 'group_5ec7baa64e985',
        'project_budget' => 'group_5fb3dd484fcb4',
        'project_accounting' => 'group_6213918ce807a',
        'project_impact' => 'group_5fb4e0ff4c111',
        'project_resident_involvement' => 'group_6022843249a67',
        'project_meta' => 'group_6214fca7b9225',
        'challenge_taxonomies' => 'group_5fb3c4e538202',
        'challenge_contacts' => 'group_5fc754f516d03',
        'challenge_appearance' => 'group_5fbe2df2d16dc',
        'challenge_preamble' => 'group_5fc4984e90cf0',
        'tax_status_fields' => 'group_5fb7d42342ff7',
        'tax_featured_image' => 'group_5fbffed2803dd',
        'tax_focal_point_meta' => 'group_6037bb3ded5e1',
        'platform_cover' => 'group_60c05db51b31d',
        'platform_features' => 'group_60c05e6dedc15',
        'platform_roadmap' => 'group_60c05ed83a959',
        'platform_details' => 'group_60bde20356c2c',
        'platform_get_started' => 'group_60d9b2cfcbda3',
    ));
    $acfExportManager->import();
});

// Instantiate and register the autoloader
$loader = new ApiProjectManager\Vendor\Psr4ClassLoader();
$loader->addPrefix('ApiProjectManager', APIPROJECTMANAGER_PATH);
$loader->addPrefix('ApiProjectManager', APIPROJECTMANAGER_PATH . 'source/php/');
$loader->register();

// Start application if ACF plugin if activated
if (!function_exists('get_field')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error">';
        echo '<p>';
        _e("API Project Manager require Advanced Custom Fields PRO to function. Please make sure that this is installed and enabled.", APIPROJECTMANAGER_TEXTDOMAIN);
        echo '</p>';
        echo '</div>';
    });
} else {
    new ApiProjectManager\App();
}
