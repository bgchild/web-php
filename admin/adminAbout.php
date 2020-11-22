<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminContact.php');
$admin_op=new adminContact();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$now_flag=$admin_op->getUserAuthority();
$one=$admin_op->aboutinfo();
if(isset($_POST['save'])) {
	if($admin_op-> aboutus($_POST['content'])) {
		//写入操作日志
		$arr=array();
		$arr[module]='9';
		$arr[type]='90';
	    $admin_op->doLog($arr);
	$db->get_show_msg($admin_op->getBackurl('adminAbout.php'),'保存成功！');
	}else{ $db->get_show_msg($admin_op->getBackurl('adminAbout.php'),'保存失败！请再次尝试');}
}

include get_admin_tpl('adminAbout');
?>