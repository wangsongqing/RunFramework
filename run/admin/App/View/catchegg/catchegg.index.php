<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>接鸡蛋游戏</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="<?=Resource?>activity/EggsDeluxe/css/style.css">
</head>

<body>
  <div id="gameView">
    <canvas id="canvas" width="640" height="1136"></canvas>
  </div>
  <div id="gameOver" class="gamesover">
    <div class="dialog">
      <div class="board">
        <div class="wrap">
          <div class="pic">
          </div>
          <div class="amout"><span id="sum2"></span>元</div>
        </div>
      </div>
      <div class="wrap">
		<div class="btns" id="overBtns">
			<a href="<?=WebUrl?>grow/grow_obtained/" class="btn btn-view" id="btn_view"></a>
			<a href="javascript:;" class="btn btn-replay" id="btn_replay"></a>
			<a href="javascript:;" class="btn btn-receive" id="btn_receive"></a>
		</div>
		<div class="rank" id="rank"></div>
      </div>
    </div>
    <div class="popup-loading">
      <i class="loading"></i>
      <br>领取中...
    </div>
  </div>
  <div id="popup">
    <div class="dialog">
      <div class="inner">
        <div class="hd"><p></p><a href="javascript:;" class="close">X</a></div>
        <div class="bd"></div>
        <div class="fd"></div>
      </div>
    </div>
  </div>
  <script src="<?=Resource?>js/zepto.min.js"></script>
  <script src="<?=Resource?>js/createjs.min.js"></script>
  <script src="<?=Resource?>activity/EggsDeluxe/js/main.js?1705121753"></script>
  <script src="<?=Resource?>js/rsa.js"></script>
  <script src="<?=Resource?>js/run_encryption.js"></script>
  <script>
	EggsDeluxeGame.isLogin = <?=$login_user['user_id'] ? 'true' : 'false'?>;
	EggsDeluxeGame.invite = 'www.baidu.com';
	EggsDeluxeGame.domain = '<?=WebUrl?>';
	EggsDeluxeGame.init({
	    path: "<?=Resource?>activity/EggsDeluxe/",
	    speeds   : [<?=$init['speeds']?>],		
	    time     : <?=$init['time']?>,
	    total    : <?=$init['total']?>,		
            price    : <?=$init['price']?>,	
            hashString : '123456',
	   
	  });
	</script>

</body>

</html>
