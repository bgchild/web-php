<?php
/**
 * 记录转移
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "userTransfer" ) {
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
        include_once(INCLUDE_PATH . "UserJoin.php");
        $obj = new UserJoin();

        $areaId = trim($_POST['areaId']);
        if ( empty($areaId) ) {
            $responseCode = 2;
            $responseMsg = "访问标识(areaId)不能为空";
        } else {
            $new = $db->get_one("form__bjhh_area", "listorder='".$areaId."'");
            if ( !$new ) {
                $responseCode = 3;
                $responseMsg = "转入城市不存在";
            } else {

                // 获取最近一条记录
                $nearOne = $obj->checkJoin();
                if ( $nearOne && ($nearOne['status'] == 1 || $nearOne['status'] == 3) ) {
                    $responseCode = 4;
                    $responseMsg = "您已提交记录转移,请等待";
                }

                if ( !$responseCode ) {
                    $bInfo=$obj->getcInfo();
                    $data = array(
                        "nname" => $new['name'],
                        "ncity" => $new['sign'],
                        "ureason" => $_POST['reason'],
                        "addtime" => time()
                    );

                    foreach($bInfo as $key=>$val) {
                        $data[$key] = $val;
                    }

                    if ( !$db->add("form__bjhh_joinrecord", $data) ) {
                        $responseCode = 5;
                        $responseMsg = "操作失败";
                    }
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
} else if ( $act == "userTransferInfo" ) {
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
        include_once(INCLUDE_PATH . "UserJoin.php");
        $obj = new UserJoin();
        // 获取最近一条记录
        $nearOne = $obj->checkJoin();

        if ( $nearOne ) {
            switch( $nearOne['status'] ) {
                case 1:
                    $msg =  date('Y-m-d H:i',$nearOne['addtime'])."----请等待".$nearOne['oname']."审核。";
                    break;
                case 2:
                    $msg = date('Y-m-d H:i',$nearOne['oedittime'])."----".$nearOne['oname']."拒绝，转出失败。";
                    $remark = "备注：".$nearOne['oremark']."。";
                    break;
                case 3:
                    $msg = date('Y-m-d H:i',$nearOne['oedittime'])."----".$nearOne['oname']."同意,  等待".$nearOne['nname']."审核。";
                    $remark = "备注：".$nearOne['oremark']."。";
                    break;
                case 4:
                    $msg = date('Y-m-d H:i',$nearOne['nedittime'])."----".$nearOne['nname']."拒绝,  转出失败。";
                    $remark = "备注：".$nearOne['nremark']."。";
                    break;
                case 5:
                    $msg = date('Y-m-d H:i',$nearone['nedittime'])."----".$nearone['nname']."同意,  转出成功。";
                    $remark = "备注：".$nearOne['nremark']."。";
                    break;
            }

            $datas = array(
                "allowTransfer" => ($nearOne['status'] != 1 && $nearOne['status'] !=3) ? true : false,
                "title" => $nearOne['oname']."转至".$nearOne['nname'],
                "msg" => $msg,
                "remark" => $remark
            );
        } else {
            $datas = array(
                "allowTransfer" => true
            );
        }


        $binfo = $obj->getcInfo();
        if ( $binfo ) {
            $datas['ownedCity'] = $binfo['oname'];
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