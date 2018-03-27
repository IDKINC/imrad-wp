<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		//
		// Post Content here
		//
		?>
<article id="<?php the_ID(); ?>">
		<?php
		echo sprintf("<h1><a href='%s'>%s</a></h1>", get_the_permalink(), get_the_title()); ?>
		<?php echo the_excerpt(); ?>
	</article>
	<hr />
<?php
	} // end while
} // end if
?>