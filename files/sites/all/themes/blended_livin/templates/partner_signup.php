
<?php
if (isset($_POST['validate_uniqueness'])) {
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
		$query = new EntityFieldQuery;
		$query->entityCondition('entity_type', 'user');
		$query->propertyCondition('name', $username);
		$query->count();
		$occupied = $query->execute() > 0;
		if ($occupied) {
			echo '"This username is already taken, please choose another!"';
		} else {
			echo 'true';
		}
	} else if (isset($_POST['email'])) {
		$email = $_POST['email'];
		$query = new EntityFieldQuery;
		$query->entityCondition('entity_type', 'user');
		$query->propertyCondition('mail', $email);
		$query->count();
		$occupied = $query->execute() > 0;
		if ($occupied) {
			echo '"This e-mail address is already present in our database, did you <a href=\"/user/password\">forget your password</a>?"';
		} else {
			echo 'true';
		}
	}
	 die(); 
 }
 ?>

<script type="text/javascript" src="<?php echo base_path() . path_to_theme() .'/js/jquery.validate.min.js';?>"></script>
<script type="text/javascript" src="<?php echo base_path() . path_to_theme() .'/js/partner_signin.js';?>"></script>
<script>
	var image_upload_skeleton = '<tr>\
					<td>Author(s): </td>\
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
		$('#partner_sign').submit(function(e){e.preventDefault();});
		$('#partner_sign').validate({
		rules: {
			partner_name:"required",
			username:{required:true,remote:{url:"/partner/join",data:{validate_uniqueness:1},type:"POST"}},
			email:{required:true,email:true,remote:{url:"/partner/join",data:{validate_uniqueness:1},type:"POST"}},
			password:{required:true,minlength:6},
			passwordConfirm:{required:true,minlength:6,equalTo: "#password"},
			"sitenames[]":"required",
			"siteurls[]":"required",
			"authorname[]":"required",
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
	});
	})(jQuery);
</script>
<?php
	$profile = profile2_load_by_user($user, 'partners');
	if ($user->uid > 0 || $profile != null) {
		drupal_goto('');
	}

