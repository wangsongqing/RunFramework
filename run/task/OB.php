<?php
/**
 * OB.php
 * 优化任务的增删改查，简化代码
 * @author jimmy <jimmywsq@163.com>
 */
require_once 'config.php';
class OB
{   
    public $databases;
    public $table;
    function __construct($databases='') {
	if($databases==''){
	    $this->databases = 'run_user';
	}else{
	    $this->databases = $databases;
	}
	
    }
     //数据库资源对象
    private $db = null;

    //连接run_import库
    private function importMysql()
    {
        $this->db = new RunDbPdo();
        $this->db->configFile = dirname(__FILE__)."/../admin/Config/dbconfig/{$this->databases}.php";
    }
    
    public function M($table=''){
	$this->table = $table;
	return $this;
    }
    
    /**
     * 查询单条数据
     */
    public function findOne($rule){
	if(empty($rule)) return false;
	$this->importMysql();
	$where = where($rule);
	$sql   = "select * from {$this->table} $where limit 1";
	$result   = $this->db->getRow($sql);
	$this->close();
	return $result;
    }
    
    /**
     * 查询多条数据
     */
    public function findAll($rule){
	if(empty($rule)) return false;
	$this->importMysql();
	$where = where($rule);
	$sql   = "select * from {$this->table} $where";
	$result   = $this->db->getRows($sql);
	$this->close();
	return $result;
    }
    
    /**
     * insert data
     */
    public function add($data=''){
	if(empty($data)) return false;
	$this->importMysql();
	$retult = $this->db->insert($this->table,$data);
	$this->close();
	return $retult;
    }
    
    /**
     * update data
     */
    public function edit($data='',$where=''){
	if($data=='' || $where=='') return false;
	$this->importMysql();
	$retult = $this->db->update($this->table,$data,$where);
	$this->close();
	return $retult;
    }
    
    
    //清楚资源
    public function close() {
	$this->db->close();
	$this->db = null;
    }
}

