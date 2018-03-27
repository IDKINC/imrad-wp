<?php 


// wp_enqueue_script("theme", __DIR__."/theme.js", array("jquery")); 

/**
 * Proper way to enqueue scripts and styles.
 */
function blank2_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_script( 'theme', get_template_directory_uri() . '/theme.js', array("jquery"), null, true );
}
add_action( 'wp_enqueue_scripts', 'blank2_scripts' );


?>