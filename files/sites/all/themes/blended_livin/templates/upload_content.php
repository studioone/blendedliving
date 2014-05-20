<?php global $user; ?>
<?php global $base_path, $base_url; ?>
<script type="text/javascript" src="<?php echo base_path() . path_to_theme() .'/js/jquery.validate.min.js';?>"></script>

<script type="text/javascript" src="<?php echo base_path() . path_to_theme() .'/js/content_upload.js';?>"></script>

<script>

		

				

	(function ($) {	

		window.updateSites = function (html) {

			$('select[name="site"]').html(html);

		};

		window.updateAuthors = function (html) {

			$('select[name="author"]').html(html);

		};

	$(function () {

		$('.upload_link > button').live('click', function (event) {

			event.preventDefault();

			upload_area_id = "upload_area"+new Date().getTime();

			$(this).parent().hide();

			$(this).parents('td').find('.upload_area').attr('id',upload_area_id).parent().show();

			var inputf = $(this).parents('td').find('.upload_link input');

			$('#image_uploader').append(inputf);

			$('#hidden_upload_button').click();

		});

		$('#upload_content').submit(function(e){e.preventDefault();});

		$('#upload_content').validate({

		rules: {

			title:"required",

			description:"required",

			article:"required",

			site:"required",

			author:"required",

			agreement:"required",

		},

		messages: {

			agreement:{required:"You need to agree to the terms."},

			site:{required:"Please select a site."},

			author:{required:"Please select an author."},

			

		},

		submitHandler: function (form) {

			$(form).append('<input type="hidden" name="validated" value="1" />');

			form.submit();

		}

		

		});

		$('a.authoradd').click(function (event) {

			event.preventDefault();

			window.open('/partner/account?popup=authors','authorpopup',"width=500,height=400");

		});

		$('a.siteadd').click(function (event) {

			event.preventDefault();

			window.open('/partner/account?popup=sites','sitepopup',"width=640,height=400");

		});

	});

	})(jQuery);

</script>

<div id="page_wrapper">

<?php include('header.php');  ?>

