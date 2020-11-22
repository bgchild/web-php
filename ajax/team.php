<?php
/**
 * 志愿组织
 */
include_once('global.php');

$act = trim($_GET['act']);
if ( $act == "home_team" ) {
    include_once (INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_GET['sign'];
    if ( !$sign ) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    if ( !$responseCode ) {
        $obj = new Index ();
        // 根据登录用户服务地来筛选,最多五条
        $team = $obj->getTeam(5, $sign);
        //var_dump($team);

        $datas = array();
        foreach($team as $key=>$val) {
            array_push($datas, array(
                'id' => $val['recordid'],
                'img' => getResUrl($val['service_thumb']),
                'name' => $val['serviceteamname']
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
} else if ( $act == "detailteam" ) {
    include (INCLUDE_PATH . "Serveteam.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $rid = intval($_GET['rid']);
    if ( empty($rid) ) {
        $responseCode = 1;
        $responseMsg = "访问标识(rid)不能为空";
    } else {
        $obj = new Serveteam();
        if(!$obj->checkrid($rid)) {
            $responseCode = 2;
            $responseMsg = "查看信息不存在";
        } else {
            $one = $obj->getDetailServeteam($rid);
            if ( !$one ) {
                $responseCode = 2;
                $responseMsg = "查看信息不存在";
            } else {
                //var_dump($one);
                $tem_pic = $obj->getTeamPcitures($rid);
                //var_dump($tem_pic);

                $imgs = array();
                foreach($tem_pic as $key => $val) {
                    array_push($imgs, array(
                        'name' => $val['img_name'],
                        'img' => getResUrl($val['img_url'])
                    ));
                }

                $datas = array(
                    "id" => $one['recordid'],
                    "name" => $one['serviceteamname'],
                    "areas" => $one['areas'],
                    "planmembernumber" => $one['planmembernumber'],
                    "member" => $one['member'],
                    "foundingtime" => $one['foundingtime'],
                    "responsibleperson" => $one['responsibleperson'],
                    "relationperson" => $one['relationperson'],
                    "mobile_telephone" => $one['mobile_telephone'],
                    "telephones" => $one['telephones'],
                    "emails" => $one['emails'],
                    "detailed_address" => $one['detailed_address'],
                    "postcodes" => $one['postcodes'],
                    "fax" => $one['fax'],
                    "serveitem" => $one['serveitem'],
                    "skillitem" => $one['skillitem'],
                    "others" => $one['others'],
                    "teamintroduction" => $one['teamintroduction'],
                    "imgs" => $imgs
                );
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
} else if ( $act == "team" ) {
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_POST['sign'];
    if ( !$sign ) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    if ( !$responseCode ) {
        include_once(INCLUDE_PATH . "Serveteam.php");
        $obj = new Serveteam();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index.",".$len;

        $query = array();
        $team = trim($_POST['name']);
        if ( $team ) {
            $query['serviceteamname'] = $team;
        }


        $list = $obj->getTeamAjax($query, $limit, $sign);
        // var_dump($list);
        if ( $list && count($list) ) {
            $datas = array();
            foreach($list as $key=>$val) {
                array_push($datas, array(
                    "id" => $val['recordid'],
                    "name" => $val['serviceteamname'],
                    "planMemberNumber" => $val['planmembernumber'],
                    "people" => $val['people'],
                    "sType" => $val['serveritem'],
                    "skill" => $val['skillitem'],
                    "areas" => $val['areas'],
                    "img" => getResUrl($val['service_thumb'])
                ));
            }
        }
    }



    /*$loginAreaId = trim($_POST['loginAreaId']);
    if ( !$loginAreaId ) {
        $responseCode = 1;
        $responseMsg = "登录地id不能为空";
    } else {
        $area = $db->get_one("form__bjhh_area", "listorder='".$loginAreaId."'");
        if ( !$area ) {
            $responseCode = 2;
            $responseMsg = "登录地不存在";
        }
    }

    if ( !$responseCode ) {

    }*/

    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if ( !$responseCode && isset($datas) ) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ( $act == "joinTeam" ) {
    include (INCLUDE_PATH . "Serveteam.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $rid = intval($_POST['rid']);

    if ( empty($rid) ) {
        $responseCode = 1;
        $responseMsg = "请选择需要加入的服务队";
    }

    $obj = new Serveteam();
    // 检测是否登录
    if ( !$responseCode && !$obj->checkUserLogin() ) {
        $responseCode = 2;
        $responseMsg = "您还没有登录";
    }

    // 检测归属地
    if ( !$responseCode && !$obj->checkSignAjax($rid) ) {
        $responseCode = 3;
        $responseMsg = "请选择您归属的城市";
    }

    // 检测用户权限
    if ( !$responseCode && $obj->checkPower() ) {
        $responseCode = 4;
        $responseMsg = "您还未通过审核";
    }

    if ( !$responseCode ) {
        if(!$obj->checkrid($rid)) {
            $responseCode = 5;
            $responseMsg = "服务队不存在";
        } else {
            $one = $obj->getDetailServeteam($rid);
            if ( !$one ) {
                $responseCode = 5;
                $responseMsg = "服务队不存在";
            }
        }
    }


    // 检测是否重复加入
    if ( !$responseCode && $obj->isRepeat($rid) ) {
        $responseCode = 6;
        $responseMsg = "您已经申请该服务队";
    }

    // 检测是否满员
    if ( !$responseCode && $obj->countPeople($rid, $one['planmembernumber']) ) {
        $responseCode = 7;
        $responseMsg = "人员已满";
    }

    // 加入
    if ( !$responseCode ) {
        $data['rid'] = $rid;
        if ( !$obj->addTeam($data) ) {
            $responseCode = 8;
            $responseMsg = "加入失败";
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