<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminindex.php');
include_once (INCLUDE_PATH . 'adminFastChannel.php');
$admin_op = new adminindex ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$fast = new adminFastChannel();
//所有数据
$list = $fast->getAllList ();
if ($_POST ['or_btn']) {
	if ($fast->fastOrder ()) {
		$fast->db->get_show_msg ( 'fastChannel.php', '排序成功' );
	} else {
		$fast->db->get_show_msg ( 'fastChannel.php', '排序成功' );
	}
}

if ($_GET ['deleteid']) {
	$did = get_url ( trim ( $_GET ['deleteid'] ) );
	if ($fast->deleteOne ( $did )) {
		$fast->db->get_show_msg ( 'fastChannel.php', '删除成功' );
	} else {
		$fast->db->get_show_msg ( 'fastChannel.php', '删除失败' );
	}
	exit ( 0 );
}
include get_admin_tpl ( 'fastChannel' );
?>
