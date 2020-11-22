<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminHelpLists.php');
include_once(INCLUDE_PATH . 'adminVolunteer.php');
$admin_op = new adminVolunteer();
$adminHelp = new adminHelpLists();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if (!preg_match("/^zbadmin(.*)/", $now_admin)) {
    $db->get_show_msg('javascript:history.back(0)', "非法访问！！");
}

if ($now_admin === 'zbadmin') {
    $isSupper = true;
} else {
    $isSupper = false;
}

//判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority();

//获取组织机构
$sign = $admin_op->getCityInfo();
$level = $admin_op->getorganization($sign['areaid']);

$title = "求助列表";
$backurl = "adminHelpList.php";

$act = trim($_GET ['act']) ? $_GET ['act'] : $_POST ['act'];
if (!$act) $act = 'init';

//状态描述
$status_descs = array(
    0 => '未处理',
    1 => '处理中',
    2 => '已处理',
);

switch ($act) {
    case 'init':
        $infos = get_url($_GET['info']);

        $infos[secity] = isset($infos[secity]) ? $infos[secity] : $sign['sign'];

        if($infos['secity'] == 'all'){
            $signs = [];
            $admin_op->getOrganizationSigns($signs, $sign['areaid']);
            $signs = array_unique($signs);
            $str_signs = join("','", $signs);
            $infos['signs'] = $str_signs;
        }

        $searchItems = array('status', 'dname', 'sdate', 'secity', 'edate','address','place','description');
        if (isset($_GET['doSearch'])) {
            foreach ($searchItems as $v) {
                if ($_GET[$v] || $_GET[$v] === '0') {
                    $infos[$v] = $_GET[$v];
                    $query = $infos;
                }
                header("Location:adminHelpList.php?act=init&info=" . set_url($infos));
            }
        }


        $page = _get_page(10);
        $lists = $adminHelp->init($infos, $page['limit'],$isSupper);

        foreach ($lists as $k => $v) {
            $lists[$k]['add_date'] = date("Y-m-d", $v['addtime']);
            $lists[$k]['status_desc'] = $status_descs[$v['status']];

            switch ($lists[$k]['type']) {
                case 1:
                    $lists[$k]['type_desc'] = '我是目击者我正在现场';
                    break;
                case 2:
                    $lists[$k]['type_desc'] = '我是目击者我已离开现';
                    break;
                case 3:
                    $lists[$k]['type_desc'] = '我是事件受影响者我在现场';
                    break;
                case 4:
                    $lists[$k]['type_desc'] = '这是我听说但经过核实的消息';
                    break;
                default:
                    $lists[$k]['type_desc'] = '不详';
                    break;
            }
        }

        // 表格导出
        $exp_lists = $adminHelp->getAllLists($infos,$isSupper);

        if ($_GET['type'] == 'batch_exp') {
            $exp_cfg = $adminHelp->h_array();
            $adminHelp->batch_exp($exp_cfg, $adminHelp->formatData($exp_lists));
        }

        $page['item_count'] = $adminHelp->getCount();
        $page = _format_page($page);

        include get_admin_tpl('admin_help_list');
        break;

    case 'edit':
        $title = "更新状态";
        $rid = get_url(trim($_GET['recordid']));

        if (!$rid) {
            $db->get_show_msg('adminHelpList.php', '参数错误！');
        }
        $info = $adminHelp->getInfo($rid);

        $info['addDate'] = date('Y-m-d H:i:s', $info['addtime']);
        $info['status_desc'] = $status_descs[$info['status']];

        switch ($info['type']) {
            case 1:
                $info['type_desc'] = '我是目击者我正在现场';
                break;
            case 2:
                $info['type_desc'] = '我是目击者我已离开现';
                break;
            case 3:
                $info['type_desc'] = '我是事件受影响者我在现场';
                break;
            case 4:
                $info['type_desc'] = '这是我听说但经过核实的消息';
                break;
            default:
                $info['type_desc'] = '不详';
                break;
        }

        //$info['image'] = $info['image'] ? "http://" . $sign . $website . "/" . $info['image']:'';
        $image_arr = explode(',', $info['image']);
        $images = array();
        foreach ($image_arr as $k => $v) {
            if ($v != '' && $v != 'undefined') {
                $images[] = "http://" . $sign . $website . "/" . $v;
            }
        }

        $info['image'] = $images;
        $info['attachment'] = $info['attachment'] ? "http://" . $sign . $website . "/" . $info['attachment'] : '';

        foreach ($cates as $ck => $cv) {
            if ($cv['recordid'] = $v['cate']) {
                $info['cate_name'] = $cv['name'];
                break;
            }
        }

        include get_admin_tpl('admin_help_edit');
        break;
    case 'show':
        $title = "查看内容";
        $rid = get_url(trim($_GET['recordid']));

        if (!$rid) {
            $db->get_show_msg('adminHelpList.php', '参数错误！');
        }

        $info = $adminHelp->getInfo($rid);
        $info['addDate'] = date('Y-m-d H:i:s', $info['addtime']);
        $info['status_desc'] = $status_descs[$info['status']];
        //$info['image'] = $info['image'] ? "http://" . $sign . $website . "/" . $info['image']:'';

        switch ($info['type']) {
            case 1:
                $info['type_desc'] = '我是目击者我正在现场';
                break;
            case 2:
                $info['type_desc'] = '我是目击者我已离开现';
                break;
            case 3:
                $info['type_desc'] = '我是事件受影响者我在现场';
                break;
            case 4:
                $info['type_desc'] = '这是我听说但经过核实的消息';
                break;
            default:
                $info['type_desc'] = '不详';
                break;
        }

        $image_arr = explode(',', $info['image']);
        $images = array();
        foreach ($image_arr as $k => $v) {
            if ($v != '' && $v != 'undefined') {
                $images[] = "http://" . $sign . $website . "/" . $v;
            }
        }

        $info['image'] = $images;
        $info['attachment'] = $info['attachment'] ? "http://" . $sign . $website . "/" . $info['attachment'] : '';

        foreach ($cates as $ck => $cv) {
            if ($cv['recordid'] = $v['cate']) {
                $info['cate_name'] = $cv['name'];
                break;
            }
        }

        include get_admin_tpl('admin_help_show');
        break;

    case 'save':
        $rid = intval($_POST['recordid']);
        $status = intval($_POST['status']);
        $remark = !empty($_POST['remark']) ? jsformat($_POST['remark']) : "";
        if (in_array($status, array(0, 1, 2)) || !$rid) {
            $data = array('status' => $status, 'remark' => $remark);
            if ($adminHelp->update($data, $rid)) {
                $db->get_show_msg('adminHelpList.php', '提交成功！');
            } else {
                $db->get_show_msg('adminHelpList.php', '提交失败！');
            }
        } else {
            $db->get_show_msg('adminHelpList.php', '参数错误！');
        }

    case 'del':
        $rid = get_url(trim($_GET['recordid']));
        if (!$rid) {
            $db->get_show_msg('adminHelpList.php', '参数错误！');
        } else {
            if ($adminHelp->delete($rid)) {
                header("Location:adminHelpList.php");
            } else {
                $db->get_show_msg('adminHelpList.php', '删除失败！');
            }
        }
        break;
    default:
        break;
}


?>