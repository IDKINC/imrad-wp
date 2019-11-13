<?php

include __DIR__ . "/includes/imrad_import.php";

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
        'supports' => array('title', 'thumbnail', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'menu_icon' => 'dashicons-businessman',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 2,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'people',
        'query_var' => true,
        'rewrite' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'taxonomies' => ['title'],
    );
    register_post_type('people', $args);

}
add_action('init', 'people_post_type', 0);

function people_add_meta_boxes($post)
{
    add_meta_box('people_issue', __('Where Do They Stand', 'imrad'), 'people_build_issues_meta_box', 'people', 'normal', 'high');
    add_meta_box('people_state', __('State & District', 'imrad'), 'people_build_state_meta_box', 'people', 'normal', 'high');

    add_meta_box('people_vote', __('Vote History', 'imrad'), 'people_build_vote_meta_box', 'people', 'normal', 'high');
    add_meta_box('people_social', __('Social Links', 'imrad'), 'people_build_social_meta_box', 'people', 'side', 'high');

}
add_action('add_meta_boxes_people', 'people_add_meta_boxes');

function people_build_issues_meta_box($post)
{

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');
    echo "<h4>Always Include Links To Sources</h4>";
    // WP_Query arguments
    $args = array(
        'post_type' => array('issue'),
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
    );

// The Query
    $issues = new WP_Query($args);

// The Loop
    if ($issues->have_posts()) {
        while ($issues->have_posts()) {
            $issues->the_post();
            // do something
            $icon = get_post_meta(get_the_id(), 'issue_icon', true);
            $slug = get_post_field('post_name', get_post());
            $content = get_post_meta($post->ID, 'issue-' . $slug, true);

            echo sprintf('<h3><i class="%s"></i> - %s</h3>', $icon, get_the_title());


            $settings = array(
                'wpautop'       => true,
                'media_buttons' => true,
                'textarea_name' => 'issue-' . $slug,
                'textarea_rows' => 10);
            wp_editor($content, 'issue-' . $slug, $settings);

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata();

}

function people_save_issues($post_id)
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

    $args = array(
        'post_type' => array('issue'),
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
    );

// The Query
    $issues = new WP_Query($args);

// The Loop
    if ($issues->have_posts()) {
        while ($issues->have_posts()) {
            $issues->the_post();
            $slug = get_post_field('post_name', get_post());

            if (isset($_REQUEST['issue-' . $slug])) {
                update_post_meta($post_id, 'issue-' . $slug, wp_filter_post_kses($_POST['issue-' . $slug]));
            }

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata();

}

add_action('save_post_people', 'people_save_issues', 10, 2);

function people_build_state_meta_box($post)
{

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_state = get_post_meta($post->ID, 'state', true);
    $current_district = get_post_meta($post->ID, 'district', true);

    ?>

    <div class='inside'>
    <p>
        State: <select name="state" id="state">

    <option <?=(!$current_state ? "selected" : "")?> disabled>Select A State</option>

        <?php // WP_Query arguments
    $args = array(
        'post_type' => array('state'),
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
    );

// The Query
    $states = new WP_Query($args);

// The Loop
    if ($states->have_posts()) {
        while ($states->have_posts()) {
            $states->the_post();
            // do something
            $abbr = get_post_meta(get_the_id(), 'abbreviation', true);

            echo sprintf('<option %s value="%s">%s - %s</option>', ($current_state == $abbr ? "selected" : ""), $abbr, $abbr, get_the_title());

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata();?>

        </select>
	</p>


    <?php //District ?>
    <p>
        District(s):

        <?php // WP_Query arguments
    $districtArgs = array(
        'post_type' => array('district'),
        'order' => 'ASC',
        'orderby' => 'name',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'state',
                'value' => $current_state,
                'compare' => '=',
            ),
        ),
    );

// The Query
    $district = new WP_Query($districtArgs);

// The Loop
    if ($district->have_posts()) {
        while ($district->have_posts()) {
            $district->the_post();
            // do something
            $district_name = get_the_title();

            echo sprintf('<input type="checkbox" %s value="%s" id="%s"><label for="%s">%s</label>', ($current_district == $district_name ? "checked" : ""), $district_name, $district_name, $district_name, $district_name);

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata();?>

        </select>
        <br />
        <em>For Senators, Leave Blank</em>
	</p>




</div>



<?php

}

function people_build_vote_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_votes_with = get_post_meta($post->ID, 'votes_with', true);
    $current_votes_against = get_post_meta($post->ID, 'votes_against', true);

    ?>

    <div class='inside'>

    <p>
        Votes With Party: <input type="number" step="0.01" placeholder="" name="votes_with" value="<?php echo $current_votes_with; ?>" /> %
    </p>


    <p>
        Votes Against Party: <input type="number" step="0.01" placeholder="" name="votes_against" value="<?php echo $current_votes_against; ?>" /> %
    </p>


    <h3>Voting History Details</h3>
    <?php 


$settings = array(
    'wpautop'       => true,
    'media_buttons' => false,
    'textarea_name' => 'votes_details',
    'textarea_rows' => 10
);
wp_editor($content, 'votes_details"', $settings);


?>

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

function people_build_issue_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_abbreviation = get_post_meta($post->ID, 'abbreviation', true);
    $current_motto = get_post_meta($post->ID, 'motto', true);

    ?>

    <div class='inside'>


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

    if (isset($_REQUEST['state'])) {
        update_post_meta($post_id, 'state', sanitize_text_field($_POST['state']));
    }

    if (isset($_REQUEST['district'])) {
        update_post_meta($post_id, 'district', sanitize_text_field($_POST['district']));
    }
///////////
    // Stats //
    ///////////
    if (isset($_REQUEST['votes_with'])) {
        update_post_meta($post_id, 'votes_with', sanitize_text_field($_POST['votes_with']));
    }

    if (isset($_REQUEST['votes_against'])) {
        update_post_meta($post_id, 'votes_against', sanitize_text_field($_POST['votes_against']));
    }


    if (isset($_REQUEST['votes_details'])) {
        update_post_meta($post_id, 'votes_details', sanitize_text_field($_POST['votes_details']));
    }

///////////
    // Issue  //
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

// Banner Image for People

add_action('after_setup_theme', 'people_banner_setup');

function people_banner_setup()
{
    add_action('add_meta_boxes', 'people_banner_meta_box');
    add_action('save_post', 'people_banner_save');
}

function people_banner_meta_box()
{

    //on which post types should the box appear?
    $post_types = array('people');
    foreach ($post_types as $pt) {
        add_meta_box('people_banner_meta_box', __('Banner Image', 'imrad'), 'people_banner_meta_box_func', $pt, 'side', 'low');
    }
}

function people_banner_meta_box_func($post)
{

    //an array with all the images (ba meta key). The same array has to be in custom_postimage_meta_box_save($post_id) as well.
    $meta_keys = array('banner_image');

    foreach ($meta_keys as $meta_key) {
        $image_meta_val = get_post_meta($post->ID, $meta_key, true);
        ?>
        <div class="custom_logo_wrapper" id="<?php echo $meta_key; ?>_wrapper" style="margin-bottom:20px;">
            <img src="<?php echo ($image_meta_val != '' ? wp_get_attachment_image_src($image_meta_val)[0] : ''); ?>" style="width:100%;display: <?php echo ($image_meta_val != '' ? 'block' : 'none'); ?>" alt="">
            <a class="addimage button" onclick="custom_logo_add_image('<?php echo $meta_key; ?>');"><?php _e('Add Image', 'imrad');?></a><br>
            <a class="removeimage" style="color:#a00;cursor:pointer;display: <?php echo ($image_meta_val != '' ? 'block' : 'none'); ?>" onclick="custom_logo_remove_image('<?php echo $meta_key; ?>');"><?php _e('remove image', 'imrad');?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php }?>
    <script>
    function custom_logo_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        custom_logo_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select Banner', 'imrad');?>',
            button: {
                text: '<?php _e('Select Banner', 'imrad');?>'
            },
            multiple: false
        });
        custom_logo_uploader.on('select', function() {

            var attachment = custom_logo_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        custom_logo_uploader.on('open', function(){
            var selection = custom_logo_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        custom_logo_uploader.open();
        return false;
    }

    function custom_logo_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
wp_nonce_field('custom_logo_meta_box', 'custom_logo_meta_box_nonce');
}

function people_banner_save($post_id)
{

    if (!current_user_can('edit_posts', $post_id)) {return 'not permitted';}

    if (isset($_POST['custom_logo_meta_box_nonce']) && wp_verify_nonce($_POST['custom_logo_meta_box_nonce'], 'custom_logo_meta_box')) {

        //same array as in custom_postimage_meta_box_func($post)
        $meta_keys = array('banner_image');
        foreach ($meta_keys as $meta_key) {
            if (isset($_POST[$meta_key]) && intval($_POST[$meta_key]) != '') {
                update_post_meta($post_id, $meta_key, intval($_POST[$meta_key]));
            } else {
                update_post_meta($post_id, $meta_key, '');
            }
        }
    }
}

// Add a column to the edit post list
/**
 * Add new columns to the post table
 *
 * @param Array $columns - Current columns on the list post
 */
function add_new_columns($columns)
{
    unset($columns['date']);
    $columns['image'] = 'Image';

    $columns['state'] = 'State';
    $columns['district'] = 'District';
    $columns['job_title'] = 'Job Title';
    return $columns;
}

add_filter('manage_people_posts_columns', 'add_new_columns');

function people_columns_data($column, $post_id)
{
    switch ($column) {
        case "state":
            echo get_post_meta($post_id, $column, true);
            break;
        case "district":
            echo get_post_meta($post_id, $column, true);
            break;
        case "job_title":
            echo get_the_terms($post_id, 'job_title')[0]->name;
            break;
        case "image":
            if (get_the_post_thumbnail_url($post_id)) {

                echo sprintf("<img src='%s' alt='%s' />", get_the_post_thumbnail_url($post_id, 'headshot-small'), get_the_title($post_id));
            }
            break;

    }
}
add_action('manage_people_posts_custom_column', 'people_columns_data', 10, 2);

// Register the column as sortable
function people_sortable_columns($columns)
{
    $columns['state'] = 'State';
    $columns['district'] = 'District';
    $columns['job_title'] = 'Job Title';
    return $columns;
}
add_filter('manage_edit-people_sortable_columns', 'people_sortable_columns');

new ImradImport(array('Name', 'Party', 'State', 'District', 'Title', 'Website', 'Facebook', 'Twitter', 'VotesWith', 'VotesAgainst'), 'people');
