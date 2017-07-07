<?php
/**
 * @author wangsongqing <jimmywsq@163.com>
 * @time 2017-05
 +------------------------------------------
 * 简单的增删改操作
 * 如果你的数据是从缓存里面读取出来的，那个你在增、删、改的时候要去刷新缓存。
 * 这块可能一下不好熟悉，大家多看一下源码就好。
 +------------------------------------------
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
	$model = $this->import('manage_user');
	$rule = array();
	if($isSearch)
	{
	    isset($admin_name) && !empty($admin_name) && $rule['like']['admin_name'] = $admin_name;
	}
	$data = $model->findAll($rule,'*',0,1);
	$this->display('index/index.php',array('result'=>$data));
    }
    
    /**
     * 添加用户
     */
    public function add()
    {
	extract($this->input);
	if($isPost)
	{
	    $salt = saltRound();//生成随机salt
	    $model = $this->import('manage_user');
	    $_arr = array('admin_name'=>$admin_name,'mobile'=>$mobile,'realname'=>$realname,'created'=>time(),'salt'=>$salt,'password'=>md5(md5($password).$salt));
	    $result = $model->add($_arr);//返回插入的id
	    if($result)
	    {	
	       $model->manage_user_revision($result); //刷新缓存
	       $this->redirect('添加成功', Root."index/index/");
	    }
	}
	$this->display('index/add.php');
    }
    /**
     * 修改用户信息
     */
    public function edit()
    {
	extract($this->input);
	$id    = isset($id) ? intval($id) : 0;
	$model = $this->import('manage_user');
        if(!$id)
	{
            $this->redirect("参数错误", Root."index/index/");
        }
	$data = $model->find($id,1);
	if($isPost)
	{
	    $jumpUrl    = Root.'index/edit?id='.$id;
	    $resultData = $this->validate($this->input,$model->validateMolde());
	    if(!empty($resultData['error']))
	    {
		$this->redirect($resultData['error'],$jumpUrl);
	    }
	    $salt = saltRound();//生成随机salt
	    $_arr  = array('admin_name'=>$admin_name,'mobile'=>$mobile,'realname'=>$realname,'salt'=>$salt,'password'=>md5(md5($password).$salt));
	    $rule = array("exact"=>array("admin_id"=>$id));
	    $re    = $model->edit($_arr, $rule);
	    if($re)
	    {
		$model->manage_user_revision($id); //刷新缓存
		$msg   = "编辑成功";
	    }else{$msg = "编辑失败";}
	    $this->redirect($msg, Root."index/index/");
	}
	$this->display('index/edit.php',array('result'=>$data));
    }
    
    /**
     * 查看用户信息
     */
    public function view()
    {
	extract($this->input);
	$model = $this->import('manage_user');
	$data = $model->find($id,1);
	$this->display('index/view.php',array('result'=>$data));
    }
    
    /**
     * 删除用户信息
     */
    public function delete()
    {
	extract($this->input);
	$model = $this->import('manage_user');
	$rule = array("exact"=>array("admin_id"=>$id));
	$re = $model->del($rule);
	if($re){
	    $model->manage_user_revision($id);//刷新缓存
	    $msg   = "删除成功";
	}else{
	    $msg = "删除失败";
	}
	    $this->redirect($msg, Root."index/index/");
    }
    
    /**
     * 上传excel并读取里面的内容，然后插入数据库，我测试的excel后缀是 .xls
     * 数据存入run_impot数据库里面的run_import_user表  在这里就涉及到一个项目多个数据库的问题
     */
    public function upload()
    {
	extract($this->input);
	require_once Lib.'/Util/FileUpload.php';
	$cdirs = '.'.Resource."/uplodes";
	$up = new FileUpload(array('isRandName'=>true,'allowType'=>array('txt', 'doc', 'php', 'gif','jpg','rar','png','xls'),'FilePath'=>$cdirs, 'MAXSIZE'=>2000000));
	$up->mkdirs($cdirs); //建立目录
	if($isPost)
	{
	    if($up->uploadFile('filename'))
	    {
		$fi=$up->getNewFileName();
		$fname=$cdirs.'/'.$fi;
		$data = readExcel($fname);//读取excel内容
		$model = $this->import('import_user');//注意此处的 import_user 表 在run_impot数据库里面里面
		$_arr = array();
		foreach($data as $key=>$value){
		    $_arr['name'] = $value['A'];
		    $_arr['age'] = $value['B'];
		    $_arr['addr'] = $value['C'];
		    $model->add($_arr);
		}
		$this->redirect('导入数据成功', Root."index/fileCache/?up=yes");
	    }
	}
	$this->display('index/upload.php');
    }
    
    /**
     * 文件缓存的使用方法,upload()方法导入数据后跳转的action
     */
    public function fileCache(){
	extract($this->input);
	if(isset($up) && $up=='yes'){$isUpData = true;}else{$isUpData = false;}//当有新的数据插入更新缓存
	
	if(getFileVar('fileData') && $isUpData==false){
	    $data = getFileVar('fileData');
	}else{
	    $model = $this->import('import_user');
	    $data = $model->findAll();
	    setFileVar('fileData', $data, $expire=3600);
	}
	$this->display('index/filecache.php', array('result'=>$data));
    }
    
    /**
     * memcahce的简单用法
     * 其实在框架里面完全不需要这样写，在框架里面封装的查询方法都是可以通过传参数来决定数据是否放在缓存的
     * 例如$model->find($id,1);最后的一个参数如果是0就是不读缓存，如果是1就读取缓存
     * 详细参数内容可以看源码来了解
     */
    public function memCache(){
	 if(getVar('userdata')){
	     $data = getVar('userdata');
	 }else{
	    $model = $this->import('import_user');
	    $data = $model->findAll();
	    setVar('userdata', $data, 3600);
	 }
	 
	 $this->display('index/memcache.php', array('result'=>$data));
    }
    
    /**
     * 原生sql的使用
     * 执行原生sql尽可能在model里面执行，这也是为了严格执行mvc和代码整洁
     */
    public function queryAll(){
    	$model = $this->import('manage_user');
    	$sql = "SELECT a.admin_id,b.admin_name FROM `run_manage_log` a,`run_manage_user` b WHERE a.admin_id=b.admin_id";
    	$data = $model->queryAll($sql);//查询多条
    	
    	$_sql = "SELECT COUNT(id) AS num FROM `run_manage_log`";
    	$_data = $model->queryOne($_sql);//查询单条
    	echo "<pre>";
    	print_r($_data);
    }


}
?>