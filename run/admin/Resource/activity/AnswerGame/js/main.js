var AnswerGame = function(win, doc) {
    var g_score = 0, //总成绩
            g_index = 0, //当前索引
            g_right_num = 0, //正确数
            g_error_num = 0, //错误数
            g_score = 0, //总分
            g_subject_id = 0, //科目
            g_opts = null;
    g_result = null;
    g_hashString = null,
            g_timer = null,
            eType = "ontouchend" in document ? "touchstart" : "click",
            g_btn = {"-1005": "去投资", "-1009": "发给好友", "-1010": "好友助力", "-1019": "去邀请", "-1020": "去登录"};
    var Element = {
        $answer: $("#answer"),
        $question: $("#question"),
        $score: $("#score"),
        $countdown: $("#countdown"),
        $start: $("#btn_start"),
        $restart: $("#btn_restart"),
        $ui_start: $(".pg-ticket"),
        $ui_game: $(".games"),
        $ui_over: $(".pg-over")
    };

    var Event = {
        click: function() {
            var el = Element,
                    clickIndex = 0;
            $(document).undelegate('#answer li', eType).delegate('#answer li', eType, function() {
                if (clickIndex == 0) {
                    if ($(this).index() == g_result[g_index].right_answer.indexOf("1")) {
                        $(this).addClass('right');
                        g_right_num += 1;
                    }
                    else {
                        $(this).addClass('error');
                        g_error_num += 1;
                    }
                    g_score = (g_opts.price * g_right_num) - (g_opts.err_price * g_error_num);
                    Element.$score.text(g_score);
                    clickIndex = 1;

                    g_index += 1;
                    setTimeout(function() {
                        if (g_result != null) {
                            if (g_result.length == g_index) {
                                Run.over();
                            }
                            else {
                                Control.createHTML(g_index);
                                clickIndex = 0;
                            }
                        }
                    }, 300);
                }
            })
        },
        start: function() {
            Element.$start.on("click", function() {
                var type = $('input[name="course_type"]').val();//课程类型
                if (type == "0") {
                    Popup.show({
                        title: '<div class="ti ti-02"></div>',
                        content: '<p style="text-align:center">答题前请选择科目！</p>',
                        btn: ['确定']
                    })
                }
                else {
                    if (Action.getQuestion(type)) {
                        Element.$ui_start.hide();
                        Element.$ui_game.show();
                        Event.init();
                        Control.createHTML(g_index)
                        Control.gameCountdown(g_opts.time / 1000, function() {
                            Run.over();
                        });
                    }
                }
            })
        },
        restart: function() {
            $(document).delegate('#btn_restart', 'click', function(event) {
                $.ajax({
                    type: "post",
                    url: "/answer/ajax_check_canplay/",
                    dataType: 'json',
                    async: false,
                    data: 'isPost=1',
                    success: function(data) {
                        if (data.err <= 0) {//不满足答题条件
                            if (g_btn[data.err] == undefined) {
                                if (data.err == '-1' && data.msg == "请先登录") {
                                    btn_word = ["以后再说", '去登陆'];
                                } else {
                                    btn_word = ['确定'];
                                }
                            } else {
                                btn_word = ["以后再说", g_btn[data.err]];
                            }
                            Popup.show({
                                title: '<div class="ti ti-02"></div>',
                                content: '<p style="text-align:center">' + data.msg + '</p>',
                                btn: btn_word,
                                ok: function() {
                                    window.location.href = data.url;
                                }
                            })
                        } else {
                            $('[data-as-id="course_type"] .text').text("请选择科目");
                            $('[data-as-id="course_type"] input[name="course_type"]').val("0");
                            $("#course_type li.active").removeClass('active');
                            Element.$ui_over.hide();
                            Element.$ui_start.show();
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        BB.popup.loading.hide();
                        BB.popup.alert('网络异常,请稍后重试');
                    }
                });
            });
        },
        init: function() {
            this.click();
            this.restart();
        }
    };

    var Control = {
        createHTML: function(index) {
            var question = "",
                    answer = "",
                    html = "",
                    obj;
            if (g_result[index]) {
                obj = g_result[index];
                question = obj.topic;
                $.each(obj.answer, function(i) {
                    html += '<li><i class="icon-' + (i + 1) + '"></i><p>' + obj.answer[i] + '</p><u></u></li>'
                });
                html = "<ul>" + html + "</ul>";
                Element.$question.html(question);
                Element.$answer.html(html);
            }
        },
        gameCountdown: function(time, callback) {
            var that = this;
            Element.$countdown.text(time);
            g_timer = setInterval(function() {
                if (time > 0) {
                    time--;
                    Element.$countdown.text(time);
                } else {
                    clearInterval(g_timer);
                    callback && callback.call();
                }
            }, 1000)
        }
    };

    var Action = {
        getQuestion: function(type) {
            $.ajax({
                type: "post",
                url: "/answer/start_answer/",
                dataType: 'json',
                async: false,
                data: 'subject_id=' + type,
                success: function(data) {
                    if (data.err <= 0) {//验证错误
                        var btn_word = '';
                        if (g_btn[data.err] == undefined) {
                            btn_word = ['确定'];
                        } else {
                            btn_word = ["以后再说", g_btn[data.err]];
                        }
                        Popup.show({
                            title: '<div class="ti ti-02"></div>',
                            content: '<p style="text-align:center">' + data.msg + '</p>',
                            btn: btn_word,
                            ok: function() {
                                window.location.href = data.url;
                            }
                        })
                        g_result = false;
                    } else {
                        var obj = $.parseJSON(data.data);
                        g_result = obj.questions;
                        g_hashString = obj.hash_string;
                        g_subject_id = obj.subject_id;
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    BB.popup.loading.hide();
                    BB.popup.alert('网络异常,请稍后重试');
                }
            });
            return g_result;
        },
        send: function() {
            var isSend = true;
            var AuthStr = g_subject_id + '#' + g_score + '#' + g_right_num + '#' + g_error_num + '#' + g_hashString;
            var PostStr = encryptionJs.run_encryption(AuthStr);
            $.ajax({
                type: "post",
                url: "/answer/send_result/",
                data: {isPost: 1, Poststr: PostStr},
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    isSend = false;
                    BB.popup.alert('网络异常,请稍后重试');
                },
                success: function(data) {
//                    Popup.show({
//                            title:'<div class="ti ti-02"></div>',
//                            content:'<p style="text-align:center">'+data.msg+'</p>',
//                            btn:btn_word,
//                            ok:function(){
//                                    window.location.href = data.url;
//                            }
//                          })
                    Element.$ui_over.html(data);
                }
            });
            return isSend;
        }
    };
    var Run = {
        init: function(options) {
            var defaults = {
                time: 30000, // 总时间
                price: 0, //单个答案分数
                err_price: 0
            };
            g_opts = $.extend({}, defaults, options);
            Event.start();
        },
        over: function() {
            if (Action.send()) {
                clearInterval(g_timer);
                g_score = 0;
                g_index = 0;
                g_right_num = 0;
                g_error_num = 0;
                g_result = null;
                Element.$score.text(g_score);
                Element.$ui_over.show();
                Element.$ui_game.hide();
            }
        }
    }
    return Run
}(window, document);

var Popup = {
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
                $obj = $(".popup");
        BB.popup.cover.show();
        $obj.show();
        $obj.find(".hd").html(opts.title);
        $obj.find(".bd").html(opts.content);
        if (opts.btn.length == 0) {
            //$obj.find(".fd").html('<a href="javascript:;" class="btn btn-ok">确定</a>');
        }
        ;
        if (opts.btn.length == 1) {
            $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">' + opts.btn[0] + '</a>');
        }
        ;
        if (opts.btn.length == 2) {
            $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">' + opts.btn[0] + '</a><a href="javascript:;" class="btn btn-ok">' + opts.btn[1] + '</a>');
        }
        var h = $obj.find(".inner").prop("scrollHeight");
        $obj.find(".inner").css({
            "margin-top": "-" + h / 2 + "px"
        });
        $(".btn-cancel").on("click", function() {
            opts.cancel();
        });
        $(".btn-ok").on("click", function() {
            opts.ok();
        });
        $obj.find(".close").on("click", function() {
            that.hide();
        });
    },
    hide: function() {
        BB.popup.cover.hide();
        $(".popup").hide();
    }
};