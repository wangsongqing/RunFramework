<?php

class answer_attendModel extends modelMiddleware {

    public $tableKey = 'answer_attend'; //数据表key
    public $cached = true; //是否读取缓存
    public $pK = 'id'; //数据表主键Id名称

    /**
     * 数据操作模型
     * @return object
     */

    public static function _model() {
        $model = M('answer_attend');
        return $model;
    }

    /**
     * 获取总榜排名前三的用户(统计周排行榜)
     *
     * @param  int  $id  科目ID
     * @access public
     * @return array
     */
    public function get_answer_top3($start_time, $end_time) {
        $table = $this->getTable($this->tableKey);
        $key = '{answer_attend:answer_attend}';
        $sql = "SELECT e.*,SUM(score) as total_score FROM  
	           (SELECT * FROM {$table} where ( created >= $start_time AND created <= $end_time AND score>0) order by created ASC) e  
	           GROUP BY user_id ORDER BY total_score DESC,created ASC LIMIT 3";
        return $this->getRows($sql, $key);
    }

}
