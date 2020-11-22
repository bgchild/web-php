<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminCaptain.php');
$admin_op = new adminCaptain ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

// 判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority ();

$searchItems = array (
		'search_name',
		'search_phone',
		'search_username', 
		'is_dz'
);
$tags = array ();
$query = array ();

if (isset ( $_POST ['doresearch'] )) {
	$tags ['searchtag'] = "true";
	foreach ( $searchItems as $item ) {
		if (trim ( $_POST [$item] )) {
			$tags [$item] = $_POST [$item];
			header ( "Location:captain.php?condition=" . set_url ( $tags ) );
		}
	}
}

$searchCondition = get_url ( $_GET ['condition'] );

if (isset ( $searchCondition ['searchtag'] )) {
	$tags ['searchtag'] = "true";
	$query ['searchtag'] = "true";
	foreach ( $searchItems as $item )
		if (trim ( $searchCondition [$item] )) {
			$query [$item] = $searchCondition [$item];
			$tags [$item] = $searchCondition [$item];
		}
}

$arr = $admin_op->init ( $query );
$list = $arr ['list'];
$page = $arr ['page'];

include get_admin_tpl ( 'captain' );

?>