<?php 

class FormField {



	private $type; 

	private $name; 





	public function __construct($type="text", $name, $id, $args=array()){



		$this->type = $type;

		$this->name = $name;

		$this->args = $args;

		$this->id = $id;



		// echo "Generating a " . $this->type . " input with name " . $this->name;

		if("textarea" == $this->type){

			$this->textarea_render();

		} else if("submit" == $this->type){

			$this->submit_render();

		} else if("select" == $this->type){

			$this->select_render();

		} else {

			

		$this->render();

		

		}

	}



	public function render(){

?>

		<span class="group material_input <?php echo $this->id; ?>">

		<input type="<?php echo $this->type; ?>"
		name="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>" 
		id="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>" 
		<?php foreach ($this->args as $args){echo $args . " "; } 
		if(isset($_POST[$this->id])){echo "value=" . htmlspecialchars($_POST[$this->id]); }

		?> 
		/>

		<label for="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>"><?php echo $this->name; ?></label>



	</span>

<?php

	}



	public function textarea_render(){

?>

		<span class="group material_input textarea <?php echo $this->id; ?>">

		<textarea type="<?php echo $this->type; ?>" name="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>" id="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>" <?php foreach ($this->args as $args){echo $args . " "; } ?>><?php if(isset($_POST[$this->id])){echo  htmlspecialchars($_POST[$this->id]); }?></textarea>

		<label for="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>"><?php echo $this->name; ?></label>



	</span>

<?php

	}


	public function select_render(){

		?>
		
				<span class="group material_input select <?php echo $this->id; ?>">
				<label for="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>"><?php echo $this->name; ?></label>
		
				<select type="<?php echo $this->type; ?>" name="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>" id="<?php echo strtolower(str_replace(' ', '_', $this->id)); ?>" <?php foreach ($this->args as $args){echo $args . " "; } ?>><?php if(isset($_POST[$this->id])){echo  htmlspecialchars($_POST[$this->id]); }?></select>
		
		
		
		
			</span>
		
		<?php
		
			}





		public function submit_render(){

?>

		<span class="group material_input submit">

		<input type="<?php echo $this->type; ?>" name="<?php echo strtolower(str_replace(' ', '_', $this->name)); ?>" id="<?php echo strtolower(str_replace(' ', '_', $this->name)); ?>" <?php foreach ($this->args as $args){echo $args . " "; } ?>/>

	</span>

<?php

	}



}

?>