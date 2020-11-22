<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminLogs.php');
$admin_op=new adminLogs();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}


//判断当前登录用户权限
$searchItems=array('username','ip','start_time','end_time');
if(isset($_GET['doSearch'])){
	foreach ($searchItems as $v){
		if($_GET[$v]) {
			$infos[$v]=$_GET[$v];
		}
		header("Location:adminLogs.php?info=".set_url($infos));
	}
}
$infos=get_url($_GET['info']);
$arr=$admin_op->Logslist($infos);
$list=$arr['list'];
$page=$arr['page'];

if (isset($_GET ['del'])) {
	$url = 'adminLogs.php';
	if ($admin_op->deletelog ()) {
		$admin_op->db->get_show_msg ($url, "删除操作日志成功！" );
	} else {
		$admin_op->db->get_show_msg ($url, "删除操作日志失败！");
	}
	exit ( 0 );
}
include get_admin_tpl('adminLogs');




?>