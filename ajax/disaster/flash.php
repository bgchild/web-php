<?php
//公众号首页轮播
if ( $act == "flash" ) {
    $sign = trim($_REQUEST['sign']);

    if (!$sign || $sign == '') {
        returnJson(2, '缺少参数');
    }

    $limit = 5;
    $datas = $db->getall(
        'form__bjzh_flash',
        "sign='$sign'",
        array('limit' => $limit),
        $fields = 'id,img,name',
        ' order by orderlist DESC'
    );

    foreach ($datas as $k => $v) {
        //$datas[$k]['img'] = "http://" . $sign . $website . "/" . $v['img'];
        $datas[$k]['img'] = getResUrl($v['img']);
    }

    //var_dump($datas);
    if (!empty($datas)) {
        returnJson(0, 'ok', $datas);
    } else {
        returnJson(1, '未搜索到信息');
    }
}