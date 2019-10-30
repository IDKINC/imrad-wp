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
		$this->motto = $this->getPostMeta($this->id, 'motto', true);
		$this->abbr = get_post_meta($this->id, 'abbreviation', true);
		$this->headshotUrl = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'headshot');
		$this->bannerUrl = wp_get_attachment_image_url(get_post_meta($post_id, 'people_banner', true), 'full');

		$this->url = get_permalink($this->id);

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


	public function state_title(){

		echo sprintf("<h1 class='state__name'><a href='%s'>%s</a></h1>", get_the_permalink($this->id), $this->name);
	}

	public function state_meta(){ 

		$population = array('meta_id' => 'population', 'label' => 'Population', 'icon' => 'fas faw fa-users', 'format' => true);
        $districts = array('meta_id' => 'districts_count', 'label' => '# of Districts', 'icon' => 'fas faw fa-border-none');

        $meta_keys = array($population, $districts);

        foreach ($meta_keys as $meta_key) {

			$meta = get_post_meta($this->id, $meta_key['meta_id']);

            if ($meta[0]) {

                echo sprintf("<li><i class='%s'></i>%s: %s</li>", $meta_key['icon'], $meta_key['label'], ($meta_key['format'] ? number_format($meta[0]) : $meta[0]));
            }

        }

	}

}

?>