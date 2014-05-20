<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="page_wrapper">
<?php include('header.php');  ?>
<div id="content_wrap">
		<div id="content">
		<div class="title_bg">
			<h1><?php print $title;?></h1>
		</div>
			<div id="articles">
				<h1 class="title">Latest Articles</h1>
				<div class="line"></div>
			
				<?php print render($page['content']) ?>
			</div> <!-- /articles -->
			<?php print render($page['footer']);?>
			
			<div class="related_articles">
			<h1>You Might Like</h1>
			<div class="related_line"></div>
			<?php print you_might_like_section(arg(2)); ?>
			<div class="related_line"></div>
	</div><!-- /related_articles -->
		</div> <!-- /content -->
		
		<?php include 'sidebar.php' ?>

	
</div>

<?php include('footer.php'); ?>
</div> <!-- /page_wrapper -->