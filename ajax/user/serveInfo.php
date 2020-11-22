<?php
/**
 * 用户服务信息
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "userServeInfo" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if ( !$responseCode && !$serveTeam->checkUserLogin() ) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    if ( $_SERVER['REQUEST_METHOD'] != "POST" ) {
        // 获取服务信息
        if ( !$responseCode ) {
            include_once (INCLUDE_PATH . "UserIndex.php");
            include_once(INCLUDE_PATH . "UserBasicInfo.php");
            $userIndex = new UserIndex();
            $userInfo = $userIndex->getCurrentUserInfo();

            $obj = new UserBasicInfo();
            $info = $obj->getExtendInfo();
            //var_dump($info);


            // 获取服务时间信息
            $serveTime = $obj->getBasicInfo("form__bjhh_service_time");
            //var_dump($serveTime);
            $am = explode(',', $serveTime['am']);
            $pm = explode(',', $serveTime['pm']);
            $night = explode(',', $serveTime['night']);

            // 专业技能
            $skills = explode(',', $info['features']);
            //var_dump($skills);

            $datas = array(
                "am" => $am,
                "pm" => $pm,
                "night" => $night,
                "skills" => $skills,
                // 服务工时
                "serveTime" => $userInfo['allservertime']
            );
        }
    } else {

        // 修改用户服务信息
        include_once(INCLUDE_PATH . "UserBasicInfo.php");
        $obj = new UserBasicInfo();

        if ( !$responseCode ) {
            $skills = implode(',',($_POST['skills']));
            if ( !$obj->editServicetime() && !$obj->editExtendInfoAjax(array('features' => $skills)) ) {
                $responseCode = 2;
                $responseMsg = "保存信息失败";
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
}