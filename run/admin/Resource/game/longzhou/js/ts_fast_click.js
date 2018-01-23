/**
*
* @author mike@trustone.me
* @version 0.1
* 
* required: jquery
* 
* 
*
*/

//-----------------------公共开始--------------------------------


window.isMobileTouch = true;
if (window.app_util==null){

window.app_util = {
	fast_click_last_ele:null,
	fastClick:function(selector,func){
		var that = this;
	
		if (window.isMobileTouch){
			
		    $(selector).unbind("touchstart");
		    $(selector).unbind("touchmove");
		    $(selector).unbind("touchend");
	
	
		    /**
		    if (app_util.fast_click_last_ele!=null){
		    	if ($(app_util.fast_click_last_ele).attr('need-bg-color')==1){
		    		$(app_util.fast_click_last_ele).css('background-color', $(app_util.fast_click_last_ele).attr('ori-background-color') );
		    	}
		    }
		    */
		    
		    $(selector).bind("touchstart", function (event) {
		    	//$(this).attr('touchClick',1);
		    	
		    	var x = event.originalEvent.touches[0].clientX;
		    	var y = event.originalEvent.touches[0].clientY;
		    	$(this).attr('start_x',x);
		    	$(this).attr('start_y',y);
		    	$(this).attr('end_x',x);
		    	$(this).attr('end_y',y);
		    	
		    	app_util.fast_click_last_ele = this;
		    	
		    	if ($(this).attr('need-bg-color')==1){
		    		//$(this).attr('ori-background-color', $(this).css('background-color') );
		    		$(this).css('background-color','#E8E8E8');
		    	}
		    	
		    });
		    
		    $(selector).bind("touchmove", function (event) {
		    	//$(this).attr('touchClick',0);
		    	
		    	var x = event.originalEvent.touches[0].clientX;
		    	var y = event.originalEvent.touches[0].clientY;
		    	$(this).attr('end_x',x);
		    	$(this).attr('end_y',y);
		    	
		    	if ($(this).attr('need-bg-color')==1){
		    		$(this).css('background-color', $(this).attr('ori-background-color') );
		    	}
		    	
		    });
		    
		    $(selector).bind("touchend", function (event) {
		    	
		    	if ($(this).attr('need-bg-color')==1){
		    		$(this).css('background-color', $(this).attr('ori-background-color') );
		    	}
		    	
		        //var touchClick = $(this).attr('touchClick');
		    	
		    	var touchClick = 1;
		    	
		    	var start_x = $(this).attr('start_x');
		    	var start_y = $(this).attr('start_y');
		    	
	
		    	var end_x = $(this).attr('end_x');
		    	var end_y = $(this).attr('end_y');
		    	
		    	
		    	//console.log(Math.abs(end_x-start_x)+"::::::::::::::::::::::::::::::::::::"+Math.abs(end_y-start_y));
		    	
		    	if (Math.abs(end_x-start_x)>8 || Math.abs(end_y-start_y)>8){
		    		touchClick = 0;
		    	}
		    	
		    	
		    	if (touchClick==1) {
		    		//$(this).attr('touchClick',0);
		    		
	
					//console.log("zzzzzzzzzzzzzzzzzz...fastClick selector:"+selector+":::"+func);
		    		
		    		var that = this;
		    		setTimeout(function(){
		    			try{
				    		//navigator.notification.beep(2);
				    		if (isAndroid && window.plugins.deviceFeedback){
				    			window.plugins.deviceFeedback.acoustic();
				    		}
			    		}catch(e){
			    			
			    		}
			    		
			    		func(that);
		    		},0);
		    		
		        }
		    });
		    
		}else{
		    $(selector).bind("click", function (e) {
		    	func(this);
		    });
		}
		
	}
};

}


//-----------------------公共结束--------------------------------









