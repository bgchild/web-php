<?php
define ( APP_PATH, PC_PATH );
class file_upload {
	var $error_no = 0;
	var $error_msg = '';
	var $images_dir = 'fileuploads';
	var $uploads_dir = 'fileuploads';
	
	/**
	 * 附件上传的处理函数
	 *
	 * @access      public
	 * @param       array       upload       包含上传的图片文件信息的数组
	 * @param       array       dir          文件要上传在$this->uploads_dir下的目录名。如果为空图片放在则在$this->images_dir下以当月命名的目录下
	 * @param       array       file_name     上传附件名称，为空则随机生成
	 * @return      mix         如果成功则返回文件名，否则返回false
	 */
	function upload_file($upload, $dir = '', $file_name = '') {
		$thumb_dir = $dir;
		if (empty ( $upload ['name'] )) {
			return false;
		}
		/* 没有指定目录默认为根目录 uploads */
		if (empty ( $dir )) {
			$dir = date ( 'Ym' ); /* 创建当月目录 */
			$dir = APP_PATH . $this->images_dir . '/' . $dir . '/';
		} else {
			$every_dir = date ( 'Ym' ); /* 创建目录 */
			$dir = APP_PATH . $this->uploads_dir . '/' . $dir . '/' . $every_dir . '/';
			if ($file_name) {
				$file_name = $dir . $file_name . $this->get_filetype ( $upload ['name'] ); // 将图片定位到正确地址
			}
		}
	  //最大文件大小5m 
      $max_size = 5242880;	
	   if ($upload['size']> $max_size) {
       $this->error_msg ( 'javascript:history.go(-1)', '文件超过限制' );
	}
		/* 如果目标目录不存在，则创建它 */
		if (! file_exists ( $dir )) {
			if (! mkdir ( $dir )) {
				/* 创建目录失败 */
				$this->error_msg ( 'javascript:history.go(-1)', '目录不存在或不可写' );
				return false;
			}
		}
		if (empty ( $file_name )) {
			$file_name = $this->random_filename ();
			$file_name = $dir . $file_name . $this->get_filetype ( $upload ['name'] );
		}
		/* 允许上传的文件类型 */
		$allow_file_types = '|pdf|xlsx|xls|doc|docx|ppt|gif|jpg|png|txt|';
		if (! $this->check_file_type ( $upload ['tmp_name'], $file_name, $allow_file_types )) {
			$this->error_msg ( 'javascript:history.go(-1)', '不是允许的附件格式' );
			return false;
		}
		if ($this->move_file ( $upload, $file_name )) {
			return str_replace ( APP_PATH, '/', $file_name );
		} else {
			$this->error_msg ( 'javascript:history.go(-1)', '附件上传失败' );
			return false;
		}
	}
	
/**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function move_file($upload, $target)
    {
        if (isset($upload['error']) && $upload['error'] > 0)
        {
        	     return false;
        }

        if (!move_uploaded_file($upload['tmp_name'], $target))
        {
            return false;
        }

        return true;
    }
	
	/**
	 * 返回文件后缀名，如‘.php’
	 *
	 * @access  public
	 * @param
	 *
	 * @return  string      文件后缀名
	 */
	function get_filetype($path) {
		$pos = strrpos ( $path, '.' );
		if ($pos !== false) {
			return substr ( $path, $pos );
		} else {
			return '';
		}
	}
	
	/**
	 * 生成随机的数字串
	 *
	 * @author: weber liu
	 * @return string
	 */
	function random_filename() {
		$str = '';
		for($i = 0; $i < 9; $i ++) {
			$str .= mt_rand ( 0, 9 );
		}
		return time () . $str;
	}
	
	/**
	 * 检查文件类型
	 *
	 * @access      public
	 * @param       string      filename            文件名
	 * @param       string      realname            真实文件名
	 * @param       string      limit_ext_types     允许的文件类型
	 * @return      string
	 */
	function check_file_type($filename, $realname = '', $limit_ext_types = '') {
		
		if ($realname) {
			$extname = strtolower ( substr ( $realname, strrpos ( $realname, '.' ) + 1 ) );
		} else {
			$extname = strtolower ( substr ( $filename, strrpos ( $filename, '.' ) + 1 ) );
		}
		
		if ($limit_ext_types && stristr ( $limit_ext_types, '|' . $extname . '|' ) === false) {
			
			return '';
		}
		if(strpos($limit_ext_types, $extname)){
			return $extname;
		}else {
			return '';
		}
		
		
		
	}
	
	/**
	 * 返回错误信息
	 *
	 * @return  string   错误信息
	 */
	
	public function error_msg($url, $show, $back = '0') {
		
		$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息提示</title>
<style type="text/css">
<!--
body{margin-top: 100px;}
.all{height: 200px;width: 400px;background-image: url(templates/images/message_bg.gif);background-repeat: no-repeat;}
.shang{height: 30px;width: 400px;line-height: 30px;font-size: 14px;color: #666666;font-weight: bold;text-decoration: none;float: left;}
.xia1{height: 30px;width: 360px;float: right;font-size: 13px;line-height: 30px;color: #333;text-decoration: none;text-align: left;}
.xia{height: 30px;width: 360px;float: right;font-size: 13px;line-height: 30px;color: #666666;text-decoration: none;text-align: left;}
.xia a{ color: #336600;text-decoration:none}
.message_h3{float: left;height:80px; width:400px;}
-->
</style>
</head>

<body>
<table width="400" border="0" align="center">
  <tr>
    <td colspan="3">
	<div class="all">
	<div class="shang message_h3"></div>
	<div class="xia1">状态：' . $show . '</div>
	<div class="xia">页面<span id ="spanSeconds" >3</span>秒后自动跳转，如果浏览器不跳转，<a href="' . $url . '">点此跳转</a></div>
	</div>
	</td>
  </tr>
</table>



<script language="JavaScript">

var seconds = 3;
var defaultUrl = \'' . $url . '\';

onload = function()
{
  if (defaultUrl == \'javascript:history.go(-1)\' && window.history.length == \'0\')
  {
    return;
  }
  window.setInterval(redirection, 1000);
}
function redirection()
{
  if (seconds <= 0)
  {
    window.clearInterval();
    return;
  }

  seconds --;
  document.getElementById(\'spanSeconds\').innerHTML = seconds;

  if (seconds == 0)
  {
    window.clearInterval();
    location.href = defaultUrl;
  }
}
</script>
</body>
</html>';
		
		echo $msg;
		
		exit ();
	
	}

}

?>