<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>疯狂打地鼠</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="keywords" content="我的钱包">
  <meta name="description" content="我的钱包">
  <link href="<?=Resource?>css/common.css?d=1705311654" type="text/css" rel="stylesheet">
  <link href="<?=Resource?>css/special/hit_mouse.css?1707111155" type="text/css" rel="stylesheet">
  <script>(function(c){var f=window,e=document,a=e.documentElement,b="orientationchange" in window?"orientationchange":"resize",d=function(){var h=a.clientWidth;if(!h){return}var g=20*(h/320);a.style.fontSize=(g>40?40:g)+"px"};if(!e.addEventListener){return}f.addEventListener(b,d,false);d()})();</script>
</head>

<body class="pg-rank">
  <div class="head"></div>
  <div class="items">
    <div class="item">
      <div class="inner">
        <div class="hd">
          <ul>
            <li class="active">总分排行榜</li>
            <li>次数排行榜</li>
          </ul>
        </div>
        <div class="bd">
          <div class="tab-item">
          <table cellspacing="0" cellpadding="0" border="0" width="100%">
  		<?if(!empty($rank_info_score)){?>
  			<?foreach($rank_info_score as $key=>$val){?>
  			  <tr>
  				<td><i class="n<?=$key+1?>"></i><?=isset($val['nick'])?hiddenShowName($val['nick'],4):'******'?></td>
  				<td><?=isset($val['telephone'])?hiddenPhoneMiddle($val['telephone']):'******'?></td>
  				<td><?=isset($val['total_score'])?$val['total_score']:'0'?>分</td>
  			  </tr>
  			<?}?>
  		<?}else{?>
  			 <tr>
			 <td cowSpan=2 style="text-align: center;">暂时没有游戏记录</td>
			 </tr>
  			<?}?>
          </table>
          </div>
          <div class="tab-item" style="display:none">
          <table cellspacing="0" cellpadding="0" border="0" width="100%">
  			<?if(!empty($rank_info_times)){?>
  				<?foreach($rank_info_times as $key=>$val){?>
  				  <tr>
  					<td><i class="n<?=$key+1?>"></i><?=isset($val['nick'])?hiddenShowName($val['nick'],4):'******'?></td>
  					<td><?=isset($val['telephone'])?hiddenPhoneMiddle($val['telephone']):'******'?></td>
  					<td><?=isset($val['total_times'])?$val['total_times']:'0'?>次</td>
  				  </tr>
  				<?}?>
  			<?}else{?>
  			 <tr>
			 <td cowSpan=2 style="text-align: center;">暂时没有游戏记录</td>
			 </tr>
  			<?}?>
  		</table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?=Resource?>js/zepto.min.js"></script>
  <script src="<?=Resource?>js/plugins.js"></script>
  <script src="<?=Resource?>js/layer/layer.m.js"></script>
  <script src="<?=Resource?>js/base.js"></script>
  <script src="<?=Resource?>js/swiper.min.js"></script>
  <script>
    BB.tabSwith({
      elem: ".item",
      menu: ".hd",
      item: ".tab-item",
      event: "click",
      active: "active"
    });
  </script>
</body>
</html>