<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminIndexManage.php');
include_once(INCLUDE_PATH . 'adminVolunteer.php');
$admin_op = new adminVolunteer();
$admin_manage = new adminIndexManage();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if (!preg_match("/^zbadmin(.*)/", $now_admin)) {
    $db->get_show_msg('javascript:history.back(0)', "非法访问！！");
}

//判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority();

$act = trim($_GET ['act']) ? $_GET ['act'] : $_POST ['act'];
if (!$act)
    $act = 'init';

switch ($act) {
    case 'init' :
        $rid = get_url($_GET['rid']);
        if (!$rid) {
            $db->get_show_msg('indexDisasterManage.php', '参数错误！');
        }
        $page = _get_page(10);
        $list = $admin_manage->news($rid, $page['limit']);
        $column = $admin_manage->fTitle($rid);
        foreach ($list as $k => $v) {
            $list[$k]['editTime'] = date("Y-m-d H:i:s", $v['editTime']);
        }
        $ftitle = $admin_manage->fTitle($rid);
        $page['item_count'] = $admin_manage->getCount();
        $page = _format_page($page);
        include get_admin_tpl('indexDisasterManageList');
        break;
    case 'edit' :
        $rid = get_url($_GET['rid']);
        if (!$rid) {
            $db->get_show_msg('indexDisasterManageList.php', '参数错误！');
        }
        $detail = $admin_manage->zTitle($rid);
        $column = $admin_manage->fTitle($detail['fid']);
        $backurl = $admin_op->getBackUrl('indexDisasterManageList.php');
        include get_admin_tpl('indexDisasterManageListEdit');
        break;

    case 'show' :
        $rid = get_url($_GET['rid']);
        if (!$rid) {
            $db->get_show_msg('indexDisasterManageList.php', '参数错误！');
        }
        $detail = $admin_manage->zTitle($rid);
        $column = $admin_manage->fTitle($detail['fid']);
        $backurl = $admin_op->getBackUrl('indexDisasterManageList.php');
        include get_admin_tpl('indexDisasterManageListShow');
        break;

    case 'delete' :
        $rid = get_url($_GET['rid']);
        if (!$rid) {
            $db->get_show_msg('indexDisasterManageList.php', '参数错误！');
        }
        $column = $admin_manage->zTitle($rid);
        $cid = set_url($column[fid]);
        $admin_manage->deleteNews($rid);
        header("Location:indexDisasterManageList.php?rid=" . $cid);
        break;

    case 'add' :
        $post = array();
        $msg = '保存';
        foreach ($_POST as $k => $v) $post[$k] = trim($v);
        if (isset($_POST['send'])) {
            $post['status'] = 1;
            $msg = '发布';
        }
        $backurl = $admin_op->getBackUrl('indexDisasterManageList.php');
        if ($admin_manage->addNews($post)) {
            $db->get_show_msg("indexDisasterManage.php", $msg . '成功');
        } else {
            $db->get_show_msg($backurl, $msg . '失败');
        }
        break;

    case 'save' :
        $post = array();
        $msg = '保存';
        foreach ($_POST as $k => $v) $post[$k] = trim($v);
        if (isset($_POST['send'])) {
            $post['status'] = 1;
            $msg = '发布';
        }

        $backurl = $admin_op->getBackUrl('indexDisasterManageList.php');
        $column = $admin_manage->zTitle($post[rid]);
        $cid = set_url($column[fid]);
        if ($admin_manage->editNews($post)) {
            $db->get_show_msg("indexDisasterManageList.php?rid=$cid", $msg . '成功');
        } else {
            $db->get_show_msg($backurl, $msg . '失败');
        }

    default :
        ;
        break;
}


?>