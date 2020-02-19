<?php get_template_part("includes/inc.people"); ?>

<?php get_header();?>
<main>
<container class="banner white site__intro">

<img class="intro__logo" src="<?=get_template_directory_uri()?>/assets/svg/imrad-logo.svg">
<p>A voter education platform that identifies whether elected officials and candidates for public office are, in fact, dipshits.</p>
<h3>Let's Get These Dipshits Out Of Office, Together.</h3>
<?php if(!is_user_logged_in(  )):?>
<div class="buttons">
	<a class="button" href="<?= home_url( "/register" )?>">Sign Up</a>
	<a class="button button--alt" href="<?= home_url( "/login" )?>">Login</a>
</div>
<?php endif; ?>

</container>

<section class="grid grid--three">
	
	<?php get_template_part("components/common/searchByZip"); ?>
	<div class="separator vertical">OR</div>
	<?php get_template_part("components/maps/us_map"); ?>

</section>

<container class="banner white biggest-dipshits">
<h1>Dipshit Leaderboard</h1>

<section class="grid grid--two dipshit-leaderboard">
<?php 
$args = array(
			'post_type' => array('people'),
			'posts_per_page' => 5,
			'meta_key' => 'dipshit_score',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'

		 );
         $biggestDipshits = new WP_Query($args);
         
         
         


if ($biggestDipshits->have_posts()) {
	echo "<section class='person__leaderboard'>";
	echo "<h2>Biggest Dipshits</h2>";
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
         
         
         
        

$args = array(
			'post_type' => array('people'),
			'posts_per_page' => 5,
			'meta_key' => 'dipshit_score',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'

		 );
         $leastDipshit = new WP_Query($args);
         
         
         


if ($leastDipshit->have_posts()) {
	echo "<section class='person__leaderboard'>";
	echo "<h2>Least Shitty</h2>";

    while ($leastDipshit->have_posts()) {
		$leastDipshit->the_post();

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
         
</section>

</container>

</main>
<?php get_footer();?>