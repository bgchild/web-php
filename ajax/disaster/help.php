<?php
//求助上报
if ($act == "phelp") {
    $openid = $_REQUEST['openid'];
    $user = $db->get_one('form__bjzh_subscribe', "openid='$openid'");
    if (empty($user)) {
        returnJson(3, "未找到上报者的资料");
    } else {
        $post_data = array();
        $post_data['volunteerid'] = $user['recordid'];

        $post_data['lng'] = trim($_POST['lng']);
        if (!$post_data['lng'] || $post_data['lng'] == '') {
            returnJson(2, "缺少经度");
        }

        $post_data['lat'] = trim($_POST['lat']);
        if (!$post_data['lat'] || $post_data['lat'] == '') {
            returnJson(2, "缺少纬度");
        }

        $post_data['sign'] = trim($_POST['sign']);
        if (!$post_data['sign'] || $post_data['sign'] == '') {
            returnJson(2, "缺少地区");
        }

        $post_data['name'] = trim($_POST['title']);
        if (!$post_data['name'] || $post_data['name'] == '') {
            returnJson(2, "缺少求助名称");
        }

        $post_data['description'] = trim($_POST['description']);
        if (!$post_data['description'] || $post_data['description'] == '') {
            returnJson(2, "缺少求助需求");
        }

        $post_data['image'] = isset($_POST['image']) ? trim($_POST['image']) : '';
        /*if (!$post_data['image'] || $post_data['image'] == '') {
            returnJson(2, "缺少现场灾情图片");
        }*/

        $post_data['address'] = trim($_POST['address']);
        if (!$post_data['address'] || $post_data['address'] == '') {
            returnJson(2, "缺少地址信息");
        }

        $post_data['place'] = trim($_POST['place']);
        if (!$post_data['place'] || $post_data['place'] == '') {
            returnJson(2, "缺少事发地点");
        }

        $post_data['type'] = trim($_POST['type']);
        if (!$post_data['type'] || $post_data['type'] == '') {
            returnJson(2, "缺少您当前的身份");
        }

        $post_data['addtime'] = time();

        if ($db->add('form__bjzh_help', $post_data)) {
            returnJson(0, 'ok');
        } else {
            returnJson(1, '提交失败');
        }
    }
} else if ($act == "hlist") {    //求助列表

    $title = $_REQUEST['title'] ? $_REQUEST['title'] : "";
    $openid = trim($_REQUEST['openid']);

    if ($openid != '') {
        $user = $db->get_one('form__bjzh_subscribe', "openid='$openid'");
    }

    if (!$openid || !$user) {
        returnJson(1, '您还未认证');
    }

    $pstart = isset($_REQUEST['pstart']) ? intval($_REQUEST['pstart']) : 1;
    $psize = $_REQUEST['psize'] ? intval($_REQUEST['psize']) : 10;
    $limit = (($pstart - 1) * $psize) . "," . $psize;

    $where = " a.volunteerid = b.recordid and a.sign = '" . $user['sign'] . "'";

    if ($user['flag'] == 0) {
        $where .= " and a.volunteerid=" . $user['recordid'];
    } else {
        if ($sign && $sign != "") {
            $where .= " and (a.volunteerid=" . $user['recordid'] . " or a.sign='$sign')";
        }
    }

    if ($title && $title != "") {
        $where .= " and a.name like '%$title%'";
    }

    $datas = $db->get_relations_info(
        'form__bjzh_help',
        'form__bjzh_subscribe',
        $where,
        array('limit' => $limit),
        ' order by recordid DESC',
        $fields = 'a.recordid,a.name,a.description,a.image,a.address,a.volunteerid,a.addtime,a.status,b.name as vname,b.mobile'
    );

    foreach ($datas as $k => $v) {
        $datas[$k]['adddate'] = date('Y-m-d', $v['addtime']);
    }

    if (empty($datas)) {
        returnJson(1, '未搜索到数据');
    }

    returnJson(0, 'ok', $datas);
} elseif ($act == "hinfo") {   //求助详情

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
    if ($rid == 0) {
        returnJson(1, '参数有误');
    }
    $where = ' a.volunteerid = b.recordid';
    $where .= ' and a.recordid = ' . $rid;

    $info = $db->get_relations_info(
        'form__bjzh_help',
        'form__bjzh_subscribe',
        $where,
        array('limit' => '0,1'),
        ' order by recordid DESC',
        $fields = 'a.*,b.name as vname,b.mobile'
    );

    switch ($info[0]['type']) {
        case 1:
            $info[0]['type_desc'] = '我是目击者我正在现场';
            break;
        case 2:
            $info[0]['type_desc'] = '我是目击者我已离开现';
            break;
        case 3:
            $info[0]['type_desc'] = '我是事件受影响者我在现场';
            break;
        case 4:
            $info[0]['type_desc'] = '这是我听说但经过核实的消息';
            break;
        default:
            $info[0]['type_desc'] = '不详';
            break;
    }

    if (empty($info)) {
        returnJson(2, '未搜索到数据');
    } else {
        $image_arr = explode(',', $info[0]['image']);
        $images = array();
        foreach ($image_arr as $k => $v) {
            if ($v != '' && $v != 'undefined') {
                $images[] = getResUrl($v);
            }
        }
        $info[0]['image'] = $images;
        returnJson(0, 'ok', $info[0]);
    }
}