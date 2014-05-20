<div class="article <?php print $classes; ?> id="node-<?php print $node->nid; ?>">	
	<a href="/node/<?php echo $node->nid; ?>">
	<?php 
		/*if(get_user_avatar_by_id($node->uid)) {
			print get_user_avatar_by_id($node->uid);
		}
		else {
			echo '<div class="no_img"></div>';
		} */
	?>
	<?php if($partnerpost) { ?>
		<img src="<?php echo $node->field_article_image['und'][0]['value'];?>" />
	<?php }
	else { ?>
	<?php if(!empty($node->field_small_image)) { ?>
		<img src="<?php echo $node->field_small_image['und'][0]['value'];?>" />
	<?php } else { ?>
		<img src="<?php echo $node->field_large_image['und'][0]['value'];?>" />
	<?php } 
	}
	?>
	</a>
	<?php 
		$blog_author = entity_load_single('field_collection_item',$node->field_author['und'][0]['value']);
	?>
	<div class="article_content">
			<a href="/node/<?php echo $node->nid; ?>"><h1 class="article_title"><?php print $title; ?></h1></a>
			<p class="meta">By <a href="/author/<?php echo $node->field_author['und'][0]['value']; ?>" class="author"><?php echo $blog_author->field_author_name['und'][0]['value']; ?></a> for <a class="blog-site" href="<?php echo $node->field_siteurl['und'][0]['value']; ?>"><?php echo $node->field_sitename['und'][0]['value']; ?></a> <span class="idk">, <?php print format_date($node->created, 'custom', 'F j, Y' ); ?></span></p>
			<p class="excerpt">
			<?php echo $node->field_description['und'][0]['value']; ?>
			
			</p>
</div><!-- /article_content -->
<div class="clearfix"></div>
<div class="line"></div> 
</div><!-- /article -->