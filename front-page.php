<?php get_header();?>
<main>
<container class="banner purple site__intro">

<h1><?= bloginfo("name"); ?></h1>
<p>An online voting tool that identifies whether elected officials and candidates for public office are, in fact, dipshits.</p>

</container>

<?php get_template_part("components/maps/us_map"); ?>

</main>
<?php get_footer();?>