function process_partner() {
	global $user;
	if (isset($_POST['validated']) && $_POST['validated'] == '1') {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	if (!is_numeric($_POST['visitors_per_month'])) {
		$_POST['visitors_per_month'] = 0;
	}
	$fields = array('partner_name', 'partner_phone', 'visitors_per_month', 'already_partner');//,'site','author');
	$values = array();
	foreach ($fields as $fieldName) {
		$values['field_'.$fieldName] = array(LANGUAGE_NONE => array(array("value"=>$_POST[$fieldName])));
	}
	$sites = array();
	foreach ($_POST['sitenames'] as $i => $sitename) {
		$sites[] = array('field_site_name' => $sitename, 'field_site_url' => $_POST['siteurls'][$i]);
	}
	
	$authors = array();
	foreach ($_POST['authorname'] as $i => $name) {
		$authors[] = array('field_author_name' => $name, 'field_bio' => $_POST['authorbio'][$i],'field_photo' => $_POST['uploaded_images'][$i]);
	}
	
	$userinfo = array(
      'name' => $username,
      'init' => $username,
      'mail' => $email,
      'pass' => $password,
      'status' => 0
    );
	$user = user_save(NULL, $userinfo);
	_user_mail_notify('register_pending_approval', $user);

	$profileInfo = array_merge(array(
        'type' => 'partners',
        'uid' => $user->uid
      ),$values);
    $profile = profile2_create($profileInfo);
	profile2_save($profile);
	foreach ($sites as $site) {
		$siteValues = array('field_name'=> 'field_site');
		foreach ($site as $key => $value) {
			$siteValues[$key]['und'][0]['value'] = $value;
		}
		$siteEntity = entity_create('field_collection_item', $siteValues);
		$siteEntity->setHostEntity('profile', $profile, LANGUAGE_NONE, true);
		$success = entity_save('field_collection_item', $siteEntity);
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
		return "Registration successful, please wait until the administrator approves your account. Meanwhile check out the <a href=\"/\">latest articles</a>.";
	} else {
		return "Invalid data was submitted, <a href=\"\">try again</a>!";
	}
}

// print  '<div id="same-id">' . drupal_render(drupal_get_form('user_register_block')) . '</div>';
// */
?>
<div id="page_wrapper">
<?php include('header.php');  ?>
<div id="content_wrap">
		<div id="content">
	
	<div class="sign-in-form">
		<h1 class="title">Partner Signup</h1>
		
		
		<?php 
		if (isset($_POST['email'])) {
			echo process_partner();
		} else {
		?>
		<form class="signinform" id="partner_sign" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td style="width: 100px;">Name: </td>
					<td style="width: 100px;"><input type="text" name="partner_name" class="text-input" placeholder="enter text..."/></td>
					<td style="width: 100px;"></td>
				</tr>
				<tr>
					<td>Username: </td>
					<td><input type="text" name="username" class="text-input" placeholder="enter text..."/></td>
					<td></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="password" name="password" id="password" class="text-input" placeholder="enter password..."/></td>
					<td><input type="password" name="passwordConfirm" class="text-input" placeholder="repeat password..."/></td>
				</tr>
				<tr>
					<td>Site Name: </td>
					<td><input type="text" name="sitenames[]" class="text-input" placeholder="enter text..."/></td>
					<td class="siteurl-wrapper">URL: <input type="text" name="siteurls[]" class="text-input" placeholder="enter text..." /></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<a href="#" id="add_another_site">Add another site</a>
						<a href="#" id="remove_last_site" style="float:right; display: none;">Remove</a>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" class="text-input" placeholder="enter text..."/></td>
					<td></td>
				</tr>
				<tr>
					<td>Phone: </td>
					<td><input type="text" name="partner_phone" class="text-input" placeholder="enter text..."/></td>
					<td></td>
				</tr>
				<tr>
					<td>Unique visitors / <br />month: </td>
					<td><input type="text" name="visitors_per_month" class="text-input" placeholder="enter text..."/></td>
					<td></td>
				</tr>
				<tr>
					<td>Are you currently<br /> a partner? </td>
					<td><input type="radio" name="already_partner" value="1" /> Yes <input type="radio" name="already_partner" value="0" /> No</td>
					<td></td>
				</tr>
				<tr>
					<td>Author(s): </td>
					<td>
						<input type="text" name="authorname[]" class="text-input" placeholder="enter text..."/>
						<label class="author-bio">
						<div>Short bio:</div>
						<textarea class="text-input" rows="4" name="authorbio[]"></textarea>
						</label>
					</td>
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
					<td></td>
					<td>
						<a href="#" id="add_another_author">Add another author</a>
						<a href="#" id="remove_last_author" style="float:right; display: none;">Remove</a>
					</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2">
						<label><input type="checkbox" id="tos_agreement" name="agreement" /> By checking this box and clicking Submit, I acknowledge that I have read, understood and agree to Blended Living's <a target="_blank" href="/tos">Terms of Use</a>.</label>
					</td>
				</tr>
				
				<tr>
					<td><input type="submit" value="Submit" id="submit_button"/></td>
					<td></td>
					<td></td>
				</tr>
				</table>
		</form>
	
		<form action="<?php echo $base_url . base_path() . path_to_theme();?>/templates/ajaxupload.php" method="post" id="image_uploader" enctype="multipart/form-data" style="visibility:hidden;">
							<button alt="1" onclick="ajaxUpload(this.form,'<?php echo $base_url . base_path() . path_to_theme();?>/templates/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=2000&amp;fullPath=<?php echo $base_url . base_path() . path_to_theme();?>/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=3000','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'<?php echo $base_url . base_path() . path_to_theme();?>/images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" id="hidden_upload_button">Upload Image</button>
						</form>
		<?php
		}
		?>
	</div><!-- /.sign-in-form -->
	
</div><!-- content -->
	
<?php include 'sidebar.php'; ?>
</div><!-- content wrapper -->
	
<?php include 'footer.php'; ?>