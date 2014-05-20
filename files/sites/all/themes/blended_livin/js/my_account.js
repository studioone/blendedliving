var upload_area_id = "upload_area"+new Date().getTime();


jQuery(document).ready(function(){
		var count_site 		= 1;
		var count_author 	= 1;
		jQuery("#add_another_site").click(function(e) {
			count_site++;
			e.preventDefault();
			jQuery(this).parent().parent().before(
				'<tr id="new-'+count_site+'">\
					<td>Site name: <input type="text" name="newsitenames[]" class="text-input" placeholder="enter text..." value="" /></td>\
					<td>URL: <input type="text" name="newsiteurls[]" class="text-input" placeholder="enter text..." value="" /></td>\
				</tr>'
			);
			if(count_site == 2) {
				jQuery("#remove_last_site").show();
			}
		});
		
		jQuery("#remove_last_site").click(function(e) {
			e.preventDefault();
			jQuery("#new-"+count_site).remove();
			count_site--;
			if(count_site < 2) {
				jQuery("#remove_last_site").hide();
			}
		});
		
		jQuery("#add_another_author").click(function(e) {
			count_author++;
			e.preventDefault();
			jQuery(this).parent().parent().before(image_upload_skeleton);
			if(count_author == 2) {
				jQuery("#remove_last_author").show();
			}
		});
		
		jQuery("#remove_last_author").click(function(e) {
			e.preventDefault();
			jQuery("#new-author-"+count_author).remove();
			count_author--;
			if(count_author < 2) {
				jQuery("#remove_last_author").hide();
			}
		});
		
		// jQuery("#partner_sign").validate({
		// rules: {
			// name: {
				// required: true
			// },
			// email: {
				// required: true,
				// email: true
			// },
			// visitors: {
				// required: true
			// },
			// currently: {
				// requred: true
			// }
		// },
		
		// messages: {
			// name: {
				// required: "Please enter your name"
			// },
			// email: {
				// required: "Please enter you email address",
				// email: "Please enter a valid email address"
			// },
			// visitors: {
				// required: "This field is required"
			// },
			// currently: {
				// requred: "This field is required"
			// }
		// }
	// });
	
	jQuery('#submit_button').click(function(e) {
		e.preventDefault();
		jQuery('#partner_sign').submit();
	});
	
	});
	
/* *** Ajax image upload script *** */
function $m(theVar){
	return document.getElementById(theVar)
}
function remove(theVar){
	var theParent = theVar.parentNode;
	theParent.removeChild(theVar);
}
function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	    obj.addEventListener(evType, fn, true)
	if(obj.attachEvent)
	    obj.attachEvent("on"+evType, fn)
}
function removeEvent(obj, type, fn){
	if(obj.detachEvent){
		obj.detachEvent('on'+type, fn);
	}else{
		obj.removeEventListener(type, fn, false);
	}
}
function isWebKit(){
	return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
function ajaxUpload(form,url_action,html_show_loading,html_error_http){
	var detectWebKit = isWebKit();
	form = typeof(form)=="string"?$m(form):form;
	var erro="";
	if(form==null || typeof(form)=="undefined"){
		erro += "The form of 1st parameter does not exists.\n";
	}else if(form.nodeName.toLowerCase()!="form"){
		erro += "The form of 1st parameter its not a form.\n";
	}
	if(erro.length>0){
		alert("Error in call ajaxUpload:\n" + erro);
		return;
	}
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id","ajax-temp");
	iframe.setAttribute("name","ajax-temp");
	iframe.setAttribute("width","0");
	iframe.setAttribute("height","0");
	iframe.setAttribute("border","0");
	iframe.setAttribute("style","width: 0; height: 0; border: none;");
	form.parentNode.appendChild(iframe);
	window.frames['ajax-temp'].name="ajax-temp";
	var doUpload = function(){
		removeEvent($m('ajax-temp'),"load", doUpload);
		var cross = "javascript: ";
		cross += "window.parent.$m('"+upload_area_id+"').innerHTML = document.body.innerHTML; void(0);";
		$m(upload_area_id).innerHTML = html_error_http;
		$m('ajax-temp').src = cross;
		if(detectWebKit){
        	remove($m('ajax-temp'));
        }else{
        	setTimeout(function(){ remove($m('ajax-temp'))}, 250);
        }
    }
	addEvent($m('ajax-temp'),"load", doUpload);
	form.setAttribute("target","ajax-temp");
	form.setAttribute("action",url_action);
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("encoding","multipart/form-data");
	if(html_show_loading.length > 0){
		$m(upload_area_id).innerHTML = html_show_loading;
	}
	form.submit();
}