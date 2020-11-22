<?php
/**
 * 用户登录
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "login" ) {
    session_start();
    include_once(INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $obj = new Index();
    $username = trim($_POST ['username']);
    if ( !$responseCode && !$username ) {
        $responseCode = 1;
        $responseMsg = "用户名不能为空";
    }

    $password = trim($_POST['password']);
    if ( !$responseCode && !$password ) {
        $responseCode = 2;
        $responseMsg = "密码不能为空";
    }

    $checkcode = trim($_POST ['checkcode']);
    if ( !$responseCode && !$checkcode ) {
        $responseCode = 3;
        $responseMsg = "验证码不能为空";
    }

    $code = $_SESSION ['checkcode'];
    //debugLog('login.txt', "checkcode: ".$checkcode." code: ".$code);
    if ( !$responseCode &&  strtolower($checkcode) != strtolower($code) ) {
        $responseCode = 4;
        $responseMsg = "验证码错误";
    }

    if ( !$responseCode ) {
        $result = $obj->loginAjax($username, $password);
        if ( $result == 1 ) {
            $user = $db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$username' ") ;
            if ( $user ) {
                $datas = array(
                    "id" => $user['recordid'],
                    "username" => $user['username'],
                    "sign" => $user['sign'],
                    "name" => $user['name']
                );
            }
            unset($_SESSION['username']);
        } else if ( $result < 0 ) {
            if ( $result == - 1 || $result == - 2 ) {
                $responseCode = 5;
                $responseMsg = "用户名或密码错误";
            } else if ( $result == - 3 ) {
                $responseCode = 6;
                $responseMsg = "用户已注销";
            } else if ( $result == - 4 ) {
                $responseCode = 7;
                $responseMsg = "初审被拒绝";
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
