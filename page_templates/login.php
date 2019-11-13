<?php
/*
Template Name: Login
 */

?>

<?php get_header();?>

<main>
<container class="banner login">
    <section class="login__card">
<h1>Login</h1>

<?php 

$loginArgs = array();

wp_login_form($loginArgs); ?>

<hr />

<a href="#" class="need">Need An Account?</a>

</section>
</container>

	</main>

<?php get_footer();?>