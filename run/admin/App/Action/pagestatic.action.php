<?php
/**
 * 页面静态化操作
 * 表演开始了
 * @author wangsongqing jimmywsq@163.com
 */
class PagestaticAction extends actionMiddleware
{
    public function index(){
        $name = '王松青5211';
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
}

