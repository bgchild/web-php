<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminSubscribeLists.php');
include_once(INCLUDE_PATH . 'adminVolunteer.php');
$admin_op = new adminVolunteer();
$adminSubscribe = new adminSubscribeLists();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^zbadmin(.*)/", $now_admin) ) {
    $db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

//判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority();

//获取组织机构
$sign = $admin_op->getCityInfo();
$level = $admin_op->getorganization($sign['areaid']);
//var_dump($level);

$title = "关注人员管理";
$backurl = "adminSubscribeList.php";

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
        $searchItems=array('name','mobile', 'secity');
        if(isset($_GET['doSearch'])){
            foreach ($searchItems as $v){
                if($_GET[$v] || $_GET[$v] === '0') {
                    $infos[$v]=$_GET[$v];
                    $query=$infos;
                }
                header("Location:adminSubscribeList.php?act=init&info=".set_url($infos));
            }
        }

        $page = _get_page(10);
        $lists = $adminSubscribe->init($infos, $page['limit']);

        foreach ($lists as $k => $v) {
            $lists[$k]['add_date'] = date("Y-m-d", $v['addtime']);
            $lists[$k]['status_desc'] = $status_descs[$v['status']];
        }

        // 表格导出
        if( $_GET['type'] == 'batch_exp' ) {
            $exp_cfg = $adminSubscribe->h_array();
            $adminSubscribe->batch_exp($exp_cfg, $adminSubscribe->formatData($lists));
        }

        $page['item_count'] = $adminSubscribe->getCount();
        $page = _format_page($page);

        include get_admin_tpl('admin_subscribe_list');
        break;

    case 'show':
        $title = "查看内容";
        $rid = get_url(trim($_GET['recordid']));

        if (!$rid) {
            $db->get_show_msg('adminSubscribeList.php', '参数错误！');
        }

        $info = $adminSubscribe->getInfo($rid);
        $info['addDate'] = date('Y-m-d H:i:s',$info['addtime']);
        $info['status_desc'] = $status_descs[$info['status']];

        foreach ($cates as $ck => $cv) {
            if ($cv['recordid'] = $v['cate']) {
                $info['cate_name'] = $cv['name'];
                break;
            }
        }

        include get_admin_tpl('admin_subscribe_show');
        break;

    case 'edit':
        $title = "设置责任人";
        $rid = get_url(trim($_POST['rid']));
        $flag = intval($_POST['flag']);

        if (!$rid) {
            $db->get_show_msg('adminSubscribeList.php', '参数错误！');
        }
        if($adminSubscribe->setFlag($rid,$flag)){
            $db->get_show_msg('adminSubscribeList.php', '操作成功！');
        }else{
            $db->get_show_msg('adminSubscribeList.php', '操作失败！');
        }

        break;

    case 'del':
        $rid = get_url(trim($_GET['recordid']));
        if(!$rid){
            $db->get_show_msg('adminSubscribeList.php', '参数错误！');
        }else{
            if($adminSubscribe->delete($rid)){
                header("Location:adminSubscribeList.php");
            }else{
                $db->get_show_msg('adminSubscribeList.php', '删除失败！');
            }
        }
        break;
    default:
        break;
}



?>