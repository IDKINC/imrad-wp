<container class="banner red search-by-zip"> 

    <h2>Search By Zip</h2>

    <?php 
    set_query_var('zip', true); 
    get_template_part('components/common/searchBar'); 
    set_query_var('zip', false); 
    
    ?>

</container>