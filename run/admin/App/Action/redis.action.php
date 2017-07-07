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



}