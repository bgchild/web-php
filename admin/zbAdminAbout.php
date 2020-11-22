<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'zbAdminContact.php');
$admin_op = new zbAdminContact();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if (!preg_match("/^zbadmin(.*)/", $now_admin)) {
    $db->get_show_msg('javascript:history.back(0)', "非法访问！！");
}

$now_flag = $admin_op->getUserAuthority();
$one = $admin_op->aboutinfo();
if (isset($_POST['save'])) {
    if ($admin_op->aboutus($_POST['content'],0)) {
        //写入操作日志
        $arr = array();
        $arr[module] = '9';
        $arr[type] = '90';
        $admin_op->doLog($arr);
        $db->get_show_msg($admin_op->getBackurl('zbAdminAbout.php'), '保存成功！');
    } else {
        $db->get_show_msg($admin_op->getBackurl('zbAdminAbout.php'), '保存失败！请再次尝试');
    }
}elseif (isset($_POST['send'])){
    if ($admin_op->aboutus($_POST['content'],1)) {
        //写入操作日志
        $arr = array();
        $arr[module] = '9';
        $arr[type] = '90';
        $admin_op->doLog($arr);
        $db->get_show_msg($admin_op->getBackurl('zbAdminAbout.php'), '发布成功！');
    } else {
        $db->get_show_msg($admin_op->getBackurl('zbAdminAbout.php'), '发布失败！请再次尝试');
    }
}

include get_admin_tpl('zbAdminAbout');
?>