<?php
/**
 * @file
 * Zen theme's implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $secondary_menu_heading: The title of the menu used by the secondary links.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 * - $page['bottom']: Items to appear at the bottom of the page below the footer.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess_page()
 * @see template_process()
 */
?>
<div id="fb-root"></div>
<div id="page_wrapper">

<?php 
	include 'header.php';
?>

  <div id="content_wrap">
  <div class="clearfix">

    <div id="content" class="column"><div class="section">
   
	  <div id="articles">
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#featured").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
		jQuery("#featured").hover(
			function() {
			jQuery("#featured").tabs("rotate",0,true);
			},
			function() {
			jQuery("#featured").tabs("rotate",5000,true);
			}
		);
		jQuery("#featured").find('.ui-tabs-nav-item a').click(function (event) {
			var $this = jQuery(this);
			if ($this.parent().hasClass('ui-state-active')) {
				location.href = '/node/'+($this.attr('href').replace('#fragment-',''));
			}
		});
	});
</script>
	<?php if($page['highlighted']): 
	$myview = views_get_view('front_page_featured_area');
	$myview->execute(); 
	foreach($myview->result as $n){
		$inner = $n -> _field_data['nid']['entity'];
		$nodes[] = $inner;
	}
	?>

	<div id="rotator">
		<div id="featured" >
			<ul class="ui-tabs-nav">
			<?php foreach($nodes as $node) : ?>
				<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-<?php echo $node->nid;?>"><a href="#fragment-<?php echo $node->nid;?>"><span><?php echo $node->title;?></span></a></li>
			<?php endforeach;?>
			</ul>
		  
			<?php foreach($nodes as $node) :
        $authorid = 0;
        if (isset($node->field_author) && isset($node->field_author['und'])) {
          $authorid = $node->field_author['und'][0]['value'];
        }	
				$blog_author = entity_load_single('field_collection_item',(int)$authorid);
			?>
			<div id="fragment-<?php echo $node -> nid;?>" class="ui-tabs-panel" style="">
				<a href="/node/<?php echo $node->nid; ?>"><img src="<?php echo $node->field_large_image['und'][0]['value'];?>" alt="" /></a>
				<div style="clear:both"></div>
				 <div class="info" >
						<p class="meta">By <a href="/author/<?php echo $authorid; ?>" class="author"><?php if (isset($blog_author->field_author_name['und'])) echo $blog_author->field_author_name['und'][0]['value']; ?></a> for <a class="blog-site" target="_blank" href="<?php if(isset($node->field_siteurl['und'])) echo $node->field_siteurl['und'][0]['value']; ?>"><?php echo $node->field_sitename['und'][0]['value']; ?></a></p>
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
				 </div><!-- /info -->
			</div>
		   <?php endforeach;?>

		</div>
	</div><!-- end rotator -->

	  <?php endif; //end highlighted area ?>
	  
	 </div> 
	
	  
	  <h1 class="title">
		<?php echo "Latest Articles"; ?></h1>
		<div class="line"></div>
      <?php if ($tabs = render($tabs)): ?>
        <div class="tabs"><?php print $tabs; ?></div>
      <?php endif; ?>
      <?php //print render($page['help']); ?>
      <?php /*if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; */?>
	   
		<?php 
		// vaR_dump($page['content']); 
		$page['content']['system_main']['nodes'] = array();
		print render($page['content']); ?>
		
	 
      <?php  //print $feed_icons; ?>
	  
		<?php 
//		if($page['features']) :
			$voc = get_vocabulary_by_name("Categories");
			$children = taxonomy_get_tree($voc->vid);

			foreach($children as $child) : 
				if($child -> depth == 0) {
					$parent[$child->tid] = array("name" => $child->name, "id" => array($child->tid));
				}
			endforeach;
			?>
			<div class="features">
				<h1 class="title" style="margin-bottom: 15px;">Features</h1>	
				
			<div id="featured_content">
				<ul>
					<li>
			<?php
			$counter = 0;
			$isFirst = true;
				
			foreach($parent as $p) {
				foreach($p['id'] as $cat) {
					$nodes = taxonomy_select_nodes($cat, TRUE, 5);
				}
				
				$counter++;

			?>
				<div class="feature_box">
					<div class="feature_title">
						<h2><a href="/taxonomy/term/<?php echo $p['id'][0]?>"><?=$p['name'];?></a></h2>
					</div>
					
					<?php
						$first = null;
						if (!empty($nodes)) {
							$first = node_load($nodes[0]);
						}
						if (is_object($first)):
					?>
					<p class="first_node_in_cat"><?php echo substr($first -> title,0,25) . "...";?></p>
					<a href="/node/<?php echo $first->nid;?>"><?php echo_article_image($first);?></a>
					<?php endif; ?>
					<div class="f">
					
						<?php 
						foreach($nodes as $nid) : 
							if($isFirst) { 
								$isFirst = false;
								continue; 
							}
							$node = node_load($nid); 
						?>
							<div class="fl"><a href='/node/<?php echo $node -> nid;?>'><?php echo substr($node -> title,0,29) . "...";?></a></div>
						<?php endforeach;	?>
					</div>
				</div>
			<?php
			if($counter%3 == 0 && $counter != 9) echo "</li><li>";
			if($counter == 9) echo "</li>";
			}
			?>			

				</ul>
			</div>
			</div><!-- /features -->
			<script type="text/javascript">
			jQuery.noConflict();
			jQuery(document).ready(function(){
				jQuery("#featured_content").easySlider({
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
		
		<div style="clear:both"></div>
			<?php
	//	endif;
?>
	</div>
  
	</div><!-- /#content -->



    <?php // print render($page['sidebar_first']); ?>

    <?php include 'sidebar.php';
	?>
		    
  </div></div>
  <!-- /#main, /#main-wrapper -->

<?php include('footer.php'); ?>

</div><!--  /#page-wrapper -->

<?php //print render($page['bottom']); ?>
