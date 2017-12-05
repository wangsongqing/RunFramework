<?php

/**
  +---------------------------------------------------------------------------------------------------------------
 * 打地鼠模型model
  +---------------------------------------------------------------------------------------------------------------
 */
class catch_eggModel extends modelMiddleware {

    public $tableKey = 'catch_egg'; //数据表key
    public $cached = false; //是否读取缓存
    public $pK = 'id'; //数据表主键Id名称

    /**
     * 数据操作模型
     * @return object
     */

    public static function _model() {
        $model = SystemParams::getDB('play_hamster');
        return $model;
    }

    /**
     * 按条件获取前三条接鸡蛋记录(统计周排行榜)
     *
     * @param  array  $rule  数据查询规则
     * @access public
     * @return array
     */
    public function get_rankApi() {
        $time = time();
        if ($time >= strtotime('2016-12-13') && $time <= strtotime('2016-12-19')) {
            $start_time = strtotime('2016-12-13');
            $end_time = strtotime('2016-12-19');
        } else {
            $end_time = strtotime(date('Y-m-d', $time) . ' 23:59:59');
            $start_time = strtotime('-7 day', $time);
            $start_time = strtotime(date('Y-m-d', $start_time));
        }
        $table = $this->getTable($this->tableKey);
        
        $key = '{catch_egg:catch_egg}';
        $sql = "SELECT user_id,telephone,nick,pcapital,created FROM (SELECT * FROM {$table} where ( created >= $start_time AND created <= $end_time ) ORDER BY pcapital DESC ,created ASC) e  GROUP BY user_id ORDER BY pcapital DESC,created ASC LIMIT 3";
        return $this->getRows($sql, $key);
    }

}

?>