<?php
/**
 * @author wangsongqing <jimmywsq@163.com>
 * @time 2018-01
 +------------------------------------------
 * 简单的增删改操作
 * 如果你的数据是从缓存里面读取出来的，那个你在增、删、改的时候要去刷新缓存。
 * 这块可能一下不好熟悉，大家多看一下源码就好。
 +------------------------------------------
 * 执行方式  例如：E:\phpstudy\WWW\runframework\run\run_task>php index.php index index
 * 如果是用法的phpstudy,进入cmd的时候从phpstudy设置里面进入
 */
class IndexAction extends actionMiddleware
{   
    /**
     * 用户列表
     */
    public function index()
    {	
	extract($this->input);
	$isSearch = isset($isSearch)?$isSearch:'';
	$model = M('manage_user')->find(1);
        var_dump($model['realname']);exit;
    }

}
?>