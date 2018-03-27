<?php $custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );?>


<div class='logo'>
	<?php if($image): ?>
	<a href="<?php echo get_site_url('/'); ?>" title="<?php bloginfo( 'name' ); ?>">
		<img src="<?php echo $image[0];?>">
	</a>
	<?php else: ?>
		<a href="<?php echo get_site_url('/'); ?>" title="<?php bloginfo( 'name' ); ?>">
		<h1><?php echo bloginfo("name"); ?></h1>
	</a>
	<?php endif; ?>

</div>