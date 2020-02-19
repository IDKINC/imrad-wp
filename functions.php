<?php

include get_template_directory() . "/includes/first_post_date.php";
include get_template_directory() . "/includes/inc.input.php";
include get_template_directory() . "/includes/author_subpages.php";
include get_template_directory() . "/includes/image_sizes.php";
include get_template_directory() . "/includes/search_modifications.php";
include get_template_directory() . "/includes/imrad_import.php";

include get_template_directory() . "/includes/cron/cron.php";
include get_template_directory() . "/includes/votes/votes.php";


include get_template_directory() . "/includes/customPostTypes/people.php";
include get_template_directory() . "/includes/customPostTypes/evidence.php";
include get_template_directory() . "/includes/customPostTypes/issues.php";
include get_template_directory() . "/includes/customPostTypes/states.php";
include get_template_directory() . "/includes/customPostTypes/districts.php";

include get_template_directory() . "/includes/customTaxonomies/job_title.php";
include get_template_directory() . "/includes/customTaxonomies/zip_codes.php";
include get_template_directory() . "/includes/customTaxonomies/party.php";

/**
 * Proper way to enqueue scripts and styles.
 */
function imrad_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('googleFonts', 'https://fonts.googleapis.com/css?family=Oswald:700|Martel:300,400,900&display=swap');
    wp_register_script('theme', get_template_directory_uri() . '/theme.js', array("jquery"), null, true);

   
    // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
    wp_localize_script( 'theme', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
    
    // enqueue jQuery library and the script you registered above
    wp_enqueue_script( 'theme' );

    wp_enqueue_script('fontAwesome', 'https://kit.fontawesome.com/0e434539c2.js');
    wp_enqueue_script( 'twitter-embed', 'https://platform.twitter.com/widgets.js',  true );
    wp_enqueue_script('d3', 'https://d3js.org/d3.v5.min.js');
}
add_action('wp_enqueue_scripts', 'imrad_scripts');

function imrad_admin_scripts()
{
    wp_enqueue_script('fontAwesome-backend', 'https://kit.fontawesome.com/0e434539c2.js');
}
add_action('admin_enqueue_scripts', 'imrad_admin_scripts');

function imrad_theme_support()
{

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails', array('post', 'state', 'people')); // Posts and Movies
}

add_action('after_setup_theme', 'imrad_theme_support');


function imrad_menus() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
  }
  add_action( 'init', 'imrad_menus' );

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Removing Default post Type

add_action('admin_menu', 'remove_default_post_type');

function remove_default_post_type()
{
    remove_menu_page('edit.php');
}

add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);

function remove_default_post_type_menu_bar($wp_admin_bar)
{
    $wp_admin_bar->remove_node('new-post');
}

add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

function remove_draft_widget()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

// Admin Only Dashboard

function imrad_restrict_admin()
{

    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    if (!current_user_can('manage_options')) {
        wp_redirect(home_url());
        exit;
    }
}

add_action('admin_init', 'imrad_restrict_admin');

function admin_default_page($redirect_to, $request, $user)
{

    if (isset($user->roles) && is_array($user->roles)) {
        //check for admins
        if (in_array('administrator', $user->roles)) {
            // redirect them to the default place
            return admin_url();
        } else {
            return home_url();
        }
    } else {
        return $redirect_to;
    }
    //todo check user role and redirect accordingly.
}

add_filter('login_redirect', 'admin_default_page', 10, 3);

function redirect_login_page()
{
    $login_page = home_url('/login/');
    $page_viewed = $_SERVER['REQUEST_URI'];
    
    if ($page_viewed == "/wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
    if ($page_viewed == "/wp-login.php?loggedout=true" && $_SERVER['REQUEST_METHOD'] == 'GET') {

        wp_redirect(home_url());
        exit;

    }
}
add_action('init', 'redirect_login_page');

/* Where to go if a login failed */
function custom_login_failed()
{
    $login_page = home_url('/login/');
    wp_redirect($login_page . '?login=failed');
    exit;
}
// add_action('wp_login_failed', 'custom_login_failed');

/* Where to go if any of the fields were empty */
function verify_user_pass($user, $username, $password)
{
    $login_page = home_url('/login/');
    if ($username == "" || $password == "") {
        wp_redirect($login_page . "?login=empty");
        exit;
    }
}
// add_filter('authenticate', 'verify_user_pass', 1, 3);

/* What to do on logout */
function logout_redirect()
{
    $login_page = home_url('/');
    wp_redirect($login_page . "?login=false");
    exit;
}
add_action('wp_logout','logout_redirect');

add_filter('show_admin_bar', function ($show) {
    if (current_user_can('subscriber')) {
        return false;
    }
    return $show;
});










function custom_posts_per_page( $query ) {

    if ( $query->is_post_type_archive('state') ) {
        set_query_var('posts_per_page', -1);
        $query->set('orderby', array('name' => 'ASC'));
    }

    if ( $query->is_post_type_archive('people') ) {
        set_query_var('posts_per_page', 50);
        $query->set('orderby', array('name' => 'ASC'));
    }
    }
    add_action( 'pre_get_posts', 'custom_posts_per_page' );