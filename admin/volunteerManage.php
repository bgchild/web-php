<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminVolunteer.php');
$admin_op = new adminVolunteer();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
    $db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

//判断当前登录用户权限
$now_flag = NULL;
$now_flag = $admin_op->getUserAuthority();

if (isset($_POST['doSumuph'])) {
    $datas['pid'] = $_POST['rid'];
    $datas['reason'] = $_POST['sumup'];
    $datas['types'] = $_POST['types'];
    $datas['workinghours'] = $_POST['working_hours'];
    $datas['date'] = time();
    $ret['result'] = 'yes';
    if (!$admin_op->addWorkingHours($datas)) $ret['result'] = 'no';
    echo json_encode($ret);
    exit(0);
}


$saveact = $_POST['saveact'];
$id = $_POST['id'];
if ($saveact && $id) {
    $user = $admin_op->getUser();
    if ($saveact == 'yes') {
        $datas = array();
        $datas['status'] = '010';
        $datas['auditor'] = $user[0];
        $conditions = " recordid=$id ";
        $result = $admin_op->edit($datas, $conditions);
        $mes['status'] = 'y';
        $mes['mes'] = '该志愿者终审通过操作成功';
        //log
        $arr = array();
        $arr[type] = '23';
        $arr[module] = '2';
        $admin_op->doLog($arr);
        echo json_encode($mes);
    } elseif ($saveact == 'editBasicinfo') {
        //判断志愿者编号是否唯一
        $hnumber = $_POST["hnumber"];
        $condition["hnumber"] = $hnumber;
        $condition["recordid"] = $id;
        if ($hnumber) {
            $result = $admin_op->checkHnumber($condition);
            if ($result) {
                $mes['status'] = 'n';
                $mes['mes'] = '已存在该志愿者编号，请修改！';
                echo json_encode($mes);
                exit();
            }
        } else {
            $mes['status'] = 'n';
            $mes['mes'] = '志愿者编号不能为空！';
            echo json_encode($mes);
            exit();
        }

        $datas = array();
        $datas['hnumber'] = $hnumber;
        $datas['applytime'] = strtotime($_POST["applytime"]);
        $datas['name'] = $_POST["name"];
        $conditions = " recordid=$id ";
        $result = $admin_op->edit($datas, $conditions);
        $mes['status'] = 'y';
        $mes['mes'] = '操作成功';
        echo json_encode($mes);
    }
    exit();
}


$act = trim($_GET['act']) ? $_GET['act'] : $_POST['act'];
if (!$act) $act = 'init';
switch ($act) {
    case 'init':
        //获取组织机构
        $sign = $admin_op->getCityInfo();
        //var_dump($sign['sign']);
        $level = $admin_op->getorganization($sign['areaid']);

        $name = trim($_GET['name']);
        $statused = trim($_GET['status']);
        $stime = trim($_GET['time_start']);
        $etime = trim($_GET['time_stop']);
        $secity = trim($_GET['secity']);
        $lower = isset($_GET['lower']) ? $_GET['lower'] : 0;

        if ($admin_op->getUserName() == 'admin' && ($_SESSION['sign'] === 'www')) {
            $arr = $admin_op->allVolunteersWithWWW($statused, $name, $stime, $etime, $secity);
        } else {
            $arr = $admin_op->allVolunteers($statused, $name, $stime, $etime, $secity);
        }


        $list = $arr['list'];
        $page = $arr['page'];
        $actstatus = 'init';

        include get_admin_tpl('volunteerManage');
        break;

    case 'detail':
        $detail = $admin_op->detail();
        $backurl = $admin_op->getBackUrl('volunteerManage.php');
        include get_admin_tpl('volunteer_detail');
        break;

    case 'yes':
        $detail = $admin_op->yes("010");
        break;

    case 'reactive':
        $reactiveid = $_GET['reactiveid'];
        $admin_op->reactive($reactiveid);
        break;
    case 'ltid':
        $ltidid = $_GET['ltidid'];
        $admin_op->logout($ltidid);
        break;
    // 添加删除志愿者
    case 'dlid':
        $dlidid = $_GET['dlidid'];
        $backurl = $admin_op->getBackUrl('volunteerManage.php');
        if ( !$dlidid ) {
            $db->get_show_msg ( 'javascript:history.back(0)', "错误操作！" );
        } else {
            $admin_op->dlout($dlidid);
            $db->get_show_msg ( $backurl, "操作成功！" );
        }
        break;
    case 'repassword':
        $rid = $_GET['id'];
        $admin_op->repassword($rid);
        $admin_op->db->get_show_msg('volunteer.php', '密码重置成功！');
        break;
    case 'batch_exp':
        $name = trim($_GET['name']);
        $statused = trim($_GET['status']);
        $stime = trim($_GET['time_start']);
        $etime = trim($_GET['time_stop']);
        $sign = trim($_GET['secity']);

        $ids = $admin_op->getPageVolunteers($statused, $name, $stime, $etime, $sign);//获取当前页面志愿者信recordid

        if (!$ids) {
            $backurl = $admin_op->getBackUrl('volunteerManage.php');
            $admin_op->db->get_show_msg($backurl, '此页面没有志愿者信息！');
        }
        $expdata = $admin_op->batch_export($ids);//获取当前页面志愿者信详细信息
        //log
        $arr = array();
        $arr[type] = '20';
        $arr[module] = '2';
        $admin_op->doLog($arr);
        batch_exp($expdata);//导出志愿者信详细信息

        break;

    default:
        ;
        break;
}

function batch_exp($expdata)
{
    $exp_cfg = array(
        'username' => '用户名',
        'name' => '姓名',
        'nickname' => '昵称',
        'sex' => '性别',
        'birthday' => '出生日期',
        'allservertime' => '服务时间',
        'idtype' => '证件类型',
        'idnumber' => '证件号码',
        'nationality' => '国籍',
        'race' => '民族',
        'politicalstatus' => '政治面貌',
        'emails' => '电子邮箱',
        'graduatecollege' => '毕业院校',
        'major' => '专业',
        'lasteducation' => '最高学位',
        'jzd' => '居住地',
        'isstudent' => '是否学生',
        'fwdd' => '服务地点',
        'work' => '工作单位',
        'detailplace' => '通信邮编',
        'cellphone' => '手机',
        'telephone' => '固定电话',
        'features' => '技能特长',
        'qq' => 'QQ',
        'serveitem' => '服务项目',
        'applytime' => '申请时间',
        'sdomain' => '服务领域',
        'hnumber' => '志愿者编码',
    );
    $firstys = 'username';
    require_once('PHPExcel.php');
    $objPHPExcel = new PHPExcel();

// Set properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

// Add some data
    $Word = 'A';
    foreach ($exp_cfg as $key => $v) {
        if ($key != $firstys) {
            $Word = ++$Word;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($Word . '1', $v);
        $objPHPExcel->getActiveSheet()->getColumnDimension($Word)->setWidth(10);
    }


    foreach ($expdata as $key => $row) {
        $k = 0;
        $k = $key + 2;

        $WordC = 'A';
        foreach ($exp_cfg as $ckey => $cv) {
            if ($ckey != $firstys) {
                $WordC = ++$WordC;
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($WordC . $k, $row[$ckey]);
        }

    }


    $name = "志愿者导出";
    $name = $name . '.xls';
    if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
        $name = rawurlencode($name);
    }
// Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('志愿者导出');

// Redirect output to a client’s web browser (Excel5)
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $name . '"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

    exit;
}

?>