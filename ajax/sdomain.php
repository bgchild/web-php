<?php
/**
 * 服务领域
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "sdomain" ) {
    include_once(INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $list = $db->getall ('form__bjhh_servearea', "1=1",array(limit=>'0,9999999'), '*',' order by listorder asc');//服务领域
    if ( $list && count($list) ) {
        $datas = array();
        foreach($list as $key=>$val) {
            array_push($datas, array(
                "value" => $val['type'],
                "text" => $val['sdomain'],
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