<?php 
/**
 * Get First Post Date Function
 *
 * @param  $format Type of date format to return, using PHP date standard, default Y-m-d
 * @return Date of first post
 */
function first_post_date($format = "Y") {
 // Setup get_posts arguments
 $ax_args = array(
 'numberposts' => -1,
 'post_status' => 'publish',
 'order' => 'ASC'
 );

 // Get all posts in order of first to last
 $ax_get_all = get_posts($ax_args);

 // Extract first post from array
 $ax_first_post = $ax_get_all[0];

 // Assign first post date to var
 $ax_first_post_date = $ax_first_post->post_date;

 // return date in required format
 $output = date($format, strtotime($ax_first_post_date));

 return $output;
} 

?>