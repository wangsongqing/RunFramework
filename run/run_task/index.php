<?php
set_time_limit(0);                                     //设置程序运行超时间
ob_start();                                            //打开磁盘缓冲
$cur_dir = dirname(__FILE__); 
chdir($cur_dir); 
//总结: 在require 时，如果是相对目录，在crontab 中运行php脚本，要进入到脚本所在目录才可以
require_once('Config/apppath.config.php');             //初始化应用程序路径  
header("Content-type: text/html; =utf-8");      //指定编码
ini_set("date.timezone", "Asia/Shanghai");             //设置时间区域
ini_set("display_errors",1);
error_reporting(E_ALL);

$_SERVER['HTTP_HOST'] = '127.0.0.1' ;
$_SERVER['REQUEST_URI'] = '' ;
$_SERVER['REQUEST_URI'] = '' ;
$_SERVER['QUERY_STRING'] = '' ;

//$GLOBALS["argv"]["1"];      
$_REQUEST['mod'] = $GLOBALS["argv"]["1"];
$_REQUEST['action'] = $GLOBALS["argv"]["2"];

require_once(Lib.'/Core/App.php');                    //载入装配器
$app = new App();                                      //实例化一个对象
$app->path            = Lib;                           //指定框架路径 
$app->isCached        = IsCached;                      //是否缓存对象资源
$app->cacheDir        = CacheDir;                      //对象资源缓存目录
$app->rootPath        = Root;                          //指定根路径
$app->module          = Module;                        //指定默认控制器
$app->exceptionModule = ExceptionModule;               //指定发生异常时的控制器(如找不到请求的控制器)   
$app->init();															//初始化框架
require_once(App."/Util/actionMiddleware.php");
require_once(App."/Util/modelMiddleware.php");
$app->execute();
$app = null;                                             //销毁对象
?>