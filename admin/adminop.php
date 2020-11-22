<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminindex.php');
$admin_op=new adminindex();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
    $db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

include get_admin_tpl('admin_op');



?>