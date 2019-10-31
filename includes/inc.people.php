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
		$this->state = $this->getPostMeta($this->id, 'state', true);


		$this->headshotUrl = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'headshot');
		$this->bannerUrl = wp_get_attachment_image_url($this->getPostMeta($this->id, 'banner_image', true), 'full');

		$this->url = get_permalink($this->id);
		$this->slug = $post->post_name;

		$this->website = $this->getPostMeta($this->id, 'website', true);
		$this->facebook = $this->getPostMeta($this->id, 'facebook', true);
		$this->twitter = $this->getPostMeta($this->id, 'twitter', true);



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
		$template = "<a href='%s'><article class='card card--person' id='%s'><img src='%s' alt='%s'><h3>%s</h3></article></a>";

		return sprintf($template, $this->url, $this->slug, $this->headshotUrl, $this->name, $this->name);
	}

}

?>