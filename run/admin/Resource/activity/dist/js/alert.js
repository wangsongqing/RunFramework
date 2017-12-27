/*通用弹出层*/
var Alert=Alert || {};

Alert={
	
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
    
    /*单按钮弹窗*/
    alertBox:function(txt,btn,link,index,click) {
        var box = '<div class="pf black-back animated-alert" id="back">'
                + '<div class="inner animated-alert">'
                + '<p>' + txt + '</p>'
                + '<a href="' + link + '" onclick="'+click+'">' + btn + '</a>'
                + '</div>'
                + '</div>';
        $("#back").remove()
        $("body").append(box)
        this.showDiv()
        this.posit()
        $("#back").addClass('fadeIn').find('div').addClass('fadeInUp');
        if (index == false) {
            $("#back a").click(function () {
            	$("#back").removeClass('fadeIn').addClass('fadeOut')
        		.find('div').removeClass('fadeInUp').addClass('fadeOutDown');
            	setTimeout(function(){$("#back").remove()},200);      
                Alert.closeDiv();
            })
        }
    },
    
    /*双按钮弹窗*/
    alertBoxs:function(txt,btn1,btn2,link1,link2,index1,index2,click1,click2) {
        var box = '<div class="pf black-back double animated-alert" id="back">'
                + '<div class="inner animated-alert">'
                + '<p>' + txt + '</p>'
                + '<a href="' + link1 + '" class="a1" onclick="'+click1+'">' + btn1 + '</a>'
                + '<a href="' + link2 + '" class="a2" onclick="'+click2+'">' + btn2 + '</a>'
                + '</div>'
                + '</div>';
        $("#back").remove();
        $("body").append(box);
        this.showDiv();
        this.posit();
        $("#back").addClass('fadeIn').find('div').addClass('fadeInUp');
        if (index1 == false) {
            $("#back .a1").click(function () {
                $("#back").removeClass('fadeIn').addClass('fadeOut')
        		.find('div').removeClass('fadeInUp').addClass('fadeOutDown');
            	setTimeout(function(){$("#back").remove()},200);
                Alert.closeDiv();
            });
        }
        if (index2 == false) {
            $("#back .a2").click(function () {
                $("#back").removeClass('fadeIn').addClass('fadeOut')
        		.find('div').removeClass('fadeInUp').addClass('fadeOutDown');
            	setTimeout(function(){$("#back").remove()},200);
                Alert.closeDiv();
            });
        }
    },
    
    /*加载中。。。（易）*/
    loadings:function(txt){
        var box = '<div class="pf black-back animated-alert" id="back">'
            	 +'<div class="yi animated-alert">'
                 +'<img src="/Resource/images/loading.gif">'
                 +'<p>'+txt+'</p>'
                 +'</div>'
                 +'</div>';
        $("#back").remove();
        $("body").append(box);
        this.showDiv();
        this.posit();
        $("#back").addClass('fadeIn').find('div').addClass('fadeInUp');
    },
    
    /*移除加载中*/
    lodingsRemove:function(){
        $("#back").removeClass('fadeIn').addClass('fadeOut')
        .find('div').removeClass('fadeInUp').addClass('fadeOutDown');
        setTimeout(function(){$("#back").remove()},200);
        this.closeDiv();
    },
    
    /*弹出框定位*/
    posit:function(){
        var that= $("#back div");
        that.css({'margin-top':($(window).height()-that.height())/2-50,'margin-left':($(window).width()-that.width())/2});
    }
};
/*
Alert.loadings('加载中...');
Alert.lodingsRemove();
Alert.alertBox('该资金距离到期日还有<span>3天</span>（2015-12-17到期），不能再修改处理方式了哟~','我知道了','javascript:void(0);',false);
Alert.alertBoxs('该资金距离到期日还有<span>3天</span>（2015-12-17到期），不能再修改处理方式了哟~','我知道了','去首页','javascript:void(0);','index-rilibao.html',false,true,'alert(1)','alert(2)');
*/

/*图形验证码弹出层*/
var validateImg = validateImg || {};
validateImg={
	/*
	<!-------------获取手机验证码   开始------------------>
			<div class="vertyPic pf z10 bb none">
				<div class="vertyPicBox br-5px" id="vertyPicBox">
					<div class="number fs26 clearfix br-5px">
						<input type="number" placeholder="请输入右侧图形验证码" class="f-fl vertyPicNumber" id="vertyPicNumber"/>
						<label class="f-fr verty tc">1232</label>
					</div>
					<button class="fs28 getTelNum br-5px tc" value="获取手机验证码" id="getTelNum">获取手机验证码</button>
				</div>
			</div>
	<!-------------获取手机验证码   结束------------------>
	*/
}
	/*图形验证码弹出框定位*/
	/*
		showDiv()
		position(document.getElementById('vertyPicBox'))
	*/
