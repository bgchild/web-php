<?php
/**
 * 联系我们
 */
include_once('global.php');

$act = trim($_GET['act']);
if ( $act == "contactus" ) {
    include_once(INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_GET['sign'];
    if ( !$sign ) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    if ( !$responseCode ) {
        $obj = new Index();
        $info = $obj->getContactInfo($sign);
        //var_dump($info);
        if ( $info ) {
            $datas = array(
                "img" => getResUrl('/templates/images/contactus.png'),
                "addr" => $info['addr'],
                "mailcode" => $info['mailcode'],
                "tel" => $info['tel'],
                "fax" => $info['fax'],
                "weburl" => $info['weburl'],
                "email" => $info['email']
            );
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if ( !$responseCode && isset($datas) ) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
}
