<?php
/**
 * 我的活动列表
 */
include_once('global.php');
$act = trim($_GET['act']);
if ($act == "userActivity") {
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
        include_once(INCLUDE_PATH . "UserActivationRecord.php");
        $obj = new UserActivationRecord();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();
        if ($_POST['type']) {
            $query['activityType'] = $_POST['type'];
        }

        $team = trim($_POST['team']);
        if ($team) {
            $query['serviceteamname'] = $team;
        }

        $status = $POST['status'];
        if (isset($status) && $status != '0') {
            $query['status'] = $status;
        }

        $startDate = trim($_POST['startDate']);
        if ($startDate) {
            $query['activityStartDate'] = $startDate;
        }

        $endDate = trim($_POST['endDate']);
        if ($endDate) {
            $query['activityEndDate'] = $endDate;
        }

        $name = trim($_POST['name']);
        if ($name) {
            $query['activityName'] = $name;
        }

        $list = $obj->getMyRecordsByStatus($query, $limit);
        /*var_dump($list);
        exit();*/
        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                array_push($datas, array(
                    "id" => $val['brecordid'],
                    "name" => $val['activityName'],
                    "startDate" => $val['activityStartDate'],
                    "endData" => $val['activityEndDate'],
                    "applyNum" => $val['applyNum'],
                    "typeName" => $val['typename'],
                    "team" => $val['serviceteamname'],
                    "status" => $val['astatus']
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
} else if ($act == "userActivityDetail") {
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
            include_once(INCLUDE_PATH . "UserMsgShow.php");
            $manage = new UserMsgShow();
            $one = $manage->getOneRecord($rid);
            if (!$one) {
                $responseCode = 3;
                $responseMsg = "查看信息不存在";
            } else {
                $team = $serveTeam->getTeamAjax(array('recordid'=>$one['serviceid']),'0,1');
                $datas = array(
                    "name" => $one['activityName'],
                    "typeName" => $one['activityType'],
                    "address" => $one['activityAddr'],
                    "planNum" => $one['planNum'],
                    "predictHour" => $one['predictHour'],
                    "startDate" => date("Y-m-d H:i:s", $one['activityStartDate']),
                    "endDate" => date("Y-m-d H:i:s", $one['activityEndDate']),
                    "time" => $one['activitytime'],
                    "signUpDeadline" => date("Y-m-d H:i:s", $one['signUpDeadline']),
                    "team" => $team[0]['serviceteamname'],
                    "actysobjnum" => $one['actysobjnum'],
                    "remarks" => $one['remarks'],
                    "profile" => $one['activityProfile'],
                    "img" => getResUrl($one['imgpath'])
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
} else if ($act == "userServiceTeams") {
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
        include(INCLUDE_PATH . "UserActivityManage.php");
        $obj = new UserActivityManage();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();
        $list = $obj->getServiceTeamsAjax($query, array("limit" => $limit));
        //var_dump($list);
        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                array_push($datas, array(
                    "id" => $val['recordid'],
                    "name" => $val['serviceteamname'],
                    "foundingTime" => date("Y-m-d H:i:s", $val['foundingtime']),
                    "skillNames" => $val['skillnames'],
                    "serviceNames" => $val['servicenames']
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
} else if ($act == "userActivityInvitationList") {
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

    $activityId = trim($_POST['rid']);
    if (!$responseCode && !$activityId) {
        $responseCode = 3;
        $responseMsg = "访问标识(rid)不能为空";
    }

    if (!$responseCode) {
        include(INCLUDE_PATH . "UserActivityManage.php");
        $obj = new UserActivityManage();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();
        $list = $obj->getServiceMenAjax($activityId, $query, "", array("limit" => $limit));
        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                array_push($datas, array(
                    "id" => $val['recordid'],
                    "name" => $val['name'],
                    "username" => $val['username'],
                    "nickname" => $val['nickname'],
                    "birthday" => date("Y-m-d", $val['birthday']),
                    "sex" => $val['sex'],
                    "pNames" => $val['pnames']
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
} else if ($act == "userActivityInvitation") {
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


    include_once(INCLUDE_PATH . "UserActivityManage.php");
    $obj = new UserActivityManage();
    $activityId = trim($_POST['rid']);
    if (!$responseCode && !$activityId) {
        $responseCode = 3;
        $responseMsg = "访问标识(rid)不能为空";
    }

    if (!$responseCode) {
        $one = $obj->getOneRecord($activityId);
        if (!$one) {
            $responseCode = 4;
            $responseMsg = "活动不存在";
        }
    }

    $uids = $_POST['uids'];
    if (!$responseCode && (!$uids || !count($uids))) {
        $responseCode = 5;
        $responseMsg = "请选择需要邀请的志愿者";
    }

    if (!$responseCode) {
        $obj->invite2Activity($uids, $activityId);
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
} else if ($act == "userActivityVolunteerList") {
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


    $activityId = trim($_POST['rid']);
    if (!$responseCode && !$activityId) {
        $responseCode = 3;
        $responseMsg = "访问标识(rid)不能为空";
    } else {
        include_once(INCLUDE_PATH . "UserActivityManage.php");
        $obj = new UserActivityManage();
    }

    if (!$responseCode && $obj) {
        $one = $obj->getOneRecord($activityId);
        if (!$one) {
            $responseCode = 4;
            $responseMsg = "活动不存在";
        }
    }

    /**
     * 活动：1
     * 通过审核：2
     * 未通过审核：3
     * 已参加：4
     */
    $tag = isset($_POST['tag']) ? $_POST['tag'] : 1;

    if (!$responseCode && $obj) {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();
        $list = $obj->getActivityMem($activityId, $tag, $limit);
        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                array_push($datas, array(
                    // 活动记录ID
                    "id" => $val['recordid'],
                    "name" => $val['name'],
                    "birthday" => date("Y-m-d", $val['birthday']),
                    "sex" => $val['sex'],
                    "skillNames" => $val['skillnames'],
                    "addDate" => date("Y-m-d", $val['addDate']),
                    "email" => $val['emails']
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
} else if ($act == "userActivityVolunteerPass") {
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

    $rids = $_POST['rids'];
    if (!$responseCode && (!$rids || !count($rids))) {
        $responseCode = 3;
        $responseMsg = "请选志愿者";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . "UserActivityManage.php");
        $obj = new UserActivityManage();
        foreach ($rids as $rid) {
            $da['recordID'] = $rid;
            $da['status'] = '2';
            $obj->editActivityMen($da);
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
} else if ($act == "userActivityVolunteerRefuse") {
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

    $rids = $_POST['rids'];
    if (!$responseCode && (!$rids || !count($rids))) {
        $responseCode = 3;
        $responseMsg = "请选志愿者";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . "UserActivityManage.php");
        $obj = new UserActivityManage();
        foreach ($rids as $rid) {
            $da['recordID'] = $rid;
            $da['status'] = '3';
            $obj->editActivityMen($da);
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