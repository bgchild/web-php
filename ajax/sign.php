<?php
/**
 * 城市标签获取
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "sign" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $name = trim($_GET['name']);
    if ( !$name ) {
        $responseCode = 1;
        $responseMsg = "地区名称不能为空";
    }

    if ( !$responseCode ) {
        $names = explode(",", $name);
        $sign = getSign($names);
        if ( $sign ) {
            $datas = array(
                "sign" => $sign
            );
        } else {
            $responseCode = 2;
            $responseMsg = "地区不存在";
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