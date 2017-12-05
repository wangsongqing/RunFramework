var EggsDeluxeGame = function(win, doc) {
  var g_width = 640,
    g_height = 1136,
    g_scale = 0,
    g_sum = 0,
    g_count = 0,
    g_temp_count = 0,
    g_catch = 0,
    g_miss = 0,
    g_eid = 0,
    g_total = 0,
    g_hashString = null,
    g_timer = null,
    g_clear = false,
    g_play_times = 0,
    domain = '',
    invite = null,
    isLogin = false,
    offsetTop = 0,
    sumText = 0,
    timeText = 0,
    opts = null,
    basketObj = null,
    bucketObj = null,
    fightingObj = null,
    fpsTextLabel = null,
    stage = new createjs.Stage("canvas"),
    preload = new createjs.LoadQueue(true),
    gameView = new createjs.Container(),
    loadingView = new createjs.Container(),
    boardView = new createjs.Container(),
    countDownMaskView = new createjs.Container(),
    mainView = new createjs.Container(),
    eggsView = new createjs.Container(),
    basketView = new createjs.Container(),
    chickenView = new createjs.Container(),
    footView = new createjs.Container(),
    sumTextLabel = null,
    timeTextLabel = new createjs.Text("30", "bold 45px Arial Helvetica", "#fffc00"),
    btnStart = null,
    btnRule = null,
    btnVoiceOff = null,
    btnVoiceOn = null;
  var responsive = function() {
    var docElem = doc.documentElement,
      EV = 'orientationchange' in window ? 'orientationchange' : 'resize',
      func = function() {
        var clientWidth = docElem.clientWidth;
        c_height = doc.documentElement.clientHeight;
        c_width = doc.documentElement.clientWidth;
        if (!clientWidth) return;
        g_scale = c_height > c_width ? clientWidth / 640 : c_height / g_height;
        offsetTop = g_height * g_scale - c_height;
        var clientHeight = c_height > c_width ? g_height * g_scale : c_height,
          width = g_width * g_scale;
        if (clientHeight > g_height) {
          width = g_width;
          clientHeight = g_height;
          offsetTop = 0;
        }
        var size = 50 * (width / 320);
        var left = !browser.versions.mobile ? g_width / 2 - width / 2 : 0;
        docElem.style.fontSize = (size > 100 ? 100 : size) + "px";
        var cssText = "display:block;left:" + left + "px;width:" + width + "px;height:" + clientHeight + "px;";
        doc.getElementById("canvas").style.cssText = cssText;
      };
    if (!doc.addEventListener) return;
    win.addEventListener(EV, func, false);
    func();
  };
  var browser = {
    versions: function() {
      var u = navigator.userAgent;
      return {
        mobile: u.indexOf("Mobile") > -1 && u.indexOf("Pad") == -1, //是否为移动端 
        IOS: (/iPhone|iPod|iPad/).test(u), //ios
        Android: u.indexOf("Android") > -1, //android
      };
    }()
  };

  var Events = {
    start: function() {
      btnStart.addEventListener("mousedown", function(event) {
        if (Action.check()) {
          controller.beginCountdown();
          footView.removeChild(event.target)
        }
      })
    },
    clear: function() {
      bucketObj.addEventListener("mousedown", function(event) {
        if(g_temp_count == 5){
          //createjs.Sound.play("CLEAR");
          bucketObj.gotoAndPlay("empty");
          g_temp_count = 0;
          basketObj.gotoAndPlay(g_temp_count);
          setTimeout(function() {
            basketObj.gotoAndStop(g_temp_count);
          }, 250)
        }
      })
    },
    fill: function() {
      basketObj.addEventListener("pressmove", function(event) {
        basketObj.set({ x: event.stageX - 98 })
        if (event.stageX >= 538) {
          basketObj.set({ x: 440 })
        }
        if (event.stageX <= 98) {
          basketObj.set({ x: -10 })
        }
      })
    },
    replay: function() {
      new createjs.DOMElement("btn_replay").htmlElement.onclick = function() {
    	  g_play_times ++;
        if (Action.check()) {
          Run.replay();
        }
      }
    },
    voice: function() {
      btnVoiceOff.addEventListener("mousedown", function(event) {
        //createjs.Sound.volume = 0;
        btnVoiceOff.visible = false;
        btnVoiceOn.visible = true;
      });
      btnVoiceOn.addEventListener("mousedown", function(event) {
        //createjs.Sound.volume = 1;
        btnVoiceOff.visible = true;
        btnVoiceOn.visible = false;
      });
    },
    rule: function() {
      btnRule.addEventListener("mousedown", function(event) {
        Popup.show({
          title: "游戏规则",
          content: '<div style="text-align:left">1.成功接到鸡蛋得分并赠送成长金(登录后玩游戏方可下发成长金)；<br>\
                    2.单次游戏成长金奖励限额300；<br>\
                    3.篮子装满后需手动清空才可继续接蛋；</div>',
          btn: ["确定"]
        });
      })
    },
    receive: function() {
      $(".btns .btn-receive").on("click", function() {
        Popup.show({
          title: '',
          content: "您还未登录，请登录后再领取奖励！",
          btn: ['取消', '确定'],
          ok: function() {
            window.location.href = EggsDeluxeGame.domain + "?app_page=login";
          },
          cancel: function() {
            Popup.hide();
          }
        });
      });
    }
  };

  var controller = {
    time: 4000,
    random: function(min, max) {
      return Math.floor(Math.random() * (max - min + 1) + min);
    },
    unique: function(name, min, max) {
      var that = this,
        num = that.random(min, max);
      that[name] = that[name] == undefined ? 0 : that[name];
      for (var i = 0;; i++) {
        if (that[name] == num) {
          num = that.random(min, max);
        } else {
          that[name] = num;
          break;
        }
      };
      return num
    },
    beginCountdown: function() {
      var that = this,
        time = that.time / 1000 - 1,
        timer = null,
        index = 0;
      countDownMaskView.addChild(view.countdown(index));
      timer = setInterval(function() {
        if (time > index) {
          index++;
          countDownMaskView.removeChildAt(0);
          countDownMaskView.addChild(view.countdown(index));
          stage.update();
        } else {
          clearInterval(timer)
          Run.start();
          countDownMaskView.removeAllChildren();
          countDownMaskView.visible = false;
          //stage.removeChild(countDownMaskView)
        }
      }, 1000)
    },
    gameCountdown: function(time, callback) {
      var that = this,
        timer = null;
      timeTextLabel.text = --time;
      timer = setInterval(function() {
        if (time > 0) {
          if(time % 5 == 0){
            fightingObj.gotoAndPlay("start");
            setTimeout(function(){
              fightingObj.gotoAndStop("empty");
            },1500)
          }
          time--;
          timeTextLabel.text = time;
        } else {
          clearInterval(timer);
          callback && callback.call();
        }
      }, 1000)
    },
    createEggs: function() {
      var arrX = [55, 225, 390, 555],
        that = this,
        timer = null,
        times = opts.speeds;
      timer = function(time) {
        g_timer = setInterval(function() {
          x = that.unique("arrX", 0, 3);
          chickenView.getChildAt(x).gotoAndPlay("down")
          setTimeout(function() {
            chickenView.getChildAt(x).gotoAndStop("down")
          }, 500);
          var egg = new createjs.Bitmap(preload.getResult("egg"));
          egg.set({ x: arrX[x] });
          createjs.Tween.get(egg, {
              override: true,
              loop: false
            })
            .to({
              y: c_height / g_scale - 536,
            }, 700).call(function(event) {
              if (g_timer) {
                g_count += 1;
                if (basketObj.x >= event.target.x - 170 && basketObj.x <= event.target.x) {
                  if (g_temp_count % 6 != 5) {
                    sumTextLabel.text = g_sum += opts.price;
                    g_catch += 1;
                    g_temp_count += 1;
                    basketObj.gotoAndPlay(g_temp_count % 6);
                    setTimeout(function() {
                      basketObj.gotoAndStop(g_temp_count % 6)
                    }, 250);
                    if (g_temp_count % 5 == 0) {
                      bucketObj.gotoAndPlay("click");
                    }
                  }
                  //createjs.Sound.play("CATCH");
                }
                g_miss = g_count - g_catch;
                eggsView.removeChild(event.target);
              }
            });
          eggsView.addChild(egg);
          if (g_count > 0 && g_count < 11) {
              clearInterval(g_timer);
              timer(times[0])
            } else if (g_count > 11 && g_count < 16) {
              clearInterval(g_timer);
              timer(times[1])
            } else if (g_count > 16 && g_count < 21) {
              clearInterval(g_timer);
              timer(times[2])
            } else if (g_count > 21 && g_count < 26) {
              clearInterval(g_timer);
              timer(times[3])
            } else {
              clearInterval(g_timer);
              timer(times[4])
            };
        }, time)
      }
      timer(times[0])
    },
    update: function() {
      createjs.Ticker.addEventListener("tick", function(event) {
        if (fpsTextLabel != null)
          fpsTextLabel.text = "FPS:" + Math.round(createjs.Ticker.getMeasuredFPS()) + " Count:" + g_count + " Catch:" + g_catch + " Miss:" + g_miss;
        if (!createjs.Ticker.paused) {
          stage.update(event);
        }
      });
    }
  };

  var view = {
    chicken: function() {
      return new createjs.SpriteSheet({
        framerate: 5,
        "images": [preload.getResult("chicken")],
        "frames": {
          "width": 106,
          "height": 136
        },
        "animations": {
          "fly": {
            frames: [0]
          },
          "down": {
            frames: [0, 1, 1]
          }
        }
      });
    },
    create: function() {
      var bg = new createjs.Bitmap(preload.getResult("BG")),
        board = new createjs.Bitmap(preload.getResult("sprite")),
        rope = new createjs.Bitmap(preload.getResult("rope")),
        tree = new createjs.Bitmap(preload.getResult("tree")),
        ck1 = new createjs.Sprite(view.chicken()),
        ft = new createjs.Bitmap(preload.getResult("ft")),
        basketSpriteSheet = new createjs.SpriteSheet({
          "images": [preload.getResult("baskets")],
          "frames": {
            "width": 196,
            "height": 167
          },
          "animations": {
            "0": {
              frames: [0]
            },
            "1": {
              frames: [1]
            },
            "2": {
              frames: [2]
            },
            "3": {
              frames: [3]
            },
            "4": {
              frames: [4]
            },
            "5": {
              frames: [5]
            }
          }
        }),
      bucketSpriteSheet = new createjs.SpriteSheet({
        "images": [preload.getResult("buckets")],
        "frames": { "width": 135, "height": 179 },
        "animations": { "empty": { frames: [0] }, "click": { frames: [1, 2] } }
      }),
      fightingSpriteSheet = new createjs.SpriteSheet({
        "images": [preload.getResult("fighting")],
        "frames": { "width": 139, "height": 191 },
        "animations": { "empty": { frames: [0] },  "start": { frames: [1,2,3] } }
      });
      fpsTextLabel = new createjs.Text("FPS:", "25px Arial Helvetica", "#FFF").set({
        x: 25,
        y: 138,
        textBaseline: "top"
      });
      basketObj = new createjs.Sprite(basketSpriteSheet, "0").set({ framerate: 4, x: 240 });
      bucketObj = new createjs.Sprite(bucketSpriteSheet, "empty").set({ framerate: 4, x: 30, y: c_height / g_scale - 556 });
      fightingObj = new createjs.Sprite(fightingSpriteSheet, "empty").set({ framerate: 4, x: 510, y: 610 });
      btnStart = new createjs.Bitmap(preload.getResult("btnStart")).set({ x: 190 });
      btnRule = new createjs.Bitmap(preload.getResult("sprite"));
      btnVoiceOff = new createjs.Bitmap(preload.getResult("sprite"));
      btnVoiceOn = new createjs.Bitmap(preload.getResult("sprite"));
      btnRule.sourceRect = new createjs.Rectangle(0, 370, 68, 72);
      btnVoiceOff.sourceRect = new createjs.Rectangle(80, 370, 68, 72);
      btnVoiceOn.sourceRect = new createjs.Rectangle(160, 370, 68, 72);
      btnRule.set({ x: 100 });
      btnVoiceOff.set({ x: 470 });
      btnVoiceOn.set({ x: 470 });
      btnVoiceOn.visible = false;
      board.set({ x: 95, y: 0 });
      board.sourceRect = new createjs.Rectangle(0, 0, 445, 126);
      rope.set({ x: 0, y: 272 });
      ck1.set({ x: 20 });
      var ck2 = ck1.clone().set({ x: 190, y: 4 });
      var ck3 = ck1.clone().set({ x: 355, y: 4 });
      var ck4 = ck1.clone().set({ x: 520, y: 1 });
      timeTextLabel = new createjs.Text(opts.time / 1000, "bold 35px Arial Helvetica", "#FFF").set({ x: 425, y: 66 });
      sumTextLabel = new createjs.Text(g_sum, "bold 35px Arial Helvetica", "#fffc00").set({ x: 218, y: 66 })
      chickenView.addChild(ck1, ck2, ck3, ck4);
      boardView.addChild(board, sumTextLabel, timeTextLabel);
      footView.set({ y: c_height / g_scale - btnStart.getBounds().height - 30 });
      footView.addChild(btnRule, btnStart, btnVoiceOn, btnVoiceOff);
      mainView.set({ y: 148 }).addChild(bucketObj, eggsView, chickenView, basketView);
      eggsView.set({ y: 100 });
      basketObj.visible = false;
      basketView.set({ y: c_height / g_scale - 436 }).addChild(basketObj);
      tree.set({ x: 411, y: 140 })
      ft.set({x:0,y:c_height / g_scale - 495});
      gameView.addChild(bg, ft,fightingObj ,tree, boardView, rope, mainView, footView);
    },
    loading: function() {
      var BG = new createjs.Shape(new createjs.Graphics().beginFill("#ff7987").drawRect(0, 0, g_width, g_height)),
        box = new createjs.Container(),
        babySpriteSheet = new createjs.SpriteSheet({
          "images": [opts.path + "images/loading.png"],
          "frames": {
            "width": 230,
            "height": 140
          },
          "animations": {
            "play": {
              frames: [0, 1]
            }
          }
        });
      var progressBarBG = new createjs.Shape(new createjs.Graphics().beginFill("#FFF").drawRoundRect(0, 142, 480, 44, 25));
      var babyAni = new createjs.Sprite(babySpriteSheet, "play").set({
        framerate: 4,
        x: 125
      });
      var loadText = new createjs.Text("加载中,请稍等...", "28px Arial Helvetica", "#FFF").set({
        x: 125,
        y: 206,
        textBaseline: "top",
        textAlign: "left"
      });
      progressBarObj = new createjs.Shape()
      box.addChild(babyAni, progressBarBG, progressBarObj, loadText);
      var y = (c_height / g_scale - 234) / 2;
      box.set({ x: 80, y: y });
      loadingView.addChild(BG, box)
      stage.addChild(loadingView);
      preload.on("progress", function(event) {
        if (event.progress > 0.06) {
          progressBarObj.graphics.clear().beginFill("#ff5464").drawRoundRect(4, 145, 472 * event.progress, 38, 20)
        }
      });
    },
    countdown: function(index) {
      var scale = 0.5,
        one = new createjs.Bitmap(preload.getResult("sprite")).set({ y: (c_height / g_scale - 116) / 2 }),
        two = one.clone(),
        three = one.clone(),
        bgein = one.clone();
      one.sourceRect = new createjs.Rectangle(0, 160, 55, 116);
      two.sourceRect = new createjs.Rectangle(60, 160, 79, 116);
      three.sourceRect = new createjs.Rectangle(150, 160, 82, 116);
      bgein.sourceRect = new createjs.Rectangle(240, 160, 221, 108);
      one.set({ x: g_width / 2 - one.getBounds().width / 2 });
      two.set({ x: g_width / 2 - two.getBounds().width / 2 });
      three.set({ x: g_width / 2 - three.getBounds().width / 2 });
      bgein.set({ x: g_width / 2 - bgein.getBounds().width / 2 });
      return [three, two, one, bgein][index]
    },
    init: function() {
      this.create();
      stage.addChild(gameView, countDownMaskView);
      stage.update();
    }
  }

  var Popup = {
    show: function(options) {
      var that = this,
        defaults = {
          title: "",
          content: "",
          btn: [],
          ok: function() {},
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
      };
      if (opts.btn.length == 1) {
        $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">' + opts.btn[0] + '</a>');
      };
      if (opts.btn.length == 2) {
        $obj.find(".fd").html('<a href="javascript:;" class="btn btn-cancel">' + opts.btn[0] + '</a><a href="javascript:;" class="btn btn-ok">' + opts.btn[1] + '</a>');
      }
      $obj.find(".dialog .inner,.dialog").css("height", "auto");
      var h = $obj.find(".dialog").prop("scrollHeight") + 88;
      $obj.find(".dialog").css({
        "margin-top": "-" + h / 2 - 10 + "px"
      });
      $obj.find(".dialog .inner").css({
        height: h
      });
      setTimeout(function() {
        $obj.find(".dialog").addClass('show')
      }, 100);
      $(".btn-cancel").on("click", function() {
        opts.cancel();
      });
      $(".btn-ok").on("click", function() {
        opts.ok();
      });
      $(".dialog .close").on("click", function() {
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

  var Action = {
    check: function() { //检测是否有游戏次数
      var flag = false;
      //ajax请求，判断用户今日是否可玩
      $.ajax({
        type: "post",
        url: "/catchegg/check_play/",
        dataType: 'json',
        data: { isPost: 1 , isRestart: g_play_times },
        async: false,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          flag = false;
          Popup.show({
            title: "网络异常",
            content: "请稍后重试"
          });
        },
        success: function(data) {
          if (data.err > 0) {
            g_eid = data.msg;
            g_hashString = data.data.hash_string;
/*            	Popup.show({
                    title: '',
                    content: data.data.msg,
                    btn: ['取消', '确定'],
                    cancel: function() {
                    	 location.href = data.data.url;
                    },
                    ok: function() {
                    	Popup.hide();
                    	Run.replay();
                    }
                  });*/
           flag = true;
          } else {
            flag = false;
          }
        }
      });
      return flag;
    },
    send: function() { //发送游戏结果
      var isSend = false;
      if (isSend == true) return false;
      var AuthStr = g_count + '#' + g_catch + '#' + g_miss + '#' + g_sum + '#' + g_eid + '#' + g_hashString;
      var PostStr = encryptionJs.run_encryption(AuthStr);
      $.ajax({
        type: "post",
        url: "/catchegg/send/",
        dataType: 'json',
        data: { isPost: 1, Poststr: PostStr },
        async: false,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          isSend = false;
          Popup.show({
            title: "网络异常",
            content: "请稍后重试"
          });
        },
        success: function(data) {
          if (data.err > 0) {
            isSend = false;
          }
        }
      });
    },
    getRank: function() { //获取排行榜
      $.ajax({
        type: "post",
        url: "/catchegg/get_rank/",
        data: { isPost: 1 },
        async: false,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          isSend = false;
          Popup.show({
            title: "网络异常",
            content: "请稍后重试"
          });
        },
        success: function(data) {
          var obj = $('#rank');
          obj.empty();
          obj.append(data);
        }
      });
    }
  };
  var Run = {
    init: function(options) {
      responsive();
      var defaults = {
        path: "",
        price: 10,
        delay: 300,
        time: 30000,
        speeds:[1000, 800, 700, 600, 500],
        debug: false
      };
      var sounds = {
        path: "/Resource/activity/EggsDeluxe/audios/",
        manifest: [{
          "id": "BGM",
          "src": {
            "mp3": "bgm.mp3?12121530",
            "ogg": "bgm.ogg?12121530"
          }
        }, {
          "id": "CLEAR",
          "src": {
            "mp3": "clear.mp3",
            "ogg": "clear.ogg"
          }
        }, {
          "id": "CATCH",
          "src": {
            "mp3": "catch.mp3",
            "ogg": "catch.ogg"
          }
        }]
      };
      opts = $.extend({}, defaults, options);
      preload.loadManifest(opts.path + "js/resource.json");
      view.loading();
      //createjs.Sound.alternateExtensions = ["mp3"];
      //createjs.Sound.addEventListener("fileload", function() {});
      //createjs.Sound.registerSounds(sounds)
      preload.on("complete", function() {
        setTimeout(function() {
          view.init();
          Events.start();
          Events.clear();
          Events.fill();
          Events.receive();
          Events.rule();
          Events.voice();
        }, 500)
      });
      createjs.Touch.enable(stage);
      createjs.Ticker.setFPS(60);
      controller.update();

    },
    start: function() {
      controller.createEggs();
      //createjs.Sound.play("BGM", "none", 0, 0, 1);
      basketObj.visible = true;
      controller.gameCountdown(opts.time / 1000, function() {
        //createjs.Sound.stop();
        eggsView.removeAllChildren();
        Action.send();
        Run.over();
        Action.getRank();
        if (EggsDeluxeGame.isLogin) {
          $("#overBtns .btn-view").show();
          $("#overBtns .btn-replay").show();
          $("#overBtns .btn-receive").hide();
        } else {
          $("#overBtns .btn-view").hide();
          $("#overBtns .btn-replay").hide();
          $("#overBtns .btn-receive").show();
        }
      });
      Events.replay();
    },
    replay: function() {
      sumTextLabel.text = 0;
      timeTextLabel.text = opts.time / 1000;
      countDownMaskView.visible = true;
      mainView.visible = true;
      eggsView.visible = true;
      basketView.visible = true;
      chickenView.visible = true;
      createjs.Ticker.paused = false;
      btnStart.visible = false;
      Events.clear();
      Events.fill();
      $("#gameOver").hide();
      $("#gameOver .dialog").removeClass('show');
      controller.beginCountdown();
    },
    over: function() {
      clearInterval(g_timer);
      mainView.visible = false;
      eggsView.removeAllChildren();
      basketView.visible = false;
      chickenView.visible = false;
      bucketObj.gotoAndPlay("empty");
      basketObj.gotoAndPlay("0");
      $("#gameOver").show();
      createjs.Ticker.paused = true;
      stage.update();
      setTimeout(function() {
        $(".popup-loading").hide();
        $("#gameOver .dialog").addClass('show');
      }, 400);
      $("#sum2").html(g_sum);
      g_sum = 0;
      g_count = 0;
      g_catch = 0;
      g_miss = 0;
      g_temp_count = 0;
      g_timer = null;
    },
  }
  return Run
}(window, document);