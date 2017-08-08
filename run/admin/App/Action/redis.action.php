<?php
/**
 * @author Jimmy Wang <jimmywsq@163.com>
 * redis的增删改查 这只是一个简单的增删改查，大家感兴趣可以自己去扩展redis的其他功能，如list等
 * 根据自己的项目需求来扩展就行了
 */
class RedisAction extends actionMiddleware
{   
    //查
    public function index()
    {
	$data = R('user')->findAll();
	$this->display('redis/index.php',array('result'=>$data));
    }
    
    //添加数据
    public function add(){
	extract($this->input);
	if($isPost){
	    $data = array('name'=>$name,'addr'=>$addr, 'age'=>$age);
	    R('user')->add($data);
	    $this->redirect("添加成功", Root.'redis/index');
	}
	$this->display('redis/add.php');
    }
    
    //删除数据
    public function delete(){
	extract($this->input);
	$re = R('user')->delete($id);
	$this->redirect("删除成功", Root.'redis/index');
    }
    
    //修改数据
    public function edit(){
	extract($this->input);
	if($isPost){
	    $data = array('name'=>$name,'addr'=>$addr, 'age'=>$age);
	    R('user')->edit($id, $data);
	    $this->redirect("编辑成功", Root.'redis/index');
	}
	$data = R('user')->findOne($id);
	$this->display('redis/edit.php',array('data'=>$data));
    }
    
    /**
     * 消息队列处理方式
     * 先把sql压入到redis，然后通过计划任务来执行sql插入点mysql
     */
    public function queue(){
	//此处sql是模拟sql
	$re = R()->lpush('sql', "update user set name='wsq' where user_id='10'");
	if(!$re){//如果压入失败或者redis服务器奔溃等情况，就把数据写入到文件中，保证数据完整性
	     file_put_contents('log/queue'.date('Y-m-d').'.txt', "update user set name='wsq' where user_id='10'",FILE_APPEND);
	}
	$re = R()->lpush('sql', "insert into user('name','age') values('wsq','20')");
	
	$data = R()->getlist('sql');
	foreach($data as $item){
	    $_sql = R()->rpop('sql');
	    var_dump($_sql);exit;//在此处执行sql
	}
    }



}