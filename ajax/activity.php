<?php
/**
 * 志愿活动
 */
include_once('global.php');

$act = trim($_GET['act']);
if ($act == "home_activity") {
    include_once(INCLUDE_PATH . "Index.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_GET['sign'];
    if (!$sign) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    if (!$responseCode) {
        $obj = new Index ();
        // 根据登录用户服务地来筛选,最多五条
        $activity = $obj->getActivity(5, $sign);
        //var_dump($activity);

        if ($activity && count($activity)) {
            $datas = array();
            foreach ($activity as $key => $val) {
                array_push($datas, array(
                    'id' => $val['recordid'],
                    'name' => $val['activityName']
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
} else if ($act == "detailactivity") {
    include_once(INCLUDE_PATH . "Activity.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $rid = intval($_GET['rid']);
    if (empty($rid)) {
        $responseCode = 1;
        $responseMsg = "访问标识(rid)不能为空";
    } else {
        $obj = new Activity();
        if (!$obj->checkrid($rid)) {
            $responseCode = 2;
            $responseMsg = "查看信息不存在";
        } else {
            $one = $obj->getDetailActivity($rid);
            //var_dump($one);
            if (!$one) {
                $responseCode = 2;
                $responseMsg = "查看信息不存在";
            } else {
                $datas = array(
                    "activityName" => $one['activityName'],
                    "activityType" => $one['activityType'],
                    "activityAddr" => $one['activityAddr'],
                    "planNum" => $one['planNum'],
                    "predictHour" => $one['predictHour'],
                    "activityStartDate" => $one['activityStartDate'],
                    "activityEndDate" => $one['activityEndDate'],
                    "activityTime" => $one['activitytime'],
                    "signUpDeadline" => $one['signUpDeadline'],
                    "serviceTeamName" => $one['serviceteamname'],
                    "actysobjnum" => $one['actysobjnum'],
                    "remarks" => $one['remarks'],
                    "activityProfile" => $one['activityProfile'],
                    "img" => getResUrl($one['sign'], $one['imgpath'])
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
} else if ($act == "activity") {
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_POST['sign'] || $_GET['sign'];
    if (!$sign) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    $lng = trim($_POST['lng']);
    $lat = trim($_POST['lat']);
    if (!$lng || !$lat) {
        $responseCode = 2;
        $responseMsg = "没有获取到您当前的经度或纬度值";
    }

    if (!$responseCode) {
        include_once(INCLUDE_PATH . "Activity.php");
        $obj = new Activity();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index . "," . $len;

        $query = array();
        $activityName = trim($_POST['name']);
        if ($activityName) {
            $query['activityName'] = $activityName;
        }

        $list = $obj->getActivityAjax($query, $limit, $lng, $lat, $sign);
        //var_dump($list);
        if ($list && count($list)) {
            $datas = array();
            foreach ($list as $key => $val) {
                $item = array(
                    "id" => $val['recordid'],
                    "name" => $val['activityName'],
                    "planNum" => $val['planNum'],
                    "people" => $val['people'],
                    "startDate" => $val['activityStartDate'],
                    "endDate" => $val['activityEndDate'],
                    "typeName" => $val['typename']
                );

                if ($val['lng'] && $val['lat']) {
                    $item['distance'] = pointDistance($lng, $lat, $val['lng'], $val['lat']);
                }
                array_push($datas, $item);
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
} else if ($act == "joinActivity") {
    $responseCode = 0;
    $responseMsg = "ok";

    include_once(INCLUDE_PATH . "Activity.php");
    $obj = new Activity();

    $rid = intval($_POST['rid']);
    if (empty($rid)) {
        $responseCode = 1;
        $responseMsg = "活动不存在";
    } else {
        $one = $obj->getDetailActivity($rid);
        if (!$one) {
            $responseCode = 1;
            $responseMsg = "活动不存在";
        }
    }

    // 检测是否登录
    if (!$responseCode && !$obj->checkUserLogin()) {
        $responseCode = 2;
        $responseMsg = "您还没有登录";
    }

    if (!$responseCode && !$obj->checkSignAjax($rid)) {
        $responseCode = 3;
        $responseMsg = "请选择您归属地";
    }

    if (!$responseCode && $obj->checkPower()) {
        $responseCode = 4;
        $responseMsg = "您还未通过审核";
    }

    if (!$responseCode && $obj->endTime($one['signUpDeadline'])) {
        $responseCode = 5;
        $responseMsg = "对不起，报名已截止";
    }

    if (!$responseCode && $obj->countPeople($rid, $one['planNum'])) {
        $responseCode = 6;
        $responseMsg = "人员已满";
    }

    if (!$responseCode && $obj->isRepeat($rid)) {
        $responseCode = 7;
        $responseMsg = "您已经加入了这个活动";
    }

    if (!$responseCode) {
        if (!$obj->addActivity(array('rid' => $rid))) {
            $responseCode = 8;
            $responseMsg = "加入失败";
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
