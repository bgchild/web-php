<?php
/**
 * 省市信息
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "pca" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    /*$datas = $db->getall ("pubmodule_area_tbl", "parentId=000001", array(limit=>'0,9999999'), "areaId as id,areaName as name");
    foreach($datas as $key=>$val) {
        $city = $db->getall("pubmodule_area_tbl", "parentId=".$val['id'], array(limit=>'0,9999999'), "areaId as id,areaName as name");
        if ( $city && count($city) ) {

            foreach($city as $key1=>$val1) {
                $area = $db->getall("pubmodule_area_tbl", "parentId=".$val1['id'], array(limit=>'0,9999999'), "areaId as id,areaName as name");
                if ($area && count($area)) {
                    $city[$key1]['children'] = $area;
                }
            }

            $datas[$key]['children'] = $city;
        }
    }*/

    $datas = $db->getall ("pubmodule_area_tbl", "parentId=000001", array(limit=>'0,9999999'), "areaId as value,areaName as text");
    foreach($datas as $key=>$val) {
        $city = $db->getall("pubmodule_area_tbl", "parentId=".$val['value'], array(limit=>'0,9999999'), "areaId as value,areaName as text");
        if ( $city && count($city) ) {

            foreach($city as $key1=>$val1) {
                $area = $db->getall("pubmodule_area_tbl", "parentId=".$val1['value'], array(limit=>'0,9999999'), "areaId as value,areaName as text");
                if ($area && count($area)) {
                    $city[$key1]['children'] = $area;
                }
            }

            $datas[$key]['children'] = $city;
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