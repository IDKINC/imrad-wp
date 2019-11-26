<?php

add_filter('cron_schedules', 'example_add_cron_interval');

function example_add_cron_interval($schedules)
{
    $schedules['sixty_seconds'] = array(
        'interval' => 60,
        'display' => esc_html__('Every 60 Seconds'),
    );

    return $schedules;
}

add_action('init', function () {

    if (!isset($_GET['addCronTime'])) {
        return;
    }

    error_reporting(1);

    do_action('addCronTime');

    die();

});


add_action('init', function () {

    if (!isset($_GET['updateDipshitScore'])) {
        return;
    }

    if($_GET['updateDipshitScore'] == true){

        return;

    }

    $personToUpdate = null;

    if(isset($_GET[id])){

        $personToUpdate = sanitize_text_field(  $_GET[id] );

    }

    do_action('updateDipshitScore', array(10, $personToUpdate));
    wp_redirect(admin_url() .'?updateDipshitScore=true');


});


function addCronTime(){

    $args = array(
        'post_type' => array('people'),
        'posts_per_page' => -1,



    );

    $people = new WP_Query($args);

    if ($people->have_posts()) {
        echo "<br/>==========<br/>";
        echo "People";
        echo "<br/>==========<br/>";

        while ($people->have_posts()) {
            $people->the_post();

            $personID = get_the_id();

            echo "<br/>==========<br/>";
            echo get_the_id();
            echo "<br/>";
            echo get_post_meta( get_the_id(), 'cron_last_updated', true );
            echo "<br/>==========<br/>";
            update_post_meta( $personID, 'cron_last_updated', time());

                }
            }
}

add_action('addCronTime', 'addCronTime');


function updateDipshitScore($count=(-1), $id=null)
{

    //  Store timestamp on update. Get 5 oldest and then do the calculations. Run cron every 30 minutes or so.
    $args = array();
    if(!is_null($id)){

        $args = array(
            'post_type' => array('people'),
            
            'p' => $id
            
        );

    } else {

        
        $args = array(
            'post_type' => array('people'),
            'posts_per_page' => $count,
            'meta_key' => 'cron_last_updated',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
            
            
        );
        
    }

    $people = new WP_Query($args);

    if ($people->have_posts()) {
       

        while ($people->have_posts()) {
            $people->the_post();

            $personID = get_the_id();

            
            $metaArray = array();

            $args2 = array(
                'post_type' => array('evidence'),
                'posts_per_page' => -1,
                'meta_query' => array(array('key' => 'evidence_people', 'value' => get_the_id(), 'compare' => '=')),
            );

            $peopleEvidence = new WP_Query($args2);

            if ($peopleEvidence->have_posts()) {

                while ($peopleEvidence->have_posts()) {
                    $peopleEvidence->the_post();

                    $metaArray['dipshit_score'] = $peopleEvidence->found_posts;
                    $metaArray['cron_last_updated'] = time();
                    $postarr = array(
                        'ID' => $personID,
                        'meta_input' => $metaArray,
                    );

                    wp_update_post($postarr);
                }

            } else {

                update_post_meta( $personID, 'cron_last_updated', time());
                delete_post_meta($personID, 'dipshit_score');
            }

            // echo nl2br("\n==========\n");


        }
    }
}

add_action('updateDipshitScore', 'updateDipshitScore', 10, 2);

if (!wp_next_scheduled('updateDipshitScore')) {
    wp_schedule_event(time(), 'sixty_seconds', 'updateDipshitScore', array(20));
}



function imrad_admin_notice() {
	
	$screen = get_current_screen();
	
		
		if (isset($_GET['updateDipshitScore'])) {
			
			if ($_GET['updateDipshitScore'] === 'true') : ?>
				
				<div class="notice notice-success is-dismissible">
					<p><?php _e('Dipshit Scores Updated.', 'imrad'); ?></p>
				</div>
				
			<?php else : ?>
				
				<div class="notice notice-error is-dismissible">
					<p><?php _e('Error Updating Dipshit Scores.', 'imrad'); ?></p>
				</div>
				
			<?php endif;
			
		}
}
add_action('admin_notices', 'imrad_admin_notice');