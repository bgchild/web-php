<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminindex.php');
include_once (INCLUDE_PATH . 'adminDisasterFlash.php');
$admin_op = new adminindex ();
$Info = new adminDisasterFlash ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^zbadmin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$now_flag=$admin_op->getUserAuthority();
if($_GET['rid']) $one=$Info->getOneInfo();
	if (isset ($_POST ['dosave'] )) {
		if ($Info->addImg () ){
			$db->get_show_msg ( 'adminDisasterflash.php', '保存信息成功' );
		} else {
			$db->get_show_msg ( 'admindisasteraddflash.php', '保存信息失败' );
		}
	}
include get_admin_tpl ( 'admin_disaster_addflash' );
?>
