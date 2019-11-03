<?php get_template_part("includes/inc.state");?>
<?php get_template_part("includes/inc.people");?>
<?php get_header();?>
<main>

<?php if (have_posts()): ?>

                <header class="search-header">


					<h1 class="search-title"><?php printf(__('Search Results for: %s', 'imrad'), '<span>' . get_search_query() . '</span>');?></h1>

					<?php 
    set_query_var('search_page', true); 
	get_template_part('components/common/searchBar');
	set_query_var('search_page', false);  ?>

                </header><!-- .page-header -->
	<section class="search-grid">
                <?php /* Start the Loop */?>
                <?php while (have_posts()): the_post();?>

		                    <?php get_template_part('components/search/search-grid-item');?>

		                <?php endwhile;?>
 </section>

            <?php else: ?>

                <?php get_template_part('no-results', 'search');?>

            <?php endif;?>
	</main>
<?php get_footer();?>