<?php

/**
 * 守护进程DEMO
 * 该进程每时每刻都在执行，只要有相关数据就会执行
 * daemon.task.php
 * 执行方法 首先打开cmd  找到你的php.exe文件 在后面执行计划任务文件就可以了
 */
require_once('config.php');

class TaskObject {

    //数据库资源对象
    private $db = null;

    //连接run_import库
    public function importMysql() {
	$this->db = new RunDbPdo();
	$this->db->configFile = dirname(__FILE__) . '/../admin/Config/dbconfig/run_import.php';
    }

    //连接run_user库
    public function userMysql() {
	$this->db = new RunDbPdo();
	$this->db->configFile = dirname(__FILE__) . '/../admin/Config/dbconfig/run_user.php';
    }

    /**
     * 运行
     * 查询一条数据  $this->db->getRow($sql);
     * 查询多条数据  $this->db->getRows($sql);
     * 插入数据      $this->db->insert($tableName,$data);
     * 更新数据      $this->db->update($tableName,$data,array('id'=>1));
     */
    public function run() {
	$do = true;
	while (1) {
	    $this->userMysql();
	    $sql = "SELECT * FROM `run_manage_log` WHERE admin_name='wsq'";
	    $data = $this->db->getRows($sql);
	    if (!empty($data)) {
		foreach ($data as $value) {
		    $this->db->update('run_manage_log', array('admin_name' => 'wsq'), array('admin_name' => 'wangsongqing'));
		}
	    }
	    sleep(3);
	}
    }

    //清楚资源
    public function close() {
	$this->db->close();
	$this->db = null;
    }

}

$addTime = microtime(true);
$task = new TaskObject();
$task->run();
$addUseTime = microtime(true) - $addTime;
echo 'Success Execute ' . $addUseTime . ' Seconds';
