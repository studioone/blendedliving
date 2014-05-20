<?php //echo_array($page); ?>

<?php if($is_front){ /*?>

<?php echo_array($node); ?>

<div class="article <?php print $classes; ?> id="node-<?php print $node->nid; ?>">	



		<a href="<?php echo $node_url; ?>"><?php print render($content['field_image']); ?></a>

		<div class="article_content">

			<a href="<?php echo $node_url; ?>"><h1 class="article_title"><?php print $title; ?></h1></a>

			<p class="meta">By <span class="author"><a href="/user/<?php echo $uid;?>"><?php print $name; ?></a></span> for <span class="idk"><?php print get_category_name($node, TRUE);?>, <?php print format_date($created, 'custom', 'F j, Y' ); ?></span></p>

			<p class="excerpt">

			<?php if(!$page) {

					print $content;

				}

			?>

			</p>

			<a href="<?php echo $node_url; ?>"><div class="more">more</div></a>

			<div class="align_right">

				<a href="<?php echo $node_url; ?>#comments" class="comments">

					<img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_comment.png" class="icon_comment"/>

					

					<span class="nr_comments"><?php echo ($comment_count == 1) ? $comment_count." Comment" : $comment_count." Comments";?></span>

				</a>

			</div>

			

		</div><!-- /article_content -->

		<div class="line"></div>

		

		

	</div> <!-- /article -->

<?php */ } 



elseif ( is_taxonomy() ) { 

//echo_array($node); 

if(isset($node->field_uploaded['und'][0]['value']) and $node->field_uploaded['und'][0]['value'] == 1) {

	$partnerpost = true;

}

else {

	$partnerpost = false;

}

?>

<div class="article <?php print $classes; ?> id="node-<?php print $node->nid; ?>">	

	<a href="<?php echo $node_url; ?>">

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

			<a href="<?php echo $node_url; ?>"><h1 class="article_title"><?php print $title; ?></h1></a>

			<p class="meta">By <a href="/author/<?php echo $node->field_author['und'][0]['value']; ?>" class="author"><?php echo $blog_author->field_author_name['und'][0]['value']; ?></a> for <a class="blog-site" target="_blank" href="<?php echo $node->field_siteurl['und'][0]['value']; ?>"><?php echo $node->field_sitename['und'][0]['value']; ?></a> <span class="idk">, <?php print format_date($node->created, 'custom', 'F j, Y' ); ?></span></p>

			<p class="excerpt">

			<?php echo $node->field_description['und'][0]['value']; ?>

			

			</p>

			<div class="actions">

				<a href="<?php echo $node_url; ?>"><div class="read_article">Read Article</div></a>

				<a href="<?php echo $node_url; ?>#comments" class="comments">

					<img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_comment.png" class="icon_comment"/>

					

					<span class="nr_comments"><?php echo ($comment_count == 1) ? $comment_count." Comment" : $comment_count." Comments";?></span>

				</a>

				<?php global $base_url; ?>

				<div class="social">

					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $base_url . $node_url;?>" data-text="<?php echo $title; ?>">Tweet</a>

					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

					<div class="fb-like" data-href="<?php echo $base_url . $node_url;?>" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false"></div>

				</div>

			</div><!-- /actions -->

</div><!-- /article_content -->

<div class="clearfix"></div>

<div class="line"></div> 

</div><!-- /article -->



<?php } 

elseif (is_user()) { ?>





<div class="article <?php print $classes; ?> id="node-<?php print $node->nid; ?>">	



		<a href="<?php echo $node_url; ?>"><?php print render($content['field_image']); ?></a>

		<div class="article_content">

			<a href="<?php echo $node_url; ?>"><h1 class="article_title"><?php print $title; ?></h1></a>

			<p class="meta"><span class="author_date"><?php print format_date($created, 'custom', 'F j, Y' ); ?></span></p>

			<p class="excerpt">

				<?php print $node -> body['und'][0]['summary']; ?>

			</p>

			

		</div><!-- /article_content -->

		<div class="line"></div>

		

		

	</div> <!-- /article -->



<?php 

} // end user page

