<?php
/**
 * 
 * 获得前台模版
 * @param  $file 模版名称
 */
function get_tpl($file) {
	$filepath = PC_PATH . 'templates/' . $file . '.tpl.php';
	if (file_exists ( $filepath )) {
		return $filepath;
	} else {
		echo $filepath . '里没有找到' . $file . '.tpl.php';
		exit;
	}
}
/**
 * 
 * 获得后台模版
 * @param  $file 模版名称
 */
function get_admin_tpl($file) {
	$filepath = PC_PATH . 'templates/admin/' . $file . '.tpl.php';
	if (file_exists ( $filepath )) {
		return $filepath;
	} else {
		echo $filepath . '里没有找到' . $file . '.tpl.php';
		exit;
	}
}
/**
 *
 * 获取用户IP
 *
 */
function get_ip() {
	if (getenv ( 'HTTP_CLIENT_IP' )) {
		$onlineip = getenv ( 'HTTP_CLIENT_IP' );
	} else if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
		$onlineip = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} else if (getenv ( 'REMOTE_ADDR' )) {
		$onlineip = getenv ( 'REMOTE_ADDR' );
	} else {
		$onlineip = $_SERVER ['REMOTE_ADDR'];
	}
	return $onlineip;
}
/**
 * 
 * 获得随机数
 * @param  $length 长度
 */
 function get_rand_str($length) {
		$mt_string = 'AzBy0CxDwEv1FuGtHs2IrJqK3pLoM4nNmOlP5kQjRi6ShTgU7fVeW8dXcY9bZa';
		$randstr = '';
		for ($i = 0; $i < $length; $i++) {
			$randstr .= $mt_string[mt_rand(0, 61)];
		}
		return $randstr;
	}

/**
 * 
 * 给字符串去掉空格
 * @param  $str 变量
 */	
function get_input($str){
	if(is_string($str))return trim($str);
	return '';
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return $pwd
 */
function password($password, $encrypt='') {
	if(!$encrypt || !$password) return '';
	$pwd = md5(md5(trim($password)).$encrypt);
	return $pwd;
}



/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password
 * @return 	TRUE or FALSE
 */
function is_password($password) {
	$strlen = strlen($password);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

 /**
 * 检测输入中是否含有错误字符
 *
 * @param char $string 要检查的字符串名称
 * @return TRUE or FALSE
 */
function is_badword($string) {
	$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#"); 
	foreach($badwords as $value){
		if(strpos($string, $value) !== FALSE) {
			return TRUE;
		}
	}
	return FALSE;
}

/**
 * 检查用户名是否符合规定
 *
 * @param STRING $username 要检查的用户名
 * @return 	TRUE or FALSE
 */
function is_username($username) {
	$strlen = strlen($username);
	if(is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username)){
		return false;
	} elseif ( 20 <= $strlen || $strlen < 2 ) {
		return false;
	}
	return true;
}


/**
 * 
 * 加密url
 * @param  $data
 */
function set_url($data) {
	$geturl = exchange(base64_encode (serialize ( $data ) ));
	return $geturl;
}

/**
 * 
 * 解密url
 * @param  $data
 */
function get_url($spm) {
	$geturl = unserialize ( base64_decode ( exchange($spm,true) ) );
	return $geturl;
}


function exchange ( $string , $reverse = false )   
{   
    if ( $reverse === false ){   
        return str_replace( array("/","+","="), array(":","|",";"), $string );   
    }else{   
        return str_replace( array(":","|",";"), array("/","+","="), $string );   
    }   
} 



// 安全过滤函数
function safe_replace($string) {
	$string = str_replace('%20','',$string);
	$string = str_replace('%27','',$string);
	$string = str_replace('%2527','',$string);
	$string = str_replace('*','',$string);
	$string = str_replace('"','&quot;',$string);
	$string = str_replace("'",'',$string);
	$string = str_replace('"','',$string);
	$string = str_replace(';','',$string);
	$string = str_replace('<','&lt;',$string);
	$string = str_replace('>','&gt;',$string);
	$string = str_replace("{",'',$string);
	$string = str_replace('}','',$string);
	return $string;
}

function jsformat($str) { 
	$str = str_replace("&lt;", '<',$str);
	$str = str_replace("&gt;", '>',$str);
	$str = str_replace("&quot;", '"',$str);
	$str = str_replace( "&#039;","'",$str);
	$str = str_replace("&amp;nbsp;", ' ',$str);
	$str = str_replace("&amp;", '&',$str);
	return $str; 
} 


function filedown($file_path,$file_name) {
	set_time_limit(0);
	$file_path=iconv("utf-8","gb2312",$file_path);
	$file_path=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF'])."/".$file_path;
	if(!file_exists($file_path) ){
		return false;
	}
	$file_size=filesize($file_path);
	$fp=fopen($file_path,"rb");
	if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
		$file_name = rawurlencode($file_name);
	}
	header("Content-Type:application/octet-stream");
	header("Accept-Ranges:bytes");
	header("Accept-Length:".$file_size);
	header("Content-Disposition:attachment;filename=".$file_name);
	$each_size=1024;
	while(!feof($fp)) {
		$file_data=fread($fp,$each_size);
		echo $file_data;
	}
	fclose($fp);
}

?>