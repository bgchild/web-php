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

$Info = new adminLink ();
if($_GET['rid']) {
    $one = $Info->getOneInfo();
} else {
    if ( empty($_POST ['dosave']) ) {
        $count = $Info->getCount();
        if ( $count >=4  ) {
            $db->get_show_msg ( 'adminlink.php', '数量已达上限' );
            exit(0);
        }
    }
}
if (isset ($_POST ['dosave'] )) {
    if ($Info->addImg () ){
        $db->get_show_msg ( 'adminlink.php', '保存信息成功' );
    } else {
        $db->get_show_msg ( 'adminaddlink.php', '保存信息失败' );
    }
}
include get_admin_tpl ( 'admin-addlink' );