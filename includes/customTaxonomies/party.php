<?php
add_action('init', 'create_party_tax');

function create_party_tax()
{

    $labels = array(
        'name' => _x('Political Parties', 'taxonomy general name', 'imrad'),
        'singular_name' => _x('Party', 'taxonomy singular name', 'imrad'),
        'search_items' => __('Search Parties', 'imrad'),
        'all_items' => __('All Parties', 'imrad'),
        'parent_item' => __('Parent Party', 'imrad'),
        'parent_item_colon' => __('Parent Party:', 'imrad'),
        'edit_item' => __('Edit Party', 'imrad'),
        'update_item' => __('Update Party', 'imrad'),
        'add_new_item' => __('Add New Party', 'imrad'),
        'new_item_name' => __('New  Party Name', 'imrad'),
        'menu_name' => __('Parties', 'imrad'),
        'separate_items_with_commas' => __('Seperate Parties with commas', 'imrad'),
        'choose_from_most_used' => __('Choose from the most used Parties', 'imrad'),
    );

    register_taxonomy(
        'party',
        null,
        array(
            'labels' => $labels,
            'public' => true,
            'rewrite' => false,
            'hierarchical' => false,
            'update_count_callback' => '_update_post_term_count',
        )
    );

    register_taxonomy_for_object_type('party', 'people');
}

add_action('party_add_form_fields', 'add_party_color_field', 10, 2);
function add_party_color_field($taxonomy)
{?>
    <div class="form-field term-group">
        <label for="party_color"><?php _e('Party Color', 'imrad');?></label>
        <input class="postform" type="color" id="party_color" name="party_color">
    </div>
<?php
}

add_action('party_edit_form_fields', 'edit_party_color_field', 10, 2);

function edit_party_color_field($term, $taxonomy)
{
    // get current group
    $current_color = get_term_meta($term->term_id, 'party_color', true);

    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="party_color"><?php _e('Party Color', 'my_plugin');?></label></th>
        <td>
            <div class="form-field term-group">
                <input class="postform" value="#<?=$current_color?>" type="color" id="party_color" name="party_color">
            </div>
        </td>
    </tr><?php
}

add_action( 'edited_party', 'update_party_meta', 10, 2 );
add_action( 'created_party', 'update_party_meta', 10, 2 );

function update_party_meta( $term_id, $tt_id ){

    if( isset( $_POST['party_color'] ) && ’ !== $_POST['party_color'] ){
        $group = sanitize_title( $_POST['party_color'] );
        update_term_meta( $term_id, 'party_color', $group );
    }
}


add_filter('manage_edit-party_columns', 'add_feature_group_column' );

function add_feature_group_column( $columns ){
    $columns['party_color'] = __( 'Party Color', 'imrad' );
    return $columns;
}


add_filter('manage_party_custom_column', 'add_feature_group_column_content', 10, 3 );

function add_feature_group_column_content( $content, $column_name, $term_id ){

    if( $column_name !== 'party_color' ){
        return $content;
    }

    $term_id = absint( $term_id );
    $party_color = get_term_meta( $term_id, 'party_color', true );

    if( !empty( $party_color ) ){
        $content =  "<span class='swatch' style='width:1em;height:1em;display: inline-block;vertical-align: middle;background: #" . $party_color . "; '></span> #" . $party_color ;
    }

    return $content;
}


add_filter( 'manage_edit-party_sortable_columns', 'add_feature_group_column_sortable' );

function add_feature_group_column_sortable( $sortable ){
    $sortable[ 'party_color' ] = 'party_color';
    return $sortable;
}