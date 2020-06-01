<?php

namespace ApiProjectManager\Roles;

class ProjectEditor
{
    private $role = 'project_editor';

    public function __construct()
    {
        add_action('admin_init', array($this, 'registerCustomRole'));
        add_action('pre_get_posts', array($this, 'filterProjectsByOrganisation'));
        add_action('acf/save_post', array($this, 'setOrganisationOnSaveProject'));
        add_filter('login_redirect', array($this, 'redirectToProjectsAfterLogin'), 10, 3);
        add_action('current_screen', array($this, 'formatAdminPageByOrganisation'), 20);
        add_action('admin_head', array($this, 'hideFields'));
    }

    public function hideFields()
    {
        $user = get_user_by('id', get_current_user_id());
        $screen = get_current_screen();

        if ($screen->base !== 'post'
        || $screen->post_type !== 'project'
        || !in_array($this->role, $user->roles)) {
            return;
        }

        echo '<style>[data-name="organisation"], #pageparentdiv, #acf-group_56c33cf1470dc, #acf-group_56d83cff12bb3 {display: none !important;}</style>';
    }

    public function redirectToProjectsAfterLogin($redirectTo, $requestedRedirectTo, $user)
    {
        if (!in_array($this->role, $user->roles)) {
            return $redirectTo;
        }

        return 'wp-admin/edit.php?post_type=project';
    }

    public function setOrganisationOnSaveProject($postId)
    {
        $user = get_user_by('id', get_current_user_id());
        $userOrganisations = get_field('organisation', 'user_' . $user->ID);

        if (get_post_type($postId) !== 'project'
        || !in_array($this->role, $user->roles)
        || empty($userOrganisations)) {
            return;
        }

        update_field('organisation', $userOrganisations, $postId);
    }

    public function filterProjectsByOrganisation($query)
    {
        if (!is_admin()
        || !$query->is_main_query()
        || !isset($_GET['post_type'])
        || $_GET['post_type'] !== 'project') {
            return;
        }

        $user = get_user_by('id', get_current_user_id());
        $userOrganisations = get_field('organisation', 'user_' . $user->ID);

        if (!in_array($this->role, $user->roles) || empty($userOrganisations)) {
            return;
        }

        $taxquery = array(
            array(
                'taxonomy' => 'organisation',
                'field' => 'id',
                'terms' => $userOrganisations,
                'operator'=> 'IN'
            )
        );

        $query->set('tax_query', $taxquery);
    }

    /**
     * Administration page shall only display relevant information for logged in user.
     *
     * @param $query
     */
    public function formatAdminPageByOrganisation($query)
    {
        if ($query->id === 'edit-project') {
            add_filter("views_{$query->id}", array($this, 'formatPostCount'));
        }
    }

    /**
     * Format and display correct post count for user by matching post and user organisation.
     *
     * @param array $view
     * @return array
     */
    public function formatPostCount($view)
    {
        global $wpdb;

        $user = get_user_by('id', get_current_user_id());
        $userOrg = get_field('organisation', 'user_' . $user->ID);

        if (!in_array($this->role, $user->roles) || empty(get_field('organisation', 'user_' . $user->ID))) {
            return $view;
        }

        $postStatues = array('all', 'publish', 'trash', 'draft');

        foreach ($postStatues as $status) {
            if (isset($view[$status])) {
                $onQuery = implode(' OR ', array_map(function ($organisationId) use ($status, $wpdb) {
                    $queryString = $wpdb->posts . ".ID = " .$wpdb->term_relationships . ".object_id AND " .$wpdb->term_relationships . ".term_taxonomy_id = " . $organisationId . " AND " . $wpdb->posts .".post_type = 'project'";

                    if ($status !== 'all') {
                        $queryString .= " AND " . $wpdb->posts . ".post_status = '$status'";
                    } else {
                        $queryString .= " AND NOT " . $wpdb->posts . ".post_status = 'trash'";
                    }

                    return $queryString;
                }, $userOrg));


                $queryResult = $wpdb->get_var(
                    "SELECT COUNT(*) 
                    FROM {$wpdb->posts}
                    INNER JOIN {$wpdb->term_relationships}
                    ON {$onQuery};"
                );

                $view[$status] = preg_replace('/\(.+\)/U', '('.$queryResult.')', $view[$status]);
            }
        }

        $postStatuesToRemove = array('mine');
        
        foreach ($postStatuesToRemove as $status) {
            if (isset($view[$status])) {
                unset($view[$status]);
            }
        }

        return $view;
    }

    public function registerCustomRole()
    {
        add_role($this->role, __('Project Editor', APIPROJECTMANAGER_TEXTDOMAIN), get_role('editor')->capabilities);
    }
}
