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
        $markup = '<a href="' . admin_url('edit.php?post_type=project&export=csv') . '" class="button" target="_blank">' . __('Export CSV', APIPROJECTMANAGER_TEXTDOMAIN) . '</a>';


        $views['csv-export'] = $markup;

        return $views;
    }

    /**
     * Export from submissions
     * @return void
     */
    public function export()
    {
        if (!is_admin()) {
            return;
        }

        $screen = get_current_screen();

        if ($screen->post_type !== 'project' || !isset($_GET['export'])) {
            return;
        }

        error_log(print_r("export me", true));

        $type = $_GET['export'];
        error_log(print_r($type, true));

        $projects = new \WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'project',
            'post_status' => 'publish',
            // ADD
            // 'meta_query' => array(
            //     'relation' => 'OR',
            //     array(
            //         'key' => 'modularity-form-id',
            //         'value' => $formId,
            //         'compare' => '='
            //     )
            // )
        ));

        $projects = $projects->posts;
        $csvData = array();

        foreach ($projects as $project) {
            error_log(print_r($project, true));
            //$data = Submission::getSubmissionData($submission->ID);

            // Flaten arrays
            $data = array_map(function ($a) {
                return is_array($a) ? implode(',', $a) : $a;
            }, (array) $project);

            $csvData[] = $data;
        }

        $this->downloadSendHeaders(sanitize_title("projects_export") . '_' . date('Y-m-d') . '.csv');
        echo chr(239) . chr(187) . chr(191);
        echo $this->array2csv($csvData);

        die();
    }

    public function array2csv(array &$array)
    {
        if (count($array) == 0) {
            return null;
        }

        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)), ';');

        foreach ($array as $row) {
            fputcsv($df, $row, ';');
        }

        fclose($df);
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
