<?php
/**
 * 活动类型
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "activityType" ) {
    include_once (INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $where = "tcode='008'";
    $list = $db->getall("form__bjhh_dictbl", $where);
    //var_dump($list);
    if ( $list && count($list) ) {
        $datas = array();
        foreach($list as $key=>$val) {
            array_push($datas, array(
                "id" => $val['id'],
                "name" => $val['name']
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