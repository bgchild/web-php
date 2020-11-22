<?php
/**
 * 我的服务列表
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "userServerTime" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if ( !$responseCode && !$serveTeam->checkUserLogin() ) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    $tag = isset($_POST['tag']) ? intval($_POST['tag']) : 1;
    if ( !$responseCode ) {
        include_once (INCLUDE_PATH . "UserMyServertime.php");
        $obj = new UserMyServertime();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index.",".$len;

        $query = array();
        $list = $obj->getOneRecords($tag, $query, $limit);
        //var_dump($list);
        if ( $list && count($list) ) {
            $datas = array();

            if ( $tag == 1 ) {
                foreach($list as $key=>$val) {
                    array_push($datas, array(
                        "activityID" => $val['uid'],
                        "activityName" => $val['activityName'],
                        "activityStartDate" => $val['activityStartDate'],
                        "activityEndDate" => $val['activityEndDate'],
                        "serviceTeamName" => $val['serviceteamname'],
                        "time" => $val['time']
                    ));
                }
            } else {
                foreach($list as $key=>$val) {
                    array_push($datas, array(
                        "addDate" => date("Y-m-d H:i:s",$val['date']),
                        "hours" => $val['workinghours'],
                        "reason" => $val['reason']
                    ));
                }
            }
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
} else if ( $act == "" ) {

}