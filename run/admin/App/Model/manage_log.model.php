<?php
 /**
 +---------------------------------------------------------------------------------------------------------------
 * 用户登陆记录模型
 +---------------------------------------------------------------------------------------------------------------
 */
class manage_logModel extends modelMiddleware{

    public $tableKey = 'manage_log'; //数据表key
    public  $cached  = false;//是否读取缓存
    public $pK = 'id'; //数据表主键Id名称
    
    /**
     * 数据操作模型
     * @return object
     */
    public static function _model(){
	$model = SystemParams::getDB('manage_log');
	return $model;
    }
    
    /**
     * 记录登陆日志
     * @return int
     */
    public function logs($arr=array()){
	if(!isset($arr) || empty($arr)){
	    throw new Exception('参数为空', '-1008');
	}
	
	$data = array(
	    'admin_id'=>$arr['admin_id'],
	    'admin_name'=>$arr['admin_name'],
	    'ip'=>$arr['loginIp'],
	    'created'=>time(),
	    'phone'=>$arr['mobile'],
	);
	return self::_model()->add($data);
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
?>