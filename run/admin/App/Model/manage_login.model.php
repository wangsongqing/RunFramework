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
    
    /**
     * 执行原生sql，查询多条
     * @return array
     */
      public function queryAll($sql='') {
        if(empty($sql)){return false;}
        $this->getTable($this->tableKey);
        $data = $this->db->getRows($sql);
        return $data;
      }
   
     /**
     * 执行原生sql，查询单条
     * @return array
     */
    public function queryOne($sql=''){
      if(empty($sql)){return false;}
      $this->getTable($this->tableKey);
      $data = $this->db->getRow($sql);
      return $data;
    }

}