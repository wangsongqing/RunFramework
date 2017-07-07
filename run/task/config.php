<?php
//加载基础库文件
set_time_limit(0);
ini_set("date.timezone", "Asia/Shanghai");
header("Content-type: text/html; charset=utf-8");      //指定编码
define('Root', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('Util', Root.'Util'.DIRECTORY_SEPARATOR);
define('Config', Root.'Config'.DIRECTORY_SEPARATOR);

define('Lib', str_replace(DIRECTORY_SEPARATOR.'task', DIRECTORY_SEPARATOR, dirname(__FILE__)).'RunFramework'.DIRECTORY_SEPARATOR);

require_once(Lib.'Core'.DIRECTORY_SEPARATOR.'RunException.php');
require_once(Lib.'Db'.DIRECTORY_SEPARATOR.'IDataSource.php');
require_once(Lib.'Db'.DIRECTORY_SEPARATOR.'RunDbPdo.php');
require_once(Lib.'Util'.DIRECTORY_SEPARATOR.'ICache.php');
require_once(Lib.'Util'.DIRECTORY_SEPARATOR.'MmCache.php');
require_once(Lib.'Util'.DIRECTORY_SEPARATOR.'IQueue.php');
require_once(Lib.'Util'.DIRECTORY_SEPARATOR.'RedisQ.php');
require_once(Lib.'Util'.DIRECTORY_SEPARATOR.'HttpPost.php');
require_once(Util.'functions.php');
?>