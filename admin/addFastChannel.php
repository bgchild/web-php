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

$fast = new adminFastChannel ();
$backurl = $fast->getBackUrl ( 'fastChannel.php' );
//快捷通道css样式
$li_style = array ('one', 'two', 'three', 'four', 'five' );
if ($_GET['spm']) {
	$spm = get_url(trim($_GET['spm']));
	if (! $spm)
			header ( "Location: fastChannel.php" );
	$fastOne = $fast->getOne($spm);
}

if ($_POST ['dosubmit']) {
	if ($fast->addFastChannel ( $_POST )) {
		$fast->db->get_show_msg ( 'fastChannel.php', '保存快捷通道成功' );
	} else {
		$fast->db->get_show_msg ( 'fastChannel.php', '保存快捷通道失败' );
	}
	exit ( 0 );
}

include get_admin_tpl ( 'addFastChannel' );
?>
