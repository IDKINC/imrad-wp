 <footer>

 	&copy; <?php echo (first_post_date() != date('Y') ? first_post_date() . " - ". date('Y') . " " : date('Y') . " "); echo bloginfo('name');?>

 	<?php $field = new FormField("text", "Name", array("required", "placeholder='First Last'")); ?>
 	<?php $field = new FormField("email", "Email", array("required", "placeholder='john@doe.com'")); ?>
 	<?php $field = new FormField("password", "Password", array("required", "placeholder='At least 7 Characters, 1 Capital letter and 1 Special Character'")); ?>
 	<?php $field = new FormField("textarea", "Description", array("required")); ?>
 	<?php $field = new FormField("submit", "Submit", array("required", "placeholder='Give Us The Dirty Details. Tell Us Everything'")); ?>
 </footer>

 <?php wp_footer();?>
</body>
 </html>
 