<?php 
/**
 *	Create Material Design Form Inputs
 * 
 * new FormField( type, name, array(args));
 */
class Person {

	private $id;
	public $name; 
	public $abbr;


	public function __construct($post = array()){
		$this->id = $post->ID;
		$this->name = get_the_title($this->id);
		$this->title = $this->setTitles($this->id);
		$this->party = $this->getParty($this->id);
		$this->partyColor = "#" . get_term_meta($this->party->term_id, 'party_color', true);
		$this->stateAbbr = $this->getPostMeta($this->id, 'state', true);

		$this->state = $this->getState($this->stateAbbr);
		wp_reset_postdata();

		$this->evidence = $this->getEvidence();
		wp_reset_postdata();
		$this->evidenceCount = (!is_null($this->evidence) ? count($this->evidence) : "0");
		$this->district = $this->getPostMeta($this->id, 'district', true);


		$this->headshotUrl = $this->getImage($this->id, "headshot");
		$this->headshotIconUrl = $this->getImage($this->id, "icon");
		$this->bannerUrl = wp_get_attachment_image_url($this->getPostMeta($this->id, 'banner_image', true), 'full');

		$this->url = get_permalink($this->id);
		$this->slug = $post->post_name;

		$this->website = $this->getPostMeta($this->id, 'website', true);
		$this->facebook = $this->getPostMeta($this->id, 'facebook', true);
		$this->twitter = $this->getPostMeta($this->id, 'twitter', true);

		$this->votesWith = $this->getPostMeta($this->id, 'votes_with', true);
		$this->votesAgainst = $post->votes_against;  
		$this->votesDetails = $post->votes_details;



		$this->dipshitScore = $this->getDipshitScore($post->dipshit_score);  




	}

	private function getImage($id, $size){

		$imageUrl = wp_get_attachment_image_url(get_post_thumbnail_id($id), $size);

		if($imageUrl){
			return $imageUrl;
		} else {
			return "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
		}


	}

	private function getParty($id){

		$party = get_the_terms($id, 'party');


		return $party[0];

	}

	private function setTitles($id){

		$terms = get_the_terms($id, 'job_title');

		foreach ( $terms as $term ) {
			$title_names[] = $term->name;
		}
							 
		$titles = join( ", ", $title_names );

		return $titles;

	}

	private function getPostMeta($id, $meta_key, $arg = array()){

		return get_post_meta($id, $meta_key, $arg);

	}

	private function getDipshitScore($score=null){

		// Sets $score to null if the field is empty.
		if(empty($score)){$score = null;}

		if(!is_null($score)){

			return round($score);
		} else {
			
			//No Data
			return null;

		}

	}


	private function getState($stateAbbr){

		$args = array(
			'post_type' => array('state'),
			'meta_query' => array(
				array(
					'key' => 'abbreviation',
					'value' => $stateAbbr,
					'compare' => '=',
				)
			)
		 );
		 $states = new WP_Query($args); 

		 if ($states->have_posts()) {
			while ($states->have_posts()) {
				$states->the_post();
				// do something
				$postObj = get_post();
				wp_reset_postdata();
			return $postObj;
	
			}
		} else {
			// no posts found
			return false;
		}
	}

	private function getEvidence(){

		$args = array(
			'post_type' => array('evidence'),
			'meta_query' => array(
				array(
					'key' => 'evidence_people',
					'value' => $this->id,
					'compare' => '=',
				)
			)
		 );
		 $evidence = new WP_Query($args); 

		 if ($evidence->have_posts()) {
			 $evidenceArr = array();
			while ($evidence->have_posts()) {
				$evidence->the_post();
				// do something
				$postObj = get_post();

				array_push($evidenceArr, $postObj);
				wp_reset_postdata();
				
			}
			return $evidenceArr;
		} else {
			// no posts found
			return null;
		}
	}

	public function personCard(){
		// URL, SLUG, ImageURL, Name, Name
	 ?>
		
		<a href='<?=$this->url?>'>
			<article class='card card--person card--<?=$this->party->slug?>' id='<?=$this->slug?>'>
				<img src='<?=$this->headshotUrl?>' alt='<?=$this->name?>'>
				<section class="card__content">
				<h3><?=$this->name?></h3>
				<span class='party'><?=substr($this->party->name, 0, 1)?>-<?= $this->stateAbbr ?></span>
				</section>
			</article>
		</a>

	<?php
	}


	public function personLeaderboard(){


		?>
		
		<a href='<?=$this->url?>'>
			<article class='leaderboard__item leaderboard__item--<?=$this->party->slug?>' id='<?=$this->slug?>'>
				<img src='<?=$this->headshotUrl?>' alt='<?=$this->name?>'>
				<div class="leaderboard__name">
					<h3><?=$this->name?></h3>
					<span class='party'><?=substr($this->party->name, 0, 1)?>-<?= $this->stateAbbr ?></span>
				</div>
				<div class='leaderboard__score'>
					<h4><?= $this->dipshitScore?> / 5</h4>
					<h5>Dipshit Score</h5>
					<hr/>
					<h4><?=$this->evidenceCount?></h4>
					<h5>Pieces Of Evidence</h5>
					<hr/>
					<h5>See Evidence &raquo;</h5> 
				</div>

			</article>
		</a>

	<?php

	}

}

?>