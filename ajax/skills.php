<?php
/**
 * 专业技能
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "skills" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $where = "tcode='006' and state='1' and fid='0' ";
    $skills = $db->getall("form__bjhh_dictbl", $where, array(limit=>'0,9999999'), '*','order by listorder ASC');
    //var_dump($skills);
    if ($skills && count($skills)) {
        $datas = array();
        foreach($skills as $key=>$val) {
            array_push($datas, array(
                "value" => $val['id'],
                "text" => $val['name']
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
} else if ( $act == "serveCate" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $where = "tcode='007' and fid='0' ";
    $list = $db->getall("form__bjhh_dictbl", $where, array(limit=>'0,9999999'), '*','order by listorder ASC');
    if ($list && count($list)) {
        $datas = array();
        foreach($list as $key=>$val) {
            array_push($datas, array(
                "value" => $val['id'],
                "text" => $val['name']
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