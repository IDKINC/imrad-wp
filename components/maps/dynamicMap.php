<?php

$mapSVG = file_get_contents(get_template_directory() . "/components/maps/svg/__". $map_code .".svg"); ?>

<container class="dynamicMap" id="<?=$map_code;?>">

<span id="zoomToggle"><i class="fas fa-search-plus"></i><i class="fas fa-times"></i></span>

<?=$mapSVG;?>

</container>