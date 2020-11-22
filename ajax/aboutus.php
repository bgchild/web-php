<?php
/**
 * 关于我们
 */
include_once('global.php');

$act = trim($_GET['act']);
if ( $act == "aboutus" ) {
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
        $info = $obj->getAboutInfo($sign);
        if ( $info ) {
            $datas = array(
                "content" => replaceFullImageUrl(stripslashes($info['con']))
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