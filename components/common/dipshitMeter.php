
<?php
$dipshitScore = $people_obj->dipshitScore;
?>


<h1 class="dipshit__conclusion">


<?=($dipshitScore > 0 ? $people_obj->name . " is " : "We Don't Have")?>


<span>
<?php

switch ($dipshitScore) {

    case 0:
        echo "Any Data";
        break;
    case 1:
        echo "NOT a  Dipshit";
        break;
    case 2:
        echo "A Snack-Sized Dipshit";
        break;
    case 3:
        echo "A Small Dipshit";
        break;
    case 4:
        echo "A Big Dipshit";
        break;
    case 5:
        echo "A Total Dipshit";
        break;

}

?>
</span>
</h1>



<svg version="1.1" id="dipshitMeter" class="<?=($dipshitScore == 0 ? "no-data" : "")?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 502.109 86.615" enable-background="new 0 0 502.109 86.615" preserveAspectRatio="xMidYMid meet"
	 xml:space="preserve">
<rect x="31.352" y="36.549" width="439.406" height="10"  fill="#cccccc"/>
<g>
	<g fill="#ffffff" class="dipshit__dot <?=($dipshitScore == 5 ? "selected" : "")?>">
		<circle fill="#cccccc" cx="470.758" cy="41.468" r="13.838"/>
		<path d="M470.758,60.306c-10.388,0-18.838-8.45-18.838-18.838c0-10.387,8.45-18.838,18.838-18.838s18.838,8.451,18.838,18.838
			C489.596,51.855,481.146,60.306,470.758,60.306z M470.758,32.63c-4.873,0-8.838,3.965-8.838,8.838s3.965,8.838,8.838,8.838
			s8.838-3.965,8.838-8.838S475.631,32.63,470.758,32.63z"/>
		<text transform="matrix(1 0 0 1 451.2383 17.0098)" font-family="'Oswald'" font-weight="900" font-size="19">Total</text>
		<text transform="matrix(1 0 0 1 440.6992 80.334)" font-family="'Oswald'" font-weight="900" font-size="19">DIPSHIT</text>
	</g>
	<g fill="#ffffff" class="dipshit__dot <?=($dipshitScore == 4 ? "selected" : "")?>">
		<circle fill="#cccccc" cx="360.906" cy="41.468" r="13.838"/>
		<path d="M360.906,60.306c-10.388,0-18.838-8.45-18.838-18.838c0-10.387,8.45-18.837,18.838-18.837s18.838,8.45,18.838,18.837
			C379.744,51.855,371.294,60.306,360.906,60.306z M360.906,32.631c-4.873,0-8.838,3.964-8.838,8.837s3.965,8.838,8.838,8.838
			s8.838-3.965,8.838-8.838S365.779,32.631,360.906,32.631z"/>
		<text transform="matrix(1 0 0 1 343.043 17.0103)" font-family="'Oswald'" font-weight="900" font-size="19">A Lot</text>
		<text transform="matrix(1 0 0 1 330.8477 80.334)" font-family="'Oswald'" font-weight="900" font-size="19">DIPSHIT</text>
	</g>
	<g fill="#ffffff" class="dipshit__dot <?=($dipshitScore == 3 ? "selected" : "")?>">
		<circle fill="#cccccc" cx="251.055" cy="41.468" r="13.838"/>
		<path d="M251.055,60.306c-10.388,0-18.838-8.45-18.838-18.838c0-10.387,8.45-18.837,18.838-18.837s18.838,8.45,18.838,18.837
			C269.893,51.855,261.442,60.306,251.055,60.306z M251.055,32.631c-4.873,0-8.838,3.964-8.838,8.837s3.965,8.838,8.838,8.838
			s8.838-3.965,8.838-8.838S255.928,32.631,251.055,32.631z"/>
		<text transform="matrix(1 0 0 1 223.8394 17.0103)" font-family="'Oswald'" font-weight="900" font-size="19">Kind Of</text>
		<text transform="matrix(1 0 0 1 220.9956 80.334)" font-family="'Oswald'" font-weight="900" font-size="19">DIPSHIT</text>
	</g>
		<g fill="#ffffff" class="dipshit__dot <?=($dipshitScore == 2 ? "selected" : "")?>">
		<circle fill="#cccccc" cx="141.203" cy="41.468" r="13.838"/>
		<path d="M141.203,60.306c-10.388,0-18.838-8.45-18.838-18.838c0-10.387,8.45-18.837,18.838-18.837s18.838,8.45,18.838,18.837
			C160.041,51.855,151.591,60.306,141.203,60.306z M141.203,32.631c-4.873,0-8.838,3.964-8.838,8.837s3.965,8.838,8.838,8.838
			s8.838-3.965,8.838-8.838S146.076,32.631,141.203,32.631z"/>
		<text transform="matrix(1 0 0 1 115.2402 17.0103)" font-family="'Oswald'" font-weight="900" font-size="19">A Little</text>
		<text transform="matrix(1 0 0 1 111.1445 80.334)" font-family="'Oswald'" font-weight="900" font-size="19">DIPSHIT</text>
	</g>
		<g fill="#ffffff" class="dipshit__dot <?=($dipshitScore == 1 ? "selected" : "")?>">
		<circle fill="#cccccc" cx="31.352" cy="41.468" r="13.838"/>
		<path d="M31.352,60.306c-10.388,0-18.838-8.45-18.838-18.838c0-10.387,8.45-18.837,18.838-18.837s18.838,8.45,18.838,18.837
			C50.189,51.855,41.739,60.306,31.352,60.306z M31.352,32.631c-4.873,0-8.838,3.964-8.838,8.837s3.965,8.838,8.838,8.838
			s8.838-3.965,8.838-8.838S36.225,32.631,31.352,32.631z"/>
		<text transform="matrix(1 0 0 1 11.957 17.0103)" font-family="'Oswald'" font-weight="900" font-size="19">Not A</text>
		<text transform="matrix(1 0 0 1 1.293 80.334)" font-family="'Oswald'" font-weight="900" font-size="19">DIPSHIT</text>
	</g>
</g>
</svg>

<?php if ($dipshitScore != 0 && $dipshitScore != null): ?>
<div class="dipshit__proof">
	<h2>Based on</h2>

	<span class="proof">
		<span>37</span>
		 Pieces of Evidence
	</span>
	<span class="proof">
		<span>42,500</span>
		Votes
	</span>
</div>
	<?php endif;?>

	<section class="dipshit__submit-box">
<h1>Have <?=($dipshitScore > 0 ? "More" : "")?> Proof of Dipshit&#8209;ery?</h1>
<a href="#" class="button button--large">Submit Evidence &raquo;</a>
<p>All Evidence is Reviewed for Authenticity. <a href="#">Learn More &raquo;</a></p>
</section> 