<?php

/**
 * @author Jimmy Wang <jimmywsq@163.com>
 * 连连看小游戏
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
