<?php
/**
 * 第三方服务连接
 */
include_once('global.php');

$act = trim($_GET['act']);
if ( $act == "fastChannel" ) {
    include_once(INCLUDE_PATH . "FastChannel.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $fast = new FastChannel ();
    $list = $fast->getAllList ();

    //var_dump($list);
    if ( $list && count($list) ) {
        $datas = array();
        foreach($list as $key=>$val) {
            array_push($datas, array(
                "name" => $val['fast_name'],
                "url" => $val['fast_url']
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
