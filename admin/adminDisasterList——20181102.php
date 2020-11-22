<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminDisasterLists.php');
include_once(INCLUDE_PATH . 'adminVolunteer.php');
$admin_op = new adminVolunteer();
$adminDisaster = new adminDisasterLists();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if (!preg_match("/^zbadmin(.*)/", $now_admin)) {
    $db->get_show_msg('javascript:history.back(0)', "非法访问！！");
}

$infos = get_url($_GET['info']);
/*if ($infos['province']) {
    $infos['secity'] = $infos['province'];
    $city = $admin_op->_getOrganizationBySign($infos['province']);
}

if ($infos['city']) {
    $infos['secity'] = $infos['city'];
    $area = $admin_op->_getOrganizationBySign($infos['city']);
}

if ($infos['area']) {
    $infos['secity'] = $infos['area'];
}*/

//判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority();

//获取组织机构
$sign = $admin_op->getCityInfo();
$level = $admin_op->getorganization($sign['areaid']);

$infos[secity] = isset($infos[secity]) ? $infos[secity] : $sign['sign'];

$signs = [];
$admin_op->getOrganizationSigns($signs, $sign['areaid']);
$signs = array_unique($signs);
$str_signs = join("','", $signs);
$infos['signs'] = $str_signs;

/*$area_info = $admin_op->getcurorganization($sign['areaid']);*/

/*if ($sign['sign'] == 'www' && $now_admin == 'zbadmin') {
    $datas = [];
    $province = $admin_op->getorganization('000001');
}*/

//$title = "灾害列表";
$backurl = "adminDisasterList.php";

$act = trim($_GET ['act']) ? $_GET ['act'] : $_POST ['act'];
if (!$act) $act = 'init';

$cates = $adminDisaster->getCateLists();

//状态描述
$status_descs = array(
    0 => '未处理',
    1 => '处理中',
    2 => '已处理',
);

switch ($act) {
    case 'init':
        $searchItems = array('status', 'dname', 'sdate', 'secity', 'edate', 'cname', 'address', 'place', 'svictims_num', 'evictims_num', 'sinjured_num', 'einjured_num', 'smissing_num', 'emissing_num', 'sdie_num', 'edie_num', 'stransfer_num', 'etransfer_num', 'sfood_help_num', 'efood_help_num', 'sdamage_land', 'esdamage_land', 'sdamage_crops', 'edamage_crops', 'damage_building', 'description', 'province', 'city', 'area');
        if (isset($_GET['doSearch'])) {
            foreach ($searchItems as $v) {
                if ($_GET[$v] || $_GET[$v] === '0') {
                    $infos[$v] = $_GET[$v];
                    $query = $infos;
                }
                header("Location:adminDisasterList.php?act=init&info=" . set_url($infos));
            }
        }

        $page = _get_page(10);
        $lists = $adminDisaster->init($infos, $page['limit']);

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

            foreach ($cates as $ck => $cv) {
                if ($cv['recordid'] == $v['cate']) {
                    $lists[$k]['cate_name'] = $cv['name'];
                    break;
                }
            }
        }

        // 表格导出
        if ($_GET['type'] == 'batch_exp') {

            $exp_lists = $adminDisaster->getAllLists($infos);
            $exp_cfg = $adminDisaster->h_array();
            $adminDisaster->batch_exp($exp_cfg, $adminDisaster->formatData($exp_lists));

        }

        $page['item_count'] = $adminDisaster->getCount();
        $page = _format_page($page);

        include get_admin_tpl('admin_disaster_list');
        break;

    case 'edit':
        $title = "更新状态";
        $rid = get_url(trim($_GET['recordid']));

        if (!$rid) {
            $db->get_show_msg('adminDisasterList.php', '参数错误！');
        }
        $info = $adminDisaster->getInfo($rid);

        $info['addDate'] = date('Y-m-d H:i:s', $info['addtime']);
        $info['status_desc'] = $status_descs[$info['status']];
        $info['image'] = $info['image'] ? "http://" . $sign . $website . "/" . $info['image'] : '';
        $info['attachment'] = $info['attachment'] ? "http://" . $sign . $website . "/" . $info['attachment'] : '';

        switch ($lists[$k]['type']) {
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

        foreach ($cates as $ck => $cv) {
            if ($cv['recordid'] = $info['cate']) {
                $info['cate_name'] = $cv['name'];
                break;
            }
        }

        include get_admin_tpl('admin_disaster_edit');
        break;
    case 'show':

        $title = "查看内容";
        $rid = get_url(trim($_GET['recordid']));

        if (!$rid) {
            $db->get_show_msg('adminDisasterList.php', '参数错误！');
        }

        $info = $adminDisaster->getInfo($rid);

        $info['addDate'] = date('Y-m-d H:i:s', $info['addtime']);
        $info['status_desc'] = $status_descs[$info['status']];
        //$info['image'] = $info['image'] ? "http://" . $sign . $website . "/" . $info['image'] : '';

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
            if ($cv['recordid'] = $info['cate']) {
                $info['cate_name'] = $cv['name'];
                break;
            }
        }

        include get_admin_tpl('admin_disaster_show');
        break;

    case 'save':
        $rid = intval($_POST['recordid']);
        $status = intval($_POST['status']);

        if (in_array($status, array(0, 1, 2)) || !$rid) {
            $data = array('status' => $status, 'remark' => $remark);
            if ($adminDisaster->update($data, $rid)) {
                $db->get_show_msg('adminDisasterList.php', '提交成功！');
            } else {
                $db->get_show_msg('adminDisasterList.php', '提交失败！');
            }
        } else {
            $db->get_show_msg('adminDisasterList.php', '参数错误！');
        }

    case 'del':
        $rid = get_url(trim($_GET['recordid']));
        if (!$rid) {
            $db->get_show_msg('adminDisasterList.php', '参数错误！');
        } else {
            if ($adminDisaster->delete($rid)) {
                header("Location:adminDisasterList.php");
            } else {
                $db->get_show_msg('adminDisasterList.php', '删除失败！');
            }
        }
        break;

    case 'province':
        $psign = trim($_GET['psign']);
        $data = $admin_op->_getOrganizationBySign($psign);

        if (empty($data)) {
            $status = 1;
            $city_html = '';
        } else {
            $city_html = '<select name="city" id="city">';
            foreach ($data as $cvar) {
                $city_html .= "<option value=\" $cvar[sign]\"> $cvar[name]</option>";
            }
            $city_html .= '</select>';
        }

        $info = array('status' => $status, 'mes' => $city_html);
        echo json_encode($info);
        exit();

    case 'city':
        $psign = trim($_GET['psign']);

        $data = $admin_op->_getOrganizationBySign($psign);

        if (empty($data)) {
            $status = 1;
            $area_html = '';
        } else {
            $status = 0;
            $area_html = '<select name="area" id="area"  style="">';
            foreach ($data as $avar) {
                $area_html .= "<option value=\" $avar[sign]\"> $avar[name]</option>\"";
            }
            $area_html .= '</select>';
        }

        $info = array('status' => $status, 'mes' => $area_html);
        echo json_encode($info);
        exit();
    default:
        break;
}


?>