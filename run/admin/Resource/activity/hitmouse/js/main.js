var HitMouse = {};
HitMouse.opts = null;
HitMouse.sum = 0;
HitMouse.invite = null;
HitMouse.hid = 0;
HitMouse.timer = null;
HitMouse.hashString = null;
HitMouse.isLogin = false;
HitMouse.isPlayAudio = true; //是否播放背景音乐
HitMouse.isPlayGame = false; //是否正在游戏中
HitMouse.scale = 0;
HitMouse.curTime = 0;
HitMouse.curStep = 0;
HitMouse.resource = null;
HitMouse.playTimeStamp = 0;
HitMouse.pauseTimeStamp = 0;
HitMouse.babyCount = 0;
HitMouse.mouseCount = 0;
HitMouse.playTimes = 0;
HitMouse.domain = '';
HitMouse.curCount = 0;
HitMouse.g_delayMax = 0;
HitMouse.g_percent = 0;
HitMouse.isAanroid = function() {
    return /(Android)/i.test(navigator.userAgent)
};
HitMouse.isIOS = function() {
    return /(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)
};
HitMouse.init = function(options) {
    var defaults = {
        path: "Resource/games/hitmouse/",
        babyAmout: 3, //每轮出现宝宝数量
        mouseAmout: 3, //每轮出现地鼠数量
        time: 20000, //总时间
        mouseSum: 10,
        babySum: 20,
        perfectSum: 200, //完美金额
        delayMax: 450, //间隔
        delayMin: 450
    };
    this.resource = {
        images: ["cover.png", "gm_bg.jpg", "over_ti.png", "start_ti.png", "sprite.png", "rotate.png", "animate.png"],
        audios: {
            bgm: ["bgm.mp3", "bgm.ogg"],
            begin: ["begin.mp3", "begin.ogg"],
            cry: ["cry.mp3", "cry.ogg"],
            hit: ["hit.mp3", "hit.ogg"],
            nohit: ["no_hit.mp3", "no_hit.ogg"],
            over: ["over.mp3", "over.ogg"],
        }
    };
    this.opts = $.extend({}, defaults, options);
    this.animate.switch($("#loading .baby"), 2, "loading");
    if (window.orientation == 90 || window.orientation == -90) {
        $("#screenTip").show();
    }
    this.g_delayMax = this.opts.delayMax;
    this.loading(this.opts.path, this.resource.images)
    this.createNum($("#sum"), this.sum);
    this.createNum($("#time"), this.opts.time / 1000);
    this.events();
};
HitMouse.responsive = function(options) {
    var win = window,
            doc = document,
            docElem = doc.documentElement,
            Events = 'orientationchange' in window ? 'orientationchange' : 'resize',
            func = function() {
                var clientWidth = docElem.clientWidth;
                var clientHeight = docElem.clientHeight;
                if (!clientWidth)
                    return;
                var sizeW = clientWidth / 640;
                var sizeH = docElem.clientHeight;
                HitMouse.scale = sizeW;
                sizeH = navigator.userAgent.toLowerCase().indexOf("mobile") > -1 ? sizeH / sizeW : 1009;
                var scale = "scale(" + (sizeW > 1 ? 1 : sizeW) + ")";
                var csstext = "height:" + sizeH + "px;width:640px;transform:" + scale + ";-ms-transform:" + scale + ";-moz-transform:rotate" + scale + ";-webkit-transform:" + scale + ";-o-transform:" + scale;
                document.querySelector("#mainContent") ? document.querySelector("#mainContent").style.cssText = csstext : !0;
            };
    if (!doc.addEventListener)
        return;
    win.addEventListener(Events, func, false);
    doc.addEventListener('DOMContentLoaded', func, false);
};
HitMouse.responsive();
HitMouse.loading = function(path, datas, callback) {
    var imgIndex = auIndex = index = sum = 0,
            images = new Array(),
            audios = new Array();

    function loading() {
        index--;
        $("#progress i").css("width", ((sum - index) * 100 / sum) + "%");
        if (index == 0) {
            setTimeout(function() {
                clearInterval(HitMouse.animate.timer["loading"]);
                $("#loading").hide();
                $("#gameScene").show();
            }, 500)
        }
    }
    for (var i = 0; i < datas.length; i++) {
        images[i] = new Image();
        images[i].src = path + "images/" + datas[i]
    }
    ;
    index = sum = images.length;
    for (var i = 0; i < images.length; i++) {
        images[i].onload = loading;
        images[i].onload = loading;
    }
};
HitMouse.createNum = function(obj, num) {
    obj.html(num)
};
HitMouse.control = {
    datas: [],
    timer: null,
    index: 5,
    elem: ["mouse", "baby", "mouse"],
    temp: 0,
    count: {
        baby: 0,
        mouse: 0
    },
    generateOrder: function(xleng) {
        var that = this;
        that.datas = [],
                arr = [];
        for (var i = 0; ; i++) {
            if (that.datas.length < xleng) {
                that.random(that.datas, that.datas);
            } else {
                break;
            }
        }
        return {
            mouse: that.datas.slice(0, HitMouse.opts.mouseAmout),
            baby: that.datas.slice(HitMouse.opts.mouseAmout, HitMouse.opts.babyAmout + HitMouse.opts.mouseAmout)
        }
    },
    randomAll: function(arr, obj) {
        var rand = Math.floor(Math.random() * 9);
        for (var j = 0; j < arr.length; j++) {
            if (arr[j] == rand) {
                return false
            }
        }
        obj.push(rand)
    },
    random: function(n) {
        return Math.floor(Math.random() * n);
    },
    beginCountdown: function() {
        var that = this;
        if (that.index > 0) {
            $("#countdown").show().find("p").html(that.index)
            that.index--;
            that.timer = setTimeout('HitMouse.control.beginCountdown()', 1000)
        } else {
            HitMouse.playTimeStamp = new Date().getTime();
            $("#countdown").hide();
            that.start();
            clearTimeout(that.timer)
        }
    },
    gameCountdown: function(time, callback) {
        var that = this,
                timer = null;
        HitMouse.createNum($("#time"), --time);
        timer = setInterval(function() {
            if (time > 0) {
                if (HitMouse.isPlayGame == false) {
                    clearInterval(timer);
                    HitMouse.curTime = time;
                } else {
                    time--;
                    HitMouse.createNum($("#time"), time);
                }
            } else {
                clearInterval(timer);
                callback && callback.call();
            }
        }, 1000)
    },
    filter: function(num) {
        var count = 0,
                timeCout = 0,
                delay = num,
                temp = 0;
        for (var i = 0; ; i++) {
            if (delay > HitMouse.opts.delayMin && timeCout < HitMouse.opts.time) {
                timeCout += delay
                count += 1;
            } else {
                break;
            }
        }
        if (HitMouse.opts.time > timeCout) {
            temp = (HitMouse.opts.time - timeCout) / HitMouse.opts.delayMin;
        }
        var amout = count + temp;
        amout = Math.floor(amout) == amout ? amout : parseInt(amout) + 1;
        return amout
    },
    shuffle: function(arr) {
        var len = arr.length;
        for (var i = 0; i < len - 1; i++) {
            var idx = Math.floor(Math.random() * (len - i));
            var temp = arr[idx];
            arr[idx] = arr[len - i - 1];
            arr[len - i - 1] = temp;
        }
        return arr;
    },
    percent: function() {
        var array = [];
        var count = HitMouse.control.filter(HitMouse.g_delayMax);
        mouse_count = HitMouse.mouseAmount,
                baby_count = count - mouse_count;
        for (var i = 0; i < baby_count; i++) {
            array.push(0)
        }
        for (var i = 0; i < mouse_count; i++) {
            array.push(1)
        }
        return this.shuffle(array);
    },
    carousel: function(time) {
        var that = this,
                opts = HitMouse.opts,
                ani = HitMouse.animate;
        var rand = that.random(9);
        for (var i = 0; ; i++) {
            if (that.temp == rand) {
                rand = that.random(9);
            } else {
                that.temp = rand;
                break;
            }
        }
        var i = 0;
        if (HitMouse.g_percent[HitMouse.curCount] == 0) {
            that.count.baby += 1;
            i = 1;
        }
        else if (HitMouse.g_percent[HitMouse.curCount] == 1) {
            if (that.count.mouse >= HitMouse.mouseAmount) {
                that.count.baby += 1;
                i = 1;
            }
            else {
                that.count.mouse += 1;
                i = 0;
            }
        }
        else {
            that.count.baby += 1;
            i = 1;
        }
        ani.inOut(that.elem[i], rand);
        if (HitMouse.g_delayMax > HitMouse.opts.delayMin) {
            HitMouse.g_delayMax -= 10;
        }
        HitMouse.timer = setTimeout('HitMouse.control.carousel()', HitMouse.g_delayMax);
        HitMouse.curCount += 1;
    },
    reset: function() {
        var that = this;
        HitMouse.createNum($("#time"), HitMouse.opts.time / 1000);
        HitMouse.createNum($("#sum"), HitMouse.opts.sum);
        $("#btn_start").removeClass("btn-pause").addClass("btn-start");
        $("#btn_start").show().attr("data-btn-status", "start");
        clearTimeout(HitMouse.timer);
        if (HitMouse.isIOS()) {
            clearInterval(HitMouse.animate.timer["mouse"]);
            clearInterval(HitMouse.animate.timer["mouse2"]);
            clearInterval(HitMouse.animate.timer["baby"]);
            clearInterval(HitMouse.animate.timer["baby2"]);
        }
        that.index = 5;
        HitMouse.g_delayMax = HitMouse.opts.delayMax;
        HitMouse.babyCount = 0;
        HitMouse.mouseCount = 0;
        HitMouse.control.count.baby = 0;
        HitMouse.control.count.mouse = 0;
        HitMouse.curCount = 0;
        HitMouse.g_percent = 0;
    },
    start: function() {
        var that = this,
                ani = HitMouse.animate;
        HitMouse.isPlayGame = true;
        HitMouse.sum = 0;
        HitMouse.audios.play("bgm");
        if (HitMouse.isIOS()) {
            ani.switch($(".mouse"), 2, "mouse");
            ani.switch($(".mouse2"), 4, "mouse2");
            ani.switch($(".baby"), 3, "baby");
            ani.switch($(".baby2"), 4, "baby2");
        }
        ;
        HitMouse.g_percent = HitMouse.control.percent();
        that.gameCountdown(HitMouse.opts.time / 1000, function() {
            that.over();
        });
        that.carousel();
        HitMouse.curStep++
    },
    over: function() {
        var that = this;
        HitMouse.audios.stop("bgm");
        HitMouse.isPlayGame = false;
        var score = HitMouse.sum <= 0 ? 0 : HitMouse.sum > 300 ? 300 : HitMouse.sum;
        $("#sum2").html(score);
        var mouseCount = HitMouse.control.count.mouse,
                hitMouseCount = HitMouse.mouseCount;
        if (hitMouseCount > mouseCount / 3 * 2) {
            HitMouse.audios.play("over");
            $("#result_expression").removeAttr('class').addClass('nice');
            HitMouse.animate.switch($("#result_expression"), 3, "result_expression");
        } else if (hitMouseCount <= mouseCount / 3 * 2 && hitMouseCount > mouseCount / 3) {
            HitMouse.audios.play("over");
            $("#result_expression").removeAttr('class').addClass('fighting');
            HitMouse.animate.switch($("#result_expression"), 2, "result_expression");
        } else {
            HitMouse.audios.play("fail");
            $("#result_expression").removeAttr('class').addClass('fighting');
            HitMouse.animate.switch($("#result_expression"), 2, "result_expression");
        }
        ;
        HitMouse.action.send();
        if (HitMouse.isLogin) {
            $("#overBtns .btn-view").show();
            $("#overBtns .btn-replay").show();
            $("#overBtns .btn-receive").hide();
        } else {
            $("#overBtns .btn-view").hide();
            $("#overBtns .btn-replay").hide();
            $("#overBtns .btn-receive").show();
        }
        that.reset();
        $("#gameScene").hide();
        setTimeout(function() {
            $("#gameOver").show();
        }, 500)
    }
};
HitMouse.animate = {
    timer: {},
    index: 0,
    switch : function(obj, n, name, loop) {
        var that = this,
                index = 0;
        that.timer[name] = setInterval(function() {
            if (index < n) {
                obj.attr({"data-frames": index})
                index++
            } else {
                if (loop != undefined && !loop) {
                    clearInterval(that.timer[name])
                    obj.removeAttr("data-frames");
                    obj.hide();
                }
                index = 0
            }
        }, 200)
    },
    inOut: function(name, arr) {
        var that = this,
                delay = 0,
                delay2 = 400,
                $this = $(this);
        $("#gird i.baby2,#gird i.mouse2").hide();
        $("#" + name + arr).removeClass("inOut").show().addClass('inOut');
        HitMouse.playTimeStamp = new Date().getTime()
        //setTimeout(function(){
        //    $("#" + name + arr).removeClass("inOut").hide();
        //},1000);
    }
};
HitMouse.popup = {
    show: function(options) {
        var that = this,
                defaults = {
                    title: "",
                    content: "",
                    btn: [],
                    ok: function() {
                    },
                    cancel: function() {
                        that.hide();
                    }
                },
        opts = $.extend({}, defaults, options),
                that = this,
                $obj = $("#popup");
        $obj.show();
        $obj.find(".hd p").html(opts.title);
        $obj.find(".bd").html(opts.content);
        if (opts.btn.length == 0) {
            $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">确定</a>');
        }
        ;
        if (opts.btn.length == 1) {
            $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">' + opts.btn[0] + '</a>');
        }
        ;
        if (opts.btn.length == 2) {
            $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">' + opts.btn[0] + '</a><a href="javascript:;" class="btn btn-buy">' + opts.btn[1] + '</a>');
        }
        $obj.find(".dialog .inner,.dialog").css("height", "auto");
        var h = $obj.find(".dialog").prop("scrollHeight") + 88;
        $obj.find(".dialog").css({"margin-top": "-" + h / 2 - 10 + "px"});
        $obj.find(".dialog .inner").css({height: h});
        setTimeout(function() {
            $obj.find(".dialog").addClass('show')
        }, 100);
        $(".btn-cancel").on("touchstart", function() {
            opts.cancel();
        });
        $(".btn-buy").on("touchstart", function() {
            opts.ok();
        });
        $(".dialog .close").on("touchstart", function() {
            that.hide();
        });
    },
    hide: function() {
        $("#popup .dialog").removeClass('show');
        setTimeout(function() {
            $("#popup").hide();
        }, 150);
    }
};
HitMouse.events = function() {
    var that = this;
    $("#btn_start").on("touchstart", function() {
        BB.popup.loading.show();
        var status = $(this).attr("data-btn-status");
        if (status == "start") {
            $(this).hide();
            if (that.action.check()) {
                if (that.curStep == 0) {
                    that.audios.preload();
                }
                ;
                that.audios.play("begin");
                $(this).hide();
                //$(this).removeClass("btn-start").addClass("btn-pause");
                //$(this).attr("data-btn-status","pause");
                that.control.beginCountdown();
            }
        } else if (status == "pause") {
            that.pauseTimeStamp = new Date().getTime() - HitMouse.playTimeStamp;
            clearTimeout(that.timer);
            that.isPlayGame = false;
            $(this).attr("data-btn-status", "restart");
            $("i.baby,i.mouse").css("-webkit-animation-play-state", "paused")
            $(this).removeClass("btn-pause").addClass("btn-start");
        } else if (status == "restart") {
            that.isPlayGame = true;
            $("i.baby,i.mouse").css("-webkit-animation-play-state", "running")
            setTimeout(function() {
                that.control.gameCountdown(that.curTime, function() {
                    that.control.over();
                });
                that.control.carousel();
                that.playTimeStamp = new Date().getTime();
                $("#btn_start").attr("data-btn-status", "pause");
                $("#btn_start").removeClass("btn-start").addClass("btn-pause");
            }, 500 - that.pauseTimeStamp);

        }
    });
    $(document).delegate("#btn_replay", "touchstart", function() {
        clearInterval(that.animate.timer["result_expression"]);
        HitMouse.playTimes++;
        if (that.action.check()) {
            $("#gird i.baby2,#gird i.mouse2").hide();
            $("#gird i.baby,#gird i.mouse").removeClass("inOut");
            $("#gameOver").hide();
            $("#gameScene").show();
            $("#btn_start").hide();
            that.audios.play("begin");
            //$("#btn_start").removeClass("btn-start").addClass("btn-pause");
            //$("#btn_start").attr("data-btn-status","pause");
            that.control.beginCountdown();
        }
    });
    $(".btn-bgm").on("touchstart", function() {
        var $this = $(".btn-bgm");
        if ($this.attr("data-btn-status") == "on") {
            that.isPlayAudio = false;
            $this.addClass('off');
            $this.attr("data-btn-status", "off");
            that.audios.stopAll();
        } else {
            that.isPlayAudio = true;
            if (that.isPlayGame) {
                that.audios.play("bgm");
            }
            $this.removeClass('off');
            $this.attr("data-btn-status", "on");

        }
    });
    $("#gird .baby").on("touchstart", function() {
        var $this = $(this),
                top = $this.position().top + 10;
        if (that.isPlayGame) {
            that.babyCount += 1;
            that.createNum($("#sum"), that.sum -= that.opts.babySum);
            $this.css("display", "none").parent().find(".baby2").css({"top": top, "display": "block"}).html('<b>' + "-" + that.opts.babySum + '</b>');
        }
    });
    $("#gird .mouse").on("touchstart", function(event) {
        var $this = $(this),
                top = $this.position().top + 10;
        if (that.isPlayGame) {
            that.mouseCount += 1;
            that.createNum($("#sum"), that.sum += that.opts.mouseSum);
            $this.css("display", "none").parent().find(".mouse2").css({"top": top, "display": "block"}).html('<b>' + "+" + that.opts.mouseSum + '</b>');
        }
    });
    $("#gird").on("touchstart", function(event) {
        if (that.isPlayGame) {
            var left = event.touches[0].pageX / that.scale - 40,
                    top = event.touches[0].pageY / that.scale - 50;
            $(".hammer").css({"left": left, "top": top, display: "block"});
            if (!that.isAanroid()) {
                if (event.srcElement.className.indexOf("mouse") > -1) {
                    that.audios.replay("hit");
                } else if (event.srcElement.className.indexOf("baby") > -1) {
                    that.audios.replay("cry");
                } else {
                    that.audios.replay("nohit");
                }
            }
            clearInterval(that.animate.timer["hammer"]);
            that.animate.switch($(".hammer"), 2, "hammer", false);
        }
    });
    $(".btn-rule").on("touchstart", function() {
        var html = '<div class="rule-list">' +
                ' <dl>' +
                '<dt>1、</dt>' +
                '<dd>打到地鼠奖成长金，打到宝宝扣双倍成长金；</dd>' +
                ' </dl>' +
                ' <dl>' +
                '<dt>2、</dt>' +
                '<dd>领取成长金后，立即到账并产生收益。</dd>' +
                ' </dl>' +
                '</div>';
        that.popup.show({
            title: "游戏规则",
            content: html,
            btn: ["知道了"]
        })
    });
};
HitMouse.audios = {
    index: {},
    preload: function() {
        if (HitMouse.isIOS()) {
            $("#audios audio").each(function(i) {
                $(this)[0].play();
                $(this)[0].pause();
            })
        }
    },
    play: function(name) {
        var that = this,
                audios = HitMouse.resource.audios,
                path = HitMouse.opts.path + "audios/";
        if (HitMouse.isPlayAudio == true) {
            $('#audio_' + name)[0].play()
        }
    },
    replay: function(name) {
        if (HitMouse.isPlayAudio == true) {
            this.index[name] = this.index[name] == undefined ? 0 : this.index[name];
            if (this.index[name] > 2) {
                this.index[name] = 0;
            }
            $("#audio_" + name + "_" + this.index[name])[0].play();
            this.index[name]++;
        }

    },
    stop: function(name) {
        $('#audio_' + name)[0].pause();
    },
    stopAll: function() {
        $("#audios audio").each(function(i) {
            $(this)[0].pause();
        })
    }
};


