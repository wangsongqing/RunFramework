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
        <link href="<?= Resource ?>css/special/hit_mouse.css?1707111155" type="text/css" rel="stylesheet">
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

    <body class="pg-cj">
        <div class="head"></div>
        <div class="items">
            <div class="item">
                <div class="inner">
                    <div class="hd">
                        <div class="ti"></div>
                    </div>
                    <div class="bd">
                        <ul>
                            <li><p>分数</p><?= isset($my_score['total_socre']) ? $my_score['total_socre'] : 0 ?></li>
                            <li><p>总分数排名</p><?= isset($my_score['total_socre_pm']) ? $my_score['total_socre_pm'] : 0 ?></li>
                            <li><p>总次数</p><?= isset($my_score['total_times']) ? $my_score['total_times'] : 0 ?></li>
                            <li><p>总次数排名</p><?= isset($my_score['total_times_pm']) ? $my_score['total_times_pm'] : 0 ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="item-2">
                <div class="inner">
                    <div class="hd"><span>我的单次成绩</span><i></i></div>
                    <div class="bd">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" id = 'statement_page'>
                            <tr>
                                <th>分数</th>
                                <th>参与时间</th>
                            </tr>
                            <tr>
                                <td><?=1?></td>
                                <td><?=date('Y/m/d H:i', time());?></td>
                            </tr>

<!--				<tr >
<td colSpan="2"><a href="/playhamster/"  >对不起：你还没有成绩，现在去打地鼠吧！</a></td>
</tr>-->

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?require(View.'/public/js.html');?> 
        <script>
            var Page = 2;
            var canRequest = true;
            $(document).ready(function() {
                var range = 50; //距下边界长度/单位px
                var totalheight = 0;
                var main = $("#statement_page"); //主体元素
                var str = '<div class="loading-more"><i></i>正在加载…</div>';
                $(window).scroll(function() {
                    var srollPos = $(window).scrollTop(); //滚动条距顶部距离(页面超出窗口的高度)
                    totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
                    if (($(document).height() - range) <= totalheight && canRequest) {
                        $('.loading-more').remove();
                        main.append(str);
                        canRequest = false;
                        $.ajax({
                            type: "get",
                            url: "/playhamster/my_score/",
                            async: false,
                            dataType: 'json',
                            data: 'ajax=1&page=' + Page,
                            success: function(result) {
                                $('.loading-more').remove();
                                canRequest = true;
                                if (result.err == '0' && result.data != "") {//查询结果有数据
                                    main.append(result.data);
                                    Page++;
                                } else if (result.err == '0' && result.data == "") {//查询结果无数据
                                    canRequest = false;
                                }
                            }
                        });
                    }
                });
            });
        </script>

    </body>
</html>