<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminindex.php');
include_once (INCLUDE_PATH . 'adminServiceTeamMoreInfo.php');
$admin_op = new adminindex ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$admin_M = new adminServiceTeamMoreInfo ();

//默认地区和服务项目、技能
$province = $admin_M->defaultCityArray ( 'province' );
$cate = $admin_M->checkboxArray ( 'form__bjhh_dictbl', 007 );
$skill = $admin_M->checkboxArray ( 'form__bjhh_dictbl', 006 );
$act = $_GET ['act'] ? trim ( $_GET ['act'] ) : 'init';

$men_per = 5;
$men_total = count ( $admin_M->init () );
 if (isset ( $_POST ['doAPage'] )) {
	$page_index = $_POST ['page_index'];
	$nickname = $_POST ['nickname'];
	$limit = ($page_index * $men_per) . "," . ($men_per);
	$limit = array (limit => $limit );
	$men_each = $admin_M->init ( $nickname, $limit );
	echo json_encode ( $men_each );
	exit ( 0 );
} 
if (isset ( $_POST ['doSearch'] )) {
	$nickname = $_POST ['nickname'];
	$men_total = count ( $admin_M->init ( $nickname ) );
	$men_each ['men_total'] = $men_total;
	echo json_encode ( $men_each );
	exit ( 0 );
}

if ($_POST ['dosubmit']) {
	$status = $_POST ['action'];
	if ($admin_M->serviceTeamAdd ( $_POST, $status )) {
		$admin_M->db->get_show_msg ( 'serviceTeamMessage.php', '保存服务队成功' );
	} else {
		$admin_M->db->get_show_msg ( 'serviceTeamMessage.php', '保存服务队失败' );
	}
	exit ( 0 );
}

switch ($act) {
	case 'detail' :
		$spm = get_url ( $_GET ['spm'] );
		if (! $spm)
			$this->db->get_show_msg ( 'serviceTeamAudit.php', '参数错误！' );
		$sid = $spm ['id'];
		$ser_one = $admin_M->detail ( $sid );
		if ($ser_one ['province'])
			$city = $admin_M->OneCityArray ( $ser_one ['province'] );
		if ($ser_one ['city'])
			$area = $admin_M->OneCityArray ( $ser_one ['city'] );
		$de_url = $admin_M->getBackUrl ( 'serviceTeamAudit.php' );
		break;
	case 'add' :
		$backurl = $admin_M->getBackUrl ( 'serviceTeamMessage.php' );
		break;
	case 'edit' :
		$backurl = $admin_M->getBackUrl ( 'serviceTeamMessage.php' );
		$recordid = get_url ( $_GET ['recordid'] );
		if (! $recordid)
			$this->db->get_show_msg ( 'serviceTeamMessage.php', '参数错误！' );
		$ser_one = $admin_M->serviceGetOne ( $recordid );
		if ($ser_one ['province'])
			$city = $admin_M->OneCityArray ( $ser_one ['province'] );
		if ($ser_one ['city'])
			$area = $admin_M->OneCityArray ( $ser_one ['city'] );
		break;
	case 'cancels' :
		$backurl = $admin_M->getBackUrl ( 'serviceTeamMessage.php' );
		$recordid = get_url ( $_GET ['cancelid'] );

		if (! $recordid) $this->db->get_show_msg ( 'serviceTeamMessage.php', '参数错误！' );
		$delrs= $admin_M->serviceDelOne ($recordid);
		if ($delrs) {
		   $admin_M->db->get_show_msg ( 'serviceTeamMessage.php', '注销服务队成功' );
	     } else {
		   $admin_M->db->get_show_msg ( 'serviceTeamMessage.php', '注销服务队失败' );
	     }	
		break;
	default :
		;
		break;
} 

include get_admin_tpl ( 'serviceTeamMoreInfo' );
?>