HitMouse.action = {
    check: function() { //检测是否有游戏次数
        var flag = false;
        //ajax请求，判断用户今日是否可玩
        $.ajax({
            type: "post",
            url: "/playhamster/start/",
            dataType: 'json',
            data: {isPost: 1, isRestart: HitMouse.playTimes},
            async: false,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                flag = false;
                HitMouse.popup.show({
                    title: "网络异常",
                    content: "请稍后重试"
                });
            },
            success: function(data) {
                BB.popup.loading.hide();
                if (data.err > 0) {
                    HitMouse.hid = data.msg;
                    HitMouse.hashString = data.data.hash_string;
                        /*HitMouse.popup.show({
                            title: '',
                            content: data.data.msg,
                            btn: ['取消', '确定'],
                            cancel: function() {
                                location.href = data.data.url;
                            },
                            ok: function() {
                                HitMouse.popup.hide();
                                $("#gird i.baby2,#gird i.mouse2").hide();
                                $("#gird i.baby,#gird i.mouse").removeClass("inOut");
                                $("#gameOver").hide();
                                $("#gameScene").show();
                                HitMouse.audios.play("begin");
                                HitMouse.control.beginCountdown();
                            }
                        });*/
                        HitMouse.mouseAmount = data.data.mouseAmount;
                        flag = true;
                   
                } else {
                     HitMouse.popup.show({
                            title: '',
                            content: data.msg,
                            btn: ['取消', '确定'],
                            ok: function() {
                                alert('ok');
                            }
                        });
                }
            }
        });
        return flag;
    },
    send: function() { //发送游戏结果
        var isSend = false;
        if (isSend == true)
            return false;
        var AuthStr = HitMouse.mouseCount + '#' + HitMouse.babyCount + '#' + HitMouse.sum + '#' + HitMouse.hid + '#' + HitMouse.hashString;
        var PostStr = encryptionJs.run_encryption(AuthStr);
        $.ajax({
            type: "post",
            url: "/playhamster/send/",
            data: {isPost: 1, Poststr: PostStr},
            async: false,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                isSend = false;
                HitMouse.popup.show({
                    title: "网络异常",
                    content: "请稍后重试"
                });
            },
            success: function(data) {
                    var obj = $('#gameOver');
                    obj.empty();
                    obj.append(data);
            }
        });
    },
    receive: function() {//确认领取成长金,服务器端已删....

    }
};