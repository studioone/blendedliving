<div id="page_wrapper">
<?php
	$uid = arg(1);
	// vd($uid);
	// if (!$uid) {
		// drupal_goto('/');
	// }
	// $user_fields = user_load($uid); 
	
	// $avatar = get_user_avatar_by_id($uid);
	// $bio = $user_fields -> field_bio['und'][0]['value'];
	// $name = $user_fields -> field_name['und'][0]['value'];

	$author_field = field_info_field('field_author');
	
	$query = new EntityFieldQuery;
        $query->entityCondition('entity_type', 'blog');
            // $query->entityCondition('bundle', 'field_author');
            $query->fieldCondition('field_author', 'value', $uid, '=');
            // $query->fieldCondition('field_feed_uid', 'value', $feed_id, '=');
            $results = $query->execute();

	var_dump($query);
?>

<div id="content_wrap">
		
		<div id="content">
		<?php if(!empty($user_fields)) { ?>
		<div class="bio">
		<div class="bio_top"></div>
			<div class="user-picture"><?php echo $avatar; ?></div>
			<div class="field-name-field-name"><?php echo $name; ?></div>
			<hr />
			<div class="field-name-field-bio"><?php echo $bio; ?></div>
		
		<div class="bio_bottom"></div>
		</div>
		<?php }
		else
			echo "Sorry, this user don't exists!";
		?>
		<?php print render($page['content']); ?>
		<div class="partner_wrap">
				<a href="#"><div class="partner_sign_up">PARTNER SIGN UP AD (728 X 90)</div></a>
			</div>
			
			<div class="related_articles">
				<h1>You Might Like</h1>
				<div class="related_line"></div>
				
				<div id="related">
				<ul>
				<li>
					<div class="box_wrap">
						<div class="relbox">
							<div class="image">
								<img src="<?php print base_path() . path_to_theme() .'/' ?>images/faszi.png" />
							</div>
							<h2 class="related_a_title">LOREM IPSUM</h2>
							<span>dolor sit amet, consectetur adipiscing elit</span>
							
						</div><!-- /box -->
						<div class="bottom_shadow"></div>
					</div><!-- /box_wrap  -- next box -> -->
					
					<div class="box_wrap">
						<div class="relbox">
							<div class="image">
								<img src="<?php print base_path() . path_to_theme() .'/' ?>images/faszi.png" />
							</div>
							<h2 class="related_a_title">LOREM IPSUM</h2>
							<span>dolor sit amet, consectetur adipiscing elit</span>
							
						</div><!-- /box -->
						<div class="bottom_shadow"></div>
					</div><!-- /box_wrap  -- next box -> -->
					
					<div class="box_wrap">
						<div class="relbox">
							<div class="image">
								<img src="<?php print base_path() . path_to_theme() .'/' ?>images/faszi.png" />
							</div>
							<h2 class="related_a_title">LOREM IPSUM</h2>
							<span>dolor sit amet, consectetur adipiscing elit</span>
							
						</div><!-- /box -->
						<div class="bottom_shadow"></div>
					</div><!-- /box_wrap  -- next box -> -->
				</li>
				
				<li>
					<div class="box_wrap">
						<div class="relbox">
							<div class="image">
								<img src="<?php print base_path() . path_to_theme() .'/' ?>images/faszi.png" />
							</div>
							<h2 class="related_a_title">LOREM IPSUM</h2>
							<span>dolor sit amet, consectetur adipiscing elit</span>
							
						</div><!-- /box -->
						<div class="bottom_shadow"></div>
					</div><!-- /box_wrap  -- next box -> -->
					
					<div class="box_wrap">
						<div class="relbox">
							<div class="image">
								<img src="<?php print base_path() . path_to_theme() .'/' ?>images/faszi.png" />
							</div>
							<h2 class="related_a_title">LOREM IPSUM</h2>
							<span>dolor sit amet, consectetur adipiscing elit</span>
							
						</div><!-- /box -->
						<div class="bottom_shadow"></div>
					</div><!-- /box_wrap  -- next box -> -->
					
					<div class="box_wrap">
						<div class="relbox">
							<div class="image">
								<img src="<?php print base_path() . path_to_theme() .'/' ?>images/faszi.png" />
							</div>
							<h2 class="related_a_title">LOREM IPSUM</h2>
							<span>dolor sit amet, consectetur adipiscing elit</span>
							
						</div><!-- /box -->
						<div class="bottom_shadow"></div>
					</div><!-- /box_wrap  -- next box -> -->
				</li>
				
				</ul>
				
				</div><!-- /related -->
				<div class="related_line"></div>
			</div><!-- /related_articles -->
			
			<script type="text/javascript">
			jQuery.noConflict();
			jQuery(document).ready(function(){
				jQuery("#related").easySlider({
					auto: true,
					continuous: true,
					nextId: "next",
					prevId: "prev",
					prevText: "<div class='prev'></div>",
					nextText: "<div class='next'></div>",
					controlsBefore:	'<div class="controls">',
					controlsAfter: '</div>',
					pause:	5000,
					speed: 1200
				});
			});	
		</script>
		</div> <!-- /content -->
	<div class="region-sidebar-second">
			<div class="ad block">
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/advertisments.png" />
			</div>
			
			<div class="social">
				<p class="social_title">Follow Us On</h2>
				<div class="under_social_title"></div>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_twitter.png" /></a>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_facebook.png" /></a>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_linkedin.png" /></a>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/icon_feed.png" /></a>
			</div>
			
			<div class="partner_of_week">
				<h2 class="partner_title">Partner of the Week</h2>
				<div class="partner_img"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner.png" /></div>
			</div>
			
			<div class="partner_posts">
				<h2 class="title">Partner posts</h2>
				<div class="post">
					<div class="post_img_wrap">
						<a href="#"><div class="post_img"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner.png" /></div></a>
					</div>
					<div class="post_excerpt">Most states have a standard fault-based ("tort") system payments based on each driver...</div>
				</div><!-- /.post -->
				<div class="post">
					<div class="post_img_wrap">
						<a href="#"><div class="post_img"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner.png" /></div></a>
					</div>
					<div class="post_excerpt">Most states have a standard fault-based ("tort") system payments based on each driver...</div>
				</div><!-- /.post -->
				<div class="post">
					<div class="post_img_wrap">
						<a href="#"><div class="post_img"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner.png" /></div></a>
					</div>
					<div class="post_excerpt">Most states have a standard fault-based ("tort") system payments based on each driver...</div>
				</div><!-- /.post -->
			</div><!-- /.partner_posts -->
			
			<div class="newsletter">
				<h2 class="title">Newsletter</h2>
				<a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/sign_up.png" /></a>
			</div><!-- /.newsletter -->
			
			<div class="news">
				<h2 class="title">News</h2>
				<div class="news_node odd">
					<div class="news_img"><a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/small_img.png" /></a></div>
					<div class="news_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lorem </div>
				</div><!-- /.news_node -->
				<div class="news_node">
					<div class="news_img"><a href="#"><img src="<?php print base_path() . path_to_theme() .'/' ?>images/small_img_1.png" /></a></div>
					<div class="news_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lorem </div>
				</div><!-- /.news_node -->
			</div><!-- /.news -->
			
			<div class="facebook_social">
				<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.blendedliving.com&amp;send=false&amp;layout=standard&amp;width=250&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:250px;" allowTransparency="true"></iframe>
			</div>
		</div>
</div>

</div> <!-- /page_wrapper -->