<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminindex.php');
include_once (INCLUDE_PATH . 'adminLink.php');

$admin_op = new adminindex ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
    $db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$now_flag=$admin_op->getUserAuthority();

$obj = new adminLink ();
$Info = $obj->getList (4);//类表显示数
if(isset($_POST['or_btn'])){
    if ($obj->orderInfo()) {
        $db->get_show_msg ( 'adminlink.php', '排序成功' );
    }
}

if($_GET['recordid']) {
    $rid = get_url($_GET['recordid']);
    if(!$rid) $db->get_show_msg($obj->getBackurl("adminlink.php"),"参数错误！！");
    if($obj->deleteOneRecord($rid)>0)
        $db->get_show_msg("adminlink.php", "删除成功！");
    else
        $db->get_show_msg("adminlink.php","删除失败！请再次尝试！");
}


include get_admin_tpl ( 'admin-link' );