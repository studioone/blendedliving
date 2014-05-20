<script type="text/javascript" src="<?php echo base_path() . path_to_theme() .'/js/jquery.validate.min.js';?>"></script>
<script type="text/javascript" src="<?php echo base_path() . path_to_theme() .'/js/my_account.js';?>"></script>
<script>
	var image_upload_skeleton = '<tr>\
					<td colspan="2">Author(s): </td>\
					</tr>\
					<tr>\
					<td>\
						<input type="text" name="authorname[]" class="text-input" placeholder="enter text..."/>\
						<label class="author-bio">\
						<div>Short bio:</div>\
						<textarea class="text-input" rows="4" name="authorbio[]"></textarea>\
						</label>\
					</td>\
					<td>\
						<div class="upload_link">\
							<input type="file" name="filename" />\
							<button>Upload Image</button>\
						</div>\
						<div class="image_display" style="display:none;">\
						Image<br />\
						<div id="upload_area1" class="upload_area">\
						</div>\
						</div>\
					</td>\
					\
				</tr>';
				
				
	(function ($) {
	$('<link rel="stylesheet" type="text/css" href="<?php echo base_path() . path_to_theme();?>/css/ui-lightness/jquery-ui-1.8.21.custom.css" />').appendTo('head');
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
		var idx = $('#account-tabs li a[href="' + document.location.hash + '"]').index();
		$('#account-tabs').tabs({index:idx});
		$('#account-tabs li a').click(function (event){
			var node = $($(this).attr('href'));
			var id = node.attr('id');
			node.attr('id','');
			document.location.hash = $(this).attr('href');
			node.attr('id',id);
		});
		$('button.save_authors').click(function (event) {
			event.preventDefault();
			window.opener.updateAuthors(authors_text);
			window.close();
		});
		$('button.save_sites').click(function (event) {
			event.preventDefault();
			window.opener.updateSites(sites_text);
			window.close();
		});
	});
	})(jQuery);
</script>
<?php
	$profile = profile2_load_by_user($user, 'partners');
	if (!$profile) {
		drupal_goto('');
	}
	if (isset($_REQUEST['popup'])) {
		$popup = $_REQUEST['popup'];
	}

    // vd($profile);
	
	 $messages = '';
	
if (isset($_POST['action'])) {
	$action = $_POST['action'];
	switch ($action) {
		case "changepassword":
			include_once 'includes/password.inc';
			$oldPass = $_POST['oldpass'];
			$new1 = $_POST['newpass1'];
			$new2 = $_POST['newpass2'];
			if ($new1 != $new2){
				$messages .= '<span class="error">The entered passwords don\'t match!</span>';
			} else {
				if (user_check_password($oldPass, $user)) {
					$usr = user_load($user->uid);
					$usr->pass = user_hash_password($new1);
					user_save($usr);
					$messages = '<span class="success">Your password was changed successfully!</span>';
				} else {
					$messages = '<span class="error">Your old password was entered incorrectly!</span>';
				}
			}
		break;
		case "changeinfo":
			$newName = $_POST['partner_name'];
			$newPhone = $_POST['partner_phone'];
			$newVisitors = $_POST['visitors_per_month'];
			$profile->field_partner_name['und'][0] = array('value'=>$newName);
			$profile->field_partner_phone['und'][0] = array('value'=>$newPhone);
			$profile->field_visitors_per_month['und'][0] = array('value'=>$newVisitors);
			profile2_save($profile);
			$messages .= '<span class="success">Your information was changed successfully!</span>';
		break;
		
		case "changesites":
			foreach ($_POST['oldsitenames'] as $i => $sname) {
				$ent = entity_load_single('field_collection_item',$i);
				$ent->field_site_name['und'][0] = array('value'=>$sname);
				$ent->field_site_url['und'][0] = array('value'=>$_POST['oldsiteurls'][$i]);
				entity_save('field_collection_item',$ent);
			}
			$sites = array();
			foreach ($_POST['newsitenames'] as $i => $sitename) {
				$sites[] = array('field_site_name' => $sitename, 'field_site_url' => $_POST['newsiteurls'][$i]);
			}
			foreach ($sites as $site) {
				$siteValues = array('field_name'=> 'field_site');
				foreach ($site as $key => $value) {
					$siteValues[$key]['und'][0]['value'] = $value;
				}
				$siteEntity = entity_create('field_collection_item', $siteValues);
				$siteEntity->setHostEntity('profile', $profile, LANGUAGE_NONE, true);
				$success = entity_save('field_collection_item', $siteEntity);
			}
			$profile->save();
			$messages .= "Modifications were successful!";
		break;
		case "changeauthors":
			foreach ($_POST['oldauthornames'] as $i => $sname) {
				$ent = entity_load_single('field_collection_item',$i);
				$ent->field_author_name['und'][0] = array('value'=>$sname);
				$ent->field_bio['und'][0] = array('value'=>$_POST['oldauthorbios'][$i]);
				entity_save('field_collection_item',$ent);
			}
			$authors = array();
			foreach ($_POST['authorname'] as $i => $name) {
				$authors[] = array('field_author_name' => $name, 'field_bio' => $_POST['authorbio'][$i],'field_photo' => $_POST['uploaded_images'][$i]);
			}
			foreach ($authors as $author) {
				$authorValues = array('field_name'=> 'field_author');
				foreach ($author as $key => $value) {
					$authorValues[$key]['und'][0]['value'] = $value;
				}
				$authorEntity = entity_create('field_collection_item',$authorValues);
				$authorEntity->setHostEntity('profile', $profile, LANGUAGE_NONE, true);
				$success = entity_save('field_collection_item',$authorEntity);
			}
			$profile->save();
			$messages .= "Modifications were successful!";
		break;
	}
}	



