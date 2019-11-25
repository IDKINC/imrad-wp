
<section class="banner dipshit-meter__container">
<h2>Evidence</h2>
</section>




<?php

$evidence = $people_obj->evidence;

if ($evidence) {?>

<section class="evidence-grid">

<?php

    foreach ($evidence as $data) {

        $url = sanitize_url(get_post_meta($data->ID, 'evidence_url', true));
        $urlObj = parse_url($url);
        $evidenceTitle = get_the_title($data->ID);
        $ogTitle = sanitize_text_field(get_post_meta($data->ID, 'evidence_title', true)); 
        $ogImage = sanitize_url(get_post_meta($data->ID, 'evidence_image', true));
        $ogDesc = sanitize_textarea_field(get_post_meta($data->ID, 'evidence_desc', true));

        ?>

        <div class="card evidence__card">
        <a target="_blank" rel="noopener" class="evidence__card-content" href="<?=$url?>">
        <h2 class="evidence__title"><?=$evidenceTitle?></h2>

        <?php if ($urlObj['host'] == 'twitter.com') {?>
            <section class="evidence__tweet-embed">
            <blockquote class="twitter-tweet"><a href="<?=$url?>">
        <p class="evidence__title"><?=$ogTitle?></p>
        <p class="evidence__description"><?=$ogDesc?> Read More &raquo;</p>
        <p class="evidence__source" title="<?=$url?>"><i class="fas fa-link"></i> via <?php echo $urlObj['host'] ?></p></a></blockquote>
            </section>
            <?php
} else {?>
        <section class="evidence__og-data">
        <img src=<?= $ogImage?>>
        <p class="evidence__title"><?=$ogTitle?></p>
        <p class="evidence__description"><?=$ogDesc?> Read More &raquo;</p>
        <p class="evidence__source" title="<?=$url?>"><i class="fas fa-link"></i> via <?php echo $urlObj['host'] ?></p>
    </section>
        <?php }?>
        </a>

        <section class="evidence__voting-grid">

            <button>Not A Dipshit Move</button>
            <h3 class="evidence__score">472 votes</h3>
            <button>Dipshit Move</button>
        </section>
        </div>



        <?php

    }

    ?>

</section>


    <?php
}

?>

