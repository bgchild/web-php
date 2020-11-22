<?php
include_once('../global.php');
include_once(INCLUDE_PATH . 'adminPatch.php');
require_once('PHPExcel.php');
$admin_op = new adminPatch();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
    $db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

if (isset($_POST['doSubmit'])) {
    $tname = $_FILES["excelFile"]["name"];
    $tnames = explode(".", $tname);
    if ($tnames[1] != "xls") {
        $admin_op->db->get_show_msg('patch.php', '上传的文件必须是xls文件');
    }
    $tname = $_FILES["excelFile"]["tmp_name"];
    $tnames = explode(".", $tname);
    $path = "./" . time() . "_" . rand(1, 100) . ".xls";
    move_uploaded_file($tname, $path);
    chmod($path,0644);
    //log
    $arr = array();
    $arr[type] = '21';
    $arr[module] = '2';
    $admin_op->doLog($arr);

    include get_admin_tpl('patch_pro');
    echo '<script type="text/javascript">sendInfo(\'' . addslashes($path) . '\',0);</script>' . "\r\n" . "</body></html>";
    ob_flush();
    flush();

    exit(0);
}

if (isset($_GET['fileName'])) {
    $file_name = html_entity_decode($_GET['fileName'], ENT_QUOTES);
    $i = $_GET['i'] ? $_GET['i'] : 0;

    if ($i == 0) {
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        $cacheSettings = array();
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        if(!file_exists($file_name)){
            $data['has_false'] = 'false';
            $data['msg'] = "上传失败";
            echo json_encode($data);
            exit();
        }

//        ini_set("display_errors", "On");
//        error_reporting(E_ALL | E_STRICT);

        $objPHPExcel = new PHPExcel();
        $PHPReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $PHPReader->load($file_name);

        //$objPHPExcel = PHPExcel_IOFactory::load($file_name);

        $rldata = $objPHPExcel->getActiveSheet()->toArray();
        $_SESSION['p_check_false'] = array();
        $rdata = array();
        for ($j = 1; $j < count($rldata); $j++) {
            if ($rldata[$j][0]) {//不为空
                $tmp = $admin_op->check($rldata[$j]);
                if ($tmp['emsg'] == 'pass') {
                    $rdata[] = array($j + 1, $tmp);
                } else {
                    $_SESSION['p_check_false'][] = array($j + 1, "<font style='color:#ff0000'>文件第【 " . ($j + 1) . " 】行(" . $tmp['emsg'] . ")</font>");
                }
            }
        }

        if (count($_SESSION['p_check_false']) > 0) {
            $data['has_false'] = 'true';
            $data['check_false'] = $_SESSION['p_check_false'];
        }

        $_SESSION['p_data'] = $rdata;
        $_SESSION['p_count'] = count($rdata);
        $_SESSION['p_error'] = array();

        if ($_SESSION['p_count'] > 0) {
            $line = $_SESSION['p_data'][$i][0];
            if ($admin_op->addInfo($_SESSION['p_data'][$i][1])) {
                $data['msg'] = "文件第【 " . $line . " 】行的数据成功入库";
            } else {
                $data['msg'] = "<font style='color:#CC6666;'>文件第【 " . $line . " 】行的数据为重复数据，不再入库</font>";
                $_SESSION['p_error'][] = array($line, $data['msg']);
            }
        } else {
            $data['msg'] = "没有检测到合格数据";
        }

        $data['i'] = $i + 1;
    } else if ($i < $_SESSION['p_count']) {
        //echo('77');
        $line = $_SESSION['p_data'][$i][0];
        if ($admin_op->addInfo($_SESSION['p_data'][$i][1])) {
            $data['msg'] = "文件第【 " . $line . " 】行的数据成功入库";
        } else {
            $data['msg'] = "<font style='color:#CC6666;'>文件第【 " . $line . " 】行的数据为重复数据，不再入库</font>";
            $_SESSION['p_error'][] = array($line, $data['msg']);
        }
        $data['i'] = $i + 1;
    } else {
        //echo('88');
        $data['isdone'] = 'true';
        $data['msg'] = "<font style='color:#C13100;font-weight:bold'>文件中共有 " . ($_SESSION['p_count'] + count($_SESSION['p_check_false'])) . " 条数据，其中无效数据 " . count($_SESSION['p_check_false']) . " 条，有效数据 " . $_SESSION['p_count'] . " 条，成功导入 " . ($_SESSION['p_count'] - count($_SESSION['p_error'])) . " 条， 失败 " . (count($_SESSION['p_error'])) . " 条</font>";
        unlink($file_name);
    }

    echo json_encode($data);
    exit(0);
}

if (isset($_GET['filepath'])) {
    filedown($_GET['filepath'], $_GET["filename"]);
    exit(0);
}

if (isset($_GET['showResult'])) {
    foreach ($_SESSION['p_check_false'] as $k => $v) {
        $check_false[$k] = $v;
    }
    //unset($_SESSION['p_check_false']);
    foreach ($_SESSION['p_error'] as $k => $v) {
        $error[$k] = $v;
    }
    //unset($_SESSION['p_error']);
    include get_admin_tpl('patch_result');
    exit(0);
}

include get_admin_tpl('patch');

?>