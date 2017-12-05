<?php

/**
 * 接鸡蛋小游戏
 * @author Jimmy Wang<jimmywsq@163.com>
 * 刚开始第一次调试的时候加载页面一直失败，到只原因是resource.json里面的图片路径需要修改
 * 
 * 表结构
 * 
CREATE TABLE `run_catch_egg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `telephone` char(11) NOT NULL COMMENT '用户手机号',
  `nick` varchar(64) NOT NULL DEFAULT '' COMMENT '宝宝昵称',
  `times` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '第几次',
  `catch_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '接中数',
  `miss_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '掉落数',
  `pcapital` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '获得特权本金',
  `is_extra` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '次数来源 0=>默认赠送,1=>充值,2=>邀请',
  `is_receive` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否领取0否 1是',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pcapital` (`pcapital`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='接鸡蛋成绩记录表'

 */
class catchEggAction extends actionMiddleware {

    public function index() {
        extract($this->input);
        //初始化游戏参数
        $init = array(
            'speeds' => "950, 750, 650, 550, 500", //鸡蛋掉落速度
            'time' => 10 * 1000, //游戏时间
            'price' => 10, //接到单个鸡蛋得分
            'total' => 100,//鸡蛋总数
        );
        $this->display('catchegg/catchegg.index.php', array(
            'init' => $init,
            'login_user' => array('user_id' => 1)
        ));
    }

    /**
     * 检测用户是否可以玩游戏
     */
    public function check_play() {
        extract($this->input);
        $this->praseJson('1', '验证成功', "", array('hash_string' => 123456));
    }

    /**
     * 接受前段发送过来的数据
     */
    public function send() {
        extract($this->input);
        if (isset($Poststr)) {
            $postStr = run_encryption($Poststr);
            $getData = explode('#', $postStr);
            if (count($getData) < 6) {
                $this->praseJson('-1008', '参数错误');
            }
            list($total_num, $catch_num, $miss_num, $pcapital, $eid, $hash) = $getData;
            //过滤数据
            $total_num = isset($total_num) ? intval($total_num) : 0;
            $catch_num = isset($catch_num) ? intval($catch_num) : 0;//接中鸡蛋数
            $miss_num = isset($miss_num) ? intval($miss_num) : 0;//没接中数
            $pcapital = isset($pcapital) ? intval($pcapital) : 0;//赠送成长金数
            $this->praseJson('1', '接受成功');
        }
    }
    
    /**
     * 发送排名等信息
     */
    public function get_rank(){
        $data = M('catch_egg')->get_rankApi();
        $this->display('catchegg/rank.php',array('data'=>$data));
    }

}
