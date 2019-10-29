<?php get_template_part("includes/inc.people"); ?>
<?php get_header();?>
<?php $current_fp = get_query_var('fpage'); ?>
<main>
	<article class="single single-people">


	<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();

		$post_id = get_the_id();
		
		$people = new Person(get_post());

 
        //
        // Post Content here
        //
        ?>


<header class="people__header">

<section class="header__content">

<img src="<?= $people->headshotUrl ?>" alt="<?= $people->name ?>" class="people__headshot"> 

<h1 class="people__name"><?= $people->name ?></h1>
    
<ul class="people__actions">
    <li><button class="follow-button">Follow</button></li>
    

    <?php 
    
    // $url, $icon, $label
    $link_template = "<li><a href='%s' class='social-link'><i class='fa-fw %s'></i>%s</a></li>"; ?>

<?= ($people->website ? sprintf($link_template, $people->website, "fas fa-globe", "Website") : ""); ?>
<?= ($people->facebook ? sprintf($link_template, "https://facebook.com/" . $people->facebook, "fab fa-facebook-f", "Facebook") : ""); ?>
<?= ($people->twitter ? sprintf($link_template, "https://twitter.com/" . $people->twitter, "fab fa-twitter", "Twitter") : ""); ?>

    </ul>

    </section>

    

</header>

<nav class="people__subpage-nav">

<ul>
    <li><a href="<?= $people->url ?>">Overview</a></li>
    <li><a href="<?= $people->url ?>voting-history/">Voting History</a></li>
    <li><a href="<?= $people->url ?>donations/">Donation History</a></li>
    <li><a href="<?= $people->url ?>bio/">About</a></li>

    </ul>

    </nav>

<?php if (!$current_fp) {
        get_template_part( 'single', 'people-index' );
    } else if ($current_fp == 'voting-history') {
        get_template_part( 'single', 'people-voting-history' );
    } else if ($current_fp == 'donations') {
        get_template_part( 'single', 'people-donations' );
    } else if ($current_fp == 'bio') {
        get_template_part( 'single', 'people-bio' );
    }; ?>



<?php
} // end while
} // end if
?>

</article>
	</main>
<?php get_footer();?>