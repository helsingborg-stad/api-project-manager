<?php

namespace ApiProjectManager\Helper;

class Taxonomy
{
    public $taxonomyName;
    public $nameSingular;
    public $namePlural;
    public $taxonomyArgs;
    public $taxonomyLabels;
    public $taxonomyRestArgs;

    public $postTypeName;

    public function __construct($taxonomyName, $nameSingular, $namePlural, $postTypeName = '', $taxonomyArgs = array(), $taxonomyLabels = array(), $taxonomyRestArgs = array())
    {
        // Set some important variables
        $this->taxonomyName = $taxonomyName;
        $this->nameSingular = $nameSingular;
        $this->namePlural = $namePlural;
        $this->taxonomyArgs = $taxonomyArgs;
        $this->taxonomyLabels = $taxonomyLabels;
        $this->taxonomyRestArgs = $restArgs;


        $this->postTypeName = $postTypeName;

        // Add action to register the post type, if the post type doesnt exist
        if (!taxonomy_exists($taxonomyName) && !empty($postTypeName)) {
            add_action('init', array(&$this, 'registerTaxonomy'));
            add_action('rest_api_init', array($this, 'registerAcfMetadataInApi'));
            add_action('rest_prepare_' . $taxonomyName, array($this, 'removeResponseKeys'), 10, 3);
        } else {
            if (!empty($postTypeName)) {
                add_action(
                    'init',
                    function () use ($taxonomyName, $postTypeName) {
                        register_taxonomy_for_object_type($taxonomyName, $postTypeName);
                    }
                );
            }
        }
    }

    public function registerTaxonomy()
    {
        // We need to know the post type name, so the new taxonomy can be attached to it.
        $postTypeName = $this->postTypeName;

        // Taxonomy properties
        $taxonomyLabels = $this->taxonomyLabels;
        $taxonomyArgs = $this->taxonomyArgs;

        // Default labels, overwrite them with the given labels.
        $this->taxonomyLabels = array_merge(
            // Default
            array(
                'name'              => $this->namePlural,
                'singular_name'     => $this->nameSingular,
                'search_items'      => sprintf(__('Search %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->namePlural)),
                'all_items'         => sprintf(__('All %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->namePlural)),
                'parent_item'       => sprintf(__('Parent %s:', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
                'parent_item_colon' => sprintf(__('Parent %s:', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)) . ':',
                'edit_item'         => sprintf(__('Edit %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
                'update_item'       => sprintf(__('Update %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
                'add_new_item'      => sprintf(__('Add new %s', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
                'new_item_name'     => sprintf(__('New %s Name', APIPROJECTMANAGER_TEXTDOMAIN), strtolower($this->nameSingular)),
                'menu_name'         => $this->namePlural,
            ),
            // Given labels
            $taxonomyLabels
        );

        // Default arguments, overwitten with the given arguments
        $this->taxonomyArgs = array_merge(
            array(
                'label'                 => $this->namePlural,
                'labels'                => $this->taxonomyLabels,
                'public'                => true,
                'show_ui'               => true,
                'show_in_nav_menus'     => true,
                '_builtin'              => false,
                ),
            $taxonomyArgs
        );

        register_taxonomy($this->taxonomyName, $postTypeName, $this->taxonomyArgs);
    }

    public function registerAcfMetadataInApi()
    {
        if (empty($this->taxonomyArgs['show_in_rest'])) {
            return;
        }
        
        // Collect ACF field groups
        $groups = acf_get_field_groups(array('taxonomy' => $this->taxonomyName));

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
                    $this->taxonomyName,
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
                    $value = get_field($fieldName, 'term_' . $object['id']);
                    break;
                case 'taxonomy':
                    $value = !empty(get_field($fieldName, 'term_' . $object['id'])) ? get_field($fieldName, 'term_' . $object['id']) : null;
                
                    // Wrapping so that we allways return objects in an array
                    $value = (!empty($value) && is_object($value)) ? array($value) : $value;
                    break;
                default:
                    // Return null if value is empty
                    $value = !empty(get_field($fieldName, 'term_' . $object['id'])) ? get_field($fieldName, 'term_' . $object['id']) : null;
                    break;
            }
            
            $value = apply_filters('api_project_manager/taxonomy/' . $this->taxonomyName . '/rest_field', $value, $type, $fieldName);

            return $value;
        }

        $value = get_term_meta($object['id'], $fieldName, true);
        $value = apply_filters('api_project_manager/taxonomy/' . $this->taxonomyName . '/rest_field', $value, $type, $fieldName);

        return $value;
    }

    public function removeResponseKeys($response, $post, $request)
    {
        // List of blacklisted keys
        $excludeKeys = array('link', 'meta');
        if (!empty($this->taxonomyRestArgs['exclude_keys']) && is_array($this->taxonomyRestArgs['exclude_keys'])) {
            $excludeKeys = array_merge($excludeKeys, $this->taxonomyRestArgs['exclude_keys']);
        }

        $excludeKeys = apply_filters('ApiProjectManager/Helper/Taxonomy::removeResponseKeys', $excludeKeys, $post, $request, $this);

        // Remove blacklisted keys from rest response
        $response->data = array_diff_key($response->data, array_flip($excludeKeys));

        return $response;
    }
}
