<?php

/**
 + -------------------------------
 * 构建fileCache对象
 + -------------------------------
 * @return boject
 + -------------------------------
 */
function getFileCacheObj(){
    require_once(Lib.'/Util/FileCache.php');
    $path = '.'.Resource."/FileCache/";
    $cache = new FileCache($path);
    return $cache;
}

/**
+----------------------------------------------------------
 * 写入文件缓存
+----------------------------------------------------------
 * @param string  $key    缓存键值
 * @param mixed   $data  被缓存的数据
 * $expire int     存储时间
+----------------------------------------------------------
 * @return boolean
+----------------------------------------------------------
 */
function setFileVar($key,$data,$expire=3600){
    $obj = getFileCacheObj();
    return $obj->set($key, $data,$expire);
}

/**
+----------------------------------------------------------
 * 读取文件缓存
+----------------------------------------------------------
 * @param string $key 缓存键值
+----------------------------------------------------------
 * @return mixed
+----------------------------------------------------------
 */
function getFileVar($key){
    $obj = getFileCacheObj();
    return $obj->get($key);
}

/**
+----------------------------------------------------------
 * 删除文件缓存
+----------------------------------------------------------
 * @param string $key 缓存键值
+----------------------------------------------------------
 * @return boolean
+----------------------------------------------------------
 */
function delFileVar($key){
    $obj = getFileCacheObj();
    return $obj->remove($key);
}

/**
+----------------------------------------------------------
 * 清楚文件缓存
 * @return boolean
+----------------------------------------------------------
 */
function clearFileVar(){
    $obj = getFileCacheObj();
    return $obj->clear();
}


/**
+----------------------------------------------------------
 * 构造MmCache 对象
+----------------------------------------------------------
 * @return object
+----------------------------------------------------------
 */
function getCacheObj()
{
    static $import = true;
    static $cache  = null;
    if ($import)
    {
        require_once(Lib.'/Util/ICache.php');
        require_once(Lib.'/Util/MmCache.php');
    }
    $import = false;
    if ($cache == null)
    {
        $cache = new MmCache();
        $cache->prefix = 'run_';
        $cache->expire = 18000;
        $cache->compressed = true;
        $cache->configFile = '../Config/memcache.config.php';
    }
    return $cache;
}


/**
+----------------------------------------------------------
 * 读取缓存
+----------------------------------------------------------
 * @param string $key 缓存键值
+----------------------------------------------------------
 * @return mixed
+----------------------------------------------------------
 */
function getVar($key)
{
    return getCacheObj()->get($key);
}


/**
+----------------------------------------------------------
 * 写入缓存
+----------------------------------------------------------
 * @param string  $key    缓存键值
 * @param mixed   $value  被缓存的数据
+----------------------------------------------------------
 * @return boolean
+----------------------------------------------------------
 */
function setVar($key, $value, $expire=18000)
{
    getCacheObj()->expire = $expire;
    return getCacheObj()->set($key, $value);
}


/**
+----------------------------------------------------------
 * 删除缓存
+----------------------------------------------------------
 * @param  string $key 缓存键值
+----------------------------------------------------------
 * @return boolean
+----------------------------------------------------------
 */
function delVar($key)
{
    return getCacheObj()->remove($key);
}

