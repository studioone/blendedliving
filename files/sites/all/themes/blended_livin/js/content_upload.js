var upload_area_id = "upload_area"+new Date().getTime();

jQuery(document).ready(function(){

		jQuery('#submit_button').click(function(e) {
			e.preventDefault();
			jQuery('.upload_area').find('input').appendTo('#upload_content');
			jQuery('#upload_content').submit();
		});
		var img_nr 		= 1;
		var dif			= "odd";
		jQuery("#add_another_author").click(function(e) {
		});
		jQuery("#more_images").click(function(e) {
			img_nr ++;
			e.preventDefault();
			jQuery(this).parent().parent().before(image_upload_skeleton);
			if(img_nr >= 2) {
				jQuery("#remove_last_author").show();
			}
		});
		
	/*	jQuery("#remove_last_img").click(function(e) {
			e.preventDefault();
			jQuery("#new-"+img_nr).remove();
			img_nr--;
			if(img_nr < 2) {
				jQuery("#remove_last_img").hide();
			}
		});*/
		
		jQuery('#description').keyup(function() {
                var len = this.value.length;
                if (len >= 150) {
                    this.value = this.value.substring(0, 150);
                }
                jQuery('#charLeft').text(150 - len);
            });
			
		jQuery('#site_select').change(function(){
			var url = jQuery('#site_select option:selected').val();
			var text = jQuery('#site_select option:selected').text();
			jQuery('#site_select_url').val(url);
			jQuery('#sitename').val(text);
		
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