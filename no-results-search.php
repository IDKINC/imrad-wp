<header class="search-header no-results">
                    <h1 class="search-title"><?php printf( __( 'No Results For: %s', 'imrad' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                    <h2>Try Searching For Something Else</h2>
                    <?php 
    set_query_var('search_page', true); 
	get_template_part('components/common/searchBar');
	set_query_var('search_page', false);  ?>
                </header><!-- .page-header --> 