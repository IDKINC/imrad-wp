<?php get_template_part("includes/inc.people"); ?>

<?php get_header();?>
<main>
<container class="banner purple site__intro">

<h1><?= bloginfo("name"); ?></h1>
<p>An online voting tool that identifies whether elected officials and candidates for public office are, in fact, dipshits.</p>

</container>

<?php get_template_part("components/maps/us_map"); ?>

<div class="separator">OR</div>

<?php get_template_part("components/common/searchByZip"); ?>


<container class="banner purple biggest-dipshits">
<h2>Biggest Dipshits</h2>
<?php 
$args = array(
			'post_type' => array('people'),
			'posts_per_page' => 10,

		 );
         $biggestDipshits = new WP_Query($args);
         
         
         


if ($biggestDipshits->have_posts()) {
	echo "<section class='card-grid'>";
    while ($biggestDipshits->have_posts()) {
		$biggestDipshits->the_post();

		$rep = new Person(get_post());

		echo $rep->personCard();
		
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