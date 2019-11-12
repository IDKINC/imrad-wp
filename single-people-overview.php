<?php global $post;
$person_id = $post->ID;

?>

<section class="banner dipshit-meter__container">
<?php get_template_part("components/common/dipshitMeter"); ?>
</section>

<section class="banner purple where-do-they-stand">

<h2>Where Do They Stand</h2>

<?php $args = array(
    'post_type' => array('issue'),
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'posts_per_page' => -1,
);

// The Query
$issues = new WP_Query($args);

// The Loop
if ($issues->have_posts()) {

    ?>
<section class="card-grid">

<?php

$issueResponses = array();
    while ($issues->have_posts()) {
        $issues->the_post();
        // do something
        $icon = get_post_meta(get_the_id(), 'issue_icon', true);
        $slug = get_post_field('post_name', get_the_id());
        $content = get_post_meta($person_id, 'issue-' . $slug, true);
        if ($content) {

            $content = apply_filters('the_content', $content);
            echo "<div class='card card--issue'>";
            echo sprintf('<h3><i class="%s"></i> %s</h3>', $icon, get_the_title());

            echo $content;
            echo "</div>";
            array_push($issueResponses, $slug);
        }
    }

    ?>

        </section>


        <?php


} else {
    // no posts found
}
            if (empty($issueResponses)) {
            
                echo "<h3>No Current Stance Data</h3>";
            
            }

// Restore original Post Data
wp_reset_postdata();
?>
</section>

