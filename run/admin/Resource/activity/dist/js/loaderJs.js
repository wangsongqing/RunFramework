/*loader*/
var loaderJs=loaderJs || {}
loaderJs={
	pointer:function(obj){
		var wHeight=document.documentElement.clientHeight;
		obj.style.marginTop=(wHeight-obj.offsetHeight)/2+'px';
	},
	loader:function(){
		var loader=document.getElementById('loader');
		var loaderHtml='<div id="loaders" class="spinner"><div class="spinner-container container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>';	
		loader.innerHTML=loaderHtml;
		var loaders=document.getElementById('loaders');	
		this.pointer(loaders)
	}	
}
loaderJs.loader()
window.onload=function(){
	document.getElementById('loader').style.display='none';
}
/*font-size*/
;(function(win,doc){
	var docEl = doc.documentElement,
	resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
	recalc = function () {
	    var clientWidth = docEl.clientWidth;
	    if (!clientWidth) return;
	        var size = clientWidth /640*100;
	        docEl.style.fontSize = (size > 100 ? 100 : size) + "px";
	    };
	    if (!doc.addEventListener) return;
	    win.addEventListener(resizeEvt, recalc, false);
	    doc.addEventListener('DOMContentLoaded', recalc, false);	          
})(window,document);	
/*低版本IE浏览器*/
(function(window,document){
    return window.ActiveXObject ? document.body.innerHTML = '<div style="font-size:24px;margin:0 5%;line-height:150%;color:#000;padding-top:50px;">对不起，您的浏览器版本过低，不支持本网站浏览，请使用<span style="color:#c00;font-size:32px;">Opera、Google Chrome、Mozilla Firefox、Safari、IE10及IE10以上</span>浏览器浏览，谢谢您对易贷微理财的支持！！！</div>' : '';
})(window,document);
 /*判断浏览器端*/
var Navigator = Navigator || {};
Navigator={
	'version':function(){
		if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {		    
			return 'ios'
		} else if (/(Android)/i.test(navigator.userAgent)) {
			return 'android'
		} else {
			return 'pc'
		};
	}
}

