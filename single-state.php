<?php get_header();?>
<main>
	<article class="single single-state">


	<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();

        $post_id = get_the_id();

        //
        // Post Content here
        //
        ?>


<header class="state__header">
<?=sprintf("<h1 class='state__name'><a href='%s'>%s</a></h1>", get_the_permalink(), get_the_title());?>


<section class="state__meta">

		<ul>
		<?php
$population = array('meta_id' => 'population', 'label' => 'Population', 'icon' => 'fas faw fa-users', 'format' => true);
        $districts = array('meta_id' => 'districts_count', 'label' => '# of Districts', 'icon' => 'fas faw fa-border-none');

        $meta_keys = array($population, $districts);

        foreach ($meta_keys as $meta_key) {

			$meta = get_post_meta($post_id, $meta_key['meta_id']);

            if ($meta[0]) {

                echo sprintf("<li><i class='%s'></i>%s: %s</li>", $meta_key['icon'], $meta_key['label'], ($meta_key['format'] ? number_format($meta[0]) : $meta[0]));
            }

        }
        ?>
		</ul>
		</section>



<section class="state__images">
	<?php

        $flag = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'full');
        $stateSVG = wp_get_attachment_image_url(get_post_meta($post_id, 'state_image', true), 'full');

        if ($flag) {
            echo "<img class='state__flag' src='" . $flag . "'>";
        }
		// You wish to make $my_var available to the template part at `content-part.php`
		set_query_var( 'map_code', get_post_meta($post_id, 'abbreviation')[0] );
        get_template_part('components/maps/dynamicMap');

        ?>

		</section>


		<?=the_content();?>
</header>


<section class="state__representatives">

<h2>Current <?= get_the_title() ?> Representatives</h2>

	</section>


<?php
} // end while
} // end if
?>

</article>
	</main>
<?php get_footer();?>