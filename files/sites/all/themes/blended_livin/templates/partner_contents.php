<div id="page_wrapper">
<?php include('header.php');  ?>
<div id="content_wrap">
		<div id="content">
		<h1 class="title">Content uploaded by You</h2>
		
		<div class="articles">
		<?php
		global $user;
		$author_field = field_info_field('field_author');
		$query = new EntityFieldQuery;
        $query->entityCondition('entity_type', 'node');
            $query->entityCondition('bundle', 'blog');
            $query->propertyCondition('uid', $user->uid);
			// $query->fieldOrderBy('field_updated','value','DESC');
        $results = $query->execute();
		foreach (reset($results) as $blog) {
			$node = node_load($blog->nid);
			
			?> 
<div class="article clearfix <?php print $classes; ?>" id="node-<?php print $node->nid; ?>">	
	<a href="<?php echo $node_url; ?>">
		<?php if (!empty($node->field_article_image['und'][0]['value'])) : ?>
		<img src="<?php echo $node->field_article_image['und'][0]['value'];?>" />
		<?php endif; ?>
		<?php if (!empty($node->field_small_image['und'][0]['value'])) : ?>
		<img src="<?php echo $node->field_small_image['und'][0]['value'];?>" />
		<?php endif; ?>
	</a>
<div class="article_content">
			<a href="/node/<?php echo $node->nid; ?>"><h1 class="article_title"><?php print $node->title; ?></h1></a>
			<p class="meta"><?php print format_date($node->created, 'custom', 'F j, Y' ); ?></span></p>
			<p class="excerpt">
			<?php echo $node->field_description['und'][0]['value']; ?>
			
			</p>
			
</div><!-- /article_content -->
</div>
<div class="line"></div>
			
			<?php
		}
		?>
		</div>
		
</div><!-- content -->
	
<?php include 'sidebar.php'; ?>
</div><!-- content wrapper -->
	
<?php include 'footer.php'; ?>