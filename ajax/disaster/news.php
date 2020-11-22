<?php
//公众号首页推送新闻
if ( $act == "news" ) {
    $sign = $_REQUEST['sign'];
    if (!$sign || $sign == '') {
        returnJson(2, '缺少参数');
    }

    $limit = '5';
    $datas = $db->getall(
        'form__bjhh_news',
        "(sign='$sign' or creator='zbadmin') and fid=170 and status=1",
        array('limit' => $limit),
        $fields = 'recordid,title,pictures',
        ' order by recordid DESC'
    );

    foreach ($datas as $k => $v) {
        //$datas[$k]['pictures'] = "http://" . $sign . $website . "/" . $v['pictures'];
        $datas[$k]['pictures'] = getResUrl($v['pictures']);
    }

    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(1, '未搜索到信息');
    }
} else if ( $act == "newslist" ) {
    //公众号新闻列表
    $sign = $_REQUEST['sign'];

    $pstart = isset($_REQUEST['pstart']) ? intval($_REQUEST['pstart']) : 1;
    $psize = $_REQUEST['psize'] ? intval($_REQUEST['psize']) : 10;
    $limit = (($pstart - 1) * $psize) . "," . $psize;

    $datas = $db->getall(
        'form__bjhh_news',
        " (sign='$sign' or creator='zbadmin') and fid=170 and status=1",
        array('limit' => $limit),
        $fields = 'recordid,title,createTime',
        ' order by recordid ASC'
    );

    foreach ($datas as $k => $v) {
        $datas[$k]['adddate'] = Date('Y-m-d', $v['createTime']);
    }

    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(1, '未搜索到信息');
    }
} else if ( $act == "newsinfo" ) {
    //公众号新闻详情
    $rid = intval($_REQUEST['rid']);
    if (!$rid || $rid == 0) {
        returnJson(2, '缺少参数');
    }

    $data = $db->get_one(
        'form__bjhh_news',
        "recordid='$rid' and fid=170 and status=1",
        $fields = 'recordid,title,creator,createTime,content',
        ' order by recordid ASC'
    );

    $data['adddate'] = Date('Y-m-d H:i:s', $data['createTime']);
    $data['from'] = "中国红十字会";//来源不详
    $data['content'] = replaceFullImageUrl($data['content']);//来源不详
    //$data['creator'] = "管理员";//发布者

    if (empty($data)) {
        returnJson(1, '未搜索到信息');
    } else {
        returnJson(0, 'ok', $data);
    }
}