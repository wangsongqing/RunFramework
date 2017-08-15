<?php
/**
 * @author wangsongqing <jimmywsq@163.com>
 * @time 2017-08
 +---------------------------------------------------
 * 百度图标统计，例如：柱状图、折线图等；此处只是一个简单的示例，详细用法可以查看网址：http://echarts.baidu.com/
 +----------------------------------------------------
 */
class echartsAction extends actionMiddleware{
    
    /**
     * 管理员登陆次数统计
     * 柱状图
     */
    public function index(){
	$num = array();
	$name = array();
	$data = $this->loginTime();
	foreach($data as $item){
	    array_push($num, $item['num']);
	    array_push($name, $item['admin_name']);
	}
	$this->display('echarts/echarts.index.php',array('num'=>$num,'name'=>$name));
    }
    
    /**
     * 折线图
     */
    public function zhe(){
	$this->display('echarts/echarts.zhe.php');
    }
    
    /**
     * 饼状图
     */
    public function bing(){
	$this->display('echarts/echarts.bing.php');
    }
    
    private function loginTime(){
	$model = M('manage_log');
	$sql = "SELECT COUNT(id) AS num,admin_name FROM `run_manage_log` GROUP BY admin_id";
	$data = $model->queryAll($sql);
	return $data;
    }
}

