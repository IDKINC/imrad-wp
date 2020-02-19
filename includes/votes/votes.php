<?php

// add_action('init', function () {

//     if (!isset($_GET['vote'])) {
//         return;
//     }

//     error_reporting(1);

//     // do_action('imrad_vote', get_current_user_id(), $_GET['evidenceId'], $_GET['vote']);

//     die();

// });

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

function imrad_vote($userId, $evidenceId, $vote, $politicianid)
{

    global $wpdb;
    $table_name = $wpdb->prefix . 'evidence_votes';

    $results = $wpdb->get_row("SELECT * FROM {$table_name} WHERE userid = {$userId} AND evidenceid = {$evidenceId}");

    try {

        if (null !== $results) {

            switch (true) {

                // If The New Vote Is The Same As The Stored Vote, Set the vote to null
                case $results->vote == $vote:
                    $wpdb->update(
                        $table_name,
                        array(
                            'timeUpdated' => current_time('mysql'),
                            'evidenceid'  => $evidenceId,
                            'politicianid' => $politicianid,
                            'userid'      => $userId,
                            'vote'        => null,

                        ),
                        array(
                            'userid'     => $userId,
                            'evidenceid' => $evidenceId,
                        )

                    );
                    break;
                // If the new vote is not the same as the stored vote, update the vote to the new vote.
                case $results->vote != $vote:
                    $wpdb->update(
                        $table_name,
                        array(
                            'timeUpdated' => current_time('mysql'),
                            'userid'      => $userId,
                            'evidenceid'  => $evidenceId,
                            'politicianid' => $politicianid,
                            'vote'        => $vote,
                        ),
                        array(
                            'userid'     => $userId,
                            'evidenceid' => $evidenceId,
                        )
                    );
                    break;

                    default:
                break;
            }
            
        } else {
            
            // No Previously Recorded Votes.
            $wpdb->insert(
                $table_name,
                array(
                    'time'       => current_time('mysql'),
                    'userid'     => $userId,
                    'evidenceid' => $evidenceId,
                    'politicianid' => $politicianid,
                    'vote'       => $vote,
                )
            );

            return true;


        }

    } catch (Exception $e) {

        return false;
    }

}

add_action('imrad_vote', 'imrad_vote', 10, 3);

add_action('after_switch_theme', 'imrad_votes_install', 10);

// define the actions for the two hooks created, first for logged in users and the next for logged out users
add_action("wp_ajax_imrad_vote", "imrad_vote_ajax");
add_action("wp_ajax_nopriv_imrad_vote", "please_login");
// define the function to be fired for logged in users
function imrad_vote_ajax()
{

    global $wpdb;

    $table_name = $wpdb->prefix . 'evidence_votes';

    // nonce check for an extra layer of security, the function will exit if it fails
    if (!wp_verify_nonce($_REQUEST['nonce'], "vote_nonce")) {
        exit("Woof Woof Woof");
    }

    // fetch like_count for a post, set it to 0 if it's empty, increment by 1 when a click is registered

    $evidenceId = $_REQUEST["evidence_id"];
    $politicianid = get_post_meta($evidenceId, 'evidence_people', true);
    $userId = get_current_user_id();
    $vote   = $_REQUEST["vote"];

    $voteResults = imrad_vote($userId, $evidenceId, $vote, $politicianid);

    // If above action fails, result type is set to 'error' and like_count set to old value, if success, updated to new_like_count
    if (false === $voteResults) {
        $result['type'] = "error";

    } else {
        $result['type'] = "success";
        $result['vote_count'] =   $wpdb->get_var("SELECT COUNT(*) FROM {$table_name} WHERE evidenceid = {$evidenceId} AND vote IS NOT NULL");
    }

    // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result = json_encode($result);
        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        
    }
    // don't forget to end your scripts with a die() function - very important
    die();
}
// define the function to be fired for logged out users
function please_login()
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        $result['type'] = "login";
        $result = json_encode($result);
        echo $result;
    } else {
        header("Location: " . home_url( "/login"));
        
    }
    die();
}
