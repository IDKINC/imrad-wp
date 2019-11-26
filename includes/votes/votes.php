<?php

add_action('init', function () {

    if (!isset($_GET['vote'])) {
        return;
    }

    error_reporting(1);

    do_action('imrad_vote', get_current_user_id(), $_GET['evidenceId'], $_GET['vote'] ); 

    die();

});


global $imrad_votes_db_version;
$imrad_votes_db_version = '1.0';

function imrad_votes_install()
{
    global $wpdb;
    global $imrad_votes_db_version;

    $table_name = $wpdb->prefix . 'evidence_votes';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		timeUpdated datetime DEFAULT NULL,
		evidenceid mediumint(9) NOT NULL,
        userid mediumint(9) NOT NULL,
		vote bool DEFAULT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    add_option('imrad_votes_db_version', $imrad_votes_db_version);
}

function imrad_votes_install_data()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'evidence_votes';

    $wpdb->insert(
        $table_name,
        array(
            'time' => current_time('mysql'),
            'evidenceid' => 123,
            'userid' => 123,
            'vote' => true,
        )
    );
}

function imrad_vote($userId = null, $evidenceId = null, $vote = null)
{

    global $wpdb;

    print_r($userId);
    $table_name = $wpdb->prefix . 'evidence_votes';

    $results = $wpdb->get_row("SELECT * FROM {$table_name} WHERE userid = {$userId} AND evidenceid = {$evidenceId}");
    
    if (null !== $results) {

        switch(true){

            case $results->vote == $vote:
                $wpdb->update(
                    $table_name,
                    array(
                        'timeUpdated' => current_time('mysql'),
                        'evidenceid' => $evidenceId,
                        'userid' => $userId,
                        'vote' => null
                        
                    ),
                    array(
                        'userid' => $userId,
                        'evidenceid' => $evidenceId
                        )
                    
                );
                break;
            case $results->vote != $vote:
                $wpdb->update(
                    $table_name,
                    array(
                        'timeUpdated' => current_time('mysql'),
                        'userid' => $userId,
                        'evidenceid' => $evidenceId,
                        'vote' => $vote
                    ),
                    array(
                        'evidenceid' => $evidenceId,
                        'userid' => $userId
                        )
                );
                break;
            default:
                $wpdb->update(
                    $table_name,
                    array(
                        'time' => current_time('mysql'),
                        'userid' => $userId,
                        'evidenceid' => $evidenceId,
                        'vote' => $vote
                    ),
                    array(
                        'evidenceid' => $evidenceId,
                        'userid' => $userId
                        )
                );
                break;
        }

    } else {

        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time('mysql'),
                'userid' => $userId,
                'evidenceid' => $evidenceId,
                'vote' => $vote
            )
        );

    }

}

add_action('imrad_vote', 'imrad_vote', 10, 3);

add_action('after_switch_theme', 'imrad_votes_install', 10);
