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
        global  $wpdb;

        $user = get_user_by('id', get_current_user_id());
        $userOrg = serialize(get_field('organisation', 'user_' . $user->ID));

        if (!in_array($this->role, $user->roles) || empty(get_field('organisation', 'user_' . $user->ID))) {
            return $view;
        }

        $total = $wpdb->get_var(
            "SELECT COUNT(*) FROM $wpdb->postmeta 
            INNER JOIN $wpdb->posts ON ($wpdb->postmeta.post_id = $wpdb->posts.ID)
            AND ($wpdb->postmeta.meta_value = '$userOrg')
            AND ($wpdb->posts.post_parent = 0)"
        );

        $mine =  $wpdb->get_var(
            "SELECT COUNT(*) FROM $wpdb->postmeta 
            INNER JOIN $wpdb->posts ON ($wpdb->postmeta.post_id = $wpdb->posts.ID)
            AND ($wpdb->postmeta.meta_value = '$userOrg')
            AND ($wpdb->posts.post_parent = 0)
            AND ($wpdb->posts.post_author = $user->ID)"
        );

        $publish =  $wpdb->get_var(
            "SELECT COUNT(*) FROM $wpdb->postmeta 
            INNER JOIN $wpdb->posts ON ($wpdb->postmeta.post_id = $wpdb->posts.ID)
            AND ($wpdb->postmeta.meta_value = '$userOrg')
            AND ($wpdb->posts.post_parent = 0)
            AND ($wpdb->posts.post_status = 'publish')"
        );

        $view['all'] = preg_replace('/\(.+\)/U', '('.$total.')', $view['all']);
        $view['mine'] = preg_replace('/\(.+\)/U', '('.$mine.')', $view['mine']);
        $view['publish'] = preg_replace('/\(.+\)/U', '('.$publish.')', $view['publish']);

        return $view;
    }

    public function registerCustomRole()
    {
        add_role($this->role, __('Project Editor', APIPROJECTMANAGER_TEXTDOMAIN), get_role('editor')->capabilities);
    }
}
