<?php


add_action( 'after_setup_theme', 'imrad_image_sizes' );
function imrad_image_sizes() {
    add_image_size( 'headshot', 360, 500, true ); 
    add_image_size( 'headshot-icon', 100, 100, true ); 
}