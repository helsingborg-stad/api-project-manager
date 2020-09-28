<?php

namespace ApiProjectManager\PostTypes;

class Project
{
    public function __construct()
    {
        add_action('init', array($this, 'registerPostType'), 9);
        add_filter('views_edit-project', array($this, 'addExportButton'));
        add_action('current_screen', array($this, 'export'));
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
            'supports'           => array('title', 'author', 'revisions', 'editor', 'thumbnail', 'themes'),
            'show_in_rest'       => true,
        );

        $restArgs = array(
          'exclude_keys' => array('author', 'acf', 'guid', 'link', 'template', 'meta', 'taxonomy', 'menu_order')
        );

        $postType = new \ApiProjectManager\Helper\PostType(
            'project',
            __('Project', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Projects', APIPROJECTMANAGER_TEXTDOMAIN),
            $args,
            array(),
            $restArgs
        );

        // Statuses
        $postType->addTaxonomy(
            'status',
            __('Status', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Statuses', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
              'hierarchical' => false,
              'show_ui' => true,
              'show_in_rest' => true,
              'show_in_quick_edit' => false,
              'meta_box_cb' => false,
            )
        );

        // Technologies
        $postType->addTaxonomy(
            'technology',
            __('Technology', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Technologies', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
              'hierarchical' => true,
              'show_ui' => true,
              'show_in_rest' => true,
              'show_in_quick_edit' => false,
              'meta_box_cb' => false,
            )
        );

        // Sectors
        $postType->addTaxonomy(
            'sector',
            __('Sector', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Sectors', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            )
        );

        // Organisations
        $postType->addTaxonomy(
            'organisation',
            __('Organisation', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Organisations', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => true,
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

        // Partners
        $postType->addTaxonomy(
            'partner',
            __('Partner', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Partners', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            )
        );
    }

    public function addExportButton($views)
    {
        $markup = '<a href="' . admin_url('edit.php?post_type=project&export=csv') . '" class="page-title-action" target="_blank">' . __('Export CSV', APIPROJECTMANAGER_TEXTDOMAIN) . '</a>';
        $views['csv-export'] = $markup;

        return $views;
    }

    /**
     * Export projects as CSV
     * @return void
     */
    public function export()
    {
        if (!is_admin()) {
            return;
        }

        $screen = get_current_screen();

        // Bail if export csv attributes is not set
        if ($screen->post_type !== 'project' || !(isset($_GET['export']) && $_GET['export'] === 'csv')) {
            return;
        }

        $args = array(
          'numberposts' => -1,
          'post_type' => 'project',
          'orderby' => 'title',
          'order' => 'ASC',
        );
        $projects = get_posts($args);

        $csvData = array();

        foreach ($projects as $project) {
            $projectData = $this->mapExportData($project);

            // Flaten arrays
            $data = array_map(function ($a) {
                return is_array($a) ? implode(',', $a) : $a;
            }, $projectData);

            $csvData[] = $data;
        }

        $this->downloadSendHeaders(sanitize_title("project_export") . '_' . date('Y-m-d') . '.csv');
        echo chr(239) . chr(187) . chr(191);
        echo $this->array2csv($csvData);

        die();
    }

    public function mapExportData($data)
    {
        $exportData = array();

        if (empty($data->ID)) {
            return $exportData;
        }

        // Collect meta data
        $metaData = get_fields($data->ID, true);

        // Define all data to be exported for each project
        $exportData['ID'] = $data->ID ?? '';
        $exportData[__('Date', APIPROJECTMANAGER_TEXTDOMAIN)] = $data->post_date ?? '';
        $exportData[__('Modified', APIPROJECTMANAGER_TEXTDOMAIN)] = $data->post_date ?? '';
        $exportData[__('Title', APIPROJECTMANAGER_TEXTDOMAIN)] = $data->post_title ?? '';
        $exportData[__('What?', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['project_what']) ? sanitize_text_field($metaData['project_what']) : '';
        $exportData[__('Why?', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['project_why']) ? sanitize_text_field($metaData['project_why']) : '';
        $exportData[__('How?', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['project_how']) ? sanitize_text_field($metaData['project_how']) : '';
        $exportData[__('Organisation', APIPROJECTMANAGER_TEXTDOMAIN)] = $metaData['organisation']->name ?? '';
        $exportData[__('Status', APIPROJECTMANAGER_TEXTDOMAIN)] = $metaData['status']->name ?? '';
        $exportData[__('Technologies', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['technology']) ? $this->gatherTaxonomyValues($metaData['technology']) : '';
        $exportData[__('Partners', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['partner']) ? $this->gatherTaxonomyValues($metaData['partner']) : '';
        $exportData[__('Sectors', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['sector']) ? $this->gatherTaxonomyValues($metaData['sector']) : '';
        $exportData[__('Global goals', APIPROJECTMANAGER_TEXTDOMAIN)] = !empty($metaData['global_goal']) ? $this->gatherTaxonomyValues($metaData['global_goal']) : '';

        return $exportData;
    }

    public function gatherTaxonomyValues($data)
    {
        if (empty($data) || !is_array($data)) {
            return null;
        }

        $taxonomyNames = array();

        foreach ($data as $key => $value) {
            if (!empty($value->name)) {
                $taxonomyNames[] = $value->name;
            }
        }

        $taxonomyNames = \implode(', ', $taxonomyNames);

        return $taxonomyNames;
    }

    public function array2csv(array &$array)
    {
        if (count($array) == 0) {
            return null;
        }

        ob_start();
        $handle = fopen("php://output", 'w');
        fputcsv($handle, array_keys(reset($array)), ';');

        foreach ($array as $row) {
            fputcsv($handle, $row, ';');
        }

        fclose($handle);
        return ob_get_clean();
    }

    public function downloadSendHeaders($filename)
    {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
}
