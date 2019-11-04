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
		$this->state = $this->getPostMeta($this->id, 'state', true);


		$this->headshotUrl = $this->getImage($this->id);
		$this->bannerUrl = wp_get_attachment_image_url($this->getPostMeta($this->id, 'banner_image', true), 'full');

		$this->url = get_permalink($this->id);
		$this->slug = $post->post_name;

		$this->website = $this->getPostMeta($this->id, 'website', true);
		$this->facebook = $this->getPostMeta($this->id, 'facebook', true);
		$this->twitter = $this->getPostMeta($this->id, 'twitter', true);



	}

	private function getImage($id){

		$imageUrl = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'headshot');

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
		 $query = new WP_Query($args);

		 if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				// do something
			return get_post();
	
			}
		} else {
			// no posts found
			return false;
		}
	}

	public function stateName(){
		$state = $this->getState($this->state);

		return get_the_title($state->id);

	}

	public function stateLink(){
		$state = $this->getState($this->state);

		return get_the_permalink($state->id);

	}

	public function personCard(){
		// URL, SLUG, ImageURL, Name, Name
	 ?>
		
		<a href='<?=$this->url?>'>
			<article class='card card--person card--<?=$this->party->slug?>' id='<?=$this->slug?>'>
				<img src='<?=$this->headshotUrl?>' alt='<?=$this->name?>'>
				<h3><?=$this->name?> <span class='party'><?=substr($this->party->name, 0, 1)?>-<?= $this->state ?></span></h3>
			</article>
		</a>

	<?php
	}

}

?>