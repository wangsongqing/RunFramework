<?php
/**
 * OB层应用类
 * @author Jimmy Wang <1105235512@qq.com>
 * @date 2018-04-13
 */
class OB
{
    private static $parmas = array () ;
    public static function set($key, $value){
        OB::$parmas[$key] = $value ;    
    }
    public static function get($key){  
        if(isset( OB::$parmas[$key])){  
            return OB::$parmas[$key]  ; 
        }   
    } 
    /**
     * 获取Model对象
     * @param unknown $apiName
     */
    public static function getDB($table){
        return OB::get('OB')->import($table);
    }
        
    /**
     * 获取ObApi对象
     * @param unknown $apiName
     */
    public static function getObApi(){
        $arguments = func_get_args();
        $apiName = array_shift($arguments);
        self::loadOB($apiName) ; 
        $class = new ReflectionClass($apiName);
        return $class->newInstanceArgs($arguments);//返回类的实例
    }
    
    public static function loadOB($obName) {
        try{
            if(file_exists(dirname(__FILE__).'/'.$obName.'.class.php')){ 
                include_once(dirname(__FILE__).'/'.$obName.'.class.php') ;    
            }else{
                throw new Exception($obName .' class error ');
            }
        }
        catch(Exception $e){
             exit($e) ;
        }
    }
}

