<?php get_header();?>
<main class="content page">

<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		//
		// Post Content here
		//
		?>
<container class="banner purple page__title">
		<?php
		echo sprintf("<h1><a href='%s'>%s</a></h1>", get_the_permalink(), get_the_title()); ?>
		</container>
		<section class="page__content">
		<?php echo the_content(); ?>
		</section>
<?php
	} // end while
} // end if
?>
	</main>
<?php get_footer();?>