<?php
class manage_loginModel extends modelMiddleware{

    /**
     * 数据表key
     */
    public $tableKey = 'manage_login';
    public  $cached  = false;


    /**
     * 按条件统计数据
     * @param  array  $rule  数据查询规则
     */
    public function getCount($rule,$fields="*")
    {
        $table = $this->getTable($this->tableKey);
        $where = where($rule);
        $sql   = "select count($fields) as total from $table $where";
        $row   = $this->getRow($sql);
        return $row['total'];
    }

}