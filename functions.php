<?php

include __DIR__ . "/includes/first_post_date.php";
include __DIR__ . "/includes/inc.input.php";
include __DIR__ . "/includes/author_subpages.php";
include __DIR__ . "/includes/image_sizes.php";
include __DIR__ . "/includes/search_modifications.php";


include __DIR__ . "/includes/customPostTypes/states.php";
include __DIR__ . "/includes/customPostTypes/people.php";

include __DIR__ . "/includes/customTaxonomies/job_title.php";
include __DIR__ . "/includes/customTaxonomies/zip_codes.php";
include __DIR__ . "/includes/customTaxonomies/party.php";


/**
 * Proper way to enqueue scripts and styles.
 */
function imrad_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('googleFonts', 'https://fonts.googleapis.com/css?family=Oswald:700|Ubuntu:400,400i,700&display=swap');
    wp_enqueue_script('theme', get_template_directory_uri() . '/theme.js', array("jquery"), null, true);

    wp_enqueue_script('fontAwesome', 'https://kit.fontawesome.com/0e434539c2.js');
}
add_action('wp_enqueue_scripts', 'imrad_scripts');

function imrad_theme_support()
{

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails', array('post', 'state', 'people')); // Posts and Movies
}

add_action('after_setup_theme', 'imrad_theme_support');

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
