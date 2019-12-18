<?php

// Search Bar

$zip = get_query_var('zip');
$search_page = get_query_var('search_page');
$placeholder = get_query_var('placeholder');

?>

<?php if($zip){ ?>
 <form id="searchBarZip" action="/" class="searchBar is-open zip">
 <input type="text" name="s" placeholder="<?=($zip ? "87114": "Search By Zip, Candidate, etc.") ?>"/>
 <button type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
 </form>

<?php } ?>



<?php if($search_page){ ?>
 <form id="searchBarFull" action="/" class="searchBar is-open large">
 <input type="text" placeholder="<?=($placeholder ? $placeholder : "Search")?>" name="s" value="<?=get_search_query() ?>"/>
 <button type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
 </form>

<?php } ?>


<?php if(!$zip && !$search_page){ ?>
 <form id="searchBar" action="/" class="searchBar">
 <input type="text" name="s" placeholder="Search By Zip, Candidate, etc."/>
 <button type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
</form>
<button id="mobileSearchToggle"><i class="fas fa-search"></i></button>



<?php } ?> 