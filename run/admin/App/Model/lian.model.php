<?php

/**
  +---------------------------------------------------------------------------------------------------------------
 * 用户登陆记录模型
  +---------------------------------------------------------------------------------------------------------------
 */
class lianModel extends modelMiddleware {

    public $tableKey = 'lian'; //数据表key
    public $cached = false; //是否读取缓存
    public $pK = 'id'; //数据表主键Id名称

    /**
     * 数据操作模型
     * @return object
     */

    public static function _model() {
        $model = SystemParams::getDB('lian');
        return $model;
    }

    /**
     * 获取总榜排名前N的用户
     *
     * @param  unknown $start_time  活动开始时间
     * @param  unknown $end_time    活动结束时间
     * @param  int     $order_type  排序类型  0=>总分数 1=>总次数
     * @param  int     $limit       查询条数
     * @access public
     * @return array
     */
    public function get_lian_top($start_time, $end_time, $order_type = 0, $limit = 10) {
        $this->getTable($this->tableKey);
        $key = '{lian:lian}';
        if ($order_type == 1) {
            $orderType = 'total_times desc';
            $where = '';
            $orderType2 = 'count(id) as total_times';
        } else {
            $orderType = 'total_score desc';
            $where = 'AND score > 0';
            $orderType2 = 'sum(score) as total_score';
        }
        $sql = "SELECT
                	nick,
                	telephone,
                	FROM_UNIXTIME(MAX(created)) as ma,
                	{$orderType2}
                FROM
                	run_lian
                WHERE
                	created >= {$start_time} and created <= {$end_time} {$where}
                GROUP BY
                	user_id
                ORDER BY
                	{$orderType} , ma asc
                limit {$limit}";
        return $this->db->getRows($sql, $key);
    }
    
    /**
     * 统计我的总成绩（总分数,总分数排名,总次数,总次数排名）
     *
     * @param  int     $user_id     用户ID
     * @param  unknown $start_time  活动开始时间
     * @param  unknown $end_time    活动结束时间
     * @param  int     $order_type  排序类型  0=>总分数 1=>总次数
     * @access public
     * @return array
     */
    public function get_my_score($user_id, $start_time, $end_time, $order_type = 0) {
	$table = $this->getTable($this->tableKey);
	$key = '{lian:lian}';
	$orderType = $order_type == 1 ? 'total_times DESC,created ASC' : 'total_score DESC,created ASC';

	$sql = "SELECT a.* FROM (
	           SELECT obj.*,@rownum := @rownum + 1 AS pm FROM ( SELECT user_id,telephone,nick,SUM(score) as total_score,count(user_id) as total_times,MAX(created) as created FROM {$table} where ( created >= $start_time AND created <= $end_time)
	           GROUP BY user_id ORDER BY {$orderType} ) AS obj ,(SELECT @rownum := 0) r  )  as a where user_id  = $user_id ";
	return $this->db->getRow($sql, $key);
    }

}

?>