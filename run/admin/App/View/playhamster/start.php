<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<title>疯狂打地鼠</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link href="<?=Resource?>activity/hitmouse/css/style.css?1707170943" type="text/css" rel="stylesheet"/>
</head>
<body>
	<div id="loading">
			<div class="box">
				<i class="baby"></i>
				<div class="progress" id="progress"><i style="width:0%"></i></div>
				<p>加载中,请稍后...</p>
			</div>
	</div>
	<main id="mainContent">
		<div id="countdown"><p></p></div>
		<div id="gameScene">
			<div class="hammer"></div>
				<div class="board">
					<div class="inner">
						<div class="l"><i class="icon icon-1"></i><span id="sum" class="nums"></span></div>
						<div class="r"><i class="icon icon-2"></i><span id="time" class="time"></span><i class="icon icon-3"></i>
						</div>
					</div>
			</div>
			<div id="screenTip"><i></i></div>
			<div id="gird">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<p class="m0"></p>
							<i class="mouse" id="mouse0"></i>
							<i class="baby" id="baby0"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
						<td>
							<i class="mouse" id="mouse1"></i>
							<i class="baby" id="baby1"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
						<td>
							<i class="mouse" id="mouse2"></i>
							<i class="baby" id="baby2"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
					</tr>
					<tr>
						<td>
							<p class="m1"></p>
							<i class="mouse" id="mouse3"></i>
							<i class="baby" id="baby3"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
						<td>
							<i class="mouse" id="mouse4"></i>
							<i class="baby" id="baby4"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
						<td>
							<i class="mouse" id="mouse5"></i>
							<i class="baby" id="baby5"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
					</tr>
					<tr>
						<td>
							<p class="m2"></p>
							<i class="mouse" id="mouse6"></i>
							<i class="baby" id="baby6"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
						<td>
							<i class="mouse" id="mouse7"></i>
							<i class="baby" id="baby7"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
						<td>
							<i class="mouse" id="mouse8"></i>
							<i class="baby" id="baby8"></i>
							<i class="mouse2"></i>
							<i class="baby2"></i>
						</td>
					</tr>
					<tr>
						<td colspan="3"><p class="m3"></p></td>
					</tr>
				</table>
			</div>
			<div id="control" class="control">
				<a href="javascript:;" id="btn_start" class="btn btn-start" data-btn-status="start"></a>
				<a href="javascript:;" id="btn_bgm" class="btn btn-bgm" data-btn-status="on"></a>
			</div>
		</div>
		<div id="audios">
				<audio id="audio_bgm" loop preload="auto">
					<source src="<?=Resource?>activity/hitmouse/audios/bgm.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/bgm.ogg" type="audio/ogg">
				</audio>
				<audio id="audio_begin" preload="auto">
					<source src="<?=Resource?>activity/hitmouse/audios/begin.ogg" type="audio/ogg">
					<source src="<?=Resource?>activity/hitmouse/audios/begin.mp3" type="audio/mpeg">
				</audio>
				<audio id="audio_over" preload="auto">
					<source src="<?=Resource?>activity/hitmouse/audios/over.ogg" type="audio/ogg">
					<source src="<?=Resource?>activity/hitmouse/audios/over.mp3" type="audio/mpeg">
				</audio>
          <audio id="audio_fail" preload="auto">
					<source src="<?=Resource?>activity/hitmouse/audios/fail.ogg" type="audio/ogg">
					<source src="<?=Resource?>activity/hitmouse/audios/fail.mp3" type="audio/mpeg">
				</audio>
			</div>
			<div id="audios2">
				<audio id="audio_cry_0">
					<source src="<?=Resource?>activity/hitmouse/audios/cry.ogg" type="audio/ogg">
					<source src="<?=Resource?>activity/hitmouse/audios/cry.mp3" type="audio/mpeg">
				</audio>
				<audio id="audio_cry_1">
					<source src="<?=Resource?>activity/hitmouse/audios/cry.ogg" type="audio/ogg">
					<source src="<?=Resource?>activity/hitmouse/audios/cry.mp3" type="audio/mpeg">
				</audio>
				<audio id="audio_cry_2">
					<source src="<?=Resource?>activity/hitmouse/audios/cry.ogg" type="audio/ogg">
					<source src="<?=Resource?>activity/hitmouse/audios/cry.mp3" type="audio/mpeg">
				</audio>
				<audio id="audio_nohit_0">
					<source src="<?=Resource?>activity/hitmouse/audios/no_hit.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/no_hit.ogg" type="audio/ogg">
				</audio>
				<audio id="audio_nohit_1">
					<source src="<?=Resource?>activity/hitmouse/audios/no_hit.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/no_hit.ogg" type="audio/ogg">
				</audio>
				<audio id="audio_nohit_2">
					<source src="<?=Resource?>activity/hitmouse/audios/no_hit.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/no_hit.ogg" type="audio/ogg">
				</audio>
				<audio id="audio_hit_0">
					<source src="<?=Resource?>activity/hitmouse/audios/hit.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/hit.ogg" type="audio/ogg">
				</audio>
				<audio id="audio_hit_1">
					<source src="<?=Resource?>activity/hitmouse/audios/hit.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/hit.ogg" type="audio/ogg">
				</audio>
				<audio id="audio_hit_2">
					<source src="<?=Resource?>activity/hitmouse/audios/hit.mp3" type="audio/mpeg">
					<source src="<?=Resource?>activity/hitmouse/audios/hit.ogg" type="audio/ogg">
				</audio>
			</div>
		<div id="gameOver">
		
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
	</main>
	<script src="<?=Resource?>js/zepto.min.js"></script>
	<script src="<?=Resource?>activity/hitmouse/js/main.js?1707141503"></script>
        <script src="<?=Resource?>js/rsa.js"></script>
        <script src="<?=Resource?>js/run_encryption.js"></script>
        <script src="<?=Resource?>js/base.js?d=1701161353"></script>
        <script src="<?=Resource?>js/layer/layer.m.js?d=1608151650"></script>
	<script>
	$(function(){
		HitMouse.isLogin = <?=$login_user['user_id'] ? 'true' : 'false'?>;
		HitMouse.invite = '<?if(isset($invite_url)){ echo $invite_url; }?>';
		HitMouse.domain = 'www.run.com';
	    HitMouse.init({
	    	path : "<?=Resource?>activity/hitmouse/",
	    	time : <?=$init['time']?> ,
	        mouseSum : <?=$init['mouseSum']?>,
	        babySum : <?=$init['babySum']?>,
	        hashString : '<?=$nonceStr?>',
	        delayMax:450,
	        delayMin:450
	    });
	})
	</script>
</body>
</html>