$site_ids = array();

foreach ($profile->field_site['und'] as $site) {
	$site_ids[] = $site['value'];
}

$sites = entity_load('field_collection_item',$site_ids);
$author_ids = array();

foreach ($profile->field_author['und'] as $author) {
	$author_ids[] = $author['value'];
}


$authors = entity_load('field_collection_item',$author_ids);

function authors_tab($authors) {
?>
<div id="account-authors">
		<form class="signinform" id="authors_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="changeauthors" />
			<table>
			<?php foreach ($authors as $author) : ?>
				<tr>
					<td colspan="2">Author: </td>
				</tr>
				<tr>
					<td>
						<input type="text" name="oldauthornames[<?php echo $author->item_id; ?>]" class="text-input" placeholder="enter text..." value="<?php echo $author->field_author_name['und'][0]['value'];?>" />
						<label class="author-bio">
						<div>Short bio:</div>
						<textarea class="text-input" rows="4" name="oldauthorbios[<?php echo $author->item_id; ?>]">
						<?php echo $author->field_bio['und'][0]['value'];?>"
						</textarea>
						</label>
					</td>
					<td>
						<div class="upload_link" style="display: none;">
							<input type="file" name="filename" />
							<button>Upload Image</button>
						</div>
						<div class="image_display" style="display:block;">
						Image<br />
						<div class="upload_area">
						<img width="130" src="<?php echo $author->field_photo['und'][0]['value'];?>" />
						</div>
						</div>
					</td>
					
				</tr>
				<?php endforeach; ?>
				<tr>
					<td>
						<a href="#" id="add_another_author">Add another author</a>
						<a href="#" id="remove_last_author" style="float:right; display: none;">Remove</a>
					</td>
					<td></td>
				</tr>
				<tr class="action-row">
					<td colspan="2"><input type="submit" value="Save" /></td>
				</tr>
			</table>
		</form>
	</div>
<?php
}

function sites_tab($sites) {
?>
<div id="account-sites">
		<form class="signinform" id="sites_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="changesites" />
			<table>
			<?php foreach ($sites as $site) : ?>
				<tr>
					<td>Site name: <input type="text" name="oldsitenames[<?php echo $site->item_id; ?>]" class="text-input" placeholder="enter text..." value="<?php echo $site->field_site_name['und'][0]['value'];?>" /></td>
					<td>URL: <input type="text" name="oldsiteurls[<?php echo $site->item_id; ?>]" class="text-input" placeholder="enter text..." value="<?php echo $site->field_site_url['und'][0]['value'];?>" /></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td>
						<a href="#" id="add_another_site">Add another site</a>
					</td>
					<td></td>
				</tr>
				<tr class="action-row">
					<td colspan="2"><input type="submit" value="Save" /></td>
				</tr>
			</table>
		</form>
	</div>
<?php
} 




if (!isset($popup)) :
?>

