<?php 
$sign_in_id 			= get_node_id_by_title("Partner Sign in");
$content_upload_id		= get_node_id_by_title("Content upload");
$my_account_id			= get_node_id_by_title("My Account");
$content_list_id		= get_node_id_by_title("Partner Contents");
if (arg(0) == "node" && arg(1) == $my_account_id) {
	include('partner_account.php');
} else if (arg(0) == "node" && arg(1) == $sign_in_id) {
	include('partner_signup.php');
} else if(arg(0) == "node" && arg(1) == $content_upload_id) {
	include('upload_content.php');
} else if(arg(0) == "node" && arg(1) == $content_list_id) {
	include('partner_contents.php');
}
else {
	if ( is_taxonomy() ) {
		/* category template */
		include('taxonomy.php');
	} else { 
		/* single article template */
		include('article.php');
	} 
}

?>
