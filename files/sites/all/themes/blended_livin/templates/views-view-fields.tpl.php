<?php

$node = $row->_field_data['nid']['entity'];
if(isset($node->field_uploaded['und'][0]['value']) and $node->field_uploaded['und'][0]['value'] == 1) {
	$partnerpost = true;
}
else {
	$partnerpost = false;
}
$blog_author = entity_load_single('field_collection_item',$node->field_author['und'][0]['value']);
?>
<div class="article" id="node-<?php echo $row->nid; ?>">	
		<?php if(isset($tabs) && $tabs) print $tabs; ?>
		<a href="/node/<?php echo $node->nid; ?>">
		<?php if($partnerpost) { ?>
			<img src="<?php echo $node->field_article_image['und'][0]['value'];?>" />
		<?php } else { ?>
			<img src="<?php echo ($node->field_small_image['und'][0]['value'] != "") ? $node->field_small_image['und'][0]['value'] : $node->field_large_image['und'][0]['value'];?>" />
		<?php } ?>
		</a>
		<div class="article_content">
			<a href="/node/<?php echo $node->nid; ?>"><h1 class="article_title"><?php echo $node->title; ?></h1></a>
					<p class="meta">By <a href="/author/<?php echo $node->field_author['und'][0]['value']; ?>" class="author"><?php echo $blog_author->field_author_name['und'][0]['value']; ?></a> for <a class="blog-site" target="_blank" href="<?php echo $node->field_siteurl['und'][0]['value']; ?>"><?php echo $node->field_sitename['und'][0]['value']; ?></a></p>
		
			
			<p class="excerpt">
				<?php echo $node->field_description['und'][0]['value']; ?>
			</p>
			<a href="/node/<?php echo $node->nid; ?>"><div class="more">more</div></a>
			<div class="align_right">
				<a href="/node/<?php echo $node->nid; ?>#comments" class="comments">
					<img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_comment.png" class="icon_comment"/>
					
					<span class="nr_comments"><?php echo ($node->comment_count == 1) ? $node->comment_count." Comment" : $node->comment_count." Comments";?></span>
				</a>
				<span class="date"><?php print format_date($node->created, 'custom', 'F j, Y' ); ?></span>
			</div>
			
		</div><!-- /article_content -->
		<div class="line"></div>
		
		
	</div> <!-- /article --> 