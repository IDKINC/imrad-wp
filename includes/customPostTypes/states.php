<?php

include __DIR__ . "/includes/imrad_import.php";
// States Custom Post Type

function state_post_type()
{

    $labels = array(
        'name' => _x('States', 'Post Type General Name', 'imrad'),
        'singular_name' => _x('State', 'Post Type Singular Name', 'imrad'),
        'menu_name' => __('States', 'imrad'),
        'name_admin_bar' => __('State', 'imrad'),
        'archives' => __('State Archives', 'imrad'),
        'attributes' => __('State Attributes', 'imrad'),
        'parent_item_colon' => __('Parent State:', 'imrad'),
        'all_items' => __('All States', 'imrad'),
        'add_new_item' => __('Add New State', 'imrad'),
        'add_new' => __('Add New', 'imrad'),
        'new_item' => __('New State', 'imrad'),
        'edit_item' => __('Edit State', 'imrad'),
        'update_item' => __('Update State', 'imrad'),
        'view_item' => __('View State', 'imrad'),
        'view_items' => __('View States', 'imrad'),
        'search_items' => __('Search State', 'imrad'),
        'not_found' => __('Not found', 'imrad'),
        'not_found_in_trash' => __('Not found in Trash', 'imrad'),
        'featured_image' => __('Flag', 'imrad'),
        'set_featured_image' => __('Set Flag', 'imrad'),
        'remove_featured_image' => __('Remove Flag', 'imrad'),
        'use_featured_image' => __('Use as flag', 'imrad'),
        'insert_into_item' => __('Insert into state', 'imrad'),
        'uploaded_to_this_item' => __('Uploaded to this state', 'imrad'),
        'items_list' => __('States list', 'imrad'),
        'items_list_navigation' => __('States list navigation', 'imrad'),
        'filter_items_list' => __('Filter states list', 'imrad'),
    );
    $args = array(
        'label' => __('State', 'imrad'),
        'description' => __('The United States of America', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
		'public' => true,
		'menu_icon' => 'dashicons-admin-site',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'states',
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'taxonomies' => ['zip_codes'],

    );
    register_post_type('state', $args);

}
add_action('init', 'state_post_type', 0);

function state_add_meta_boxes($post)
{
    add_meta_box('state_info', __('State Info', 'fort-overwatch'), 'state_build_info_meta_box', 'state', 'normal', 'high');
    add_meta_box('state_stats', __('State Stats', 'fort-overwatch'), 'state_build_stats_meta_box', 'state', 'side', 'high');

}
add_action('add_meta_boxes_state', 'state_add_meta_boxes');

function state_build_stats_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'state_meta_box_nonce');

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

function state_build_info_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'state_meta_box_nonce');

    $current_abbreviation = get_post_meta($post->ID, 'abbreviation', true);
    $current_motto = get_post_meta($post->ID, 'motto', true);

    ?>

    <div class='inside'>
    <p>
	Abbreviation: <input type="text" maxlength="2" placeholder="e.g. NM" name="abbreviation" value="<?php echo $current_abbreviation; ?>" />
	</p>
	
	<p>
	State Motto: <input type="text" placeholder="e.g. Land of Enchantment" name="motto" value="<?php echo $current_motto; ?>" />
    </p>

</div> <?php

}

function state_save_meta_boxes_data($post_id)
{
    if (!isset($_POST['state_meta_box_nonce']) || !wp_verify_nonce($_POST['state_meta_box_nonce'], basename(__FILE__))) {
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

}
add_action('save_post_state', 'state_save_meta_boxes_data', 10, 2);

// start Logo Image

// add_action('after_setup_theme', 'custom_logo_setup');


function custom_logo_setup()
{
    add_action('add_meta_boxes', 'custom_logo_meta_box');
    add_action('save_post', 'custom_logo_meta_box_save');
}

function custom_logo_meta_box()
{

    //on which post types should the box appear?
    $post_types = array('state');
    foreach ($post_types as $pt) {
        add_meta_box('custom_logo_meta_box', __('State Image SVG', 'imrad'), 'custom_logo_meta_box_func', $pt, 'side', 'low');
    }
}

function custom_logo_meta_box_func($post)
{

    //an array with all the images (ba meta key). The same array has to be in custom_postimage_meta_box_save($post_id) as well.
    $meta_keys = array('state_image');

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
            title: '<?php _e('select image', 'imrad');?>',
            button: {
                text: '<?php _e('select image', 'imrad');?>'
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

function custom_logo_meta_box_save($post_id)
{

    if (!current_user_can('edit_posts', $post_id)) {return 'not permitted';}

    if (isset($_POST['custom_logo_meta_box_nonce']) && wp_verify_nonce($_POST['custom_logo_meta_box_nonce'], 'custom_logo_meta_box')) {

        //same array as in custom_postimage_meta_box_func($post)
        $meta_keys = array('state_image');
        foreach ($meta_keys as $meta_key) {
            if (isset($_POST[$meta_key]) && intval($_POST[$meta_key]) != '') {
                update_post_meta($post_id, $meta_key, intval($_POST[$meta_key]));
            } else {
                update_post_meta($post_id, $meta_key, '');
            }
        }
    }
}

// END Logo on Projects
new ImradImport(array('Name','Abbreviation','Population','Motto'), 'state');
