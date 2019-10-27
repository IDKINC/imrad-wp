 <footer class="site__footer">

 	&copy; <?php echo (first_post_date() != date('Y') ? first_post_date() . " - ". date('Y') . " " : date('Y') . " "); echo bloginfo('name');?>
 </footer>

 <?php wp_footer();?>
</body>
 </html>
 