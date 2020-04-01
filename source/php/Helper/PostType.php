<?php

namespace ApiProjectManager\Helper;

class PostType
{
    public $postTypeName;
    public $nameSingular;
    public $namePlural;
    public $postTypeArgs;
    public $postTypeLabels;

    /* Class constructor */
    public function __construct($postTypeName, $nameSingular, $namePlural, $args = array(), $labels = array())
    {
        // Set some important variables
        $this->postTypeName = $postTypeName;
        $this->nameSingular = $nameSingular;
        $this->namePlural = $namePlural;
        $this->postTypeArgs = $args;
        $this->postTypeLabels = $labels;

        // Add action to register the post type, if the post type doesnt exist
        if (!post_type_exists($this->postTypeName)) {
            add_action('init', array(&$this, 'registerPostType'));
        }

        // Listen for the save post hook
        // $this->save();
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

    // /* Attaches meta boxes to the post type */
    // public function add_meta_box($title, $fields = array(), $context = 'normal', $priority = 'default')
    // {
    //     if (!empty($title)) {
    //         // We need to know the Post Type name again
    //         $postTypeName = $this->postTypeName;

    //         // Meta variables
    //         $box_id         = strtolower(str_replace(' ', '_', $title));
    //         $box_title      = ucwords(str_replace('_', ' ', $title));
    //         $box_context    = $context;
    //         $box_priority   = $priority;

    //         // Make the fields global
    //         global $custom_fields;
    //         $custom_fields[$title] = $fields;

    //         add_action(
    //             'admin_init',
    //             function () use ($box_id, $box_title, $postTypeName, $box_context, $box_priority, $fields) {
    //                 add_meta_box(
    //                     $box_id,
    //                     $box_title,
    //                     function ($post, $data) {
    //                         global $post;

    //                         // Nonce field for some validation
    //                         wp_nonce_field(plugin_basename(__FILE__), 'custom_post_type');

    //                         // Get all inputs from $data
    //                         $custom_fields = $data['args'][0];

    //                         // Get the saved values
    //                         $meta = get_post_custom($post->ID);

    //                         // Check the array and loop through it
    //                         if (!empty($custom_fields)) {
    //                             /* Loop through $custom_fields */
    //                             foreach ($custom_fields as $label => $type) {
    //                                 $field_id_name  = strtolower(str_replace(' ', '_', $data['id'])) . '_' . strtolower(str_replace(' ', '_', $label));

    //                                 echo '<label for="' . $field_id_name . '">' . $label . '</label><input type="text" name="custom_meta[' . $field_id_name . ']" id="' . $field_id_name . '" value="' . $meta[$field_id_name][0] . '" />';
    //                             }
    //                         }
    //                     },
    //                     $postTypeName,
    //                     $box_context,
    //                     $box_priority,
    //                     array( $fields )
    //                         );
    //             }
    //                 );
    //     }
    // }

    // /* Listens for when the post type being saved */
    // public function save()
    // {
    //     // Need the post type name again
    //     $postTypeName = $this->postTypeName;

    //     add_action(
    //         'save_post',
    //         function () use ($postTypeName) {
    //             // Deny the wordpress autosave function
    //             if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    //                 return;
    //             }

    //             if (!wp_verify_nonce($_POST['custom_post_type'], plugin_basename(__FILE__))) {
    //                 return;
    //             }

    //             global $post;

    //             if (isset($_POST) && isset($post->ID) && get_post_type($post->ID) == $postTypeName) {
    //                 global $custom_fields;

    //                 // Loop through each meta box
    //                 foreach ($custom_fields as $title => $fields) {
    //                     // Loop through all fields
    //                     foreach ($fields as $label => $type) {
    //                         $field_id_name  = strtolower(str_replace(' ', '_', $title)) . '_' . strtolower(str_replace(' ', '_', $label));

    //                         update_post_meta($post->ID, $field_id_name, $_POST['custom_meta'][$field_id_name]);
    //                     }
    //                 }
    //             }
    //         }
    //         );
    // }
}
