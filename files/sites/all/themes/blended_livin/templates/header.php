
	<div id="fb-root"></div>
	<div id="header">
	<div class="section clearfix">

    <?php if ($logo): ?>
      <div class="logo">
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
      <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
      </div>
    <?php endif; ?>
    <div class="header_right">
		<script>
			jQuery(document).ready(function(){
				jQuery("#login_text").click(function(event){
					event.preventDefault();
					jQuery(".login_join").hide();
					jQuery(".login_form").show();
				});
				jQuery('.login_form .login_button').click(function (event) {
					event.preventDefault();
					jQuery(this).parents('form').submit();
				});
			});
		</script>
		<?php if ( $user->uid ): ?>
		<div class="user_menu">
			Welcome <?php
			global $profile;
				if (isset($profile) && isset($profile->field_partner_name)) {
					echo $profile->field_partner_name['und'][0]['value']; 
				} else {
					echo $user->name; 
				}
			?> | 
			<a href="/partner/account">My account</a> | 
			<a href="/user/logout/">Logout</a>
			<div class="header_action_button submit_content" style="font-size:12px;">
				<a href="/partner/upload">
						<img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner_join.png" />
						<span>Submit Content</span>
				</a>
			</div>
		</div>
		<?php endif; ?>
		<?php if (!$user->uid): ?>
		<?php 
			$loginBlockStyle = 'display:none;'; 
			$joinBlockStyle = 'display:block;'; 
			$loginFail = false;
			if (isset($_POST['form_id']) && $_POST['form_id'] == 'user_login_block') {
				$loginFail = true;
				$loginBlockStyle = 'display:block;'; 
				$joinBlockStyle = 'display:none;'; 
			}
		?>
		
		<div class="login_join clearfix" style="<?php echo $joinBlockStyle; ?>">
			<div class="login_wrap">
				<a href="#" id="login_text">Login</a>
			</div>
			<div class="header_action_button partner_join">
				<!--<a href="/partner/join">-->
				<a href="/gate/partner-sign-up">
					<img src="<?php print base_path() . path_to_theme() .'/' ?>images/partner_join.png" />
					<span>Partner Join</span>
				</a>
			</div>
		</div>
		<div class="login_form clearfix" style="<?php echo $loginBlockStyle; ?>">
			<div class="forgot_password_link"><a href="/user/password">Forgot Password</a></div>
			<?php
				$custom_login_form = drupal_get_form('user_login_block');
				// vd($custom_login_form);
				$custom_login_form['name']['#attributes']['placeholder'] = "Username";
				$custom_login_form['pass']['#attributes']['placeholder'] = "Password";
				$custom_login_form['actions']['submit']['#attributes']['style'] = "display: none";
				$key_img_path =  base_path() . path_to_theme().'/';
				$custom_login_form['zfakesubmit'] = array('#markup'=> <<<HEREHTML
				<div class="header_action_button login_button" style="font-size:12px;">
				<a href="#" tabindex="1000">
						<img src="{$key_img_path}images/partner_join.png" />
						<span>Login</span>
				</a>
			</div>
HEREHTML
);

			print render($custom_login_form); 
			if ($loginFail) {
				echo '<div class="clearfix" style="color: #8C2E0B;">Incorrect username or password!</div>';
			}
			?>
			
		</div>
		<?php endif; ?>
		
				<?php print render($page['header']); ?>
			<!--	<form action="#" name="search">
					<input type="text" name="term" />
					<input type="submit" value="Search" />
				</form> -->
			</div>
		</div>
		<div class="menu">
			<div class="menu_border side_left"></div>
			<div class="menu_border side_right"></div>
			<?php print theme('links__system_main_menu', array(
						'links' => $main_menu,
						'attributes' => array(
						'id' => 'navlist')
						)); ?>
		</div>
		<div class="under_menu"></div>
	</div> <!-- /header -->
	
	<?php 
	
	// function almakompot() {
		// $ent = entity_create('field_collection_item', array(
			// 'field_name' => 'field_author',
			// 'field_author_name' => array('und' => array('FindMe')),
			// 'field_photo' => array('und' => array('FindMe picture')),
			// 'field_bio' => array('und' => array('FindMes bio')),
			// 'field_feed_uid' => array('und' => array(100))));
		// $ent->save();
		// die();
	// }
	// almakompot();
	// $query = new EntityFieldQuery;
        // $query->entityCondition('entity_type', 'field_collection_item');
        // $query->entityCondition('entity_type', 'blog');
            // $query->entityCondition('bundle', 'field_author');
            // $query->entityCondition('entity_id', $this->entity_id);
            // $query->fieldCondition('field_author_name', 'value', 'By Sandy Reynolds', '=');
            // $query->fieldCondition('field_feed_uid', 'value', 'EK9', '=');
       

             // $results = $query->execute();

	// echo_array($results);

	?>