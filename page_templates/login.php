<?php
/*
Template Name: Login
 */

?>

<?php get_header();

if($_POST) 
{ 

global $wpdb; 

//We shall SQL escape all inputs 
$username = $wpdb->escape($_REQUEST['username']); 
$password = $wpdb->escape($_REQUEST['password']); 
$remember = $wpdb->escape($_REQUEST['rememberme']); 

if($remember) $remember = "true"; 
else $remember = "false"; 

$login_data = array(); 
$login_data['user_login'] = $username; 
$login_data['user_password'] = $password; 
$login_data['remember'] = $remember; 

$user_verify = wp_signon( $login_data, false ); 

if ( is_wp_error($user_verify) ) 
{ 
echo '<span class="mine">Invlaid Login Details</span>'; 
} else { 
echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>"; 
exit(); 
} 

} else 
{  }
?>

<main>
<container class="banner login">
    <section class="login__card">
<h1>Login</h1>

<?php 

$loginArgs = array('redirect' => home_url());

wp_login_form($loginArgs); ?>

<hr />

<a href="#" class="need">Need An Account?</a>

</section>

<div class="separator vertical">OR</div>



<section class="login__card">
<h1>Create An Account</h1>

<?php 

$loginArgs = array('redirect' => home_url());

wp_register_form($loginArgs); ?>

<hr />

<a href="#" class="need">Need An Account?</a>

</section>
</container>

	</main>

<?php get_footer();?>

