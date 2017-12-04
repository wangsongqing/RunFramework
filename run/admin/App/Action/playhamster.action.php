<?php

/**
 * @author Jimmy Wang <jimmywsq@163.com>
 * 打地鼠小游戏
 * 游戏表结构
 * CREATE TABLE `bb_play_hamster` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `telephone` char(11) NOT NULL COMMENT '用户手机号',
  `nick` varchar(64) NOT NULL DEFAULT '' COMMENT '宝宝昵称',
  `rounds` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '当前第几轮',
  `times` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '第几轮第几次',
  `sys_mouse_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '本轮最大地鼠数',
  `mouse_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '打中地鼠数',
  `baby_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '打中宝宝数',
  `score` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '实际得分数',
  `sub_score` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '提交分数',
  `pcapital` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '获得特权本金',
  `red` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '现金红包',
  `credit` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '宝贝豆',
  `is_extra` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '额外获得0否 1是',
  `is_receive` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否领取0否 1是',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pcapital` (`pcapital`),
  KEY `created` (`created`)
  ) ENGINE=MyISAM AUTO_INCREMENT=1945982 DEFAULT CHARSET=utf8 COMMENT='打地鼠成绩记录表'
 */
class PlayhamsterAction extends actionMiddleware {

    public function index() {
        extract($this->input);
        $goods_id = isset($goods_id) ? $goods_id : 0;

        //首页总分排行榜,前三位的数据
        $rank_info_socre = M('play_hamster')->get_play_hamster_top('1451279031', '1451357238', 0, 3);
        $this->display('playhamster/playhamster.index.php', array(
            'rank_info_socre' => $rank_info_socre,
            'goods_id' => $goods_id
                )
        );
    }
    
    public function start(){
        extract($this->input);
        if($isPost){
            $this->praseJson('1001', '重新开始', "",array('hash_string'=>'lvTIgeYA6v6vmadt','mouseAmount'=>'15'));
        }
        $this->display('playhamster/start.php',array(
            'login_user'=>array('user_id'=>'1'),
            'init'=>array('time'=>1000*10,'mouseSum'=>4,'babySum'=>0),//mouseSum 打到地鼠加分，打到宝宝减分
            'nonceStr'=>'MnrRvYyZjmVm9CVJ',
            'invite_url'=>''
            )
        );
    }
    
    /**
     * 接受前段发送过来的数据
     */
    public function send(){
        extract($this->input);
        if(isset($Poststr)){
            $postStr = run_encryption($Poststr);
            $getData = explode('#', $postStr);
            list($mouse_num,$baby_num,$score,$hid,$hash) = $getData;
            $rank_info_socre = M('play_hamster')->get_play_hamster_top('1451279031', '1451357238', 0, 3);
            $this->display('playhamster/result.php',array('score'=>$score,'rank_info'=>$rank_info_socre));
        }
    }
    
    /**
     * 我的成绩
     */
    public function my_score(){
        extract($this->input);
        $my_score_order = M('play_hamster')->get_my_score(1,time(), time(),0);
        $my_times_order = M('play_hamster')->get_my_score(1,time(), time(),1);
        $my_score['total_socre']        =$my_score_order['total_score'];
        $my_score['total_socre_pm']     =$my_score_order['pm'];
        $my_score['total_times']        =$my_times_order['total_times'];
        $my_score['total_times_pm']     =$my_times_order['pm'];
        $this->display('playhamster/myscore.php');
    }
    
    /**
     * 排行榜
     */
    public function get_rank(){
        //获取总分数排行榜前10数据
        $rank_info_socre = M('play_hamster')->get_play_hamster_top(time(),time(),0);
        //获取总次数排行榜前10数据
        $rank_info_times = M('play_hamster')->get_play_hamster_top(time(),time(),1);
        $this->display('playhamster/rank_list.php',array('rank_info_score'=>$rank_info_socre,'rank_info_times'=>$rank_info_times));
    }

}
