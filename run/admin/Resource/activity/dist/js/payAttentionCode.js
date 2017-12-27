/*payAttentionCode*/
var payAttentionCodeJs=payAttentionCodeJs || {}
payAttentionCodeJs={
	/*显示 弹出div*/
    showDiv:function(){
        document.addEventListener("touchmove",function(e){
            e.preventDefault && e.preventDefault();
            e.returnValue=false;
            e.stopPropagation && e.stopPropagation();
            return false;
        },false)
    },
    
    /*关闭 弹出div*/
    closeDiv:function(){
        document.addEventListener("touchmove",function(e){
            e.preventDefault && e.preventDefault();
            e.returnValue=true;
            e.stopPropagation && e.stopPropagation();
            return true;
        },false)
    },
	pointer:function(obj){
		var wHeight=document.documentElement.clientHeight;
		obj.style.marginTop=(wHeight-obj.offsetHeight)/2-20+'px';
	},
	appends:function(){
		var codeHtml='<div class="bb pf" id="payAttentionCode"><div class="pay-attention fs24 tc" id="payAttention"><h1 class="fs28">关注易贷微理财即可游戏</h1><img src="/Resource/activity/dist/images/attention-code.jpg" alt="易贷微理财二维码"><p>长按图片识别二维码，关注易贷微理财</p></div></div>';	
		var code=document.createElement('div');
		code.innerHTML=codeHtml;
		document.body.appendChild(code);
		var payAttention=document.getElementById('payAttention');	
		this.pointer(payAttention);
		this.showDiv();
		return false;
	}	
}
