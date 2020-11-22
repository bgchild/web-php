<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminindex.php');
include_once (INCLUDE_PATH . 'adminServictTeamAudit.php');
$admin_op = new adminindex ();
$serTP = new adminServictTeamAudit ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

/*
 * 服务队管理GET传参数组 $spm
 * $spm['recordid'] 服务队主键
 * $spm['page'] 服务队分页信息
 */ 
$spm = get_url($_GET['spm']);

//图片添加入库
if ($_POST ['dosubmit']) {
	if ($serTP->serTeamPicAdd ( $_POST, $spm ['recordid'] )) {
		$serTP->db->get_show_msg ( 'serviceTeamPicture.php?spm=' . set_url ( $spm ), '图片保存成功' );
	} else {
		$serTP->db->get_show_msg ( 'serviceTeamPicture.php?spm=' . set_url ( $spm ), '图片保存失败' );
	}
	exit ( 0 );
}

//服务队展示图片信息获取
$stp_info = $serTP->getSTPInfo ( $spm ['recordid'] );

//图片删除
if ($_GET ['deleteid']) {
	$did = get_url ( $_GET ['deleteid'] );
	if ($serTP->deletePic ( $did )) {
		$serTP->db->get_show_msg ( 'serviceTeamPicture.php?spm=' . set_url ( $spm ), '图片删除成功' );
	} else {
		$serTP->db->get_show_msg ( 'serviceTeamPicture.php?spm=' . set_url ( $spm ), '图片删除失败' );
	}
}

//排序
if ($_POST ['or_btn']) {
	if ($serTP->serTpOrder ( $_POST ['order'], $_POST ['rid'] )) {
		$serTP->db->get_show_msg ( 'serviceTeamPicture.php?spm=' . set_url ( $spm ), '排序成功！' );
	} else {
		$serTP->db->get_show_msg ( 'serviceTeamPicture.php?spm=' . set_url ( $spm ), '排序成功！' );
	}
}

include get_admin_tpl ( 'serviceTeamPicture' );
?>
