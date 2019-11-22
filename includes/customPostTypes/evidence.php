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
        'description' => __('Evidence of Dipshitery', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'thumbnail', 'revisions'),
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

function evidence_add_meta_boxes($post)
{

    add_meta_box('evidence_people', __('People', 'imrad'), 'evidence_build_person_meta_box', 'evidence', 'normal', 'high');
    add_meta_box('evidence_url', __('URL', 'imrad'), 'evidence_build_icon_meta_box', 'evidence', 'normal', 'high');
    add_meta_box('evidence_image', __('Data Scraped from URL', 'imrad'), 'evidence_build_image_meta_box', 'evidence', 'normal', 'high');

}
add_action('add_meta_boxes_evidence', 'evidence_add_meta_boxes');

function evidence_build_icon_meta_box($post)
{

    wp_nonce_field(basename(__FILE__), 'evidence_meta_box_nonce');

    $current_icon = get_post_meta($post->ID, 'evidence_url', true);

    ?>

    <div class='inside'>
    <p>
        URL:
        <input type="text" placeholder="e.g 'https://bbc.com/'" name="evidence_url" value="<?=$current_icon?>"/>
	</p>

</div>


<?php

}

function evidence_build_person_meta_box($post)
{

    wp_nonce_field(basename(__FILE__), 'evidence_meta_box_nonce');

    $current_person = get_post_meta($post->ID, 'evidence_people', true);

    ?>

    <div class='inside'>
    <p>
        Person:
        <select id="evidence_people" name="evidence_people" value="<?=$current_person?>">



<?php
$args = array(
        'post_type' => array('people'),
        'order' => 'ASC',
        'orderby' => 'name',
        'posts_per_page' => -1,
    );

// The Query
    $issues = new WP_Query($args);

// The Loop
    if ($issues->have_posts()) {
        while ($issues->have_posts()) {
            $issues->the_post();
            // do something
            echo "<option ".($current_person == get_the_id() ? "selected" : "") ." value='" . get_the_id() . "'>" . get_the_title() . "</option>";

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata();?>





	</p>

</div>


<?php

}

function evidence_build_image_meta_box($post)
{

    wp_nonce_field(basename(__FILE__), 'evidence_meta_box_nonce');

    $current_image_url = get_post_meta($post->ID, 'evidence_image', true);

    $current_desc = get_post_meta($post->ID, 'evidence_desc', true);
    $current_title = get_post_meta($post->ID, 'evidence_title', true);

    ?>

    <div class='inside'>
    <p>
        Link Title:
        <input id="evidence_title" name="evidence_title" value="<?= $current_title ?>">

    </p>
    <p>
        Link Desc:
        <textarea id="evidence_desc" name="evidence_desc">
            <?= $current_desc ?>
        </textarea>

    
    </p>
    <p>
        Image URL:
        <input id="evidence_image" name="evidence_image" value="<?= $current_image_url ?>">

        <?php if(isset($current_image_url)){
            echo "<img src='$current_image_url' width='200' />";} ?>
    </p>

</div>


<?php

}

function evidence_save_meta_boxes_data($post_id)
{
    if (!isset($_POST['evidence_meta_box_nonce']) || !wp_verify_nonce($_POST['evidence_meta_box_nonce'], basename(__FILE__))) {
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

    if (isset($_REQUEST['evidence_url'])) {
        update_post_meta($post_id, 'evidence_url', sanitize_text_field($_POST['evidence_url']));
    }

    if(isset($_REQUEST['evidence_people'])){

        update_post_meta($post_id, 'evidence_people', sanitize_text_field($_POST['evidence_people']));
    }
        
    

}
add_action('save_post_evidence', 'evidence_save_meta_boxes_data', 10, 2);

// Update OG:Image on Post Update

add_action('save_post_evidence', 'getOGImage', 10, 2);

function getOGImage($post_id, $post)
{
    $evidence_url = get_post_meta($post_id, 'evidence_url',true);
    print_r($evidence_url);
    $page_content = file_get_contents($evidence_url);

    $dom_obj = new DOMDocument();
    $dom_obj->loadHTML($page_content);
    $meta_img = null;
    $meta_desc = null;
    $meta_title = null;

    foreach ($dom_obj->getElementsByTagName('meta') as $meta) {

        if ($meta->getAttribute('property') == 'og:image') {

            $meta_img = $meta->getAttribute('content');
        }


        if ($meta->getAttribute('property') == 'og:description') {

            $meta_desc = $meta->getAttribute('content');
        }

        if ($meta->getAttribute('property') == 'og:title') {

            $meta_title = $meta->getAttribute('content');
        }
    }
    if(!is_null($meta_img)){

        update_post_meta($post_id, 'evidence_image', sanitize_text_field($meta_img));
    } 

    if(!is_null($meta_desc)){

        update_post_meta($post_id, 'evidence_desc', sanitize_text_field($meta_desc));
    } 

    if(!is_null($meta_title)){

        update_post_meta($post_id, 'evidence_title', sanitize_text_field($meta_title));
    } 

}