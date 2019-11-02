<?php
add_action( 'init', 'create_zip_code_tax' );

function create_zip_code_tax() {

    $labels = array(
		'name'              => _x( 'Zip Codes', 'taxonomy general name', 'imrad' ),
		'singular_name'     => _x( 'Zip Code', 'taxonomy singular name', 'imrad' ),
		'search_items'      => __( 'Search Zip Codes', 'imrad' ),
		'all_items'         => __( 'All Zip Codes', 'imrad' ),
		'parent_item'       => __( 'Parent Zip Code', 'imrad' ),
		'parent_item_colon' => __( 'Parent Zip Code:', 'imrad' ),
		'edit_item'         => __( 'Edit Zip Code', 'imrad' ),
		'update_item'       => __( 'Update Zip Code', 'imrad' ),
		'add_new_item'      => __( 'Add New Zip Code', 'imrad' ),
		'new_item_name'     => __( 'New Zip Code Name', 'imrad' ),
        'menu_name'         => __( 'Zip Codes', 'imrad' ),
        'separate_items_with_commas' => __( 'Seperate Zip Codes with commas', 'imrad'),
        'choose_from_most_used' => __('Choose from the most used Zip Codes', 'imrad')
    );
    
    register_taxonomy(
        'zip_codes',
        null,
        array(
            'labels'            => $labels,
            'public' => true,
            'rewrite' => false,
            'hierarchical' => false,
            'update_count_callback' => '_update_post_term_count',
        )
    );

    register_taxonomy_for_object_type('zip_codes', 'state');
    register_taxonomy_for_object_type('zip_codes', 'people');
}