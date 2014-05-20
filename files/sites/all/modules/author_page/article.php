<?php 
$node = $latest_article;
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