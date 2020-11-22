<?php
/**
 * Home flash
 */
include_once('global.php');

$act = trim($_GET['act']);
if ( $act == "home_flash" ) {
    include_once (INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_GET['sign'];
    if ( !$sign ) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    if ( !$responseCode ) {
        $obj = new Index();
        $flash = $obj->getflash(5, $sign);

        $datas = array();
        foreach($flash as $key=>$val) {
            array_push($datas, array(
                'img' => getResUrl($val['img']),
                'url' => $val['url']
            ));
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