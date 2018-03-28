<?php 

class FormField {

	private $type;
	private $name; 


	public function __construct($type="text", $name, $args=array()){

		$this->type = $type;
		$this->name = $name;
		$this->args = $args;

		// echo "Generating a " . $this->type . " input with name " . $this->name;
		if("textarea" == $this->type){
			$this->textarea_render();
		} else if("submit" == $this->type){
			$this->submit_render();



		}else {
			
		$this->render();
		
		}
	}

	public function render(){
?>
		<span class="group material_input">
		<input type="<?php echo $this->type; ?>" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>" <?php foreach ($this->args as $args){echo $args . " "; } ?>/>
		<label for="<?php echo $this->name; ?>"><?php echo $this->name; ?></label>

	</span>
<?php
	}

	public function textarea_render(){
?>
		<span class="group material_input textarea">
		<textarea type="<?php echo $this->type; ?>" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>" <?php foreach ($this->args as $args){echo $args . " "; } ?>></textarea>
		<label for="<?php echo $this->name; ?>"><?php echo $this->name; ?></label>

	</span>
<?php
	}


		public function submit_render(){
?>
		<span class="group material_input submit">
		<input type="<?php echo $this->type; ?>" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>" <?php foreach ($this->args as $args){echo $args . " "; } ?>/>
	</span>
<?php
	}

}

?>