<?php
/**
 * 短信验证
 */
include_once('global.php');
$act = trim($_GET['act']);
// 发送短信验证码
if ( $act == "sendSmsCode" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $cellphone = $_POST['cellphone'];
    if ( !$responseCode && !validateCellPhoneNumber($cellphone) ) {
        $responseCode = 1;
        $responseMsg = "请填写正确的手机号";
    }

    // 检测手机账户对应的账号是否存在
    if ( !$responseCode ) {
        include_once(INCLUDE_PATH . "findpsw.php");
        $findpsw = new findpsw();
        $user = $findpsw->getUserByCellphone($cellphone);
        if ( !$user ) {
            $responseCode = 2;
            $responseMsg = "账号不存在";
        } else {
            if ( $user['status'] == '100' ) {
                $responseCode = 3;
                $responseMsg = "帐号已注销";
            } else if ( $user['status'] == '011' ) {
                $responseCode = 4;
                $responseMsg = "帐号初审被拒绝";
            }
        }
    }

    if ( !$responseCode ) {
        session_start();
        unset($_SESSION['findpsw.cellphone']);
        unset($_SESSION['findpsw.smstime']);
        $smstime = $_SESSION['findpsw.smstime'];
        $smscode = rand(100000, 999999);
        include_once(INCLUDE_PATH . "aliyun-dysms-sdk-php/Sms.php");

        $response = Sms::sendSms(
            $smsConfig['signName'], $smsConfig['templateCode'], $cellphone, ["code" => $smscode, "product" => $smsConfig['product']]
        );


        $content = "cellphone: ". $_SESSION['findpsw.cellphone']. " smscode: ".$_SESSION['findpsw.smscode'];
        // 发送成功
        if($response->Code == "OK") {
            $_SESSION['findpsw.cellphone'] = $cellphone;
            //设置发送限制时间
            $_SESSION['findpsw.smstime'] = time() + $smsConfig['interval'];
            //设置验证码5分钟内有效
            $_SESSION['findpsw.smscode'] = $smscode;
            $_SESSION['findpsw.smscode.time'] = time() + $smsConfig['effectiveTime'];
        } else {
            $responseCode = 5;
            //$responseMsg = $response->Message;
            $responseMsg = "本日短信次数已达上限";
            $content .= " msg: ".$responseMsg;
        }

        debugLog("sms.txt", $content);
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
} else if( $act == "checkSmsCode" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $smscode = trim($_POST['code']);
    if ( !$smscode ) {
        $responseCode = 1;
        $responseMsg = "请填写验证码";
    }

    if ( !$responseCode ) {
        session_start();
        $cellphone = $_SESSION['findpsw.cellphone'];
        $session_smscode = $_SESSION['findpsw.smscode'];
        $session_smscode_time = $_SESSION['findpsw.smscode.time'];

        if ( !$cellphone || !$session_smscode || !$session_smscode_time ) {
            $responseCode = 2;
            $responseMsg = "请先发送短信验证";
        }

        if ( !$responseCode ) {
            if ( time() > $session_smscode_time || $smscode != $session_smscode ) {
                $responseCode = 3;
                $responseMsg = "验证码不正确";
            } else {
                // 验证成功,设置tag
                $_SESSION['findpsw.power'] = true;
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
} else if ( $act == "changePassword" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $password = trim($_POST['password']);
    if ( !$password ) {
        $responseCode = 1;
        $responseMsg = "新密码不能为空";
    }

    if ( !$responseCode ) {
        session_start();
        if ( !$_SESSION['findpsw.power'] ) {
            $responseCode = 2;
            $responseMsg = "非法操作";
        } else {
            $cellphone = $_SESSION['findpsw.cellphone'];
            include_once(INCLUDE_PATH . "findpsw.php");
            $findpsw = new findpsw();
            $user = $findpsw->getUserByCellphone($cellphone);
            if ( !$user ) {
                $responseCode = 3;
                $responseMsg = "账户不存在";
            } else {
                if(!$findpsw->changeNewPassword($user['username'], $password)) {
                    $responseCode = 4;
                    $responseMsg = "密码修改失败";
                } else {
                    unset($_SESSION['findpsw.cellphone']);
                    unset($_SESSION['findpsw.power']);
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
}