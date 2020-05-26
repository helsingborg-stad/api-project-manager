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

    public function registerCustomRole()
    {
        add_role($this->role, __('Project Editor', APIPROJECTMANAGER_TEXTDOMAIN), get_role('editor')->capabilities);
    }
}
