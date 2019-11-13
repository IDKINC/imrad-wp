<?php

// Search Bar

?>

<?php if($zip){ ?>
 <form id="searchBarZip" action="/" class="is-open zip">
 <input type="text" name="s" placeholder="<?=($zip ? "87114": "Search By Zip, Candidate, etc.") ?>"/>
 <button type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
 </form>

<?php } ?>



<?php if($search_page){ ?>
 <form id="searchBarFull" action="/" class="is-open large">
 <input type="text" name="s" value="<?=get_search_query() ?>"/>
 <button type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
 </form>

<?php } ?>


<?php if(!$zip && !$search_page){ ?>
 <form id="searchBar" action="/" class="">
 <input type="text" name="s" placeholder="Search By Zip, Candidate, etc."/>
 <button type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
</form>
<button id="mobileSearchToggle"><i class="fas fa-search"></i></button>



<?php } ?>