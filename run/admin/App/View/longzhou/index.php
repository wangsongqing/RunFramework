<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta name="viewport" content="width=device-width"/>
        <meta name="MobileOptimized" content="320"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>赛龙舟</title>
        <script type="text/javascript" src="<?=Resource?>game/longzhou/js/jquery-2.1.0.min.js"></script>
        <link rel="stylesheet" href="<?=Resource?>bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="<?=Resource?>bootstrap/css/bootstrap.min.css" />
        <link href="<?=Resource?>bootstrap/css/font-awesome.min.css" rel="stylesheet">
        <script src="<?=Resource?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=Resource?>game/longzhou/js/jquery.transit.js"></script>
        <script src="<?=Resource?>game/longzhou/js/jquery.touchSwipe.min.js"></script>
        <script src="<?=Resource?>game/longzhou/js/ts_page_slider.js"></script>
        <script src="<?=Resource?>game/longzhou/js/ts_fast_click.js"></script>
        <script src="<?=Resource?>game/longzhou/js/jquery.post_form.js"></script>
        <style type="text/css">
            /*-----默认样式-----*/
            body{
                -moz-user-select:none; /*火狐*/
                -webkit-user-select:none; /*webkit浏览器*/
                -ms-user-select:none; /*IE10*/
                -khtml-user-select:none; /*早期浏览器*/
                user-select:none;
                overflow:hidden;
                width:100%;
                height:100%;
            }
            #game_panel{
                -moz-user-select:none; /*火狐*/
                -webkit-user-select:none; /*webkit浏览器*/
                -ms-user-select:none; /*IE10*/
                -khtml-user-select:none; /*早期浏览器*/
                user-select:none;
            }
            #lz_my_boat{
                -moz-user-select:none; /*火狐*/
                -webkit-user-select:none; /*webkit浏览器*/
                -ms-user-select:none; /*IE10*/
                -khtml-user-select:none; /*早期浏览器*/
                user-select:none;
            }
            .circle_btn { 
                width: 50px; 
                height: 50px; 
                border: 0px; 
                -webkit-border-radius: 25px 25px 25px 25px; 
            }
            .shake_boat {
                -webkit-animation: shake_boat 0.5s infinite linear;
            }
            @-webkit-keyframes shake_boat {
                0% {-webkit-transform: translateX(0px);}
                10% {-webkit-transform: translateX(-10px);}
                20% {-webkit-transform: translateX(10px);}
                30% {-webkit-transform: translateX(-10px);}
                40% {-webkit-transform: translateX(10px);}
                50% {-webkit-transform: translateX(-10px);}
                60% {-webkit-transform: translateX(10px);}
                70% {-webkit-transform: translateX(-10px);}
                80% {-webkit-transform: translateX(10px);}
                90% {-webkit-transform: translateX(-10px);}
                100% {-webkit-transform: translateX(0);}    
            }
            .lh_class1{

                -webkit-transform-origin:50% 90%;
                -webkit-transform:rotate(5deg);

            }
        </style>
        <script>
            var SLZ = {
                dead: false,
                start_height: 70, //需要重新计算，根据屏幕大小
                docHeight: $(window).height(),
                docWidth: $(window).width(),
                lane_start_lane_pos: [],
                lane_end_lane_pos: [],
                ele_start_lane_pos: [],
                ele_end_lane_pos: [],
                mp_speed: 1800,
                max_level: 4,
                my_boat: {
                    cur_lane: 0, score: 0, life: 100,
                    ele_end_lane_pos: [],
                    shake: function() {
                        $('#lz_my_boat').addClass('shake_boat');
                        setTimeout(function() {
                            $('#lz_my_boat').removeClass('shake_boat');
                        }, 500);
                    },
                    move: function(lane_idx) {
                        if (lane_idx < 0 || lane_idx > 2 || lane_idx == this.cur_lane) {
                            return;
                        }
                        this.cur_lane = lane_idx;
                        console.log('move:' + this.cur_lane + ':' + this.ele_end_lane_pos[this.cur_lane][0]);
                        //$('#lz_my_boat').css({left:this.ele_end_lane_pos[this.cur_lane][0]-38});
                    },
                    go_left: function() {
                        if (this.cur_lane == 0) {
                            return;
                        }
                        this.cur_lane--;
                        $('#lz_my_boat').transition({left: this.ele_end_lane_pos[this.cur_lane][0] - 38}, 300);
                    },
                    go_right: function() {
                        if (this.cur_lane == 2) {
                            return;
                        }
                        this.cur_lane++;
                        $('#lz_my_boat').transition({left: this.ele_end_lane_pos[this.cur_lane][0] - 38}, 300);
                    },
                    boat_move_react: function() {
                        var oevent = window.event || arguments[0];
                        oevent.preventDefault();
                        oevent.stopPropagation();
                        var chufa = oevent.srcElement || oevent.target;
                        var boatX = oevent.changedTouches[0].clientX;
                        var boatY = oevent.changedTouches[0].clientY;
                        if (!window.boat_last_x) {
                            window.boat_last_x = boatX;
                            window.boat_last_y = boatY;
                        }
                        var x_offset = window.boat_last_x - boatX;
                        /**
                         if ( Math.abs(x_offset)>60 ){
                         if (x_offset>0){
                         SLZ.my_boat.go_left();
                         }else{
                         SLZ.my_boat.go_right();
                         }
                         window.boat_last_x = boatX;
                         }
                         */
                        $('#lz_my_boat').css({left: (boatX - 58)});
                        //if ( Math.abs(x_offset)>10 ){
                        window.boat_last_x = boatX;
                        if ((SLZ.lane_end_lane_pos[0][0] <= boatX && SLZ.lane_end_lane_pos[1][0] >= (boatX - 20))) {
                            SLZ.my_boat.move(0);
                        } else if ((SLZ.lane_end_lane_pos[1][0] <= boatX && SLZ.lane_end_lane_pos[2][0] >= boatX)) {
                            SLZ.my_boat.move(1);
                        } else if ((SLZ.lane_end_lane_pos[2][0] <= boatX && SLZ.lane_end_lane_pos[3][0] >= boatX)) {
                            SLZ.my_boat.move(2);
                        }
                        //}
                    }

                },
                core_task_handler: null,
                core_task: function() {
                },
                update_score: function() {
                    if (this.dead)
                        return;
                    $('.ready_tips').html('');
                    $('.ready_tips').show();
                    var count = 0;
                    window.update_tips_task = setInterval(function() {
                        count++;
                        if (count % 4 == 1) {
                            $('.ready_tips').html('.');
                        } else if (count % 4 == 2) {
                            $('.ready_tips').html('..');
                        } else if (count % 4 == 3) {
                            $('.ready_tips').html('..');
                        } else if (count % 4 == 0) {
                            $('.ready_tips').html('...');
                        }
                    }, 500);
                    $('#lz_my_boat').hide();
                    $.post('xx.php', {act: 'draw'}, function(data) {
                        clearInterval(window.update_tips_task);
                        $('.loading').hide();
                        //$('.wish_layer').show();
                        $('#submit_form').modal('show');
                        if (data.code == 1) {
                            if (data.prize == 1) {
                                //表单
                            } else {
                                //弹层显示祝福
                                var tq_img = ['/Resource/game/longzhou/img/tq1.png', '/Resource/game/longzhou/img/tq2.png', '/Resource/game/longzhou/img/tq3.png', '/Resource/game/longzhou/img/tq4.png', '/Resource/game/longzhou/img/tq5.png', '/Resource/game/longzhou/img/tq6.png'];
                                $('.no_gift_img').prop('src', tq_img[parseInt(Math.random() * 6)]);
                                $('.no_gift').show();

                            }
                        }
                    }, 'json');
                },
                bg_animation_task: function() {
                    var that = this;
                    this.gen_lane_bg(that.lane_start_lane_pos, that.lane_end_lane_pos);
                    /**
                     * 生成门牌
                     */
                    window.distance = 0;
                    window.distance_sec = 3000;
                    mp_stask = function() {
                        window.distance++;
                        if (window.distance < that.max_level) {
                            console.log("hited mp");
                            var mp_list = ['/Resource/game/longzhou/img/mp1.png'];
                            var mp_src = mp_list[0];
                            var mp_obj = $('<img src="' + mp_src + '" style="position:absolute;top:' + (-that.start_height) + 'px;width:' + (that.docWidth) + 'px;" />');
                            mp_obj.css({y: '0px', scale: '0.1'}).appendTo($('#game_panel'))
                            mp_obj.transition({y: (that.start_height + 50) + 'px', scale: 3}, that.mp_speed, 'linear');
                            (function(mp_obj) {
                                setTimeout(function() {
                                    $(mp_obj).remove();
                                }, that.mp_speed - 500);
                            })(mp_obj);
                            if (window.distance == (that.max_level - 1)) {
                                window.distance_sec = 1000;
                            }
                            setTimeout(function() {
                                if (!that.dead) {
                                    mp_stask();
                                }
                            }, window.distance_sec);
                        } else { //到达终点啦
                            console.log("hited finished");
                            var mp_src = '/Resource/game/longzhou/img/mp3.png';
                            var mp_obj = $('<img src="' + mp_src + '" style="position:absolute;top:' + (-that.start_height) + 'px;width:' + (that.docWidth) + 'px;" />');
                            mp_obj.css({y: '0px', scale: '0.1'}).appendTo($('#game_panel'))
                            mp_obj.transition({y: that.start_height + 'px', scale: 1}, 500, 'linear');
                            (function(mp_obj) {
                                setTimeout(function() {
                                    that.stop();
                                }, 200);
                            })(mp_obj);
                        }
                    }
                    setTimeout(function() {
                        mp_stask();
                    }, window.distance_sec);
                    /**
                     * 随机生成撞击物体
                     */
                    var when_end_func = function(obj) {
                        if (that.dead) {
                            return;
                        }
                        var obj_lane_idx = $(obj).attr('lane_idx');
                        if (obj_lane_idx == that.my_boat.cur_lane) { //hited game over
                            that.my_boat.life--;
                            console.log("hited:" + that.my_boat.life);
                            that.my_boat.shake();
                            $('#panel_life').html(that.my_boat.life);

                            that.stop(true);
                            $('#lz_my_boat').hide();
                            var game_over_layer_idx = parseInt(Math.random() * 4);
                            $('.game_over_layer' + (game_over_layer_idx + 1)).show();
                        }
                        $(obj).remove();
                    };
                    window.hit_task = setInterval(function() {
                        var lane_hit = [parseInt(Math.random() * 2), parseInt(Math.random() * 2), parseInt(Math.random() * 2)];
                        var hited_money_rate = parseInt(Math.random() * 10);
                        var hit_count = 0;
                        if (that.max_level <= (window.distance + 1)) { //吐币就不要出障碍物了
                        } else {
                            //var za_list = ['img/za1.png','img/za2.png'];
                            var za_list = ['/Resource/game/longzhou/img/za3.png', '/Resource/game/longzhou/img/za4.png'];
                            for (var i = 0; i < 3; i++) {
                                if ((lane_hit[i] == 1) && hit_count <= 1) { //按一定机率，出现障碍物, 而且不能三条道都出现，总要给人留条活路
                                    hit_count++;
                                    //$('<i class="fa fa-taxi" lane_idx="'+i+'" style="position:absolute;"></i>')
                                    var za_src = za_list[parseInt(Math.random() * 2)];
                                    //var za_src = za_list[0];
                                    var speed = that.gen_hit_speed();
                                    var hit_obj = $('<img src="' + za_src + '" lane_idx="' + i + '" style="position:absolute;width:30px;" />');
                                    hit_obj.css({x: that.ele_start_lane_pos[i][0], y: that.start_height, scale: '0.3', color: 'red'}).appendTo($('#game_panel'))
                                    hit_obj.transition({x: that.ele_end_lane_pos[i][0], y: that.ele_end_lane_pos[i][1], scale: 8}, speed, 'linear');
                                    (function(hit_obj) {
                                        setTimeout(function() {
                                            when_end_func(hit_obj);
                                        }, speed - 500);
                                    })(hit_obj);
                                }
                            }
                        }
                    }, 1000);
                    $('<div class="" id="panel_life" style="display:none;left:10px;top:10px;position:absolute;text-align:center;">100</div>').appendTo($('#game_panel'));
                    $('<div class="" id="panel_score" style="display:none;right:10px;top:10px;position:absolute;text-align:center;">0</div>').appendTo($('#game_panel'));
                },
                gen_hit_speed: function() {
                    var s = parseInt(Math.random() * 3);
                    if (s == 1) {
                        return 2000;
                    } else if (s == 2) {
                        return 2000;
                    } else {
                        return 2000;
                    }
                },
                start: function() {
                    var that = this;
                    this.docHeight = $(window).height();
                    this.docWidth = $(window).width();
                    var top_lane_width = parseInt(that.docWidth / 3);
                    var top_lane_interval_width = parseInt(top_lane_width / 4);
                    var top_lane_pos_start = parseInt((that.docWidth - top_lane_width) / 2);
                    var bottom_lane_width = parseInt(that.docWidth * 1.5);
                    var bottom_lane_interval_width = parseInt(bottom_lane_width / 4);
                    var bottom_lane_pos_start = parseInt((that.docWidth - bottom_lane_width) / 2);
                    /**
                     var lane_start_lane_pos = [];
                     var lane_end_lane_pos = [];
                     var ele_start_lane_pos = [];
                     var ele_end_lane_pos = [];
                     */
                    for (var i = 0; i < 4; i++) {
                        /** 赛道位置*/
                        that.lane_start_lane_pos.push([top_lane_pos_start + (top_lane_interval_width * i), 0]);
                        that.lane_end_lane_pos.push([bottom_lane_pos_start + (bottom_lane_interval_width * i) + 20, that.docHeight]);
                        /** 物体的运动轨迹在赛道中间*/
                        that.ele_start_lane_pos.push([top_lane_pos_start + (top_lane_interval_width * i + parseInt(top_lane_interval_width / 2)) + 10, 0]);
                        that.ele_end_lane_pos.push([bottom_lane_pos_start + (bottom_lane_interval_width * i + parseInt(bottom_lane_interval_width / 2)) + 30, that.docHeight + 30]);
                    }
                    that.my_boat.ele_end_lane_pos = that.ele_end_lane_pos;
                    console.log("starting");
                    that.my_boat.cur_lane = 1;
                    $('<div id="lz_my_boat" style="z-index:999;position:absolute;background-image:url(../../Resource/game/longzhou/img/my_boat.png); background-size:120px auto;width:120px;height:160px;" ></div>')
                            .css({left: that.ele_end_lane_pos[that.my_boat.cur_lane][0] - 38, top: (that.docHeight - 160), color: 'black'}).appendTo($('#game_panel'));

                    /** 初始化控制按钮3 */
                    $(window).bind("touchmove", that.my_boat.boat_move_react);
                    $('<div class="ready_tips" style="font-size:50px;color:red;text-align:center;position:absolute;top:' + parseInt((that.docHeight / 2) - 60) + 'px;width:' + (that.docWidth) + 'px;"></div>').appendTo($('#game_panel'));
                    $('<div class="za_tips" style="z-index:999;text-align:center;position:absolute;top:' + parseInt((that.docHeight / 2)) + 'px;width:' + (that.docWidth) + 'px;"><img src="img/za_tips.png" style="width:200px;"/></div>').appendTo($('#game_panel'));
                    var mp_src = '/Resource/game/longzhou/img/mp4.png';
                    var mp_obj = $('<img src="' + mp_src + '" style="position:absolute;top:90px;width:' + (that.docWidth) + 'px;" />');
                    mp_obj.css({y: '0px', scale: '1'}).appendTo($('#game_panel'));
                    var count = 3;
                    window.ready_count = setInterval(function() {
                        count--;
                        if (count == 0) {
                            $('.ready_tips').html('Go!');
                        } else if (count < 0) {
                            clearInterval(window.ready_count);
                            $('.ready_tips').hide();
                            $('.za_tips').fadeOut();
                            (function(mp_obj) {
                                mp_obj.transition({y: (that.start_height + 50) + 'px', scale: 3}, that.mp_speed, 'linear');
                                setTimeout(function() {
                                    $(mp_obj).remove();
                                    that.bg_animation_task();
                                }, that.mp_speed - 500);
                            })(mp_obj);

                        } else {
                            $('.ready_tips').html(count);
                        }

                    }, 1000);
                },
                gen_lane_bg: function(lane_start_lane_pos, lane_end_lane_pos) {
                    var css = '<style type="text/css">';
                    css = css + '.lane_boder_0 { -webkit-animation:lane_boder_0 0.2s infinite linear}';
                    css = css + '@-webkit-keyframes lane_boder_0 { from{-webkit-transform:translate(' + lane_start_lane_pos[0][0] + 'px,' + this.start_height + 'px) scale(0.2);} to{-webkit-transform:translate(' + lane_end_lane_pos[0][0] + 'px,' + lane_end_lane_pos[0][1] + 'px) scale(1);} }';
                    css = css + '.lane_boder_1 { -webkit-animation:lane_boder_1 0.2s infinite linear}';
                    css = css + '@-webkit-keyframes lane_boder_1 { from{-webkit-transform: translate(' + lane_start_lane_pos[1][0] + 'px,' + this.start_height + 'px) scale(0.2);  } to{-webkit-transform: translate(' + lane_end_lane_pos[1][0] + 'px,' + lane_end_lane_pos[1][1] + 'px) scale(1); } }';
                    css = css + '.lane_boder_2 { -webkit-animation:lane_boder_2 0.2s infinite linear}';
                    css = css + '@-webkit-keyframes lane_boder_2 { from{-webkit-transform:translate(' + lane_start_lane_pos[2][0] + 'px,' + this.start_height + 'px) scale(0.2);} to{-webkit-transform:translate(' + lane_end_lane_pos[2][0] + 'px,' + lane_end_lane_pos[2][1] + 'px) scale(1);} }';
                    css = css + '.lane_boder_3 { -webkit-animation:lane_boder_3 0.2s infinite linear}';
                    css = css + '@-webkit-keyframes lane_boder_3 { from{-webkit-transform:translate(' + lane_start_lane_pos[3][0] + 'px,' + this.start_height + 'px) scale(0.2);} to{-webkit-transform:translate(' + lane_end_lane_pos[3][0] + 'px,' + lane_end_lane_pos[3][1] + 'px) scale(1);} }';
                    css = css + '</style>';
                    $(css).appendTo("head");
                    for (var i = 0; i < 4; i++) {
                        $('<img class="lane_lh lane_boder_' + i + '"  src="img/lh' + (i + 1) + '.png" style="position:absolute;width:30px;" />').appendTo($('#game_panel'));
                    }
                },
                stop: function(dead) {
                    var that = this;
                    clearInterval(window.hit_task);
                    //clearInterval(window.mp_stask);
                    $('.lane_lh').remove();
                    this.dead = dead;
                    if (!dead) {
                        setTimeout(function() {
                            that.update_score();
                        }, 2000);
                    }
                }
            }
            var preload_func = function(preload_images, when_done_func) {
                var _preload_images = [];
                if (preload_images.length > 0) {
                    for (var i = 0; i < preload_images.length; i++) {
                        _preload_images[i] = new Image();
                        _preload_images[i].src = preload_images[i];
                    }
                    preload_handler = setInterval(function() {
                        var all_done = true;
                        for (var i = 0; i < _preload_images.length; i++) {
                            if (!_preload_images[i].complete) {
                                all_done = false;
                            }
                        }
                        if (all_done) {
                            clearInterval(preload_handler);
                            if (when_done_func != null) {
                                when_done_func();
                            }
                        }
                    }, 100);
                }
            }

            $(function() {
                $(document.body).css({height: $(window).height() + 'px'});
                $(document.body).css({width: $(window).width() + 'px'});
                $('#game_panel').css({height: $(window).height() + 'px'});
                $('#game_panel').css({width: $(window).width() + 'px'});
                $('.full_screen').css({height: $(window).height() + 'px'});
                $('.full_screen').css({width: $(window).width() + 'px'});
                var preload_images = ['/Resource/game/longzhou/img/tq1.png', '/Resource/game/longzhou/img/tq2.png', '/Resource/game/longzhou/img/tq3.png', '/Resource/game/longzhou/img/tq4.png', 'img/tq5.png', '/Resource/game/longzhou/img/tq6.png', '/Resource/game/longzhou/img/za1.png', '/Resource/game/longzhou/img/za2.png', '/Resource/game/longzhou/img/za3.png', '/Resource/game/longzhou/img/za4.png', '/Resource/game/longzhou/img/wish_notice.png', '/Resource/game/longzhou/img/bg2.jpg', '/Resource/game/longzhou/img/lh1.png', '/Resource/game/longzhou/img/lh2.png', '/Resource/game/longzhou/img/lh3.png', '/Resource/game/longzhou/img/lh4.png', '/Resource/game/longzhou/img/mp1.png', '/Resource/game/longzhou/img/mp2.png', '/Resource/game/longzhou/img/mp3.png', '/Resource/game/longzhou/img/mp4.png', '/Resource/game/longzhou/img/my_boat.png'];
                preload_func(preload_images, function() {
                    $('.loading').hide();
                    $('#game_panel').show();
                    SLZ.start();
                });
                $('.btn_share').click(function() {
                    $('.game_over_layer').hide();
                    $('.no_gift').hide();
                    $('.share_layer').show();
                });
            });
        </script>
    </head>
    <body style="padding:0px;margin:0px; overflow:hidden">
        <div class="loading full_screen" style="background:#78D0F6;color:white;position:absolute;top:0px;left:0px;width:100%;text-align:center;padding-top:100px;">loading...</div>

        <div class="wish_layer full_screen" style="display:none;z-index:2;text-align:center; padding:20px;position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">
            <img src="/Resource/game/longzhou/img/wish_notice.png" style="width:100%;" />
        </div>




        <div class="game_over_layer game_over_layer4 full_screen" style="display:none;z-index:2;text-align:center; padding:20px;position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">
            <div style="margin:auto;margin-top:20px;text-align:center;">
                <img src="/Resource/game/longzhou/img/za3.png" style="width:150px;"/>
            </div>

            <div style="font-size:22px;margin:auto;margin-top:30px;color:white;text-align:center;">
                我不是慢严舒柠家族的铜墙铁壁系列，<br/>
                没事别撞我！
            </div>
            <div style="margin-right:20px;margin-top:30px;color:white;text-align:right;">
                <img src="/Resource/game/longzhou/img/yh4.png" style="width:150px;"/>
            </div>
            <div style="margin:auto;margin-top:30px;text-align:center;">
                <a href="" class="btn btn-success" style="width:40%;margin-right:30px;">再来一次</a>
                <a href="" class="btn btn-success" style="width:40%;">挑逗一下</a>
            </div>
        </div>


        <div class="game_over_layer game_over_layer3 full_screen" style="display:none;z-index:2;text-align:center; padding:20px;position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">
            <div style="margin:auto;margin-top:20px;text-align:center;">
                <img src="/Resource/game/longzhou/img/za3.png" style="width:150px;"/>
            </div>

            <div style="font-size:22px;margin:auto;margin-top:30px;color:white;text-align:center;">
                撞到粽子别上火，<br/>
                来颗好爽糖压压惊吧！
            </div>
            <div style="margin-right:20px;margin-top:30px;color:white;text-align:right;">
                <img src="/Resource/game/longzhou/img/yh3.png" style="width:150px;"/>
            </div>
            <div style="margin:auto;margin-top:30px;text-align:center;">
                <a href="" class="btn btn-success" style="width:40%;margin-right:30px;">再来一次</a>
                <a href="" class="btn btn-success" style="width:40%;">挑逗一下</a>
            </div>
        </div>


        <div class="game_over_layer game_over_layer2 full_screen" style="display:none;z-index:2;text-align:center; padding:20px;position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">
            <div style="margin:auto;margin-top:20px;text-align:center;">
                <img src="/Resource/game/longzhou/img/za3.png" style="width:150px;"/>
            </div>

            <div style="font-size:22px;margin:auto;margin-top:30px;color:white;text-align:center;">
                撞我没礼物，<br/>不爽再来吧！
            </div>
            <div style="margin-right:20px;margin-top:30px;color:white;text-align:right;">
                <img src="/Resource/game/longzhou/img/yh2.png" style="width:150px;"/>
            </div>
            <div style="margin:auto;margin-top:30px;text-align:center;">
                <a href="" class="btn btn-success" style="width:40%;margin-right:30px;">再来一次</a>
                <button class="btn btn-success btn_share" style="width:40%;">挑逗一下</button>
            </div>
            <div style="position:fixed;bottom:2px;width:100%;margin:auto;font-size:12px;color:white;margin-top:20px;text-align:center;">
                皖药广审（视）第：2015010001号
            </div>
        </div>

        <div class="game_over_layer game_over_layer1 full_screen" style="display:none;z-index:2;text-align:center; padding:20px;position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">
            <div style="margin:auto;margin-top:20px;text-align:center;">
                <img src="/Resource/game/longzhou/img/za3.png" style="width:150px;"/>
            </div>

            <div style="font-size:22px;margin:auto;margin-top:30px;color:white;text-align:center;">
                撞我不要紧，<br/>但是你失去了一次柠博士给你派发礼物的机会！
            </div>
            <div style="margin-right:20px;margin-top:30px;color:white;text-align:right;">
                <img src="/Resource/game/longzhou/img/yh1.png" style="width:80px;"/>
            </div>
            <div style="margin:auto;margin-top:30px;text-align:center;">
                <a href="" class="btn btn-success" style="width:40%;margin-right:30px;">再来一次</a>
                <button class="btn btn-success btn_share" style="width:40%;">挑逗一下</button>
            </div>

            <div style="position:fixed;bottom:2px;width:100%;margin:auto;font-size:12px;color:white;margin-top:20px;text-align:center;">
                皖药广审（视）第：201308063号
            </div>

        </div>


        <div class="no_gift full_screen" style="display:none;z-index:2;text-align:center; padding:20px;position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">

            <div style="font-size:22px;margin:auto;margin-top:10px;color:white;text-align:center;">
                <img class="no_gift_img" src="/Resource/game/longzhou/img/tq1.png" style="width:99%"/>
            </div>
            <div style="margin:auto;margin-top:30px;text-align:center;">
                <a href="" class="btn btn-success" style="width:40%;margin-right:30px;">再来一次</a>

                <button class="btn btn-success btn_share" style="width:40%;">挑逗一下</button>
            </div>
        </div>



        <div class="share_layer full_screen" style="display:none;z-index:2;text-align:center; position:absolute;top:0px;left:0px;width:100%;background:rgba(0,0,0,0.85);">
            <div class="full_screen" style="padding:10px;margin-top:1px;text-align:right;">
                <img src="/Resource/game/longzhou/img/share_tips.png" style="width:100%;"/>
            </div>
        </div>

        <div id="game_panel" style="display:none;position:relative;margin:0px;padding:0px;overflow:hidden; width:100%;height:100%;background-image:url(../../Resource/game/longzhou/img/bg2.jpg); background-size:100% 100%; background-repeat:no-repeat;"></div>
        <div class="modal fade" id="submit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div style="position:relative;margin-top:15px;">
                <img src="/Resource/game/longzhou/img/form_ele1.png" style="float:left;width: 70px;position: absolute;top: 30px;z-index: 999999999;" />
                <img src="/Resource/game/longzhou/img/form_ele2.png" style="float: right;width: 200px;margin-right: 13px;">
            </div>
            <div style="clear:both;margin:0px;padding:0px;"></div>
            <div class="modal-dialog" style="">
                <div class="modal-content">
                    <!--  
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">奖品邮寄信息填写</h4>
                      </div>
                    -->
                    <div class="modal-body">
                        <input type="hidden" name="pid" value="" class="pid" /> 	  
                        <div class="input-group input-group" style="margin-bottom:10px;">
                            <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="姓名" name="uname" value="" >
                        </div>

                        <div class="input-group input-group" style="margin-bottom:10px;">
                            <span class="input-group-addon" ><i class="fa fa-phone"></i></span>
                            <input type="tel" class="form-control" placeholder="电话" name="tel" value="">
                        </div>  

                        <!--  
                        <hr  style="height:1px;border:none;border-top:1px dashed #0066CC; width:100%; margin-top:40px;"/>
                        <div style="font-size:14px;margin-left:4px;margin-bottom:10px;font-weight: bold;">邮寄地址:</div>
                        -->

                        <div class="input-group" style="margin-bottom:10px;;width:100%">
                            <div id="city_china_val"> 
                                <select class="province form-control" name="province" id="province" data-first-title="请选择省份" data-first-value="" style="margnin-left:4px; max-width:35%"></select> 
                                <select class="city form-control "  name="city" id="city" data-first-title="请选择城市" data-first-value="" style="margnin-left:4px; max-width:35%"></select> 
                                <select class="area form-control " name="area" id="area" data-first-title="请选择区域" data-first-value="" style="margnin-left:4px; max-width:30%"></select>
                            </div>
                        </div>

                        <div class="input-group input-group" style="margin-bottom:10px;width:100%">
                            <input type="text" class="form-control" placeholder="详细地址" name="ydmc" value="">
                        </div>       
                    </div>
                    <div class="modal-footer">
                        <!--  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>  -->
                        <button type="button" class="btn btn-primary" onclick="sub()">提交</button>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function select_def_city(pname, cname, aname) {
                if (pname != null) {
                    $('.province').attr('data-value', pname);
                }
                if (cname != null) {
                    $('.city').attr('data-value', cname);
                }
                if (aname != null) {
                    $('.area').attr('data-value', aname);
                }
                $('#city_china_val').cxSelect({
                    selects: ['province', 'city', 'area'],
                });
            }
            $.cxSelect.defaults.url = 'js/cityData.min.json';
            select_def_city(null, null, null);
        </script>

    </body>
</html>