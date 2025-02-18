<?php
/**
 +------------------------------------------------------------------------------
 * Run Framework Redis操作类
 +------------------------------------------------------------------------------
 * @date    17-06
 * @author Jimmy Wang <jimmywsq@163.com>
 * @version 1.0
 +------------------------------------------------------------------------------
 */
class RedisQ implements IQueue
{
	public $name       = "queue";//队列默认名称
	public $q	       = null;//队列连接对象
	public $configFile = null;//配置文件
	public $prefix = 'wlc_';//前缀
	public function __construct()//构造子
	{
	}


	/**
	 * 释放资源
	 */
	public function __destruct()
	{
		$this->close();
		$this->q          = null;
		$this->configFile = null;
		$this->name	      = null;
	}


	/**
	 * 连接到队列
	 */
	private function connect()
	{
		if ( $this->q == null )
		{
			if( !file_exists($this->configFile) ) 
			{
				RunException::throwException("缓存配置文件：".$this->configFile."不存在!");
			}
			require($this->configFile);
			$this->q = new Redis();
			$this->q->connect($host, $port);
		}
	}


	/**
	 * 关闭队列连接
	 */
	private function close()
	{
		if ( $this->q != null )
		{
			$this->q->close();
		}
	}


	/**
	 * 数据入队
	 */
	public function push($data)
	{
		$this->connect();
		$bool = $this->q->lPush($this->prefix.$this->name, serialize($data));
		return $bool;
	}
	
	/**
	 * 数据出队返回名称为key的list中start至end之间的元素
	 */
	public function getlist($key,$start = 0,$end = -1)
	{
		$this->connect();
		$date = $this->q->lrange($this->prefix.$key,$start,$end);//lGetRange($key,0,-1);
		return $data ? unserialize($data) : ''; 
	}


	/**
	 * 数据出队
	 */
	public function pop()
	{
		$this->connect();
		$data = $this->q->rPop($this->prefix.$this->name);
		return $data ? unserialize($data) : '';
	}

	/**
	 * 队列长度(队列中元素个数)
	 */
	public function size()
	{
		$this->connect();
		return $this->q->llen($this->prefix.$this->name);
	}
	
	
	/**
	 * 数据入队
	 */
	public function lpush($key, $val)
	{
		$this->connect();
		$bool = $this->q->lPush($this->prefix.$key, serialize($val));
		return $bool;
	}
	/**
	 * 数据出队
	 */
	public function rpop($key)
	{
		$this->connect();
		$data = $this->q->rPop($this->prefix.$key);
		return $data ? unserialize($data) : '';
	}
	
	
	/**
	 * 数据入队
	 */
	public function set($key, $val)
	{
		$this->connect();
		$this->q->set($this->prefix.$key, $val);
	}
	
	
	/**
	 * 返回匹配的键名
	 */
	public function keys($key)
	{
		$this->connect();
		$data = $this->q->keys($this->prefix.$key);
		return $data;
	}
	
	/**
	 * 返回数据
	 */
	public function hSort($key, $option)
	{
		$this->connect();
		$data = $this->q->SORT($this->prefix.$key, $option);
		return $data;
	}
	
	
	/**
	 * 删除键名
	 */
	public function delKey($key)
	{
		$this->connect();
		$this->q->del($this->prefix.$key);
	}
	
	
	/**
	 *  删除value相等的元素
	 */
	public function lrem($key, $val, $count = 0 )
	{
		$this->connect();
		$this->q->lrem($this->prefix.$key, $val, $count);
	}
	
	/**
	 * 向名称为hName的hash中添加元素hKey
	 */
	public function hSet($hName, $hKey,$data)
	{
		$this->connect();
		$this->q->hSet($this->prefix.$hName, $hKey, $data);
		
	}
	
	/**
	 * 向名称为hName的hash中元素hKey自动加val
	 */
	public function hincrBy($hName, $hKey,$val)
	{
		$this->connect();
		$this->q->hincrby($this->prefix.$hName, $hKey, $val);
		
	}
	
	/**
	 * 返回名称为hName的hash中hKey对应的value
	 */
	public function hGet($hName, $hKey)
	{
		$this->connect();
		$data = $this->q->hget($this->prefix.$hName, $hKey);
		return $data ? $data : '';

	}
	/**
	 * 删除名称为hName的hash中hKey对应的value
	 */
	public function hdel($hName, $hKey)
	{
		$this->connect();
		$data = $this->q->hdel($this->prefix.$hName, $hKey);
		return $data ? $data : '';

	}
	
	/**
	 * 返回名称为hName的hash中所有键对应的value
	 */
	public function hVals($hName)
	{
		$this->connect();
		$data = $this->q->hVals($this->prefix.$hName);
		return $data;

	}
	
	/**
	 * 返回名称为hName的hash中所有键与对应的value
	 */
	public function hGetAll($hName)
	{
		$this->connect();
		$data = $this->q->hGetAll($this->prefix.$hName);
		return $data;

	}
	
	
	/**
	 * 返回名称为hName的hash中是否存在键名为hKey的域
	 */
	public function hExists($hName, $hKey)
	{
		$this->connect();
		$data = $this->q->hExists($this->prefix.$hName, $hKey);
		return $data;

	}
}
?>