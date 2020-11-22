<?php
/**
 * 志愿服务证书
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "userServeCert" ) {
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
        include_once(INCLUDE_PATH . "UserBasicInfo.php");
        $obj = new UserBasicInfo();
        $info = $obj->getBasicInfo ( "form__bjhh_volunteermanage_volunteerbasicinfo");
        //var_dump($info);
        if ($info) {
            // 获取注册地信息
            $_address = array();
            $address = $db->get_one("form__bjhh_area", "sign='".$info['sign']."'");
            if ( $address ) {
                array_unshift($_address, $address['name']);
                $address = $db->get_one("form__bjhh_area", "areaid='".$address['parentid']."'");
                if ( $address ) {
                    array_unshift($_address, $address['name']);
                    if ( $address['parentid'] != 1 ) {
                        $address = $db->get_one("form__bjhh_area", "areaid='".$address['parentid']."'");
                        if ( $address ) {
                            array_unshift($_address, $address['name']);
                        }
                    }
                }
            }

            $datas = array(
                "name" => $info['name'],
                "hnumber" => $info['hnumber'],
                "sex" => $info['sex'],
                "regAddr" => join(" ", $_address),
                "regDate" => date('Y年m月d日', $info['applytime'])
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