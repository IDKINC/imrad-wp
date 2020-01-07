<section class="footer__email-sign-up">
	<div>
	<h2>Let's Get These Dipshits Out Of Office, Together.</h2>
	<p>Sign up for our mailing list to keep up to date with all the latest IMRAD info.</p>
</div>
	<form>
<?php $field = new FormField("email", "Your Email", "evidence_title", array("required", "placeholder='john@doe.com'"));?>

<input type="submit" name="contactForm" value="&raquo;" alt="Sign up for our Newsletter">

<span class="finePrint">We will never sell your data and you can unsubscribe at any time.</span>

</form>
</section>

<footer class="site__footer">

 	&copy; <?php echo (first_post_date() != date('Y') ? first_post_date() . " - " . date('Y') . " " : date('Y') . " ");
echo bloginfo('name'); ?>
 </footer>

 <button id="toTop" onClick="window.scrollTo({ top: 0, behavior: 'smooth' });"><i class="fas fa-arrow-up"></i><span>To Top</span></button>

 <?php wp_footer();?>
</body>
 </html>
