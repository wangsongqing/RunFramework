/**
 * @author mikewu
 * 
 * 
 */


/** Usage:

$(function(){
	$.post_form('http://localhost/web_test/post_form_rs.php',{a:'123',bb:'xxxx'},function(data){
		alert(data.code);
	});
});


post_form_rs.php outputs:


function ret_post_form($data){
	$json_data = json_encode($data);
	$cb = 'parent.'.trim($_REQUEST['_cb_name']);
	echo "<script>{$cb}({$json_data})</script>";
	exit;
}
ret_post_form( array('code'=>1,'msg'=>'xxxx') );


*/

jQuery.post_form = function(url,param,func){
		if (jQuery.post_form_func_list==null){
			jQuery.post_form_func_list = [];
		}
		
		var uniq_id = (new Date).getTime()+parseInt(Math.random()*999999);
		var iframe_id = '_dyiframe_'+uniq_id;
		var form_id = '_dyform_'+uniq_id;
		var cb_name = '_post_form_cb_'+uniq_id;
		
		$(document.body).append('<iframe name="'+iframe_id+'" id="'+iframe_id+'" height="0" width="0" style="height:0px;width:0px;"></iframe>');
		
		var form_html = '<form target="'+iframe_id+'" id="'+form_id+'" action="'+url+'" method="POST">';
		
		form_html = form_html+'<input type="hidden" name="_uniq_id" value="'+uniq_id+'"/>';
		form_html = form_html+'<input type="hidden" name="_cb_name" value="'+cb_name+'"/>';

		for(var kw in param){
			form_html = form_html+'<input type="hidden" name="'+kw+'" value="'+param[kw]+'"/>';
		}
		form_html = form_html+'</form>';
		$(document.body).append(form_html);
		
		if (func!=null){
			window[cb_name] = function(data){
				func(data);
			}
		}
		
		//jQuery.post_form_func_list[ uniq_id ]  = func;
		$('#'+form_id).submit();
		
		//JSON.parse();
}