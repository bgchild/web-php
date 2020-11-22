<?php
/**
 * 关于我们
 */
include_once('global.php');

$act = trim($_GET['act']);
if ($act == "about") {

    $sign = $_GET['sign'];
    if (!$sign) {
        returnJson(1, '请选择您所在的地区');
    }

    if (!$responseCode) {
        $info = getAboutInfo($sign);
        /*var_dump($info);
        var_dump(stripslashes($info['con']));
        var_dump(replaceFullImageUrl(stripslashes($info['con'])));*/
        if ($info) {
            $datas = array(
                "content" => replaceFullImageUrl(stripslashes($info['con']))
            );
        }
    }

    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(2, '未找到相关信息');
    }
}

function getAboutInfo($sign = "")
{
    global $db;
    if (!empty($sign)) {
        $where = "sign='$sign' and status =1";
    } else {
        $where = "sign='$_SESSION[sign]' and status =1";
    }
    return $db->get_one('form__bjhh_zb_about', $where);
}