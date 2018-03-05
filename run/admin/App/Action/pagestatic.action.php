<?php
/**
 * 页面静态化操作
 * 表演开始了
 * @author wangsongqing jimmywsq@163.com
 */
class PagestaticAction extends actionMiddleware
{
    public function index(){
        $name = '王松青42666';
        $this->display('pagestatic/pagestatic.index.php',array(
            'name'=>$name
        ));
    }
    
    public function views(){
        $name = 'werqqw222';
         $this->display('pagestatic/pagestatic.index.php',array(
            'name'=>$name
        ));
    }
    /**
     * http://www.run.com/pagestatic/clearstatus/?key=pagestatic/index/
     * 移处某个key的缓存
     */
    public function clearstatus(){
        extract($this->input);
        if(isset($key)){
            $host = $_SERVER['HTTP_HOST'];
            $url = 'http://'.$host.'/'.$key;
            $re = delFileVar(md5($url));
            if($re){
                die('清楚缓存成功');
            }
        }
    }
    
    /**
     * 清除所有缓存
     */
    public  function clearAll(){
        $re = clearFileVar();
        var_dump($re);
    }
}

