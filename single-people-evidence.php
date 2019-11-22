
<section class="banner dipshit-meter__container">
<h2>Evidence</h2>
</section>




<?php

$evidence = $people_obj->evidence;

if ($evidence) {?>

<section class="evidence-grid">

<?php

    foreach ($evidence as $data) {

        $url = get_post_meta( $data->ID, 'evidence_url', true);

        ?>

        <div class="card evidence__card">
        <a target="_blank" rel="noopener" class="evidence__card-content" href="<?=$url ?>">
        <h2 class="evidence__title">"<?=get_the_title($data->ID)?>"</h2>
        <section class="evidence__og-data">
        <img src=<?= get_post_meta($data->ID, 'evidence_image', true );?>>
        <p class="evidence__title"><?= get_post_meta($data->ID, 'evidence_title', true); ?></p>
        <p class="evidence__description"><?= get_post_meta($data->ID, 'evidence_desc', true); ?> Read More &raquo;</p> 
        <p class="evidence__source" title="<?=$url?>"><i class="fas fa-link"></i> via <?php echo parse_url($url)['host'] ?></p>
    </section>
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

