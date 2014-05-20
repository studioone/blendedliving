<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can modify or override Drupal's theme
 *   functions, intercept or make additional variables available to your theme,
 *   and create custom PHP logic. For more information, please visit the Theme
 *   Developer's Guide on Drupal.org: http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to blended_livin_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: blended_livin_breadcrumb()
 *
 *   where blended_livin is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override either of the two theme functions used in Zen
 *   core, you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function blended_livin_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function blended_livin_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function blended_livin_preprocess_node(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // blended_livin_preprocess_node_page() or blended_livin_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function blended_livin_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function blended_livin_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  $variables['classes_array'][] = 'count-' . $variables['block_id'];
}
// */

ini_set('display_errors', 'On');
error_reporting(E_ALL);
// phpinfo();

function blended_livin_preprocess_node ( &$vars ) {
    if ($vars["is_front"]) {
        $vars["theme_hook_suggestions"][] = "node__front";
    }
}

function field_image() {
	$image_uri = $node->field_image['und'][0]['file']['uri'];
	$image_url_with_style = image_style_url('large',$image_uri);
	echo '<img src="'.$image_url_with_style.'">';
}
 
function echo_array($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function is_user() {
	 if ( arg(0) == 'user' && is_numeric(arg(1)) ) {
		return true;
	 }
	 return false;
}

function is_author() {
	 if ( arg(0) == 'author') {
		return true;
	 }
	 return false;
}

function is_taxonomy() {
	if ( arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2)) ) {
		return true;
	}
	return false;
}

function get_user_avatar_by_id($uid = null) {
	if($uid != null) {
		$node_author = user_load($uid);
		$pic = $node_author -> picture;
		if(isset($pic) && !empty($pic)) {
			$up = theme_image_style( array(
							'style_name' => 'large',
							'path' => $pic -> uri,
							'attributes' => array(
								'class' => 'avatar'
							)            
						)
					);
			return $up;
		}
		else {
			return false;
		}
	} 
	else {
		return false;
	}
}

function get_category_name($node, $front = false) {
	if($front) {
		return $node -> field_cat[0]['taxonomy_term'] -> name;
	}
	return $node -> field_cat['und'][0]['taxonomy_term'] -> name;
}

function blended_livin_preprocess_comment(&$vars) {
	$vars['preprocessed_date'] = format_date($vars['comment']->created, 'custom', 'F j, Y \a\t g:i a' );
}

function blended_livin_form_comment_form_alter(&$form, &$form_state, &$form_id) {
  $form['comment_body']['#after_build'][] = 'blended_livin_customize_comment_form'; 
 $form['submit']['#value'] = t("Submit");  
}

function blended_livin_customize_comment_form(&$form) {  
    $form['und'][0]['format']['#access'] = FALSE; // Note LANGUAGE_NONE, you may need to set your comment form language code instead 
  
    return $form;  
	
}

function blended_livin_form_alter(&$form, &$form_state, $form_id) {
  switch($form_id) {
    case 'comment_node_article_form':
      $form['author']['homepage']['#access'] = FALSE;
      break;
  }
}

function get_vocabulary_by_name($vocabulary_name) {
  $vocabs = taxonomy_get_vocabularies(NULL);
  foreach ($vocabs as $vocab_object) {
    if ($vocab_object->name == $vocabulary_name) {
      return $vocab_object;
    }
  }
  return NULL;
}

function hook_form_comment_node_article_form_alter(&$form, &$form_state) {
  // Modification for the form with the given form ID goes here. For example, if
  // FORM_ID is "user_register" this code would run only on the user
  // registration form.

  // Change Text on Save Button
  // $form['my_new_form_node_form'] = array(
  //  '#title' => t("Save and add new"),
  // );
  
      $form['submit']['#value'] = t("Submit");
}

function comment_form_above_comments_preprocess_box(&$vars) {
  global $conf;
  if (isset($conf['comment_form_location_true'])) {
    if(!preg_match('`comment/reply/(.*)`', $_REQUEST['q'])) {
      $vars = array();
    }
    $conf['comment_form_location_'. $conf['comment_form_location_true']] = COMMENT_FORM_ABOVE;
    unset($conf['comment_form_location_true']);
  }
}

function blended_livin_preprocess_search_result(&$vars, $hook) {
  $n = node_load($vars['result']['node']->nid);
  $n && ($vars['node'] = $n);
}

function get_node_id_by_title($title) {
	$result = db_query("SELECT n.nid FROM {node} n WHERE n.title = :title AND n.type = :type", array(":title"=> $title, ":type"=> "page"));
	$nid = $result->fetchField();
	return $nid;
}

function vd($var) {
	echo '<pre style="font-family: monospace;">';
	var_dump($var);
	echo '</pre>';
}
global $profile;
global $user;
if ($user->uid) {
	$profile = profile2_load_by_user($user, 'partners');
}

function echo_email_doc_link() {
	$html =  print_mail_insert_link();
	$html = preg_replace('/src="[^"]+"/','src="'.base_path() . path_to_theme() .'/images/email_icon.png"',$html);
	echo $html;
}
function echo_download_doc_link() {
	$html =  print_pdf_insert_link();
	$html = preg_replace('/src="[^"]+"/','src="'.base_path() . path_to_theme() .'/images/dl_icon.png"',$html);
	echo $html;
}

function echo_article_image($node) {
	$img = '';
	if (!empty($node->field_small_image) && $node->field_small_image['und'][0]['value'] != "") {
		$img = $node->field_small_image['und'][0]['value'];
	} else if (!empty($node->field_article_image) && $node->field_article_image['und'][0]['value'] != "") {
		$img = $node->field_article_image['und'][0]['value'];
	}
	echo '<img src="'.$img.'" />';
}
