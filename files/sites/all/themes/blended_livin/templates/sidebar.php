
    <?php
		if($page['sidebar_second']) : 
	?>
		<div class="region-sidebar-second">
			
			<div>
				<?php 
				print render(ads_block_view('ads_sidebar')); 
				?>
			</div>
		
			<div class="social">
				<!--<p class="social_title">Follow Us On</p>
				<div class="under_social_title"></div>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_twitter.png" /></a>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_facebook.png" /></a>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_linkedin.png" /></a>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_feed.png" /></a>
			</div>-->
			
			<a class="twitter-timeline" width="275" data-chrome="nofooter transparent noborders noscrollbar" data-tweet-limit="5" href="https://twitter.com/Blended_Living"  data-widget-id="438360316628312064">Tweets by @Blended_Living</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
			<div class="partner_of_week">
				<h2 class="partner_title">Partner of the Week</h2>
				<div class="partner_img"><a href="http://studioone.com/?utm_source=blendedliving&utm_medium=banner&utm_campaign=partner-of-the-week" target="_blank"/><img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner.png" /></a></div>
			</div>
			
			<div class="partner_posts">
				<h2 class="title">Partner posts</h2>
				<?php 
				$myview = views_get_view('partner_posts_view');
				$myview->execute(); 
				foreach($myview->result as $n):
				$partnerPost = $n -> _field_data['nid']['entity'];
				
				?>
				
				<div class="post">
					<div class="post_img_wrap">
						<a href="/node/<?php echo $partnerPost->nid; ?>"><div class="post_img"><img src="<?php print $partnerPost->field_article_image['und'][0]['value']; ?>" /></div></a>
					</div>
					<div class="post_excerpt"><?php echo $partnerPost->field_description['und'][0]['value']; ?></div>
				</div><!-- /.post -->
				
				
				<?php endforeach; ?>
			</div><!-- /.partner_posts -->
			
			<!--<div class="news">
				<h2 class="title">News</h2>
				<?php
					/*$author_field = field_info_field('field_author');
	$query = new EntityFieldQuery;
        $query->entityCondition('entity_type', 'node');
            $query->entityCondition('bundle', 'feed_item');
			$query->propertyOrderBy('changed','DESC');
			$query->range(NULL,10);
        $results = reset($query->execute());
        if ($results) {
		$rkeys = array_rand($results, 2);
		foreach ($rkeys as $rkey) : 
			$feedItem = node_load($results[$rkey]->nid);
			// var_dump($feedItem->field_feed_image);
			// var_dump();
			*/
		?>
				<div class="news_node odd">
					<div class="news_img"><a target="_blank" href="<?php // echo $feedItem->field_feed_item_url['und'][0]['value']; ?>"><img src="<?php /* print str_replace('public://','/sites/default/files/',$feedItem->field_feed_image['und'][0]['uri']); */ ?>" /></a></div>
					<div class="news_text"><?php /* echo $feedItem->field_feed_item_description['und'][0]['value']; */ ?></div>
				</div><!-- /.news_node -->
				<?php // endforeach;  } ?>
			</div><!-- /.news -->
			
			<div class="facebook_social">
				<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.blendedliving.com&amp;send=false&amp;layout=standard&amp;width=250&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:250px;" allowTransparency="true"></iframe>
			</div>
		</div>
	<?php
		endif;   
	?>
    
