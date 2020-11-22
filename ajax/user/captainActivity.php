<?php
/**
 * 活动管理-队长
 */

include_once('../../global.php');
include_once('../common.php');

include_once(INCLUDE_PATH . "UserActivityManage.php");

$manage = new UserActivityManage(true);

$act = trim($_GET['act']);

if ($act == "addActivity") {  //新增活动

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    $items = array(
        'name' => 'activityName',//活动名称
        'type' => 'activityType',//活动类型
        'province' => 'activityProvince',//活动省份
        'city' => 'activityCity',//活动城市
        'area' => 'activityArea',//活动地区
        'address' => 'activityAddr',//详细地址
        'point' => 'activityPoint',//活动坐标
        'pnum' => 'planNum',//计划人数
        'hours' => 'predictHour',//服务时间
        'sdate' => 'activityStartDate',//开始时间
        'edate' => 'activityEndDate',//结束时间
        //'edate' => 'activityEndDate',//结束时间
        'time' => 'activitytime',//活动时长
        'ssdate' => 'signUpDeadline',//报名截止时间
        'sid' => 'serviceid',//服务队id
        'money' => 'actysmoney',//活动经费
        'anum' => 'actysobjnum',//收益人次
        'large' => 'large',//是否是大型活动
        'largeid' => 'largeid',//父级活动id
        'remarks' => 'remarks',//活动要求
        'content' => 'activityProfile',//活动简介
        'imgpath' => 'imgpath',//活动宣传图片
        'status' => 'status',//保存状态
    );

    $post = array();

    foreach ($_POST as $k => $v) {
        if ($items[$k]) {
            $post[$items[$k]] = trim($v);
        }
    }

    if (isset($_POST['imgpath'])) {
        $post['imgpath'] = str_replace('//', '/', $post['imgpath']);
    }

    if ($post['status'] == '1') {
        if ($manage->addOneActivity($post)) {
            returnJson(0, '保存活动草稿成功');
        } else {
            returnJson(2, '保存活动草稿失败');
        }
    } else if ($post['status'] == '2') {
        if ($manage->addOneActivity($post)) {
            returnJson(0, '提交活动成功');
        } else {
            returnJson(2, '提交活动失败');
        }
    }

} elseif ($act == "activityLists") { //活动列表

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    }

    $query = array();

    $searchItems = array(
        'name' => 'activityName',//活动名称
        'type' => 'activityType',//活动类型
        'sdate' => 'activityStartDate',//活动开始时间
        'edate' => 'activityEndDate',//活动结束时间

        //'address' => 'activityAddr',
        //'time' => 'activitytime',
        //'pnum' => 'planNum'
    );

    $status = $_GET['status'] ? intval($_GET['status']) : 0;

    foreach ($searchItems as $key => $item) {
        if (trim($_GET[$key])) {
            $query[$item] = $_GET[$key];
        }
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $len = isset($_GET['len']) ? $_GET['len'] : 10;
    $index = ($page - 1) * $len;
    $limit = $index . "," . $len;

    /*$pstart = $_GET['pstart'] ? intval($_GET['pstart']) : 0;
    $psize = $_GET['psize'] ? intval($_GET['psize']) : 10;
    $limit = $pstart . "," . $psize;*/

    $datas = $manage->getRecordsByStatus($status, "", $query, $limit);
    //var_dump($datas);

    foreach ($datas as $key => $val) {
        $val['activityStartDate'] = date("Y-m-d", $val['activityStartDate']);
        $val['activityEndDate'] = date("Y-m-d", $val['activityEndDate']);
        $val['creattime'] = date("Y-m-d H:i:s", $val['creattime']);
        $val['signUpDeadline'] = date("Y-m-d H:i:s", $val['signUpDeadline']);
        $datas[$key] = $val;
    }

    returnJson(0, 'ok', $datas);

} elseif ($act == "editActivity") {  //编辑活动

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }


    if ( $_SERVER['REQUEST_METHOD'] != "POST" ) {
        // 获取活动信息,进行编辑
        // 编辑活动数据 表单提交
        if (!$_GET['rid']) {
            returnJson(2, '缺少参数');
        }

        $obj = $manage->getActivityServicename($_GET['rid']);
        if ( $obj ) {
            $datas = array(
                'name' => $obj['activityName'],//活动名称
                'type' => $obj['activityType'],//活动类型
                'province' => $obj['activityProvince'],//活动省份
                'city' => $obj['activityCity'],//活动城市
                'area' => $obj['activityArea'],//活动地区
                'address' => $obj['activityAddr'],//详细地址
                'lng' => $obj['lng'],// 活动经度
                'lat' => $obj['lat'], // 活动纬度
                'pnum' => $obj['planNum'],//计划人数
                'hours' => $obj['predictHour'],//服务时间
                'sdate' => date("Y-m-d H:i:s", $obj['activityStartDate']),//开始时间
                'edate' => date("Y-m-d H:i:s", $obj['activityEndDate']),//结束时间
                'time' => $obj['activitytime'],//活动时长
                'ssdate' => date("Y-m-d H:i:s", $obj['signUpDeadline']),//报名截止时间
                'sid' => $obj['serviceid'],//服务队id
                'money' => $obj['actysmoney'],//活动经费
                'anum' => $obj['actysobjnum'],//收益人次
                'large' => $obj['large'],//是否是大型活动
                'largeid' => $obj['largeid'],//父级活动id
                'remarks' => $obj['remarks'],//活动要求
                'content' => $obj['activityProfile'],//活动简介
                'imgpath' => getResUrl($obj['imgpath']),//活动宣传图片
            );
        }

        returnJson(0, 'ok', $datas);
    } else {
        // 编辑活动数据 表单提交
        if (!$_POST['rid']) {
            returnJson(2, '缺少参数');
        }

        $items = array(
            'rid' => 'recordid',
            'name' => 'activityName',//活动名称
            'type' => 'activityType',//活动类型
            'province' => 'activityProvince',//活动省份
            'city' => 'activityCity',//活动城市
            'area' => 'activityArea',//活动地区
            'address' => 'activityAddr',//详细地址
            'point' => 'activityPoint',//活动坐标
            'pnum' => 'planNum',//计划人数
            'hours' => 'predictHour',//服务时间
            'sdate' => 'activityStartDate',//开始时间
            'edate' => 'activityEndDate',//结束时间
            //'edate' => 'activityEndDate',//结束时间
            'time' => 'activitytime',//活动时长
            'ssdate' => 'signUpDeadline',//报名截止时间
            'sid' => 'serviceid',//服务队id
            'money' => 'actysmoney',//活动经费
            'anum' => 'actysobjnum',//收益人次
            'large' => 'large',//是否是大型活动
            'largeid' => 'largeid',//父级活动id
            'remarks' => 'remarks',//活动要求
            'content' => 'activityProfile',//活动简介
            'imgpath' => 'imgpath',//活动宣传图片
            'status' => 'status',//保存状态
        );

        $post = array();

        foreach ($_POST as $k => $v) {
            if ($items[$k]) {
                $post[$items[$k]] = trim($v);
            }
        }

        if (isset($_POST['imgpath'])) {
            $post['imgpath'] = str_replace('//', '/', $post['imgpath']);
        }

        if ($post['status'] == '1') {
            if ($manage->addOneActivity($post)) {
                returnJson(0, '保存活动草稿成功');
            } else {
                returnJson(4, '保存活动草稿失败');
            }
        } else if ($post['status'] == '2') {
            if ($manage->addOneActivity($post)) {
                returnJson(0, '提交活动成功');
            } else {
                returnJson(4, '提交活动失败');
            }
        } else {
            returnJson(2, '缺少参数');
        }
    }
} elseif ($act == 'delActivity') { //删除活动

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    $rrid = $_GET['rid'];

    if (!$rrid) {
        returnJson(2, '缺少参数');
    }

    if ($manage->deleteOneRecord($rrid) > 0) {
        returnJson(0, 'ok');
    } else {
        returnJson(4, '删除失败！请再次尝试！');
    }
} elseif ($act == 'cancelActivity') {  //取消活动

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }
    // 检测活动是否为大型活动,如果存在子集活动进行中,则必须等活动结束,或取消子集活动,方可.
    if (!$_POST['rid']) {
        returnJson(2, '缺少参数');
    }

    $record = $manage->getOneRecord($_POST['rid']);

    if ($record && $record['large']) {
        // 如果存在子集活动处于 3:活动进行中 的情况,则大型活动将不能立即结束,必须等这些子集活动全部结束后,方可执行.
        $childrenCount = $db->get_count("form__bjhh_activityexamine_activityinfo", "largeid=$rid and status=3");
        if ($childrenCount > 0) {
            returnJson(1, '存在子集活动未结束!');
        }
    }

    $data['recordid'] = $_POST['rid'];
    $data['cancelreason'] = $_POST['cancelreason'];
    $data['status'] = "5";

    if ($manage->editRecord($data)) {
        $manage->sendCancelActivityMsg2Mem($data[recordid]);
        returnJson(0, 'ok');
    } else {
        returnJson(4, '操作失败');
    }

} elseif ($act == 'colseActivity') {   //结束活动

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    if (!$_POST['rid']) {
        returnJson(2, '缺少参数');
    }

    $result = $manage->stopActivity($_POST['rid']);

    if ($result['err']) {
        returnJson($result['err'], $result['msg']);
    } else {
        returnJson(0, 'ok');
    }

} elseif ($act == 'vlist') {       //志愿者列表
    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    $rrid = $_GET['rid'];
    $status = $_GET['status'];

    $pstart = isset($_GET['pstart']) ? intval($_GET['pstart']) : 1;
    $psize = $_GET['psize'] ? intval($_GET['psize']) : 10;
    $limit = (($pstart-1) * $psize) . "," . $psize;

    if (!$rrid) {
        returnJson(2, '缺少参数');
    }

    $datas = $manage->getActivityMem($rrid, $status, $limit);

    foreach ($datas as $k => $v) {
        $datas[$k]['birthday'] = date('Y-m-d', $v['birthday']);
    }

    returnJson(0, 'ok', $datas);

} /*elseif ($act == 'addinActivity') { //邀请志愿者

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    }

    $aid = $_POST['aid'];
    $_recd = $_POST['recds'];
    $rids = split(",", $_recd);

    $manage->invite2Activity($rids, $aid);

    returnJson(0, 'ok');

}*/ elseif ($act == 'getActivityTime') {    //获取当前活动时间

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    if (!isset($_GET['rid']) || !intval($_GET['rid'])) {
        returnJson(2, '缺少参数');
    }

    $rid = $_GET['rid'];

    $record = $manage->getOneRecord($rid);

    if (empty($record)) {
        returnJson(4, '未找到信息');
    } else {
        $datas = array(
            'startDate' => date('Y-m-d H:i:s', $record['activityStartDate']),
            'endDate' => date('Y-m-d H:i:s', $record['activityEndDate']),
        );
        returnJson(0, 'ok', $datas);
    }

} elseif ($act == 'changeDate') {   //活动改期

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    if (!isset($_POST['rid']) || !intval($_POST['rid'])) {
        returnJson(2, '缺少参数');
    }
    $rid = $_POST['rid'];

    $record = $manage->getOneRecord($rid);
    // 检测活动是否为大型活动,如果是,则时间范围必须包含所有子集活动时间
    if ($record['large']) {
        $minActivityStartDate = 0;
        $maxActivityEndData = 0;
        $children = $db->getall("form__bjhh_activityexamine_activityinfo", "largeid=$rid and status IN (2,3,4)");

        foreach ($children as $val) {
            if (!$minActivityStartDate || $val['activityStartDate'] < $minActivityStartDate) {
                $minActivityStartDate = $val['activityStartDate'];
            }

            if (!$maxActivityEndData || $val['activityStartDate'] > $maxActivityEndData) {
                $maxActivityEndData = $val['activityEndDate'];
            }
        }

        if ($minActivityStartDate && $maxActivityEndData) {
            if (strtotime($_POST['nsdate']) > $minActivityStartDate || strtotime($_POST['nedate']) < $maxActivityEndData) {
                returnJson(4, '日期范围必须包含所有子集活动日期');
            }
        }

        // 检测活动是否为大型活动的子集,如果是,则时间必须在父级活动时间范围内
    } else if ($record['largeid']) {
        $largeRecord = $manage->getOneRecord($record['largeid']);
        if ($largeRecord) {
            if (
                strtotime($_POST['nsdate']) < $largeRecord['activityStartDate'] ||
                strtotime($_POST['nsdate']) > $largeRecord['activityEndDate'] ||
                strtotime($_POST['nedate']) < $largeRecord['activityStartDate'] ||
                strtotime($_POST['nedate']) > $largeRecord['activityEndDate']
            ) {
                returnJson(5, '活动时间必须在父级活动范围内');
            }

        }
    }

    $data['recordid'] = $_POST['rid'];
    $data['activityStartDate'] = strtotime($_POST['nsdate']);
    $data['activityEndDate'] = strtotime($_POST['nedate']);
    $data['changereason'] = $_POST['changereason'];
    $data['activityTime'] = round(($data['activityEndDate'] - $data['activityStartDate']) / (60 * 60));
    $ret['result'] = 'no';
    $ret['activityStartDate'] = date("Y-m-d", $data['activityStartDate']);
    $ret['activityEndDate'] = date("Y-m-d", $data['activityEndDate']);
    if ($manage->editRecord($data)) {
        $manage->sendChangeTimeMsg2Mem($data[recordid]);
        returnJson(0, 'ok');
    }
} elseif ($act == 'sumupActivity') {   //活动总结

    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$manage->checkCaptain()) {
        returnJson(3, '您不是队长无权访问');
    }

    if (!intval($_POST['rid'])) {
        returnJson(2, '缺少参数');
    }

    $data['recordid'] = $_POST['rid'];
    $data['sumup'] = $_POST['sumup'];

    if (!$manage->editRecord($data)) {
        returnJson(1, '提交失败');
    } else {
        returnJson(0, 'ok');
    }
}elseif($act == 'isCaptain'){
    if (!$manage->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if ($manage->checkCaptain()) {
        returnJson(0, 'ok');
    }else{
        returnJson(2, '您不是队长');
    }
}
