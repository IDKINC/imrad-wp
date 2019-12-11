<?php 



add_action('init', 'imrad_custom_registration');

function imrad_custom_registration(){

    if ( ! isset( $_POST['djie3duhb3edub3u'] ) || ! wp_verify_nonce( $_POST['djie3duhb3edub3u'], 'create_user_form_submit')){

        return;
         
    } else {
        $username = sanitize_text_field($_POST['user_name']);
        $email = sanitize_text_field($_POST['user_email']);
        $password = $_POST['user_password'];
        $user_id = username_exists( $username );
        if ( !$user_id and email_exists($email) == false ) {

            // do some code to validate password how ever you want it.

            $user_id = wp_create_user( $username, $password, $email );
            $stuff = array('ID'=>$user_id,'another_user_field'=>'something');
            wp_update_user($stuff); // first name, last name etc
         } else {
             return false; //username exists already
         }
     }
}