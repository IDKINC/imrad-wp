<?php get_header();?>
<main>
<container class="banner purple site__intro">

<h1><?= bloginfo("name"); ?></h1>
<p>An online voting tool that identifies whether elected officials and candidates for public office are, in fact, dipshits.</p>

</container>

<?php get_template_part("components/maps/us_map"); ?>

<div class="separator">OR</div>

<?php get_template_part("components/common/searchByZip"); ?>

</main>
<?php get_footer();?>