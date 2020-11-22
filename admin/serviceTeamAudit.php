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
if (isset ( $_POST ['doSumup'] )) {
	$ret ['result'] = 'yes';
	if (! $serv->sendReason ( $_POST ))
		$ret ['result'] = 'no';
	echo json_encode ( $ret );
	exit ( 0 );
}
	
switch ($act) {
	case 'init' :
		$cate = $serv->getServictTeamType ( 'form__bjhh_dictbl', 007 );
		$gets = $serv->filterChars ( $_GET );
		$reason = $serv->auditReason ( 'form__bjhh_dictbl', '011' );
		$agree = '1';
		$arr = $serv->init ( $gets, $agree );
		$list = $arr ['list'];
		$page = $arr ['page'];
		/*if (isset($_GET['del'])) {
			$did = get_url($_GET['del']);
			$serv->logicDel($did);
		}*/
		include get_admin_tpl ( 'serviceTeamAudit' );
		break;
	case 'yes' :
		$detail = $serv->yes ();
		break;
	default :
		;
		break;
}

?>
