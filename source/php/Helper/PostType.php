<?php

namespace ApiProjectManager\Helper;

class PostType
{
    public $postTypeName;
    public $nameSingular;
    public $namePlural;
    public $postTypeArgs;
    public $postTypeRestArgs;
    public $postTypeLabels;

    /* Class constructor */
    public function __construct($postTypeName, $nameSingular, $namePlural, $args = array(), $labels = array(), $restArgs = array())
    {
        // Set some important variables
        $this->postTypeName = $postTypeName;
        $this->nameSingular = $nameSingular;
        $this->namePlural = $namePlural;
        $this->postTypeArgs = $args;
        $this->postTypeRestArgs = $restArgs;
        $this->postTypeLabels = $labels;

        // Add action to register the post type, if the post type doesnt exist
        if (!post_type_exists($this->postTypeName)) {
            add_action('init', array(&$this, 'registerPostType'));
            add_action('rest_api_init', array($this, 'registerAcfMetadataInApi'));
            add_action('rest_prepare_' . $postTypeName, array($this, 'removeResponseKeys'), 10, 3);
        }
    }

    /* Method which registers the post type */
    public function registerPostType()
    {
        // We set the default labels based on the post type name and plural. We overwrite them with the given labels.
        $labels = array_merge(
            // Default
            array(
              'name'              => $this->namePlural,
              'singular_name'     => $this->nameSingular,
              'add_new'             => sprintf(__('Add new %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
              'add_new_item'        => sprintf(__('Add new %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
              'edit_item'           => sprintf(__('Edit %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
              'new_item'            => sprintf(__('New %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
              'view_item'           => sprintf(__('View %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
              'search_items'        => sprintf(__('Search %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->namePlural)),
              'not_found'           => sprintf(__('No %s found', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->namePlural)),
              'not_found_in_trash'  => sprintf(__('No %s found in trash', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->namePlural)),
              'parent_item_colon'   => sprintf(__('Parent %s:', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
              'menu_name'           => $this->namePlural,
            ),
            // Given labels
            $this->postTypeLabels
        );

        // Same principle as the labels. We set some default and overwite them with the given arguments.
        $args = array_merge(
            // Default
            array(
                'label'                 => $this->namePlural,
                'labels'                => $labels,
                'public'                => true,
                'show_ui'               => true,
                'supports'              => array('title', 'editor'),
                'show_in_nav_menus'     => true,
                '_builtin'              => false,
            ),
            // Given args
            $this->postTypeArgs
        );

        // Register the post type
        register_post_type($this->postTypeName, $args);
    }

    public function registerAcfMetadataInApi()
    {
        if (empty($this->postTypeArgs['show_in_rest'])) {
            return;
        }

        // Collect ACF field groups
        $groups = acf_get_field_groups(array('post_type' => $this->postTypeName));

        // List of field types to skip
        $skipTypes = array('tab', 'accordion');

        // Loop over field groups
        foreach ($groups as $key => $group) {
            // Get all fields
            $fields = acf_get_fields($group['key']);
            // Bail if empty
            if (empty($fields)) {
                continue;
            }
            // Loop over meta fields and register to rest response
            foreach ($fields as $key => $field) {
                if (!$field['name'] || in_array($field['type'], $skipTypes)) {
                    continue;
                }
                // Register meta as rest field
                register_rest_field(
                    $this->postTypeName,
                    $field['name'],
                    array(
                      'get_callback' => array($this, 'getCallback'),
                      'schema' => null,
                    )
                );
            }
        }
    }

    public function getCallback($object, $fieldName, $request)
    {
        if (function_exists('get_field')) {
            $fieldObj = get_field_object($fieldName);
            $type = $fieldObj['type'] ?? 'text';
            
            // Return different values based on field type
            switch ($type) {
              case 'true_false':
                $value = get_field($fieldName, $object['id']);
                break;
            case 'taxonomy':
                $value = !empty(get_field($fieldName, $object['id'])) ? get_field($fieldName, $object['id']) : null;              
                
                // Wrapping so that we allways return objects in an array
                $value = (!empty($value) && is_object($value)) ? array($value) : $value;
                break;

              default:
                // Return null if value is empty
                $value = !empty(get_field($fieldName, $object['id'])) ? get_field($fieldName, $object['id']) : null;
                break;
            }
            
            $value = apply_filters('api_project_manager/' . $this->postTypeName . '/rest_field', $value, $type, $fieldName);

            return $value;
        }

        $value = get_post_meta($object['id'], $fieldName, true);
        $value = apply_filters('api_project_manager/' . $this->postTypeName . '/rest_field', $value, $type, $fieldName);

        return $value;
    }

    public function removeResponseKeys($response, $post, $request)
    {
        // List of blacklisted keys
        $excludeKeys = $this->postTypeRestArgs['exclude_keys'] ?? array();
        // Remove blacklisted keys from rest response
        $response->data = array_diff_key($response->data, array_flip($excludeKeys));

        return $response;
    }

    /* Method to attach the taxonomy to the post type */
    public function addTaxonomy($taxonomySlug, $nameSingular, $namePlural, $args = array(), $labels = array())
    {
        if (!empty($nameSingular)) {
            // We need to know the post type name, so the new taxonomy can be attached to it.
            $postTypeName = $this->postTypeName;

            // Taxonomy properties
            $taxonomyLabels = $labels;
            $taxonomyArgs = $args;

            if (!taxonomy_exists($taxonomySlug)) {
                // Default labels, overwrite them with the given labels.
                $labels = array_merge(
                    // Default
                    array(
                        'name'              => $namePlural,
                        'singular_name'     => $nameSingular,
                        'search_items'      => sprintf(__('Search %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($namePlural)),
                        'all_items'         => sprintf(__('All %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($namePlural)),
                        'parent_item'       => sprintf(__('Parent %s:', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($nameSingular)),
                        'parent_item_colon' => sprintf(__('Parent %s:', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($nameSingular)) . ':',
                        'edit_item'         => sprintf(__('Edit %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($nameSingular)),
                        'update_item'       => sprintf(__('Update %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($nameSingular)),
                        'add_new_item'      => sprintf(__('Add new %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($nameSingular)),
                        'new_item_name'     => sprintf(__('New %s Name', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($nameSingular)),
                        'menu_name'         => $namePlural,
                    ),
                    // Given labels
                    $taxonomyLabels
                );

                // Default arguments, overwitten with the given arguments
                $args = array_merge(
                    array(
                      'label'                 => $namePlural,
                      'labels'                => $labels,
                      'public'                => true,
                      'show_ui'               => true,
                      'show_in_nav_menus'     => true,
                      '_builtin'              => false,
                      ),
                    $taxonomyArgs
                );
                // Add the taxonomy to the post type
                add_action(
                    'init',
                    function () use ($taxonomySlug, $postTypeName, $args) {
                        register_taxonomy($taxonomySlug, $postTypeName, $args);
                    }
                );
            } else {
                add_action(
                    'init',
                    function () use ($taxonomySlug, $postTypeName) {
                        register_taxonomy_for_object_type($taxonomySlug, $postTypeName);
                    }
                );
            }
        }
    }
}
