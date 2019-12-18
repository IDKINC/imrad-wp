 <footer class="site__footer">

 	&copy; <?php echo (first_post_date() != date('Y') ? first_post_date() . " - ". date('Y') . " " : date('Y') . " "); echo bloginfo('name');?>
 </footer>

 <button id="toTop" onClick="window.scrollTo({ top: 0, behavior: 'smooth' });"><i class="fas fa-arrow-up"></i><span>To Top</span></button>

 <?php wp_footer();?>
</body>
 </html>
 