<div id="page_wrapper">
<?php include('header.php');  ?>
<div id="content_wrap">
		<div id="content" class="my-account">
	
	<div class="my-account-content">
		<h1 class="title">Partner Information</h1>
		<?php if (!empty($messages)): ?>
		<div class="messages"><?php echo $messages; ?></div>
		<?php endif; ?>
		<div id="account-tabs">
	<ul>
		<li><a href="#account-main">Account</a></li>
		<li><a href="#account-password">Change Password</a></li>
		<li><a href="#account-sites">Manage Sites</a></li>
		<li><a href="#account-authors">Manage Authors</a></li>
	</ul>
	<div id="account-main">
	<form class="signinform" id="partner_sign" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="changeinfo" />
			<table>
				<tr>
					<td>Username: </td>
					<td><?php echo $user->name; ?></td>
				</tr>
				<tr>
					<td style="width: 100px;">Name: </td>
					<td style="width: 100px;"><input type="text" name="partner_name" class="text-input" placeholder="enter text..." value="<?php echo $profile->field_partner_name['und'][0]['value'];?>" /></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" disabled="disabled" class="text-input" placeholder="enter text..." value="<?php echo $user->mail; ?>"/></td>
				</tr>
				<tr>
					<td>Phone: </td>
					<td><input type="text" name="partner_phone" class="text-input" placeholder="enter text..." value="<?php echo $profile->field_partner_phone['und'][0]['value'];?>" /></td>
				</tr>
				<tr>
					<td>Unique visitors / <br />month: </td>
					<td><input type="text" name="visitors_per_month" class="text-input" placeholder="enter text..." value="<?php echo $profile->field_visitors_per_month['und'][0]['value'];?>" /></td>
				</tr>
				<tr class="action-row">
					<td colspan="2"><input type="submit" value="Save" /></td>
				</tr>
			</table>
		</form>
	</div>
	<div id="account-password">
		<form class="signinform" id="password_change_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="changepassword" />
			<table>
				<tr>
					<td>Old password: </td>
					<td><input type="text" name="oldpass" class="text-input" placeholder="enter password..."/></td>
				</tr>
				<tr>
					<td>New Password: </td>
					<td><input type="password" name="newpass1" class="text-input" placeholder="enter password..."/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="password" name="newpass2" class="text-input" placeholder="repeat password..."/></td>
				</tr>
				<tr class="action-row">
					<td colspan="2"><input type="submit" value="Change password" /></td>
				</tr>
			</table>
		</form>
	
	</div>
	<?php
		sites_tab($sites);
		authors_tab($authors);
	?>
	
</div>
		
		
		
		<form action="<?php echo $base_url . base_path() . path_to_theme();?>/templates/ajaxupload.php" method="post" id="image_uploader" enctype="multipart/form-data" style="visibility:hidden;">
							<button alt="1" onclick="ajaxUpload(this.form,'<?php echo base_path() . path_to_theme();?>/templates/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=2000&amp;fullPath=<?php echo $base_url . base_path() . path_to_theme();?>/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=3000','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" id="hidden_upload_button">Upload Image</button>
						</form>
		<?php
		// print(render($mf)); 
		?>
	</div><!-- /.sign-in-form -->
	</div><!-- content -->
	
<?php include 'sidebar.php'; ?>
</div><!-- content wrapper -->
	
<?php include 'footer.php'; ?>

<?php endif; ?>

<?php if (isset($popup) && $popup == 'authors') : ?>
<script type="text/javascript">
<?php 
	$jauthors = array('<option value="">Select Author</option>');
	foreach ($authors as $author) {
		$jauthors[] = '<option value="'.$author->item_id.'">'.$author->field_author_name['und'][0]['value'].'</option>';
	}
	echo 'var authors_text = \''.implode('',$jauthors).'\';';
?>
</script>

</div>
<div class="account-popup">
<?php authors_tab($authors); ?>
</div>
<div style="margin:20px;"> <button class="save_authors" >Save and close</button> </div>
<form action="<?php echo $base_url . base_path() . path_to_theme();?>/templates/ajaxupload.php" method="post" id="image_uploader" enctype="multipart/form-data" style="visibility:hidden;">
							<button alt="1" onclick="ajaxUpload(this.form,'<?php echo base_path() . path_to_theme();?>/templates/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=2000&amp;fullPath=<?php echo $base_url . base_path() . path_to_theme();?>/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=3000','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" id="hidden_upload_button">Upload Image</button>
						</form>
<?php endif; ?>



<?php if (isset($popup) && $popup == 'sites') : ?>
<script type="text/javascript">
<?php 
	$jsites = array('<option value="">Select site</option>');
	foreach ($sites as $site) {
		$jsites[] = '<option value="'.$site->field_site_name['und'][0]['value'].'">'.$site->field_site_name['und'][0]['value'].'</option>';
	}
	echo 'var sites_text = \''.implode('',$jsites).'\';';
?>
</script>

</div>
<div class="account-popup">
<?php sites_tab($sites); ?>
</div>
<div style="margin:20px;"> <button class="save_sites" >Save and close</button> </div>
<?php endif; ?>


