<?php
/**
 * 用户基本资料
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "userBasicInfo" ) {
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
        // 获取用户信息
        if ( !$responseCode ) {
            include_once(INCLUDE_PATH . "UserBasicInfo.php");
            $obj = new UserBasicInfo();
            $info = $obj->getBasicInfo ( "form__bjhh_volunteermanage_volunteerbasicinfo" );
            //var_dump($info);
            //获取扩展信息
            $extendinfo = $obj->getExtendInfo ();
            if ( $info ) {
                $datas = array(
                    "id" => $info['recordid'],
                    "username" => $info['username'],
                    "nickname" => $info['nickname'],
                    "serveprovince" => $info['serveprovince'],
                    "servecity" => $info['servecity'],
                    "servearea" => $info['servearea'],
                    "sdomain" => $info['sdomain'],
                    "name" => $info['name'],
                    "idtype" => $info['idtype'],
                    "idnumber" => $info['idnumber'],
                    "sex" => $info['sex'],
                    "birthday" => date("Y-m-d",$info['birthday']),
                    "nationality" => $info['nationality'],
                    "cellphone" => $info['cellphone'],
                    "province" => $info['province'],
                    "city" => $info['city'],
                    "area" => $info['area']
                );
            }

            if ( $extendinfo ) {
                $datas['isstudent'] = $extendinfo['isstudent'];
            }
        }
    } else {

        // 修改用户基本信息
        include_once(INCLUDE_PATH . "UserBasicInfo.php");
        $obj = new UserBasicInfo();

        // 生日日期
        $birthday = $_POST['birthday'];
        if( !$responseCode && (empty($birthday) || date('Y-m-d', strtotime($birthday))  != $birthday )) {
            $responseCode = 2;
            $responseMsg = "出生日期格式不正确";
        }

        $cellphone = $_POST['cellphone'];
        if ( !$responseCode && $cellphone && !preg_match("/1[3458]{1}\d{9}$/",$cellphone) ) {
            $responseCode = 3;
            $responseMsg = "手机格式不正确";
        }

        if ( !$responseCode ) {
            if ( !$obj->editBasicInfoAjax() && !$obj->editExtendInfoAjax(array('isstudent' => trim($_POST['isstudent']))) ) {
                $responseCode = 4;
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
} else if ( $act == "userStar" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if ( !$responseCode && !$serveTeam->checkUserLogin() ) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    if ( !$responseCode ) {
        include_once (INCLUDE_PATH . "UserIndex.php");
        $userIndex = new UserIndex();
        $curr = $userIndex->getNextTime();
        //var_dump($curr);

        if ( $curr ) {
            $datas = array(
                "currentTime" => intval($curr['time']),
                "star" => intval($curr['star']),
                "next" => intval($curr['next'])
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