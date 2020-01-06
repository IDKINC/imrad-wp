<?php get_template_part("includes/inc.people"); ?>

<?php get_header();?>
<main>
<container class="banner white site__intro">

<img src="<?=get_template_directory_uri()?>/assets/svg/imrad-logo.svg">
<p>An online voting tool that identifies whether elected officials and candidates for public office are, in fact, dipshits.</p>
<h3>Let's get these dipshits out of office, together.</h3>
<div class="buttons">
	<a class="button">Sign Up</a>
	<a class="button button--alt">Login</a>
</div>

</container>

<section class="grid grid--three">
	
	<?php get_template_part("components/common/searchByZip"); ?>
	<div class="separator vertical">OR</div>
	<?php get_template_part("components/maps/us_map"); ?>

</section>

<container class="banner white biggest-dipshits">
<h2>Dipshit Leaderboard</h2>
<?php 
$args = array(
			'post_type' => array('people'),
			'posts_per_page' => 10,
			'meta_key' => 'dipshit_score',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'

		 );
         $biggestDipshits = new WP_Query($args);
         
         
         


if ($biggestDipshits->have_posts()) {
	echo "<section class='person__leaderboard'>";
    while ($biggestDipshits->have_posts()) {
		$biggestDipshits->the_post();

		$rep = new Person(get_post());

		echo $rep->personLeaderboard();
		
	}
	echo "</section>";

	}

	else {

		echo "No Current Reps";
	}

    wp_reset_postdata();
         
         
         
         ?>


</container>

</main>
<?php get_footer();?>