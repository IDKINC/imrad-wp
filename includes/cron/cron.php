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

    if (!isset($_GET['bl_cron_hook'])) {
        return;
    }

    error_reporting(1);

    do_action('addCronTime');

    die();

});


function addCronTime(){

    $args = array(
        'post_type' => array('people'),
        'posts_per_page' => -1,
        'meta_key' => 'cron_last_updated',
        'orderby' => 'meta_value_num',
        'meta_type' => 'datetime',

        'order' => 'DESC'


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


function updateDipshitScore()
{

    //  Store timestamp on update. Get 5 oldest and then do the calculations. Run cron every 30 minutes or so.

    $args = array(
        'post_type' => array('people'),
        'posts_per_page' => 20,
        'meta_key' => 'cron_last_updated',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'


    );


    $people = new WP_Query($args);

    if ($people->have_posts()) {
        echo nl2br("\n==========\n");
        echo "People";
        echo nl2br("\n==========\n");

        while ($people->have_posts()) {
            $people->the_post();

            $personID = get_the_id();

            echo "\n==========";
            $metaArray = array();

            $args2 = array(
                'post_type' => array('evidence'),
                'posts_per_page' => -1,
                'meta_query' => array(array('key' => 'evidence_people', 'value' => get_the_id(), 'compare' => '=')),
            );

            $peopleEvidence = new WP_Query($args2);

            if ($peopleEvidence->have_posts()) {
                echo nl2br("\n- Evidence");

                while ($peopleEvidence->have_posts()) {
                    $peopleEvidence->the_post();
                    echo $personID;

                    echo "- " . $peopleEvidence->found_posts;
                    $metaArray['dipshit_score'] = $peopleEvidence->found_posts;
                    $metaArray['cron_last_updated'] = time();
                    $postarr = array(
                        'ID' => $personID,
                        'meta_input' => $metaArray,
                    );

                    wp_update_post($postarr);
                }
                echo nl2br("\n==========\n");

            } else {
                echo nl2br("\nRemoving Meta For: ". $personID . "\n");

                update_post_meta( $personID, 'cron_last_updated', time());
                delete_post_meta($personID, 'dipshit_score');
            }

            // echo nl2br("\n==========\n");


        }
    }
}

add_action('bl_cron_hook', 'updateDipshitScore');

if (!wp_next_scheduled('bl_cron_hook')) {
    wp_schedule_event(time(), 'sixty_seconds', 'bl_cron_hook');
}
