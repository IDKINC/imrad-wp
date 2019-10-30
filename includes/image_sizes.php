<?php


add_action( 'after_setup_theme', 'imrad_image_sizes' );
function imrad_image_sizes() {
    add_image_size( 'headshot', 500, 500, true ); 
}