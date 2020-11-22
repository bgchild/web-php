<?php
/**
 * 志愿服务时间管理
 */
include_once('../../global.php');
include_once('../common.php');

$act = trim($_GET['act']);

// 判断用户是否已经登录
include_once(INCLUDE_PATH . "Serveteam.php");
include_once(INCLUDE_PATH . "UserAddServertime.php");

$serveTeam = new Serveteam();
$serAddServertime = new UserAddServertime(true);

//新增自愿者服务时间
if ($act == "servetime") {

    if (!$serveTeam->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$serAddServertime->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    } else {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();
            $data['recordid'] = $_POST['rid'];//活动id
            $data['basePredictHour'] = $_POST['hours'];//服务时间

            $state = $serAddServertime->editRecordAjax($data);

            if ($state == -2) {
                returnJson(2, '提交失败，大型活动不参加计时');
            } elseif ($state == -3) {
                returnJson(3, '提交失败，基础工时应小于志愿服务时间');
            } elseif ($state === false) {
                returnJson(1, '提交失败');
            } else {
                returnJson(0, 'ok');
            }
        } else {
            returnJson(4, '未接受到数据');
        }
    }
    //自愿者服务时间列表
} elseif ($act == 'servertimelist') {

    if (!$serveTeam->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$serAddServertime->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    } else {

        include(INCLUDE_PATH . "UserServertime.php");
        $serviceTime = new UserServertime(true);

        $title = $_GET['title'] ? $_GET['title'] : '';
        if ($title && $title != '') {
            $where['activityName'] = $title;
        }

        $sdate = $_GET['sdate'] ? $_GET['sdate'] : '';
        if ($sdate && $sdate != '') {
            $where['activityStartDate'] = $sdate;
        }

        $edate = $_GET['edate'] ? $_GET['edate'] : '';
        if ($edate && $edate != '') {
            $where['activityEndDate'] = $edate;
        }

        $pstart = isset($_REQUEST['pstart']) ? intval($_REQUEST['pstart']) : 1;
        $psize = $_REQUEST['psize'] ? intval($_REQUEST['psize']) : 10;
        $limit = (($pstart - 1) * $psize) . "," . $psize;

        $datas = $serviceTime->getRecords($where, $limit);

        returnJson(0, 'ok', $datas);
    }

    //人员时间微调列表
} elseif ($act == 'usertimelist') {

    if (!$serveTeam->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$serAddServertime->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    } else {

        $aid = $_GET['aid'] ? intval($_GET['aid']) : 0;
        $info = array();
        if ($aid) {
            $conditions = "uid=$aid and status=4 and delstatus=0";
            $activity = $db->get_one('form__bjhh_activityexamine_activityinfo', "recordid=" . $aid);
            $persons = $db->getAll('form__bjhh_activity_personadd', $conditions);
            foreach ($persons as $k => $v) {
                if ($v['pid'] && $v['uid']) {
                    $pinfo = $db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$v[pid]");
                    $ainfo = $db->get_one('form__bjhh_activityexamine_activityinfo', "recordid=$v[uid]");
                    $info[$k]['time'] = $v['time'];
                    $info[$k]['status'] = $pinfo['status'];
                    $info[$k]['reason'] = $v['reason'];
                    $info[$k]['recordid'] = $v['recordID'];
                    $info[$k]['name'] = $pinfo['name'];
                    $info[$k]['basePredictHour'] = $ainfo['predictHour'];
                    $info[$k]['nickname'] = $pinfo['nickname'];
                    $info[$k]['birthday'] = (int)date("Y", time()) - (int)date("Y", $pinfo['birthday']) + 1;
                    $info[$k]['sex'] = $pinfo['sex'];
                }
            }
            returnJson(0, 'ok', $info);
        } else {
            returnJson(3, '活动id不能为空');
        }
    }
} elseif ($act == 'updateusertime') {
    if (!$serveTeam->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$serAddServertime->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        include_once(INCLUDE_PATH . 'UserTimeUpdate.php');
        $userTimeUpdate = new UserTimeUpdate(true);

        $ttimes = $_POST['ttime'];
        $htime = $_POST['htime'];
        $reasons = $_POST['reason'];

        if (empty($ttimes) || empty($htime)) {
            returnJson(5, '参数有误');
        }

        if ($userTimeUpdate->updateTime($ttimes, $reasons, $htime)) {
            returnJson(0, 'ok');
        } else {
            returnJson(3, '提交失败');
        }
    } else {
        returnJson(4, '未接受到参数');
    }

} elseif ($act == 'addtimelist') {   //新增服务时间活动列表

    if (!$serveTeam->checkUserLogin()) {
        returnJson(1, '请先登录');
    }

    if (!$serAddServertime->checkCaptain()) {
        returnJson(2, '您不是队长无权访问');
    }


    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $len = isset($_GET['len']) ? $_GET['len'] : 99999;//页面要求不分页
    $start = (intval($page) - 1) * $len;

    $query = array();
    $activitys = $serAddServertime->getRecords($query, $start . ',' . $len);

    if (empty($activitys)) {
        returnJson(3, '未找到数据');
    } else {
        $datas = array();
        foreach ($activitys as $k => $v) {
            $datas[$k]['recordid'] = $v['recordid'];
            $datas[$k]['activityName'] = $v['activityName'];
        }
        returnJson(0, 'ok', $datas);
    }

}