<div id="page_wrapper">
<?php include('header.php'); ?>

<div id="content_wrap">
		<div id="content">
		<!--adding edit tabs back-->
		      <?php if ($tabs = render($tabs)): ?>
        <div class="tabs"><?php print $tabs; ?></div>
      <?php endif; ?>
      <?php //print render($page['help']); ?>
      <?php /*if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; */?>
	  <br><br>
	  		<!--adding edit tabs back-->
		<div class="title_bg">
			<h1><?php print $title;?></h1>
		</div>
			<div id="article_single">
				<?php print render($page['content']) ?>
			</div> <!-- /articles -->
			 <?php  //print $feed_icons; ?>
		</div> <!-- /content -->
		<?php include 'sidebar.php'; ?>
</div>

<?php include('footer.php'); ?>
</div> <!-- /page_wrapper -->