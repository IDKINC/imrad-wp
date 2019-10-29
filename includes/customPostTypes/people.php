<?php

// Peoples Custom Post Type

function people_post_type()
{

    $labels = array(
        'name' => _x('People', 'Post Type General Name', 'imrad'),
        'singular_name' => _x('People', 'Post Type Singular Name', 'imrad'),
        'menu_name' => __('People', 'imrad'),
        'name_admin_bar' => __('People', 'imrad'),
        'archives' => __('Directory', 'imrad'),
        'attributes' => __('People Attributes', 'imrad'),
        'parent_item_colon' => __('Parents:', 'imrad'),
        'all_items' => __('All People', 'imrad'),
        'add_new_item' => __('Add New Person', 'imrad'),
        'add_new' => __('Add New', 'imrad'),
        'new_item' => __('New Person', 'imrad'),
        'edit_item' => __('Edit Person', 'imrad'),
        'update_item' => __('Update Person', 'imrad'),
        'view_item' => __('View Person', 'imrad'),
        'view_items' => __('View People', 'imrad'),
        'search_items' => __('Search People', 'imrad'),
        'not_found' => __('Not found', 'imrad'),
        'not_found_in_trash' => __('Not found in Trash', 'imrad'),
        'featured_image' => __('Headshot', 'imrad'),
        'set_featured_image' => __('Set Headshot', 'imrad'),
        'remove_featured_image' => __('Remove Headshot', 'imrad'),
        'use_featured_image' => __('Use as Headshot', 'imrad'),
        'insert_into_item' => __('Insert into people', 'imrad'),
        'uploaded_to_this_item' => __('Uploaded to this person', 'imrad'),
        'items_list' => __('Directory', 'imrad'),
        'items_list_navigation' => __('Directory navigation', 'imrad'),
        'filter_items_list' => __('Filter directory', 'imrad'),
    );
    $args = array(
        'label' => __('People', 'imrad'),
        'description' => __('Elected Officials in the USA', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'menu_icon' => 'dashicons-businessman',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 7,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'people',
        'query_var' => true,
        'rewrite' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    );
    register_post_type('people', $args);

}
add_action('init', 'people_post_type', 0);

function people_add_meta_boxes($post)
{
    add_meta_box('people_info', __('People Info', 'imrad'), 'people_build_info_meta_box', 'people', 'normal', 'high');
    add_meta_box('people_stats', __('People Stats', 'imrad'), 'people_build_stats_meta_box', 'people', 'side', 'high');
    add_meta_box('people_social', __('People Social Links', 'imrad'), 'people_build_social_meta_box', 'people', 'side', 'high');

}
add_action('add_meta_boxes_people', 'people_add_meta_boxes');

function people_build_stats_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_population = get_post_meta($post->ID, 'population', true);
    $current_districts_count = get_post_meta($post->ID, 'districts_count', true);

    ?>

    <div class='inside'>
    <p>
        Population: <input type="number" placeholder="e.g. 2,123,412" name="population" value="<?php echo $current_population; ?>" />
	</p>

	<p>
        # of Districts: <input type="number" placeholder="e.g. 12" name="districts_count" value="<?php echo $current_districts_count; ?>" />
    </p>


</div>



<?php

}

function people_build_social_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_website = get_post_meta($post->ID, 'website', true);
    $current_facebook = get_post_meta($post->ID, 'facebook', true);
    $current_twitter = get_post_meta($post->ID, 'twitter', true);

    ?>

    <div class='inside'>
    <p>
        Website: <input type="text" placeholder="e.g. https://IsMyRepADipshit.com" name="website" value="<?php echo $current_website; ?>" />
    </p>
    <p>
        Facebook Username: <input type="text" placeholder="e.g. DipShitRep" name="facebook" value="<?php echo $current_facebook; ?>" />
    </p>
    <p>
        Twitter Username: <input type="text" placeholder="e.g. DipShitRep" name="twitter" value="<?php echo $current_twitter; ?>" />
	</p>


</div>



<?php

}

function people_build_info_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_abbreviation = get_post_meta($post->ID, 'abbreviation', true);
    $current_motto = get_post_meta($post->ID, 'motto', true);

    ?>

    <div class='inside'>
    <p>
	Abbreviation: <input type="text" maxlength="2" placeholder="e.g. NM" name="abbreviation" value="<?php echo $current_abbreviation; ?>" />
	</p>

	<p>
	People Motto: <input type="text" placeholder="e.g. Land of Enchantment" name="motto" value="<?php echo $current_motto; ?>" />
    </p>

</div> <?php

}

function people_save_meta_boxes_data($post_id)
{
    if (!isset($_POST['people_meta_box_nonce']) || !wp_verify_nonce($_POST['people_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;

    }
///////////
    // Stats //
    ///////////
    if (isset($_REQUEST['population'])) {
        update_post_meta($post_id, 'population', sanitize_text_field($_POST['population']));
    }

    if (isset($_REQUEST['districts_count'])) {
        update_post_meta($post_id, 'districts_count', sanitize_text_field($_POST['districts_count']));
    }

///////////
    // Info  //
    ///////////

    if (isset($_REQUEST['abbreviation'])) {
        update_post_meta($post_id, 'abbreviation', strtoupper(sanitize_text_field($_POST['abbreviation'])));
    }

    if (isset($_REQUEST['motto'])) {
        update_post_meta($post_id, 'motto', sanitize_text_field($_POST['motto']));
    }



    // Social Links

    if (isset($_REQUEST['website'])) {
        update_post_meta($post_id, 'website', sanitize_text_field($_POST['website']));
    }

    if (isset($_REQUEST['facebook'])) {
        update_post_meta($post_id, 'facebook', sanitize_text_field($_POST['facebook']));
    }


    if (isset($_REQUEST['twitter'])) {
        update_post_meta($post_id, 'twitter', sanitize_text_field($_POST['twitter']));
    }
}
add_action('save_post_people', 'people_save_meta_boxes_data', 10, 2);
