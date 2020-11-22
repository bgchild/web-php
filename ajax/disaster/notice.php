<?php
//公众号首页推送通知
if ($act == "notice") {
    $sign = $_REQUEST['sign'];
    if (!$sign || $sign == '') {
        returnJson(2, '缺少参数');
    }

    $limit = 4;
    $datas = $db->getall(
        'form__bjhh_news',
        "(sign='$sign' or creator='zbadmin') and fid=169 and status=1",
        array('limit' => $limit),
        $fields = 'recordid,title,pictures',
        ' order by recordid DESC'
    );

    foreach ($datas as $k => $v) {
        //$datas[$k]['pictures'] = "http://" . $sign . $website . "/" . $v['pictures'];
        $datas[$k]['pictures'] = ($v['pictures']);
    }

    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(1, '未搜索到信息');
    }
} else if ($act == "noticelist") {
    //公众号通知列表
    $sign = $_REQUEST['sign'];

    if (!$sign || $sign == '') {
        returnJson(2, '缺少参数');
    }

    $pstart = isset($_REQUEST['pstart']) ? intval($_REQUEST['pstart']) : 1;
    $psize = $_REQUEST['psize'] ? intval($_REQUEST['psize']) : 10;
    $limit = (($pstart - 1) * $psize) . "," . $psize;

    $datas = $db->getall(
        'form__bjhh_news',
        "(sign='$sign' or creator='zbadmin') and fid=169 and status=1",
        array('limit' => $limit),
        $fields = 'recordid,title,createTime',
        ' order by recordid DESC'
    );

    foreach ($datas as $k => $v) {
        $datas[$k]['adddate'] = date('Y-m-d', $v['createTime']);
    }

    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(1, '未搜索到信息');
    }
} else if ($act == "noticeinfo") {
    //公众号通知详情
    $rid = intval($_REQUEST['rid']);
    if (!$rid || $rid == 0) {
        returnJson(2, '缺少参数');
    }

    $data = $db->get_one(
        'form__bjhh_news',
        "recordid='$rid' and fid=169 and status=1",
        $fields = 'recordid,title,creator,createTime,content,flag',
        ' order by recordid DESC'
    );

    if (!empty($data)) {
        $data['content'] = replaceFullImageUrl($data['content']);
        $data['adddate'] = Date('Y-m-d H:i:s', $data['createTime']);//格式化发布时间
        $data['from'] = "中国红十字会";//来源不详
        returnJson(0, 'ok', $data);
    } else {
        returnJson(1, "未搜索到信息");
    }
}