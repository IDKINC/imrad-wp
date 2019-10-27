<?php get_template_part("includes/inc.state"); ?>
<?php get_header();?>
<main>
	<article class="single single-state">


	<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();

		$post_id = get_the_id();
		
		$state = new State(get_post());

 
        //
        // Post Content here
        //
        ?>


<header class="state__header">
<?php $state->state_title() ?>


<section class="state__meta">

		<ul>
		<?php
	$state->state_meta();
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