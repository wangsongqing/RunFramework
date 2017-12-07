<!doctype html>
<html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>疯狂打地鼠</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="我的钱包">
        <meta name="description" content="我的钱包">
        <link href="<?= Resource ?>css/common.css?d=1705311654" type="text/css" rel="stylesheet">
        <link href="<?= Resource ?>activity/hitmouse/css/style.css" type="text/css" rel="stylesheet"/>
        <link href="<?= Resource ?>css/special/hit_mouse.css?1707111425" type="text/css" rel="stylesheet">
        <script>(function(c) {
                var f = window, e = document, a = e.documentElement, b = "orientationchange" in window ? "orientationchange" : "resize", d = function() {
                    var h = a.clientWidth;
                    if (!h) {
                        return
                    }
                    var g = 20 * (h / 320);
                    a.style.fontSize = (g > 40 ? 40 : g) + "px"
                };
                if (!e.addEventListener) {
                    return
                }
                f.addEventListener(b, d, false);
                d()
            })();</script>
    </head>

    <body class="pg-zt2">
        <div class="head">
            <div class="links">
                <a href="javascript:;" class="l" id="rule">活动规则</a>
                <a href="/playhamster/my_score/" class="r">我的成绩</a>
            </div>
        </div>
        <div class="item">
            <div class="inner">
                <div class="hd">
                    <div class="ti"></div>
                    <a href="/playhamster/get_rank/" class="link">更多排行<i></i></a>
                </div>
                <div class="bd">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <?if(!empty($rank_info_socre)){?>
                        <?foreach($rank_info_socre as $key=>$val){?>
                        <tr>
                            <td><i class="n<?= $key + 1 ?>"></i><?= isset($val['nick']) ? $val['nick'] : '******' ?></td>
                            <td><?= isset($val['telephone']) ? $val['telephone'] : '******' ?></td>
                            <td><?= isset($val['total_score']) ? $val['total_score'] : '0' ?>分</td>
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
        <div class="btns">
            <a href="/playhamster/start/<?= !empty($goods_id) ? ('?goods_id=' . $goods_id) : ''; ?>" class="btn"></a>
            <p>本活动解释权归run所有</p>
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
        <script type="text/template" id="popup_rule">
    <div class="popup-rule">
      <p>1. 打中地鼠得4分，打中宝宝扣1分；</p>
      <p>2. 登录后玩游戏，结束后根据得分赠送红包和宝贝豆，红包可提现。</p>
      <p>3. 每人每日无条件赠送1次游戏机会；当日投资宝贝计划赠送1次游戏机会；当日邀请好友注册关注赠送3次游戏机会；</p>
      <p>4. 活动时间：2017年12月01 至2018年12月01 <br>活动结束后根据<span class="c-red">游戏总分</span>奖励如下：</p>
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tbody><tr>
            <th>总分排名</th>
            <th>奖励</th>
          </tr>
          <tr>
            <td>第1-3名</td>
            <td>100000成长金</td>
          </tr>
          <tr>
            <td>第4-10名</td>
            <td>60000成长金</td>
          </tr>
          <tr>
            <td>第11-50名</td>
            <td>30000成长金</td>
          </tr>
          <tr>
            <td>第51-100名</td>
            <td>10000成长金</td>
          </tr>
          <tr>
            <td>第101-300名</td>
            <td>8000成长金</td>
          </tr>
          <tr>
            <td>第301-500名</td>
            <td>6000成长金</td>
          </tr>
          <tr>
            <td>第501-1000名</td>
            <td>2000成长金</td>
          </tr>
        </tbody></table>
      <p>活动结束后，根据<span class="c-red">游戏次数</span>排行奖励如下：</p>
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tbody><tr>
            <th>名次</th>
            <th>投资红包</th>
          </tr>
          <tr>
            <td>第1名</td>
            <td>666元</td>
          </tr>
          <tr>
            <td>第2-3名</td>
            <td>366元</td>
          </tr>
          <tr>
            <td>第4-10名</td>
            <td>266元</td>
          </tr>
          <tr>
            <td>第11-30名</td>
            <td>166元</td>
          </tr>
          <tr>
            <td>第31-50名</td>
            <td>150元</td>
          </tr>
          <tr>
            <td>第51-100名</td>
            <td>88元</td>
          </tr>
          <tr>
            <td>第101-200名</td>
            <td>66元</td>
          </tr>
          <tr>
            <td>第201-300名</td>
            <td>56元</td>
          </tr>
          <tr>
            <td>第301-500名</td>
            <td>40元</td>
          </tr>
          <tr>
            <td>第501-1000名</td>
            <td>20元</td>
          </tr>
        </tbody></table>
      <p>若总分/次数相同，先达到分值的用户排名靠前；
有奖排行的成长金及投资红包奖励于活动结束后3个工作日内下发，投资红包需单笔宝贝计划≥10000元时使用，使用后可提现；</p>
    <p>5.如果以技术或者其他非法手段获取奖励，将取消活动资格。</p>
    </div>
        </script>
        <script src="<?= Resource ?>js/jquery-2.1.4.min.js"></script>
        <script src="<?= Resource ?>activity/js/zepto.min.js"></script>
        <script src="<?= Resource ?>activity/hitmouse/js/main.js?1707111155"></script>
        <script src="<?= Resource ?>/layer/layer.m.js?d=1604151430"></script>
        <script src="<?= Resource ?>js/base.js?d=170105"></script>

        <script>
            $("#rule").click(function() {
                HitMouse.popup.show({
                    title: "活动规则",
                    btn: ["知道啦"],
                    content: $("#popup_rule").html()
                })
                $(document).delegate("#popup .close,#popup .btn-cancel", "click", function() {
                    HitMouse.popup.hide();
                })
            });

        </script>
    </body>
</html>

