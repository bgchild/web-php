<?php
/**
 * 用户注册接口
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "register" ) {
    include (INCLUDE_PATH . "ApplyVolunteer.php");
    $obj = new ApplyVolunteer();

    $responseCode = 0;
    $responseMsg = "ok";

    $sign = trim($_POST['sign']);
    if ( !$responseCode && !$sign ) {
        $responseCode = 1;
        $responseMsg = "请选择城市";
    } else {
        $cityInfo = $db->get_one ( 'form__bjhh_area', "sign='$sign' and status='1' " );
        if ( !$cityInfo ) {
            $responseCode = 2;
            $responseMsg = "城市不存在";
        } else {
            $fid = $cityInfo ['parentid'];
        }
    }

    $username = trim($_POST['username']);
    if ( !$responseCode && !$username ) {
        $responseCode = 3;
        $responseMsg = "用户名不能为空";
    }

    if ( !$responseCode && !is_username ($username) ) {
        $responseCode = 4;
        $responseMsg = "用户名不符合规定";
    }

    if ( !$responseCode && $username ) {
        if ( $obj->_check_username($username) ) {
            $responseCode = 5;
            $responseMsg = "用户名已被注册";
        }
    }

    // 密码验证
    $password = $_POST['password'];
    if ( !$responseCode ) {
        if ( strlen($password) < 8 || strlen($password) > 20 ) {
            $responseCode = 6;
            $responseMsg = "密码长度必须在8-20位之间";
        }
    }

    // 用户昵称
    $nickname = trim($_POST['nickname']);
    if ( !$responseCode && !$nickname ) {
        $responseCode = 7;
        $responseMsg = "昵称不能为空";
    }

    // 服务省市信息
    $sprovince = trim($_POST['sprovince']);
    $scity = trim($_POST['scity']);
    $sarea = trim($_POST['sarea']);
    if ( !$responseCode && (!$sprovince || !$scity || !$sarea) ) {
        $responseCode = 8;
        $responseMsg = "请选择服务地";
    }

    $sdomain = trim($_POST['sdomain']);
    if ( !$responseCode && !$sdomain ) {
        $responseCode = 9;
        $responseMsg = "请选择服务领域";
    }

    $name = trim($_POST['name']);
    if ( !$responseCode && !$name ) {
        $responseCode = 10;
        $responseMsg = "姓名不能为空";
    }

    $idtype = trim($_POST['idtype']);
    if ( !$responseCode && !$idtype ) {
        $responseCode = 11;
        $responseMsg = "请选择证件类型";
    }

    $idnumber = trim($_POST['idnumber']);
    if ( !$responseCode && !$idnumber ) {
        $responseCode = 12;
        $responseMsg = "证件号码不能为空";
    }

    // 生日日期
    $birthday = trim($_POST['birthday']);
    if(!$responseCode && (empty($birthday) || date('Y-m-d', strtotime($birthday))  != $birthday )) {
        $responseCode = 13;
        $responseMsg = "出生日期格式不正确";
    }

    $nationality = trim($_POST['nationality']);
    if ( !$responseCode && !$nationality ) {
        $responseCode = 14;
        $responseMsg = "请选择国籍";
    }

    $cellphone = $_POST['cellphone'];
    if ( !$responseCode && !validateCellPhoneNumber($cellphone) ) {
        $responseCode = 15;
        $responseMsg = "请填写正确的手机号";
    }

    $province = trim($_POST['province']);
    $city = trim($_POST['city']);
    $area = trim($_POST['area']);
    if ( !$responseCode && (!$province || !$city || !$area) ) {
        $responseCode = 16;
        $responseMsg = "请选择居住地";
    }


    if ( !$responseCode ) {
        $data = array();
        $data['sign'] = $sign;
        $data['parentid'] = $fid;

        $data['username'] = $username;
        $encrypt = get_rand_str(6);
        $data['password'] = password($password, $encrypt);
        $data ['encrypt'] = $encrypt;
        $data['nickname'] = $nickname;

        $data['serveprovince'] = $sprovince;
        $data['servecity'] = $scity;
        $data['servearea'] = $sarea;
        $data['sdomain'] = $sdomain;

        $data['name'] = $name;
        $data['idtype'] = $idtype;
        $data['idnumber'] = $idnumber;

        $data['sex'] = $_POST['sex'];
        $data['birthday'] = strtotime($birthday);
        $data['nationality'] = $nationality;
        $data['cellphone'] = $cellphone;
        $data['province'] = $province;
        $data['city'] = $city;
        $data['area'] = $area;

        $data['applytime'] = time();
        if( $_GET ['agree']  == "agreed"){
            $data ['status'] = "001";
        } else {
            $data ['status'] = "1000";
        }
        $sessionid = session_id();
        $data['last_session'] = $sessionid;


        // 获取服务地区的serveid
        $one = $db->add ( "form__bjhh_volunteermanage_volunteerbasicinfo", $data );
        if ( $one ) {
            //志愿者编码
            $obj->pcode($one);
            $obj->addExtendInfoAjax($username, array(
                'isstudent' => trim($_POST['isstudent']),
                "features" => implode ( ',', ($_POST ['skills'])),
                "serveitem" => implode ( ',', ($_POST ['serveitem']))
            ));
            $obj->addServicetime();
            $file= USERLOG_PATH.'ss_'.$sessionid;
            $userfile = fopen("$file","w");
            fclose($userfile);
            $_SESSION ['code'] = $obj->xxtea->createLoginIdentify ( $one, $username );
        } else {
            $responseCode = 17;
            $responseMsg = "注册失败";
        }
    }



    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if ( $responseCode && isset($datas) ) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ( $act == "checkUsername" ) {
    include (INCLUDE_PATH . "ApplyVolunteer.php");
    $obj = new ApplyVolunteer();

    $responseCode = 0;
    $responseMsg = "ok";

    $username = trim($_POST['username']);
    if ( !$responseCode && !$username ) {
        $responseCode = 1;
        $responseMsg = "用户名不能为空";
    }

    if ( !$responseCode && !is_username ($username) ) {
        $responseCode = 2;
        $responseMsg = "用户名不符合规定";
    }

    if ( !$responseCode && $username ) {
        if ( $obj->_check_username($username) ) {
            $responseCode = 3;
            $responseMsg = "用户名已被注册";
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
} else if ( $act == "idtype" ) {
    include (INCLUDE_PATH . "ApplyVolunteer.php");
    $obj = new ApplyVolunteer();

    $responseCode = 0;
    $responseMsg = "ok";

    $idtype = $obj->getTypes ( "001" ); //证件类型
    //var_dump($idtype);
    if ( $idtype && count($idtype) ) {
        $datas = array();
        foreach($idtype as $key=>$val) {
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
} else if ( $act == "nationality" ) {
    include (INCLUDE_PATH . "ApplyVolunteer.php");
    $obj = new ApplyVolunteer();

    $responseCode = 0;
    $responseMsg = "ok";

    $nationality = $obj->getTypes ( "004" ); //国籍
    //var_dump($nationality);
    if ( $nationality && count($nationality) ) {
        $datas = array();
        foreach($nationality as $key=>$val) {
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



/**
 * 获取用户注册服务地信息
 */
function getServe() {
    global $db;

    $one = $db->get_one("form__bjhh_area", "");
}