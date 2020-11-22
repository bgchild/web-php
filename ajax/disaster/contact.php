<?php
/**
 * 联系我们
 */
include_once('global.php');

$act = trim($_GET['act']);

if ($act == "contact") {

    $sign = $_GET['sign'];

    if (!$sign) {
        returnJson(1, '请选择您所在的地区');
    }

    if (!$responseCode) {
        $info = getContactInfo($sign);
        $active = trim($info['htels']) == '' ? 0 : 1;

        if ($info) {
            $datas = array(
                "img" => getResUrl('/templates/images/contactus.png'),
                "addr" => $info['addr'],
                "mailcode" => $info['mailcode'],
                "tel" => $info['tel'],
                "fax" => $info['fax'],
                "weburl" => $info['weburl'],
                "email" => $info['email'],
                "htels" => $info['htels'],
                "active" => $active
            );
        }
    }

    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(2, '未找到相关信息');
    }


}

function getContactInfo($sign = "")
{
    global $db;
    if (!empty($sign)) {
        $where = "sign='$sign' and status =1";
    } else {
        $where = "sign='$_SESSION[sign]' and status =1";
    }

    return $db->get_one('form__bjhh_zb_contact', $where);
}