else if ($node->type == 'blog') {

/* SINGLE ARTICLE PAGE */

$partnerpost = isset($node->field_uploaded['und'][0]['value']) && $node->field_uploaded['und'][0]['value'] == 1;

// print_r(node_load($node->nid));

?>



<div class="content">

<div class="blog-origin">This article originally appeared on <a target="_blank" href="<?php echo $node->field_siteurl['und'][0]['value']; ?>" target="_blank"><?php echo $node->field_sitename['und'][0]['value']; ?></a></div>



<?php //echo_array($node); ?>

	<div class="img_usr">

		<div class="image">

		<?php if($partnerpost) { ?>

		<img src="<?php echo $node->field_article_image['und'][0]['value'];?>" />

	<?php }

	else { ?>

	<a target="_blank" href="<?php echo $node->field_large_image['und'][0]['value'];?>"><img class="single" src="<?php echo $node->field_large_image['und'][0]['value'];?>" /></a>

	<?php

	}

	?>

		

		</div><!-- /image -->

		<div class="usr_info">

		

		<?php

			$authorEntity = entity_load_single('field_collection_item', $node->field_author['und'][0]['value']);

			$author_id = $authorEntity->item_id;

			$author_bio = $authorEntity->field_bio['und'][0]['value'];

			if (strlen($author_bio) > 300) {

				$separation = strpos($author_bio,' ',250);

				$short_bio = substr($author_bio,0,$separation);

				$further_bio = substr($author_bio,$separation);

			}

			$author_name = $authorEntity->field_author_name['und'][0]['value'];

			$author_photo = $authorEntity->field_photo['und'][0]['value'];

		?>

		<p><a href="/author/<?php echo $author_id; ?>" class="title"><?php print $author_name ?></a></p>

		<?php if (strlen($author_photo)) : ?>

		<img src="<?php echo $author_photo ?>" alt="" />

		<?php endif; ?>

		<?php

			if (isset($short_bio)) {

				print $short_bio;

				print '<em class="ellipsis"> ... <a href="#" class="bio_more"> more</a></em>';

				print '<span class="rest_of_bio" style="display: none;">'.$further_bio.'</span>';

			} else {

				print $author_bio;

			}

		?>

		<script type="text/javascript">

			(function ($){

				$(function () {

					$('a.bio_more').click(function (event) {

						$(this).parent().next().show();

						$(this).parent().hide();

						event.preventDefault();

					});

				});

			})(jQuery);

		</script>

		</div><!-- /usr_info -->

	</div><!-- /img_usr -->

	

	<div class="sponsor-unit"><?php echo $node->field_sponsor_unit['und'][0]['value']; ?></div>

	<div class="content_title"><h2><?php echo $title;?></h2></div>

	<div class="text">

		<?php print render($content['body']);//echo_array($node); ?>

	</div>

	<div class="article-actions-bar clearfix" style="padding-top: 20px;">

		<div class="article-actions">

			<?php

			// echo print_insert_link();

			echo_email_doc_link();

			echo_download_doc_link(); 

			?>

			<a name="fb_share" type="button"></a>

			<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>

			<div class="g-plus" data-action="share" data-annotation="none"></div>

			<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>

			

		</div>

	

		<div style="float: right;">

			<span style="color: #AF3542;">Rate this article</span><?php echo  rate_generate_widget(1, 'node', $node->nid); ?> 

		</div>

	</div>

	

	<div class="clearfix"></div>

	<div class="related_articles">

			<h1>You Might Like</h1>

			<div class="related_line"></div>

			<?php print you_might_like_section($node); ?>

			<div class="related_line"></div>

	</div><!-- /related_articles -->

			

		

		

</div><!-- /content -->

<div class="clearfix"></div>



<div class="comments">

<?php print render($content['comments']); ?>

</div><!-- /comments -->

<!--to line break captcha-->
<br><br>
<!--to line break captcha-->



<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 

        type="text/javascript">

</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>



<!-- Place this tag after the last share tag. -->

<script type="text/javascript">

  (function() {

    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;

    po.src = 'https://apis.google.com/js/plusone.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);

  })();

</script>

<?php print render(ads_block_view('ads_banner'));?>

<?php 



 // end single article page



} else {

?>



<?php

	echo render($content);

}//end simple page

?>

