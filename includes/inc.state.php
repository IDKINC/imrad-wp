<?php 
/**
 *	Create Material Design Form Inputs
 * 
 * new FormField( type, name, array(args));
 */
class State {

	private $id;
	public $name; 
	public $abbr;


	public function __construct($post = array()){
		$this->id = $post->ID;
		$this->name = get_the_title($this->id);
		$this->motto = $this->getPostMeta($this->id, 'motto', true);
		$this->abbr = get_post_meta($this->id, 'abbreviation', true);
		$this->url = get_the_permalink($this->id);
		$this->flagUrl = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'full');
	}

	private function getPostMeta($id, $meta_key, $arg = array()){

		return get_post_meta($id, $meta_key, $arg);

	}


	public function state_title(){

		echo sprintf("<h1 class='state__name'><a href='%s'>%s</a></h1>" . ($this->motto ? "<h2 class='state__motto'>%s</h2>": ""), get_the_permalink($this->id), $this->name, $this->motto);
	}

	public function state_meta(){ 

		$population = array('meta_id' => 'population', 'label' => 'Population', 'icon' => 'fas faw fa-users', 'format' => true);
        $districts = array('meta_id' => 'districts_count', 'label' => 'Districts', 'icon' => 'fas faw fa-border-none');

        $meta_keys = array($population, $districts);

        foreach ($meta_keys as $meta_key) {

			$meta = get_post_meta($this->id, $meta_key['meta_id']);
 
            if ($meta[0]) {

                echo sprintf("<li><i class='%s'></i>%s <span class='value'>%s</span></li>", $meta_key['icon'], $meta_key['label'], ($meta_key['format'] ? number_format($meta[0]) : $meta[0]));
            }

        }

	}

	public function getPeople(){

		$args = array(
			'post_type' => array('people'),
			'meta_query' => array(
				array(
					'key' => 'state',
					'value' => $this->abbr,
					'compare' => '=',
				)
			)
		 );
		 $query = new WP_Query($args);
		

		return $query;
	}

	public function stateCard(){
		// URL, SLUG, ImageURL, Name, Name
	 ?>
		
		<a href='<?=$this->url?>'>
			<article class='card card--state card--<?=$this->abbr?>' id='<?=$this->slug?>'>
				<img src='<?=$this->flagUrl?>' alt='<?=$this->name?>'>
				<h3><?=$this->name?></h3>
				<h4><?=$this->motto?></h4>
			</article>
		</a>

	<?php
	}


}

?>