<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminIndexManage.php');
include_once(INCLUDE_PATH . 'adminVolunteer.php');
$admin_op = new adminVolunteer();
$admin_manage = new adminIndexManage();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
    $db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();

//判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority();

$act = trim($_GET ['act']) ? $_GET ['act'] : $_POST ['act'];

if (!$act) $act = 'init';

switch ($act) {
    case 'init' :
        $list = $admin_manage->init();
        include get_admin_tpl('indexManage');
        break;

    case 'edit' :
        $rid = get_url(trim($_GET['rid']));
        if (!$rid) {
            $db->get_show_msg('indexManage.php', '参数错误！');
        }
        $detail = $admin_manage->fTitle($rid);
        include get_admin_tpl('indexManageEdit');
        break;
    case 'add' :
        $isshow = 1;
        $rid = get_url(trim($_GET['rid']));
        if (!$rid) {
            $db->get_show_msg('indexManage.php', '参数错误！');
        }
        $column = $admin_manage->fTitle($rid);
        include get_admin_tpl('indexManageListEdit');
        break;
    case 'delete' :
        $rid = get_url(trim($_GET['rid']));
        if (!$rid) {
            $db->get_show_msg('indexManage.php', '参数错误！');
        }
        $detail = $admin_manage->deleteColumn($rid);
        header("Location:indexManage.php");
        break;
    case 'save' :
        $rid = trim($_POST['rid']);
        $name = $_POST['name'];
        $backurl = $admin_op->getBackUrl('indexManage.php');
        if ($admin_manage->editTitle($rid, $name)) {
            $db->get_show_msg("indexManage.php", '保存成功');
        } else {
            $db->get_show_msg($backurl, '保存失败');
        }

    default :
        ;
        break;
}


?>