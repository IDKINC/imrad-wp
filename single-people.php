<?php get_template_part("includes/inc.people");?>
<?php global $person?>
<?php get_header();?>
<?php $current_fp = get_query_var('fpage');?>
	<article class="single single-people">


	<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();

        $post_id = get_the_id();

        $person = new Person(get_post());

        //
        // Post Content here
        //
        ?>


<header class="people__header">

<section class="header__content">

    <h1 class="people__name"><?=$person->name?> <a href="<?=get_term_link($person->party, 'party')?>" class="party party--<?=$person->party->slug?>" ><?=$person->party->name?></a></h1>
<h2 class="people__title"><?=$person->title?> <?=($person->district ? "(" . $person->district . ")" : "")?> from <a href="<?=get_the_permalink($person->state->ID)?>"><?=$person->state->post_title?></a></h2>

<ul class="people__actions">
    <!-- <li><button class="follow-button btn-alt">Follow</button></li> -->


    <?php

        // $url, $icon, $label
        $link_template = "<li><a href='%s' class='social-link'><i class='fa-fw %s'></i>%s</a></li>";?>

<?=($person->website ? sprintf($link_template, $person->website, "fas fa-globe", "Website") : "");?>
<?=($person->facebook ? sprintf($link_template, "https://facebook.com/" . $person->facebook, "fab fa-facebook-f", "Facebook") : "");?>
<?=($person->twitter ? sprintf($link_template, "https://twitter.com/" . $person->twitter, "fab fa-twitter", "Twitter") : "");?>

    </ul>

    </section>

<img src="<?=$person->headshotUrl?>" alt="<?=$person->name?>" class="people__headshot">




</header>

<nav class="people__subpage-nav">

<ul>
    <li><a href="<?=$person->url?>" <?=(!$current_fp ? "class='current'" : "")?>>Overview</a></li>
    <li><a href="<?=$person->url?>evidence/" <?=($current_fp == 'evidence' ? "class='current'" : "")?>>Evidence <?= ($person->evidenceCount > 0 ? "($person->evidenceCount)" : "") ?></a></li>
    <li><a href="<?=$person->url?>voting-history/" <?=($current_fp == 'voting-history' ? "class='current'" : "")?>>Voting History</a></li>
    <li><a href="<?=$person->url?>donations/" <?=($current_fp == 'donations' ? "class='current'" : "")?>>Donation History</a></li>
    <li><a href="<?=$person->url?>bio/" <?=($current_fp == 'bio' ? "class='current'" : "")?>>About</a></li>

    </ul>

    </nav>

    <main class="content">


<?php

        set_query_var("people_obj", $person);
        if (!$current_fp) {
            get_template_part('single', 'people-overview');
        } else if ($current_fp == 'evidence') {
            get_template_part('single', 'people-evidence');
        } else if ($current_fp == 'voting-history') {
            get_template_part('single', 'people-voting-history');
        } else if ($current_fp == 'donations') {
            get_template_part('single', 'people-donations');
        } else if ($current_fp == 'bio') {
            get_template_part('single', 'people-bio');
        }
        ;?>

    </main>


<?php
} // end while
} // end if
?>

</article>
<?php get_footer();?>