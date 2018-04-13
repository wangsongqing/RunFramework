<?php
/**
 * Api类的应用
 * @author Jimmy Wang <1105235512@qq.com>
 * @date 2018-04-13
 */
class User
{
    
    public function getUser(){
        $data = M('user')->find(1);
        return $data;
    }
}