<div id="content_wrap">

		<div id="content">

	<?php 

		if(isset($_POST) && !empty($_POST)) : 


			if (isset($_POST['validated']) && $_POST['validated'] == '1') {

			$title 	= $_POST['title'];

			$desc	= $_POST['description'];

			$body	= $_POST['article'];

			$taxonomy = $_POST['category'];

			$sitename 	= $_POST['sitename'];

			$siteurl	= $_POST['site'];

			if(substr($siteurl, 0, 7) != "http://") {

				$siteurl = "http://" . $siteurl;

			}

			$byline 	= "By ". $_POST['author'];
      
      $images = array();
      if (isset($_POST['uploaded_images'])) {
        $images    = $_POST['uploaded_images'];
      }
			

			$newNode = new stdClass;

				$newNode->type = 'blog';

				$newNode->title = $title;

				$newNode->uid = $user->uid;

				$newNode->status = 0;

				$newNode->comment = 2;

				$newNode->moderate = 1;

				$newNode->sticky = 0;

				$newNode->body['und'][0] = array(

												'value' => $body,

												'format' => 'full_html');

				$newNode->log      = 'Partner post';

				$newNode->language = LANGUAGE_NONE;



				// add fields

				$newNode->field_description[LANGUAGE_NONE][0]['value'] = $desc;

				$newNode->field_uploaded[LANGUAGE_NONE][0]['value'] = 1;

				$newNode->field_byline[LANGUAGE_NONE][0]['value'] = $byline;

				foreach($images as $img) {

					$newNode->field_article_image[LANGUAGE_NONE][] = array('value' => $img);

				}

				$newNode->field_sitename[LANGUAGE_NONE][0]['value'] = $sitename;

				$newNode->field_siteurl[LANGUAGE_NONE][0]['value'] 	= $siteurl;

				foreach ($taxonomy as $tax => $value) {
					$newNode->field_category[LANGUAGE_NONE][]['tid']= $value;

				}

				$newNode->field_author[LANGUAGE_NONE][0]['value'] = $_POST['author'];
      //  echo 'here'.$user->uid;exit;

				$newNode->field_author[LANGUAGE_NONE][0]['revision_id'] = $user->uid;
				
        
				$newNode->field_updated[LANGUAGE_NONE][0]['value'] = REQUEST_TIME;

				

				

				// save node

				$newNode->created 	= REQUEST_TIME;

				$newNode->change  	= REQUEST_TIME;

				$newNode->date 		= REQUEST_TIME;

				// vaR_dump($newNode);

				node_save($newNode);

				echo "Your content was successfully submitted, please wait while the administrator approves it. Meanwhile check out the <a href=\"/\">latest articles</a>.";

				} else {

					echo "Invalid data was submitted, <a href=\"\">try again</a>!";

				}

			

		else : ?>

	<div class="content-upload-form">

	<?php

	$uid = user_load($user->uid);

	$profile = profile2_load_by_user($uid, 'partners');

	if(empty($profile)) {

		echo "Sorry, you don't have access to this page. ";

	}

	else { 

		$authornames = array();

		$collection_ids = array();

		foreach($profile->field_site['und'] as $id) {

			array_push($collection_ids,$id['value']);

		}

		//echo_array($profile);

		$arr = entity_load('field_collection_item',$collection_ids);

		$sites = array();

		foreach($arr as $key => $field) {

			$sites[$key] = array( 

								'name' 	=> $field -> field_site_name['und'][0]['value'],

								'url'	=> $field -> field_site_url['und'][0]['value']);

		}

		//authors

		foreach($profile->field_author['und'] as $id) {

			array_push($authornames,$id['value']);

		}

		//echo_array($profile);

		$arr = entity_load('field_collection_item',$authornames);

		$authornames = array();

		foreach($arr as $key => $field) {

			$authornames[$key] = $field -> field_author_name['und'][0]['value'];

		}

		

		$voc = get_vocabulary_by_name("Categories");

		$children = taxonomy_get_tree($voc->vid);

		foreach($children as $child) : 

			if($child -> depth == 0) {

				$cat[$child->tid] = $child->name;

			}

		endforeach;

?>

		<h1 class="title">Content upload</h1>

		<form class="content-upload" id="upload_content" method="POST" action="">

			<table>

				<tr>

					<td>Title (Headline): </td>

					<td><input type="text" name="title" class="text-input" placeholder="enter text..."/></td>

				</tr>

				<tr>

					<td>Description: </td>

					<td><textarea id="description" name="description"></textarea><br /><span class="area-limit">(<span id="charLeft">150</span> Character Max)</span></td>

				</tr>

				<tr>

					<td>Full Article<br/>HTML</td>

					<td>

						<textarea id="full-article" name="article"></textarea>

					</td>

				</tr>

				<tr>

					<td>Preferred Channel(s) </td>

					<td>

						<div class="categories">

						<?php 

						$limit = 0;

						foreach($cat as $key=>$category) : 

							$limit++;

						?>

						

						<input type="checkbox" value="<?=$key;?>" name="category[]"/><?=$category;?>

						<br />

						<?php if($limit % 3 == 0) : ?>

							</div><div class="categories">

						<?php endif; 

							 endforeach; 

							 echo ($limit % 3 != 0) ? "</div>" : "";

						 ?>

						 <div style="clear:both;"></div>

						 <br />

						 <span class="reclassify">We reserve the right to reclassify content</span>

						 <br />

					</td>

				</tr>

				<tr>

					<td  class="site_row">Sitename </td>

					<td  class="site_row">

						<select name="site" id="site_select">

							<option value="">Select site</option>

							<?php foreach($sites as $site) : ?>

							<option value="<?=$site['url'];?>"><?=$site['name'];?></option>

							<?php endforeach; ?>

						</select> 

						<input style="float: left;" type="hidden" id="sitename" name="sitename" value="" />

						<span style="margin-left:100px;">URL: <input type="textbox" readonly="readonly" value="" id="site_select_url"/></span>

					</td>

				</tr>

				<tr>

					<td></td>

					<td>

						<a href="#" class="siteadd">Add another site</a>

					</td>

				</tr>

				<tr>

					<td>Author </td>

					<td>

						<select name="author">

							<option value="">Select author</option>

							<?php foreach($profile->field_author['und'] as $id => $author) :

								if (isset($authornames[$author['value']])) :

							?>

							<option value="<?=$author['value'];?>"><?=$authornames[$author['value']];?></option>

							<?php

							endif;

							endforeach; ?>

						</select>

					</td>

				</tr>

				<tr>

					<td></td>

					<td>

						<a href="#" class="authoradd">Add another author</a>

					</td>

				</tr>

				<tr>

					<td>Image</td>

					<td>

						<div class="upload_link">

							<input type="file" name="filename" />

							<button>Upload Image</button>

						</div>

						<div class="image_display" style="display:none;">

						Image<br />

						<div id="upload_area1" class="upload_area">

						</div>

						</div>

					</td>

				</tr>

				<tr>

					<td colspan="2">

						<a href="#" id="more_images">Upload more images</a>

					<a href="#" id="remove_last_img" style="float:left; display: none;margin-left: 200px">Remove</a></td>

				</tr>

				<tr>

					<td colspan="2"><span class="reclassify">All submissions to Blended Living will be reviewed prior to publication to the website.</span></td>

				</tr>

				<tr>

					<td colspan="2">

						<label><input type="checkbox" id="content_agree" name="agreement" />By checking this box and clicking Submit, I warrant and represent that this submission is made in accordance with Blended Living's <a target="_blank" href="/tos">Terms of Use</a>.</label>

					</td>

				</tr>

				<tr>

					<td><input type="submit" value="Submit" id="submit_button"/></td>

				</tr>

			</table>

			</form>

		<form action="<?php echo $base_url . base_path() . path_to_theme();?>/templates/ajaxupload.php" method="post" id="image_uploader" enctype="multipart/form-data" style="visibility:hidden;">

							<button alt="1" onclick="ajaxUpload(this.form,'<?php echo $base_url . base_path() . path_to_theme();?>/templates/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=2000&amp;fullPath=<?php echo $base_url . base_path() . path_to_theme();?>/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=3000','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" id="hidden_upload_button">Upload Image</button>

						</form>

	<?php } //end if-else ?>

	</div><!-- /.content-upload-form -->

	<?php endif; ?>

</div><!-- content -->

	

<?php include 'sidebar.php'; ?>

</div><!-- content wrapper -->

	

<?php include 'footer.php'; ?>