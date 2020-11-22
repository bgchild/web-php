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

$one = $admin_op->init();
$now_flag = $admin_op->getUserAuthority();
if (isset($_POST['submit'])) {
    $insertItem = array('title', 'mailcode', 'tel', 'fax', 'weburl', 'addr', 'email','htels');
    foreach ($_POST as $k => $v) {
        if (in_array($k, $insertItem)) $datas[$k] = trim($v);
    }
    if ($admin_op->update($datas,0)) {
        //写入操作日志
        $arr = array();
        $arr[module] = '8';
        $arr[type] = '80';
        $admin_op->doLog($arr);
        $db->get_show_msg($admin_op->getBackurl('zbAdminContact.php'), '保存成功！');
    } else {
        $db->get_show_msg($admin_op->getBackurl('zbAdminContact.php'), '保存失败！请再次尝试');
    }
}elseif(isset($_POST['send'])){
    $insertItem = array('title', 'mailcode', 'tel', 'fax', 'weburl', 'addr', 'email','htels');
    foreach ($_POST as $k => $v) {
        if (in_array($k, $insertItem)) $datas[$k] = trim($v);
    }
    if ($admin_op->update($datas,1)) {
        //写入操作日志
        $arr = array();
        $arr[module] = '8';
        $arr[type] = '80';
        $admin_op->doLog($arr);
        $db->get_show_msg($admin_op->getBackurl('zbAdminContact.php'), '发布成功！');
    } else {
        $db->get_show_msg($admin_op->getBackurl('zbAdminContact.php'), '发布失败！请再次尝试');
    }
}

include get_admin_tpl('zbAdminContact');


?>