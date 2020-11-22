<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminindex.php');
include_once (INCLUDE_PATH . 'adminServictTeamAudit.php');
$admin_op = new adminindex ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$serv = new adminServictTeamAudit ();
//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();
$act = trim ( $_GET ['act'] ) ? $_GET ['act'] : $_POST ['act'];
if (! $act)
	$act = 'init';
switch ($act) {
	case 'init' :
		$cate = $serv->getServictTeamType ( 'form__bjhh_dictbl', 007 );
		$gets = $serv->filterChars ( $_GET );
		$agree = '2';
		$arr = $serv->init ( $gets, $agree );
		$list = $arr ['list'];
		$page = $arr ['page'];
		include get_admin_tpl ( 'serviceTeamMessage' );
		break;	
	default :
		;
		break;
}

?>