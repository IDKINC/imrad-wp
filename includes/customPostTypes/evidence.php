<?php


// Evidence Custom Post Type

function evidence_post_type()
{

    $labels = array(
        'name' => _x('Evidence', 'Post Type General Name', 'imrad'),
        'singular_name' => _x('Evidence', 'Post Type Singular Name', 'imrad'),
        'menu_name' => __('Evidence', 'imrad'),
        'name_admin_bar' => __('Evidence', 'imrad'),
        'archives' => __('Evidence Archives', 'imrad'),
        'attributes' => __('Evidence Attributes', 'imrad'),
        'parent_item_colon' => __('Parent Evidence:', 'imrad'),
        'all_items' => __('All Evidence', 'imrad'),
        'add_new_item' => __('Add New Evidence', 'imrad'),
        'add_new' => __('Add New', 'imrad'),
        'new_item' => __('New Evidence', 'imrad'),
        'edit_item' => __('Edit Evidence', 'imrad'),
        'update_item' => __('Update Evidence', 'imrad'),
        'view_item' => __('View Evidence', 'imrad'),
        'view_items' => __('View Evidence', 'imrad'),
        'search_items' => __('Search Evidence', 'imrad'),
        'not_found' => __('Not found', 'imrad'),
        'not_found_in_trash' => __('Not found in Trash', 'imrad'),
        'featured_image' => __('Flag', 'imrad'),
        'set_featured_image' => __('Set Flag', 'imrad'),
        'remove_featured_image' => __('Remove Flag', 'imrad'),
        'use_featured_image' => __('Use as flag', 'imrad'),
        'insert_into_item' => __('Insert into state', 'imrad'),
        'uploaded_to_this_item' => __('Uploaded to this state', 'imrad'),
        'items_list' => __('Evidence list', 'imrad'),
        'items_list_navigation' => __('Evidence list navigation', 'imrad'),
        'filter_items_list' => __('Filter states list', 'imrad'),
    );
    $args = array(
        'label' => __('Evidence', 'imrad'),
        'description' => __('The Congressional Evidence of the USA', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
		'public' => true,
		'menu_icon' => 'dashicons-visibility',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 2,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'states',
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'taxonomies' => [],

    );
    register_post_type('evidence', $args);

}
add_action('init', 'evidence_post_type', 0);


