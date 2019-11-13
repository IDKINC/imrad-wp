<?php


// Issues Custom Post Type

function issue_post_type()
{

    $labels = array(
        'name' => _x('Issues', 'Post Type General Name', 'imrad'),
        'singular_name' => _x('Issue', 'Post Type Singular Name', 'imrad'),
        'menu_name' => __('Issues', 'imrad'),
        'name_admin_bar' => __('Issue', 'imrad'),
        'archives' => __('Issue Archives', 'imrad'),
        'attributes' => __('Issue Attributes', 'imrad'),
        'parent_item_colon' => __('Parent Issue:', 'imrad'),
        'all_items' => __('All Issues', 'imrad'),
        'add_new_item' => __('Add New Issue', 'imrad'),
        'add_new' => __('Add New', 'imrad'),
        'new_item' => __('New Issue', 'imrad'),
        'edit_item' => __('Edit Issue', 'imrad'),
        'update_item' => __('Update Issue', 'imrad'),
        'view_item' => __('View Issue', 'imrad'),
        'view_items' => __('View Issues', 'imrad'),
        'search_items' => __('Search Issue', 'imrad'),
        'not_found' => __('Not found', 'imrad'),
        'not_found_in_trash' => __('Not found in Trash', 'imrad'),
        'featured_image' => __('Flag', 'imrad'),
        'set_featured_image' => __('Set Flag', 'imrad'),
        'remove_featured_image' => __('Remove Flag', 'imrad'),
        'use_featured_image' => __('Use as flag', 'imrad'),
        'insert_into_item' => __('Insert into state', 'imrad'),
        'uploaded_to_this_item' => __('Uploaded to this state', 'imrad'),
        'items_list' => __('Issues list', 'imrad'),
        'items_list_navigation' => __('Issues list navigation', 'imrad'),
        'filter_items_list' => __('Filter states list', 'imrad'),
    );
    $args = array(
        'label' => __('Issue', 'imrad'),
        'description' => __('The Congressional Issues of the USA', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
		'public' => true,
		'menu_icon' => 'dashicons-lightbulb',
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
    register_post_type('issue', $args);

}
add_action('init', 'issue_post_type', 0);

function issue_add_meta_boxes($post)
{

    add_meta_box('issue_icon', __('Issue Icon', 'imrad'), 'issue_build_icon_meta_box', 'issue', 'side', 'high');

}
add_action('add_meta_boxes_issue', 'issue_add_meta_boxes');


function issue_build_icon_meta_box($post){

    wp_nonce_field(basename(__FILE__), 'issue_meta_box_nonce');

    $current_icon = get_post_meta($post->ID, 'issue_icon', true);

    ?>

    <div class='inside'>
    <p>
        Font Awesome Icon: 
        <input type="text" placeholder="e.g 'fab fa-accessible-icon'" name="issue_icon" value="<?=$current_icon?>"/>
	</p>

</div>


<?php

}



function issue_save_meta_boxes_data($post_id)
{
    if (!isset($_POST['issue_meta_box_nonce']) || !wp_verify_nonce($_POST['issue_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;

    }


///////////
    // Info  //
    ///////////

    if (isset($_REQUEST['issue_icon'])) {
        update_post_meta($post_id, 'issue_icon', sanitize_text_field($_POST['issue_icon']));
	}


}
add_action('save_post_issue', 'issue_save_meta_boxes_data', 10, 2);


