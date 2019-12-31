
<section class="banner dipshit-meter__container">
<h2>Evidence</h2>
</section>

<?php

$evidence = $people_obj->evidence;

if ($evidence) {
    ?>

<section class="evidence-grid">

<?php $currentUserVotes = getCurrentUserVotes(); ?>

<?php

    foreach ($evidence as $data) {

        $url           = esc_url_raw(get_post_meta($data->ID, 'evidence_url', true));
        $urlObj        = parse_url($url);
        $evidenceTitle = get_the_title($data->ID);
        $ogTitle       = sanitize_text_field(get_post_meta($data->ID, 'evidence_title', true));
        $ogImage       = esc_url_raw(get_post_meta($data->ID, 'evidence_image', true));
        $ogDesc        = sanitize_textarea_field(get_post_meta($data->ID, 'evidence_desc', true));

        ?>

        <div class="card evidence__card" id="evidence__<?=$data->ID?>">
        <a target="_blank" rel="noopener" class="evidence__card-content" href="<?=$url?>">
        <h2 class="evidence__title"><?=$evidenceTitle?></h2>

        <?php if ('twitter.com' == $urlObj['host']) {?>
            <section class="evidence__tweet-embed">
            <blockquote class="twitter-tweet">
                <a href="<?=$url?>">
                    <p class="evidence__title"><?=$ogTitle?></p>
                    <p class="evidence__description"><?=$ogDesc?></p>
                    <p class="evidence__source" title="<?=$url?>"><i class="fas fa-link"></i> via <?php echo $urlObj['host'] ?></p>
                </a>
            </blockquote>
            </section>
            <?php
} else {?>
        <section class="evidence__og-data">
        <img class="og__img" src=<?=$ogImage?>>
        <p class="evidence__title"><?=$ogTitle?></p>
        <p class="evidence__description"><?=$ogDesc?></p>
        <p class="evidence__source" title="<?=$url?>"><i class="fas fa-link"></i> via <?php echo $urlObj['host'] ?></p>
    </section>
        <?php }?>
        </a>

        <section class="evidence__voting-grid">
            <?php 
            
            $nonce = wp_create_nonce("vote_nonce");
            $voted = (array_key_exists(strval($data->ID), $currentUserVotes) ? $currentUserVotes[strval($data->ID)] : false); 
            
            ?>

            

            <?php
	$link = admin_url('admin-ajax.php?action=imrad_vote&vote=-1&evidence_id='.$data->ID.'&nonce='.$nonce);
	echo '<button class="button '. ($voted === "-1" ? "voted" : "") .'" data-voteButton data-voteMinus id="'.$data->ID.'-voteMinus" data-nonce="' . $nonce . '" data-evidence_id="' . $data->ID . '" href="' . $link . '">Not A Dipshit Move</button>'; ?>

                <h3 class="evidence__score"><span id="voteCount"><?= count(getVotes($data->ID))?></span> Votes</h3>

            <?php
	$link = admin_url('admin-ajax.php?action=imrad_vote&vote=1&evidence_id='.$data->ID.'&nonce='.$nonce);
	echo '<button class="button '. ($voted === "1" ? "voted" : "") .'" data-voteButton data-votePlus id="'.$data->ID.'-votePlus" data-nonce="' . $nonce . '" data-evidence_id="' . $data->ID . '" href="' . $link . '">Dipshit Move</button>'; ?>
        </section>
        </div>



        <?php

    }

    ?>

</section>


    <?php
} else {

    echo "<section class='evidence-grid'>";

    echo "<h1>No Evidence On File</h1>";
    get_template_part( "components/common/dipshitSubmitBox" );


    echo "</section>";
}

?>




<?php

function getVotes($evidenceId){


    global $wpdb;

    $table_name = $wpdb->prefix . 'evidence_votes';

    $results = $wpdb->get_results("SELECT * FROM {$table_name} WHERE evidenceid = {$evidenceId} AND vote IS NOT NULL");

    return $results;
}

function getCurrentUserVotes(){

    global $wpdb;
    $userId = get_current_user_id();
    $table_name = $wpdb->prefix . 'evidence_votes';
    $votesArray = array();



    $results = $wpdb->get_results("SELECT * FROM {$table_name} WHERE userid = {$userId} AND vote IS NOT NULL");

    foreach ($results as $result) {
        $votesArray[strval($result->evidenceid)] = $result->vote;
    }

    return $votesArray;
}