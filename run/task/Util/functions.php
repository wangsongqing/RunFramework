<?php

function writeLog($content, $file='log.log')
{
	$file = Root.'log'.DIRECTORY_SEPARATOR.$file;
	if(preg_match('/php/i',$file) || is_array($content)) return ;
	$content = "【".date("Y-m-d H:i:s", time())."】\t\t".$content."\r\n";
	file_put_contents($file, $content, FILE_APPEND);
}

//记录索引更新数据日志
function dataLog($content, $file='data.log')
{
	if(preg_match('/php/i',$file) || is_array($content)) return ;
	$logDir  = "/www/ApiServer/log";
	if (!file_exists($logDir)) 
	{
		@mkdir($logDir);
		@chmod($logDir, 0777);
	}
	$content = $content."\r\n";
	file_put_contents($logDir.'/'.$file, $content, FILE_APPEND);
}

//创建多级目录
function createDir($path)
{
	if(file_exists($path)) return true;
	$dirs = explode('/', $path);
	$total = count($dirs);
	$temp = '';
	for($i=0; $i<$total; $i++)
	{
		$temp .= $dirs[$i].'/';
		if (!is_dir($temp))
		{
			if(!@mkdir($temp)) return false;
			@chmod($temp, 0777);
		}
	}
	return true;
}

/**
 * 请求远程地址
 *
 * @param string $url 请求url
 * @param mixed $postFields 请求的数据
 * @param string $referer 来源网址
 * @param integer $timeOut 请求超时时间
 * @return mixed 错误返回false，正确返回获取的字符串
 * @author fengxu
 */
function httpRequest($url, $postFields = null, $referer = null, $timeOut = 10)
{
	if(empty($url) || !preg_match("#https?://[\w@\#$%*&=+-?;:,./]+#i", $url)) {
		return false;
	}
	$isPost = empty($postFields) ? false : true;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	if ($isPost) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
	}
	curl_setopt($ch, CURLOPT_USERAGENT, ($userAgent = ini_get('user_agent')) ? $userAgent : 'Edai Broswer');
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//对于大于或等于400的状态码返回false
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept-Charset: GB2312,utf-8',
		'Accept-Language: zh-cn,zh',
		'Connection: close',
	));
	$response = curl_exec($ch);
	return $response;
}

/**
 +----------------------------------------------------------
 * 数据加密、解密
 +----------------------------------------------------------
 * @param string   $string     加密、解密字符串
 * @param string   $operation  加密、解密操作符(ENCODE加密、DECODE解密)
 * @param string   $key        密钥
 * @param string   $expiry     过期时间
 +----------------------------------------------------------
 * @return string
 +---------------------------------------------------------- 
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
	$ckey_length = 4;
	$key         = md5($key != '' ? $key : AuthKey);
	$keya        = md5(substr($key, 0, 16));
	$keyb        = md5(substr($key, 16, 16));
	$keyc        = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey    = $keya.md5($keya.$keyc);
	$key_length  = strlen($cryptkey);
	$string = $operation == 'DECODE' ? 
		base64_decode(substr($string, $ckey_length)) 
		: sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		}else{
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}
/**
 +----------------------------------------------------------
 * 获取用户IP地址
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function getIp()
{
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
	{
		$onlineip = getenv('HTTP_CLIENT_IP');
	}
	elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
	{
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
	{
		$onlineip = getenv('REMOTE_ADDR');
	}
	elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
	{
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	return $onlineip;
}

 

/**
* 抓取文件内容
* @param string   $fileUrl 抓取内容的地址
* @param string   $parameter 参数
* @param int      $timeout 过期时间
* @param string   $method  GET POST
* @return string
*/
function getcontent($fileUrl, $parameter, $method='GET', $timeout=60){
		
		$parameter = serialize($parameter);//序列化参数
		$str = base64_encode(authcode($parameter, 'ENCODE', md5('589lokj45w4sdtrt')));//加密
		$url = $fileUrl.'/?str='.$str;
		//echo $url;die;
		//通过curl抓取数据
		$result = httpRequest($url);
		if ( $result ) {
			$result =parsecontent($result);
			return $result;
		} else {
			return false;	
		}
}


/**
* 返回内容
* @param max      $str
* @return string
*/
function retruncontent($str){
	return base64_encode(serialize($str));
}


/**
* 解析内容
* @param string      $str
* @return string
*/
function parsecontent($str){
	$data = unserialize(base64_decode($str));
	return $data;
}
 
?>