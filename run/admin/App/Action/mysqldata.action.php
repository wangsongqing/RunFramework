<?php
/**
 * 分布式数据库的应用
 */
class MysqldataAction extends actionMiddleware
{   
    
    public function index(){
        $data = array('name'=>'ww','age'=>30);
        $insert_id = M('user')->add($data);
        if($insert_id>0){
            $data['user_id'] = $insert_id;
            $insert_id = M('user')->add($data,$insert_id);
        }
    }
    
    public function getuser(){
        $rule['exact']['name'] = 'ls';
        $rule['slice'] = 2;
        $data = M('user')->findOne($rule,'*',0);
        var_dump($data);
    }
}

