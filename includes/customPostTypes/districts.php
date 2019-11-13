<?php

include __DIR__ . "/includes/imrad_import.php";
// States Custom Post Type

function district_post_type()
{

    $labels = array(
        'name' => _x('Districts', 'Post Type General Name', 'imrad'),
        'singular_name' => _x('District', 'Post Type Singular Name', 'imrad'),
        'menu_name' => __('Districts', 'imrad'),
        'name_admin_bar' => __('District', 'imrad'),
        'archives' => __('District Archives', 'imrad'),
        'attributes' => __('District Attributes', 'imrad'),
        'parent_item_colon' => __('Parent District:', 'imrad'),
        'all_items' => __('All Districts', 'imrad'),
        'add_new_item' => __('Add New District', 'imrad'),
        'add_new' => __('Add New', 'imrad'),
        'new_item' => __('New District', 'imrad'),
        'edit_item' => __('Edit District', 'imrad'),
        'update_item' => __('Update District', 'imrad'),
        'view_item' => __('View District', 'imrad'),
        'view_items' => __('View Districts', 'imrad'),
        'search_items' => __('Search District', 'imrad'),
        'not_found' => __('Not found', 'imrad'),
        'not_found_in_trash' => __('Not found in Trash', 'imrad'),
        'featured_image' => __('Flag', 'imrad'),
        'set_featured_image' => __('Set Flag', 'imrad'),
        'remove_featured_image' => __('Remove Flag', 'imrad'),
        'use_featured_image' => __('Use as flag', 'imrad'),
        'insert_into_item' => __('Insert into state', 'imrad'),
        'uploaded_to_this_item' => __('Uploaded to this state', 'imrad'),
        'items_list' => __('Districts list', 'imrad'),
        'items_list_navigation' => __('Districts list navigation', 'imrad'),
        'filter_items_list' => __('Filter states list', 'imrad'),
    );
    $args = array(
        'label' => __('District', 'imrad'),
        'description' => __('The Congressional Districts of the USA', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
		'public' => true,
		'menu_icon' => 'dashicons-grid-view',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 2,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'states',
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'taxonomies' => ['zip_codes'],

    );
    register_post_type('district', $args);

}
add_action('init', 'district_post_type', 0);

function district_add_meta_boxes($post)
{

    add_meta_box('district_state', __('District State', 'imrad'), 'district_build_state_meta_box', 'district', 'side', 'high');

}
add_action('add_meta_boxes_district', 'district_add_meta_boxes');


function district_build_state_meta_box($post){

    wp_nonce_field(basename(__FILE__), 'district_meta_box_nonce');

    $current_state = get_post_meta($post->ID, 'state', true);

    ?>

    <div class='inside'>
    <p>
        State: <select name="state" id="state">

    <option <?=(!$current_state ? "selected" : "") ?> disabled>Select A State</option>

        <?php // WP_Query arguments
    $args = array(
        'post_type' => array('state'),
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1
    );

// The Query
    $states = new WP_Query($args);

// The Loop
    if ($states->have_posts()) {
        while ($states->have_posts()) {
            $states->the_post();
            // do something
            $abbr = get_post_meta(get_the_id(), 'abbreviation', true);

    
    echo sprintf('<option %s value="%s">%s - %s</option>',($current_state == $abbr ? "selected": ""), $abbr, $abbr, get_the_title());

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata(); ?>

        </select>
	</p>

</div>


<?php

}



function district_save_meta_boxes_data($post_id)
{
    if (!isset($_POST['district_meta_box_nonce']) || !wp_verify_nonce($_POST['district_meta_box_nonce'], basename(__FILE__))) {
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

    if (isset($_REQUEST['state'])) {
        update_post_meta($post_id, 'state', strtoupper(sanitize_text_field($_POST['state'])));
	}


}
add_action('save_post_district', 'district_save_meta_boxes_data', 10, 2);


new ImradImport(array('Name','State','Zips'), 'district');
