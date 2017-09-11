<?php

/**
 * 守护进程DEMO
 * 该进程每时每刻都在执行，只要有相关数据就会执行
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
	$model = new OB('run_user');
	while (1) {
	   $rule = array('admin_name'=>'wsq');
	   $data = $model->M('run_manage_log')->findAll($rule);
	    if (!empty($data)) {
		foreach ($data as $value) {
		    $_data = array('admin_name' => 'wsqqq');
		    $_rule = array('admin_name' => 'wangsongqing');
		    $model->M('run_manage_log')->edit($_data,$_rule);
		}
	    }
	    sleep(3);
	}
    }

}

$addTime = microtime(true);
$task = new TaskObject();
$task->run();
$addUseTime = microtime(true) - $addTime;
echo 'Success Execute ' . $addUseTime . ' Seconds';
