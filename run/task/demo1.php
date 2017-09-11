<?php

/**
 * daemon.task.php
 * 执行方法 首先打开cmd  找到你的php.exe文件 在后面执行计划任务文件就可以了
 */
require_once('config.php');
require_once 'OB.php';
class TaskObject {

    /**
     * 运行
     */
    public function run() {
	$model = new OB('run_user');//初始化数据库对象
	//$rule = array('admin_name'=>'admin');
	//$data = $model->M('run_manage_log')->findOne($rule);//查询单条数据
	//$data = $model->M('run_manage_log')->findAll($rule);//查询多条数据
	
	//$data = array('admin_id'=>'1','admin_name'=>'wangmengmeng','ip'=>'192.168.1.1','created'=>time(),'phone'=>'18201197925');
	//$result = $model->M('run_manage_log')->add($data);//插入数据
	
	$data = array('admin_name'=>'wmm');
	$rule = array('id'=>'37');
	$result = $model->M('run_manage_log')->edit($data,$rule);//更新数据
	var_dump($result);
    }

}

$addTime = microtime(true);
$task = new TaskObject();
$task->run();
$addUseTime = microtime(true) - $addTime;
echo 'Success Execute ' . $addUseTime . ' Seconds';
