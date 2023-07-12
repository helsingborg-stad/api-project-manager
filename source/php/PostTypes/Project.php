<?php

namespace ApiProjectManager\PostTypes;

class Project
{
    public static $postType = 'project';

    public function __construct()
    {
        add_action('init', array($this, 'registerPostType'), 9);
        add_action('acf/save_post', array($this, 'saveLastStatusWithPositiveRange'), 5, 1);
        add_action('acf/save_post', array($this, 'inheritChallengeTermsOnSave'));
        add_filter('acf/load_value/name=challenge_category', array($this, 'resetCategoryField'), 10, 3);

        add_filter(
            'acf/validate_value',
            array($this, 'conditionallyRequireField'),
            10,
            3
        );
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

        $exposedPostMetaKeys = ['previous_status_progress_value', 'previous_status'];

        $postType = new \ApiProjectManager\Helper\PostType(
            'project',
            __('Project', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Projects', APIPROJECTMANAGER_TEXTDOMAIN),
            $args,
            array(),
            $restArgs
        );

        $postType->registerRestPostMeta($exposedPostMetaKeys);

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

        // Category
        $postType->addTaxonomy(
            'challenge_category',
            __('Category', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Categories', APIPROJECTMANAGER_TEXTDOMAIN),
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
                'show_ui' => in_array('project_editor', wp_get_current_user()->roles) ? false : true,
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

        //  Innovation traits
        $postType->addTaxonomy(
            'innovation-potential',
            __('Innovation potential', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Innovation potentials', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_rest' => false,
                'show_in_quick_edit' => true,
                'meta_box_cb' => false,
            )
        );

        // Förväntad effekt
        $postType->addTaxonomy(
            'expected-impact',
            __('Expected Impact', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Expected Impact', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_rest' => false,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            )
        );

        // Verksamhet
        $postType->addTaxonomy(
            'operation',
            __('Operation', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Operations', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_rest' => false,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            )
        );

        // Verksamhetsområde
        $postType->addTaxonomy(
            'operation-domain',
            __('Operation Domain', APIPROJECTMANAGER_TEXTDOMAIN),
            __('Operation Domains', APIPROJECTMANAGER_TEXTDOMAIN),
            array(
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_rest' => false,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            )
        );
    }

    /**
     * Resets category field to avoid confusion of inherited term
     */
    public function resetCategoryField($value, $postId, $field)
    {
        if (!function_exists('get_current_screen')) {
            return $value;
        }

        $currentScreen = get_current_screen();
        if (
            empty($currentScreen)
            || $currentScreen->parent_base !== 'edit'
            || $currentScreen->post_type !== self::$postType
            || empty(get_field('challenge', $postId))
        ) {
            return $value;
        }

        return null;
    }

    /**
     * Inherit term from Challenge post type
     */
    public function inheritChallengeTermsOnSave($postId)
    {
        if (get_post_type($postId) !== self::$postType) {
            return;
        }

        $challenge = get_field('challenge', $postId);
        $termFromTaxField = get_field('challenge_category', $postId);
        $existingTerms = get_the_terms($postId, 'challenge_category');

        // Inherit term from challenge post type
        if (!empty($challenge)) {
            $challengeTerms = get_the_terms($challenge->ID, 'challenge_category');
            $challengeTerm = !empty($challengeTerms) ? $challengeTerms[0] : false;

            // Set term
            if (
                count($existingTerms) !== 1 && $challengeTerm
                || in_array($challengeTerm, $existingTerms) && $challengeTerm
            ) {
                wp_set_post_terms($postId, array($challengeTerm->term_id), false);
            }

            // Set ACF field
            if (
                empty($termFromTaxField) && $challengeTerm
                || $challengeTerm && $termFromTaxField !== $challengeTerm
            ) {
                update_field('challenge_category', $challengeTerm, $postId);
            }

            return;
        }

        // Make sure we have the correct and only 1 term
        if (
            !empty($termFromTaxField) && count($existingTerms) !== 1
            || !empty($termFromTaxField) && in_array($termFromTaxField, $existingTerms)
        ) {
            wp_set_post_terms($postId, array($termFromTaxField->term_id), false);
        }
    }

    /**
     * Logs the previous status progress value if new status has negative progress value (-1)
     */
    public function saveLastStatusWithPositiveRange($postId)
    {
        $acfKeys = array(
            'status' => 'field_5e8d9b71fc34b'
        );

        if (
            get_post_type($postId) !== self::$postType
            || !isset($_POST['acf'])
            || !isset($_POST['acf'][$acfKeys['status']])
        ) {
            return;
        }

        $newStatus = get_term((int) $_POST['acf'][$acfKeys['status']], 'status');

        if (!$newStatus instanceof \WP_Term) {
            return;
        }

        $newStatusRange = get_field('progress_value', 'term_' . $newStatus->term_id);

        if ((int) $newStatusRange === -1) {
            $prevStatus = get_field('status', $postId);

            if ($prevStatus instanceof \WP_Term) {
                $prevProgressValue = get_field('progress_value', 'term_' . $prevStatus->term_id);

                if ((int) $prevProgressValue > -1) {
                    update_post_meta($postId, 'previous_status', $prevStatus->term_id);
                    update_post_meta($postId, 'previous_status_progress_value', (int) $prevProgressValue);
                }
            }
            return;
        }

        delete_post_meta($postId, 'previous_status');
        delete_post_meta($postId, 'previous_status_progress_value');
    }

    /**
     * Require a value for project_lessons_learned if the current status set requires it.
     *
     * @param mixed $valid Whether or not the value is valid (boolean) or a custom error message (string).
     * @param string $value The field value.
     * @param array $field The field array containing all settings.
     *
     * @return mixed
     */
    public function conditionallyRequireField($valid, $value, $field)
    {
        if ($valid !== true) {
            return $valid;
        }

        if ('project_lessons_learned' === $field['name']) {
            $statusTermId = !empty($_POST['acf']['field_5e8d9b71fc34b']) ? $_POST['acf']['field_5e8d9b71fc34b'] : 0;
            $status = get_term($statusTermId, 'status');

            if (term_exists($status)) {
                $lessonsLearnedIsObligatory = (bool) get_field('lessons_learned_is_obligatory', $status);
                if ($lessonsLearnedIsObligatory && empty($value)) {
                    return sprintf(__('Lessons learned is a required field for initiatives with the status "%s".'), $status->name);
                }
            }
        }

        return $valid;
    }
}
