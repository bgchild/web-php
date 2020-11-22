<?php
/**
 * 我加入的组织
 */
include_once('global.php');
$act = trim($_GET['act']);
if ($act == "userTeam") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . "UserBelongServiceTeam.php");
        $obj = new UserBelongServiceTeam();
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
        $len = isset($_GET['len']) && $_GET['len'] > 0 ? $_GET['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();
        $team = trim($_GET['name']);

        if ($team) {
            $query['serviceteamname'] = $team;
        }

        $status = $_GET['status'];
        if (isset($status) && $status != '0') {
            $query['status'] = $status;
        }

        $startDate = trim($_GET['startDate']);
        if ($startDate) {
            $query['join_start'] = $startDate;
        }

        $endDate = trim($_GET['endDate']);
        if ($endDate) {
            $query['join_stop'] = $endDate;
        }

        $list = $obj->getBelongServiceTeamInfo($query, $limit);

        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                array_push($datas, array(
                    "id" => $val['recordid'],
                    "name" => $val['serviceteamname'],
                    "joinDate" => $val['joinserviceteamdate'],
                    "passNum" => $val['passNum'],
                    "relationPerson" => $val['relationperson'],
                    "telephones" => $val['telephones'],
                    "status" => $val['sp_status2']
                ));
            }
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamDetail") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    if (!$responseCode) {
        $rid = intval($_GET['rid']);
        if (empty($rid)) {
            $responseCode = 2;
            $responseMsg = "访问标识(rid)不能为空";
        } else {
            include_once(INCLUDE_PATH . "UserBelongServiceTeam.php");
            $obj = new UserBelongServiceTeam();
            $one = $obj->serviceGetOne($rid);
            if (!$one) {
                $responseCode = 3;
                $responseMsg = "查看信息不存在";
            } else {

                $_address = array();
                $province = $db->get_one("pubmodule_area_tbl", "areaId='" . $one['province'] . "'");
                if ($province) {
                    array_push($_address, $province['areaName']);
                }
                $city = $db->get_one("pubmodule_area_tbl", "areaId='" . $one['city'] . "'");
                if ($city) {
                    array_push($_address, $city['areaName']);
                }
                $area = $db->get_one("pubmodule_area_tbl", "areaId='" . $one['area'] . "'");
                if ($area) {
                    array_push($_address, $area['areaName']);
                }

                $cate = $obj->checkboxArray("form__bjhh_dictbl", 007);
                $skills = $obj->checkboxArray("form__bjhh_dictbl", 006);

                $_cate = array();
                $_skills = array();

                //var_dump($one);
                $serviceclassification_checkbox = $one['serviceclassification_checkbox'];
                //var_dump($serviceclassification_checkbox);
                foreach ($cate as $key => $val) {
                    if (in_array($val['id'], $serviceclassification_checkbox)) {
                        array_push($_cate, $val['name']);
                    }
                }

                $skills_checkbox = $one['skills_checkbox'];
                foreach ($skills as $key => $val) {
                    if (in_array($val['id'], $skills_checkbox)) {
                        array_push($_skills, $val['name']);
                    }
                }

                $datas = array(
                    "name" => $one['serviceteamname'],
                    "pca" => join(" ", $_address),
                    "foundingTime" => $one['foundingtime'],
                    "responsiblePerson" => $one['responsibleperson'],
                    "relationPerson" => $one['relationperson'],
                    "planMemberNumber" => $one['planmembernumber'],
                    "mobile" => $one['mobile_telephone'],
                    "postcodes" => $one['postcodes'],
                    "emails" => $one['emails'],
                    "detailedAddress" => $one['detailed_address'],
                    "img" => getResUrl($one['service_thumb']),
                    "cates" => $_cate,
                    "skills" => $_skills,
                    "others" => $one['others'],
                    "introduction" => $one['teamintroduction']
                );
            }
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamAdd" || $act == "userTeamEdit") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }


    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    $recordid = trim($_POST['rid']);
    if (!$responseCode && $act == "userTeamEdit" && !$recordid) {
        $responseCode = 2;
        $responseMsg = "非法访问";
    }

    $name = trim($_POST['name']);
    if (!$responseCode && !$name) {
        $responseCode = 3;
        $responseMsg = "名称不能为空";
    }

    $province = trim($_POST['province']);
    $city = trim($_POST['city']);
    $area = trim($_POST['area']);
    if (!$responseCode && (!$province || !$city || !$area)) {
        $responseCode = 4;
        $responseMsg = "所属地区不能为空";
    }

    $foundingtime = trim($_POST['foundingTime']);
    if (!$responseCode && !$foundingtime) {
        $responseCode = 5;
        $responseMsg = "成立日期不能为空";
    }

    $responsibleperson = trim($_POST['responsiblePerson']);
    if (!$responseCode && !$responsibleperson) {
        $responseCode = 6;
        $responseMsg = "负责人不能为空";
    }

    $relationperson = trim($_POST['relationPerson']);
    if (!$responseCode && !$relationperson) {
        $responseCode = 7;
        $responseMsg = "联系人不能为空";
    }

    $planmembernumber = trim($_POST['planMemberNumber']);
    if (!$responseCode && !$planmembernumber) {
        $responseCode = 8;
        $responseMsg = "计划人数不能为空";
    }

    $mobile_telephone = trim($_POST['mobile']);
    if (!$responseCode && !$mobile_telephone) {
        $responseCode = 9;
        $responseMsg = "手机号不能为空";
    }

    $postcodes = trim($_POST['postcodes']);
    if (!$responseCode && !$postcodes) {
        $responseCode = 10;
        $responseMsg = "邮编不能为空";
    }

    $emails = trim($_POST['emails']);
    if (!$responseCode && !$emails) {
        $responseCode = 11;
        $responseMsg = "电子邮箱不能为空";
    }

    $detailed_address = trim($_POST['address']);
    if (!$responseCode && !$detailed_address) {
        $responseCode = 12;
        $responseMsg = "详细通信地址不能为空";
    }


    $others = trim($_POST['others']);
    if (!$responseCode && !$others) {
        $responseCode = 14;
        $responseMsg = "服务计划不能为空";
    }

    $teamintroduction = $_POST['introduction'];
    if (!$responseCode && !$teamintroduction) {
        $responseCode = 15;
        $responseMsg = "服务队简介不能为空";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . "ServiceTeamAdd.php");
        $serverAdd = new ServiceTeamAdd ();

        $creatorid = $serverAdd->getUser(0);
        $sign = $serverAdd->getUser('sign');
        $parentid = $serverAdd->getUser('parentid');

        $data = array();
        $data["serviceteamname"] = $name;
        $data["province"] = $province;
        $data["city"] = $city;
        $data["areas"] = $area;
        $data["foundingtime"] = strtotime($foundingtime);
        $data["responsibleperson"] = $responsibleperson;
        $data["relationperson"] = $relationperson;
        $data["planmembernumber"] = $planmembernumber;
        $data["mobile_telephone"] = $mobile_telephone;
        $data["postcodes"] = $postcodes;
        $data["emails"] = $emails;
        $data["fax"] = $_POST['fax'];
        $data["detailed_address"] = $detailed_address;
        if ($act == "userTeamAdd") {
            if ($_POST['img']) {
                $data['service_thumb'] = $_POST['img'];
            } else {
                $data['service_thumb'] = 'templates/images/No_photo.jpg';
            }
        } else {
            if ($_POST['img']) {
                $data['service_thumb'] = $_POST['img'];
            }
        }

        $data['serviceclassification_checkbox'] = implode(',', $_POST ['stype']);
        $data['skills_checkbox'] = implode(',', $_POST['skills']);
        $data['others'] = $others;
        $data['teamintroduction'] = $teamintroduction;
        $data['creatorid'] = $creatorid;


        if ($recordid) {
            $data ['edittime'] = time();
            $where = 'recordid=' . $recordid;
            $affected = $db->edit('form__bjhh_serviceteammanage_addserviceteam', $data, $where);
            if ($affected) {
                if ($post ['tid'] == '3') {
                    $data ['agree'] = '1';
                    $db->edit('form__bjhh_serviceteammanage_addserviceteam', $data, $where);
                }
            } else {
                $responseCode = 16;
                $responseMsg = "操作失败";
            }
        } else {
            $data ['sign'] = $sign;
            $data ['parentid'] = $parentid;
            $data ['serviceteamcaptainid'] = $creatorid;
            $insert_id = $db->add('form__bjhh_serviceteammanage_addserviceteam', $data);
            if ($insert_id) {
                $arr = array();
                $arr ['serviceteamid'] = $insert_id;
                $arr ['captain'] = '1';
                $arr ['joinserviceteamdate'] = time();
                $arr ['serviceteamcaptainid'] = $creatorid;
                $arr ['sp_status'] = '2';
                $insert_id = $db->add('form__bjhh_serviceteammanage_addserviceteamperson', $arr);
            } else {
                $responseCode = 16;
                $responseMsg = "操作失败";
            }
        }

    }

    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamManage") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }


    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }


    if (!$responseCode) {
        include_once(INCLUDE_PATH . "ServiceTeamManage.php");
        $server = new ServiceTeamManage ();

        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();

        $tag = $_POST['tag'] ? $_POST['tag'] : 1;
        $serviceteamname = isset($_POST['name']) ? trim($_POST['name']) : '';

        if ($serviceteamname) {
            $query = array('serviceteamname' => $serviceteamname);
        }
        // tag 1:申请中 2:已通过 3:未通过
        $list = $server->init($tag, $query, $limit);
        if ($list && count($list)) {
            $datas = array();

            switch ($tag) {
                // 申请中
                case 1:
                    foreach ($list as $key => $val) {
                        array_push($datas, array(
                            "id" => $val['recordid'],
                            "status" => "",
                            "name" => $val['serviceteamname'],
                            "foundingTime" => $val['foundingtime'],
                            "editTime" => $val['edittime'],
                        ));
                    }
                    break;
                // 已通过
                case 2:
                    foreach ($list as $key => $val) {
                        array_push($datas, array(
                            "id" => $val['recordid'],
                            "status" => "",
                            "name" => $val['serviceteamname'],
                            "foundingTime" => $val['foundingtime'],
                            "passTime" => $val['edittime'],
                            "passNum" => $val['passNum'],
                            "auditNum" => $val['auditNum']
                        ));
                    }
                    break;
                // 未通过
                case 3:
                    foreach ($list as $key => $val) {
                        array_push($datas, array(
                            "id" => $val['recordid'],
                            "status" => "",
                            "name" => $val['serviceteamname'],
                            "foundingTime" => $val['foundingtime'],
                            "editTime" => $val['edittime'],
                            "reason" => $val['fail_name']

                        ));
                    }
                    break;
            }

        }

    }

    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPersonnel") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    $serverId = trim($_POST['rid']);
    if (!$responseCode && !$serverId) {
        $responseCode = 3;
        $responseMsg = "访问标识(rid)不能为空";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . 'ServiceTeamPersonnelAudit.php');
        $obj = new ServiceTeamPersonnelAudit();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $list = $obj->initAjax($serverId, $limit);
        //var_dump($list);
        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                array_push($datas, array(
                    "id" => $val['srecordid'],
                    "name" => $val['name'],
                    "joinDate" => $val['joinserviceteamdate'],
                    "age" => date('Y', time()) - date('Y', $val['birthday']),
                    "sex" => $val['sex'],
                    "serverTime" => $val['allservertime']
                ));
            }
        }
    }

    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPersonnelPass") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    $serverId = trim($_POST['rid']);
    if (!$responseCode && !$serverId) {
        $responseCode = 3;
        $responseMsg = "请选服务队";
    }

    $ids = $_POST['ids'];
    if (!$responseCode && (!$ids || !count($ids))) {
        $responseCode = 4;
        $responseMsg = "请选志愿者";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . 'ServiceTeamPersonnelAudit.php');
        $servicePen = new ServiceTeamPersonnelAudit();
        if (!$servicePen->yesAjax($ids, $serverId)) {
            $responseCode = 5;
            $responseMsg = "操作失败";
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPersonnelRefuse") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    $serverId = trim($_POST['rid']);
    if (!$responseCode && !$serverId) {
        $responseCode = 3;
        $responseMsg = "请选服务队";
    }

    $ids = $_POST['ids'];
    if (!$responseCode && (!$ids || !count($ids))) {
        $responseCode = 4;
        $responseMsg = "请选志愿者";
    }


    if (!$responseCode) {
        include_once(INCLUDE_PATH . 'ServiceTeamPersonnelAudit.php');
        $servicePen = new ServiceTeamPersonnelAudit();
        if (!$servicePen->noAjax($ids, $serverId)) {
            $responseCode = 5;
            $responseMsg = "操作失败";
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPictureList") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    if (!$responseCode) {
        $rid = intval($_GET['rid']);
        if (empty($rid)) {
            $responseCode = 3;
            $responseMsg = "访问标识(rid)不能为空";
        } else {

            include(INCLUDE_PATH . "ServiceTeamManage.php");
            $obj = new ServiceTeamManage();
            $list = $obj->getSTPInfo($rid);
            //var_dump($list);
            if ($list && count($list)) {
                $datas = array();
                foreach ($list as $key => $val) {
                    array_push($datas, array(
                        "id" => $val['recordid'],
                        "name" => $val['img_name'],
                        "img" => getResUrl($val['img_url'])
                    ));
                }
            }
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPictureAdd") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    if (!$responseCode) {
        $rid = intval($_POST['rid']);
        if (empty($rid)) {
            $responseCode = 3;
            $responseMsg = "访问标识(rid)不能为空";
        }
    }

    $img_name = trim($_POST['name']);
    if (!$responseCode && !$img_name) {
        $responseCode = 4;
        $responseMsg = "图片名称不能为空";
    }

    $img_url = trim($_POST['img']);
    if (!$responseCode && !$img_url) {
        $responseCode = 5;
        $responseMsg = "图片地址不能为空";
    }

    if (!$responseCode) {
        $data = array();
        $data['img_name'] = $img_name;
        $data['img_url'] = $img_url;
        $data['serverid'] = $rid;

        $recordid = $db->add("form__bjhh_serviceteampicture", $data);
        if (!$recordid) {
            $responseCode = 6;
            $responseMsg = "操作失败";
        } else {
            $datas = array(
                "id" => $recordid,
                "name" => $img_name,
                "img" => getResUrl($img_url)
            );
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPictureEdit") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    if (!$responseCode) {
        $rid = intval($_POST['rid']);
        if (empty($rid)) {
            $responseCode = 3;
            $responseMsg = "访问标识(rid)不能为空";
        }
    }

    if (!$responseCode) {
        $one = $db->get_one("form__bjhh_serviceteampicture", "recordid='" . $rid . "'");
        if (!$one) {
            $responseCode = 4;
            $responseMsg = "图片不存在";
        }
    }


    $img_name = trim($_POST['name']);
    if (!$responseCode && !$img_name) {
        $responseCode = 5;
        $responseMsg = "图片名称不能为空";
    }

    $img_url = trim($_POST['img']);
    if (!$responseCode && !$img_url) {
        $responseCode = 6;
        $responseMsg = "图片地址不能为空";
    }

    if (!$responseCode) {
        $data = array();
        $data['img_name'] = $img_name;
        $data['img_url'] = $img_url;
        if (!$db->edit("form__bjhh_serviceteampicture", $data, "recordid='" . $rid . "'")) {
            $responseCode = 7;
            $responseMsg = "操作失败";
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamPictureDel") {
    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    if (!$responseCode) {
        $rid = intval($_GET['rid']);
        if (empty($rid)) {
            $responseCode = 3;
            $responseMsg = "访问标识(rid)不能为空";
        } else {
            include(INCLUDE_PATH . "ServiceTeamManage.php");
            $obj = new ServiceTeamManage();

            if (!$obj->deletePic($rid)) {
                $responseCode = 4;
                $responseMsg = "操作失败";
            }
        }
    }

    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
} else if ($act == "userTeamDel") {

    $responseCode = 0;
    $responseMsg = "ok";

    // 判断用户是否已经登录
    include_once(INCLUDE_PATH . "Serveteam.php");
    $serveTeam = new Serveteam();
    if (!$responseCode && !$serveTeam->checkUserLogin()) {
        $responseCode = 1;
        $responseMsg = "请先登录";
    }

    // 检测队长身份
    if (!$responseCode) {
        include_once(INCLUDE_PATH . "user.php");
        $userIndex = new user();
        if (!$userIndex->checkCaptain()) {
            $responseCode = 2;
            $responseMsg = "非法访问";
        }
    }

    if (!$responseCode) {
        $rid = intval($_GET['rid']);
        if (empty($rid)) {
            $responseCode = 3;
            $responseMsg = "访问标识(rid)不能为空";
        } else {
            include(INCLUDE_PATH . "ServiceTeamManage.php");
            $obj = new ServiceTeamManage();
            if (!$obj->deleteOne($rid)) {
                $responseCode = 4;
                $responseMsg = "操作失败";
            }
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if (!$responseCode && isset($datas)) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
}