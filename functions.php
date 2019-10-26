<?php 

include __DIR__ . "/includes/first_post_date.php";
include __DIR__ . "/includes/inc.input.php";

// wp_enqueue_script("theme", __DIR__."/theme.js", array("jquery")); 

/**
 * Proper way to enqueue scripts and styles.
 */
function blank2_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'googleFonts', 'https://fonts.googleapis.com/css?family=Oswald:700|Ubuntu:400,400i,700&display=swap');
    wp_enqueue_script( 'theme', get_template_directory_uri() . '/theme.js', array("jquery"), null, true );

    wp_enqueue_script('fontAwesome', 'https://kit.fontawesome.com/0e434539c2.js');
}
add_action( 'wp_enqueue_scripts', 'blank2_scripts' );


?>