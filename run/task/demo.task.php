<?php
/**
 * 计划任务DEMO
 * demo.task.php
 * 执行方法 首先打开cmd  找到你的php.exe文件 在后面执行计划任务文件就可以了
 * 最原始的执行任务方法，后期已经优化，请看demo1.php是优化后的写法。此处方法可以查看学习
*/
require_once('config.php');
class TaskObject
{
    //数据库资源对象
    private $db = null;

    //连接run_import库
    public function importMysql()
    {
        $this->db = new RunDbPdo();
        $this->db->configFile = dirname(__FILE__).'/../admin/Config/dbconfig/run_import.php';
    }
    
    //连接run_user库
    public function userMysql(){
	$this->db = new RunDbPdo();
	$this->db->configFile = dirname(__FILE__).'/../admin/Config/dbconfig/run_user.php';
    }

    /**
     * 运行
     * 查询一条数据  $this->db->getRow($sql);
     * 查询多条数据  $this->db->getRows($sql);
     * 插入数据      $this->db->insert($tableName,$data);
     * 更新数据      $this->db->update($tableName,$data,array('id'=>1));
     */
    public function run()
    {	
	//接受参数
	$param1 = isset($GLOBALS["argv"]["1"]) && !empty($GLOBALS["argv"]["1"])?$GLOBALS["argv"]["1"]:'admin';
	$param2   = isset($GLOBALS["argv"]["2"]) && !empty($GLOBALS["argv"]["2"])?$GLOBALS["argv"]["2"]:'20';
	$param3   = isset($GLOBALS["argv"]["3"]) && !empty($GLOBALS["argv"]["3"])?$GLOBALS["argv"]["3"]:'shanghai';
	
        //连接import库
        $this->importMysql();
        $sql = "SELECT * FROM run_import_user WHERE id='1'";
        $result   = $this->db->getRow($sql);
	
	if(!empty($result)){
	    $param = array('name'=>$result['name'],'age'=>$result['age'],'addr'=>$result['addr']);
	}else{
	    $param = array('name'=>$param1,'age'=>$param2,'addr'=>$param3);
	}
	$this->db->insert('run_import_user',$param);
        $this->close();
	
	$this->userMysql();
	//做和run_user库相关的数据操作。。。。。。。。。。
	$this->close();
    }

    //清楚资源
    public function close()
    {
        $this->db->close();
        $this->db = null;
    }
}

$addTime = microtime(true);
$task = new TaskObject();
$task->run();
$addUseTime = microtime(true) - $addTime ;
echo 'Success Execute '.$addUseTime.' Seconds';