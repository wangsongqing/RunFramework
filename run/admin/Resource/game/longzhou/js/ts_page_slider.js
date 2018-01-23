/**
*
* @author mike@trustone.me
* @version 0.2
* 
* required: jquery.touchSwipe.min.js , jquery.transit.js
* 
* 
*
*/




/**
	position:absolute;
	left:0;
	top:0;	
	height:100%;
	width:100%;
	
 */
	
var TSPageSlider = {
	
	docHeight:0,
	docWidth:0,
	cur_page_idx:0,
	total_pages:0,
	main_class:'main',
	page_container_class:'page_container',
	init:function(main_class,page_container_class){
	
		this.docHeight = document.getElementsByTagName('body')[0].offsetHeight;
		this.docWidth = document.getElementsByTagName('body')[0].offsetWidth;
	
		this.cur_page_idx = 0;
		this.total_pages = $('.section').length;
	
		for(var i=0;i<this.total_pages;i++){
			 $('.page'+(i+1)).css({top:i*this.docHeight});
		}
		
	
		var that = this;
		$('.'+main_class).swipe( {
	        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
	          console.log("You swiped " + direction ); 
			  //alert(total_pages);
			  if (direction=='up'){
				  if (that.cur_page_idx+1>=that.total_pages){ //已翻到最后一页
					  return;
				  }
				  that.cur_page_idx++;
				  $('.'+that.page_container_class).transition({y:-(that.docHeight*that.cur_page_idx)},600);
			  
			  
			  
			  }else if (direction=='down'){
				  if (that.cur_page_idx-1<0){ //已翻到最前一页
					  return;
				  }
				  that.cur_page_idx--;
				  $('.'+that.page_container_class).transition({y:-(that.docHeight*that.cur_page_idx)},600);
			  }
		  
	        }
		});
		
		
	}
	
	
}






/**
.section{
	float:left;
	margin:0;
	padding:0;	
	height:100%;
	width:100%;
}

*/
var TSPageLRSlider = {
	
	already_loaded:false,
	preload_function:function(){return true;},
	preload_handler:null,
	
	no_gap:false,
	speed:600,
	disabledLeft:false,
	disabledRight:false,
	
	docHeight:0,
	docWidth:0,
	cur_page_idx:1,
	total_pages:0,
	main_class:'main',
	page_container_class:'page_container',
	before_swipe_func:null,
	swipe:function(page,func,no_gap){
		var that = this;
		if (page==that.cur_page_idx || page>that.total_pages || page<1){
			return;
		}
		
		var cur_speed = that.speed;
		if ( Math.abs(that.cur_page_idx - page)>1 && that.no_gap){
			cur_speed = 0;
		}
		
		that.cur_page_idx = page;
		if (func==null){
			func = function(){}
		}
		
		if (that.before_swipe_func!=null){
			that.before_swipe_func(that.cur_page_idx);
		}
		
		
		$('.'+that.page_container_class).transition({x:-(that.docWidth* (that.cur_page_idx-1))},cur_speed,func);
		
	},
	swipeLeft:function(){
		var that = this;
		that.swipe(that.cur_page_idx+1);		
	},
	swipeRight:function(){
		var that = this;
		that.swipe(that.cur_page_idx-1);
	},
	init:function(main_class,page_container_class){

		var that = this;
		
		this.docHeight = document.getElementsByTagName('body')[0].offsetHeight;
		this.docWidth = document.getElementsByTagName('body')[0].offsetWidth;
		
		
		if (!this.already_loaded && preload_function!=null){
			setInterval(function(){
				if (that.preload_function()){
					that.already_loaded = true;
					clearInterval(that.preload_handler);
					alert(main_class+":"+page_container_class);
					that.init(main_class,page_container_class);
				}
			},200);
			return;
		}
		
		$('.page0').hide();
		this.already_loaded = true;
		
	
		this.cur_page_idx = 1;
		this.total_pages = $('.section').length;
		
		
		$('.'+page_container_class).css({'width':(this.total_pages*this.docWidth) +'px'});
		$('.section').css({'width':(this.docWidth)});
	
		
		/**
		for(var i=0;i<this.total_pages;i++){
			 $('.page'+(i+1)).css({left:i*this.docWidth});
		}
		*/
	
		$('.'+main_class).swipe( {
			
	        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
	          console.log("You swiped " + direction ); 
			  //alert(total_pages);
			  if (direction=='left' && !that.disabledLeft){
				  that.swipeLeft();
			  }else if (direction=='right'  && !that.disabledRight){
				  that.swipeRight();
			  }
		  
	        }
		});
		
		
	}
	
	
}
