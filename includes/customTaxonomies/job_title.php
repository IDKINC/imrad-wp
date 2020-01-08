<?php
add_action( 'init', 'create_people_title_tax' );

function create_people_title_tax() {

    $labels = array(
		'name'              => _x( 'Job Titles', 'taxonomy general name', 'imrad' ),
		'singular_name'     => _x( 'Title', 'taxonomy singular name', 'imrad' ),
		'search_items'      => __( 'Search Titles', 'imrad' ),
		'all_items'         => __( 'All Titles', 'imrad' ),
		'parent_item'       => __( 'Parent Title', 'imrad' ),
		'parent_item_colon' => __( 'Parent Title:', 'imrad' ),
		'edit_item'         => __( 'Edit Title', 'imrad' ),
		'update_item'       => __( 'Update Title', 'imrad' ),
		'add_new_item'      => __( 'Add New Title', 'imrad' ),
		'new_item_name'     => __( 'New Title Name', 'imrad' ),
        'menu_name'         => __( 'Titles', 'imrad' ),
        'separate_items_with_commas' => __( 'Seperate Titles with commas', 'imrad'),
        'choose_from_most_used' => __('Chomes from the most used titles', 'imrad')
    );
    
    register_taxonomy(
        'job_title',
        'people',
        array(
            'labels'            => $labels,
            'public' => true,
            'rewrite' => false,
            'hierarchical' => true,
            'update_count_callback' => '_update_post_term_count',
        )
    );
}



add_action( 'create_term', 'add_sub_titles_tax', 10, 3);


function add_sub_titles_tax($term_id, $tt_id , $taxonomy){

    if($taxonomy != "job_title"){
        return;
    }

    $term = get_term_by( 'id', $term_id, $taxonomy );

    if(!$term->parent){

        // If Term Isn't A Child Of Anything

        wp_insert_term( "Candidate", "job_title", array("parent" => $term_id, "slug" => $term->slug . "-candidate") );
        wp_insert_term( "In Office", "job_title", array("parent" => $term_id, "slug" => $term->slug ."-in-office") );
        wp_insert_term( "Former", "job_title", array("parent" => $term_id, "slug" => $term->slug . "-former") );


    } else { return;}



}