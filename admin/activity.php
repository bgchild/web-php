<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminActivity.php');
$admin_op=new adminActivity();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();

$act=trim($_GET['act'])?$_GET['act']:$_POST['act'];
if(!$act)$act='init';
switch ($act) {
	case 'init':
	$activityStatus=trim($_GET['status']);
	//var_dump($status);
	$keyword=trim($_GET['keyword']);	
	$arr=$admin_op->init($status,$keyword);
    $list=$arr['list'];
    $page=$arr['page'];
    $agree=$arr['type1'];
    $refuse=$arr['type2'];
    include get_admin_tpl('activity');
	break;
	
	case 'detail':	
	$detail=$admin_op->detail();
	$backurl=$admin_op->getBackUrl('activity.php');
    include get_admin_tpl('detail');
	break;
	case 'yes':
	$detail=$admin_op->yes();	
	break;
	case 'no':
	$detail=$admin_op->no();	
	break;
	default:
		;
	break;
}



?>