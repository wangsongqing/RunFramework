<?php

/**
 * @author Jimmy Wang <jimmywsq@163.com>
 * 连连看小游戏
 * 游戏表结构
 * CREATE TABLE `run_lian` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `telephone` char(11) NOT NULL COMMENT '用户手机号',
  `lian_num` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '连接图标个数',
  `is_floop` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0:未使用翻倍卡,1:使用翻倍卡',
  `score` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '本次连连看获得分数',
  `nick` varchar(20) NOT NULL DEFAULT '' COMMENT '用户的昵称',
  `pcapital` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '成长金金额',
  `red_bag` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '现金红包金额',
  `credit` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '宝贝豆',
  `red_invest` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '投资红包金额',
  `join_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '参与类型 0免费 1充值 2邀请',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created` (`created`),
  KEY `join_type` (`join_type`),
  KEY `score` (`score`)
) ENGINE=InnoDB AUTO_INCREMENT=512 DEFAULT CHARSET=utf8 COMMENT='连连看游戏参与记录表'
 */
class LianAction extends actionMiddleware {

    public function index() {
        extract($this->input);
        $goods_id = isset($goods_id) ? $goods_id : 0;

        //首页总分排行榜,前三位的数据
        $data = M('lian')->get_lian_top('1509514186', '1512093174', 0, 3);
        $game_time = '30'; //游戏时间
        $game_score = '1'; //每消除一对得分
        $game_floop = '1'; //得分是否翻倍
        $this->display('lian/lian.index.php', array(
            'data' => $data,
            'goods_id' => $goods_id,
            'game_time' => $game_time * 1000,
            'game_score' => $game_score,
            'game_floop' => $game_floop
                )
        );
    }

    /**
     * 接受游戏结果
     * 这里需要把游戏结果add数据库
     */
    public function send() {
        extract($this->input);
        $num = isset($num) ? $num : 0;
        if ($num == 27) {$is_floop = 1;} else {$is_floop = 0;}

        //用户未登录玩游戏需要加这些代码
        $score['score'] = floor($num * 1);//消除的对数*没对的得分
        $score['red_bag'] = $num;
	$this->display('lian/lian.score.php',array(
            'data'=>$score,
            'is_floop'=>$is_floop
        ));
    }
    
    /**
     * 更多排行榜，总分排行榜
     */
    public function numscoreorder(){
        $data = M('lian')->get_lian_top('1509514186', '1512093174', 0, 10);
	$this->display('lian/lian.numscoreorder.php',array('data'=>$data));
    }
    
    /**
     * 连连我的成绩
     */
     public function myscore(){
        $user_id  = '1065777';
	$_rule['exact']['user_id'] = $user_id;
	$_rule['order']['id'] = 'desc';
	$_rule['limit'] = 6;
	$mylist = M('lian')->findAll($_rule);//我的成绩列表
        $allData = M('lian')->get_my_score($user_id,'1509514186', '1512093174',0);//我的成绩总分和总排名
        $this->display('lian/lian.myscore.php',array('data'=>$mylist,'alldata'=>$allData));
     }

}
