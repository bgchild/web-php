<?php
//灾情上报
if ($act == "pdisaster") {
    $openid = $_REQUEST['openid'];
    $user = $db->get_one('form__bjzh_subscribe', "openid='$openid'");
    if (empty($user)) {
        returnJson(1, "未找到上报者的资料");
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

        $post_data['name'] = trim($_POST['name']);
        /*if (!$post_data['name'] || $post_data['name'] == '') {
            returnJson(2, "缺少灾情名称");
        }*/

        $post_data['cate'] = trim($_POST['cate']);
        if (!$post_data['cate'] || $post_data['cate'] == '') {
            returnJson(2, "缺少灾情种类");
        }

        $post_data['description'] = trim($_POST['description']);
        if (!$post_data['description'] || $post_data['description'] == '') {
            returnJson(2, "缺少灾情需求");
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

        $post_data['victims_num'] = trim($_POST['victims_num']);
        /*if (!$post_data['victims_num'] || $post_data['victims_num'] == '') {
            returnJson(2, "缺少受灾人数");
        }*/

        $post_data['injured_num'] = trim($_POST['injured_num']);
        /*if (!$post_data['injured_num'] || $post_data['injured_num'] == '') {
            returnJson(2, "缺少受伤人数");
        }*/

        $post_data['missing_num'] = trim($_POST['missing_num']);
        /* if (!$post_data['missing_num'] || $post_data['missing_num'] == '') {
             returnJson(2, "缺少失踪人数");
         }*/

        $post_data['die_num'] = trim($_POST['die_num']);
        /*if (!$post_data['die_num'] || $post_data['die_num'] == '') {
            returnJson(2, "缺少死亡人数");
        }*/

        $post_data['transfer_num'] = trim($_POST['transfer_num']);
        /*if (!$post_data['transfer_num'] || $post_data['transfer_num'] == '') {
            returnJson(2, "缺少紧急转移安置人口数");
        }*/

        $post_data['food_help_num'] = trim($_POST['food_help_num']);
        /*if (!$post_data['food_help_num'] || $post_data['food_help_num'] == '') {
            returnJson(2, "缺少需口粮救济人口数");
        }*/

        $post_data['damage_land'] = trim($_POST['damage_land']);
        /*if (!$post_data['damage_land'] || $post_data['damage_land'] == '') {
            returnJson(2, "缺少损坏耕地面积");
        }*/

        $post_data['damage_crops'] = trim($_POST['damage_crops']);
        /*if (!$post_data['damage_crops'] || $post_data['damage_crops'] == '') {
            returnJson(2, "缺少农作物/草场受灾面积");
        }*/

        $post_data['damage_building'] = trim($_POST['damage_building']);
        /*if (!$post_data['damage_building'] || $post_data['damage_building'] == '') {
            returnJson(2, "缺少建筑物损毁情况");
        }*/

        $post_data['type'] = trim($_POST['type']);
        if (!$post_data['type'] || $post_data['type'] == '') {
            returnJson(2, "缺少您当前的身份");
        }

        $post_data['addtime'] = time();

        if ($db->add('form__bjzh_disaster', $post_data)) {
            returnJson(0, "ok");
        } else {
            returnJson(1, "提交失败");
        }
    }
} else if ($act == "dlist") {    //灾情列表

    $cate = $_REQUEST['cate'] ? $_REQUEST['cate'] : -1;
    //$status = $_REQUEST['status'] ? $_REQUEST['status'] : -1;
    $name = $_REQUEST['name'] ? $_REQUEST['name'] : '';

    $openid = trim($_REQUEST['openid']);

    if ($openid != '') {
        $user = $db->get_one('form__bjzh_subscribe', "openid='$openid'");
    }

    if (!$openid || !$user) {
        returnJson(1, '您还未认证');
    }

    $sign = $user['sign'];
    $where = ' a.volunteerid = b.recordid and a.cate = c.recordid';

    if ($user['flag'] == 0) {
        $where .= " and a.volunteerid=" . $user['recordid'];
    } else {
        if ($sign && $sign != "") {
            $where .= " and (a.volunteerid=" . $user['recordid'] . " or a.sign='$sign')";
        }
    }

    if ($name && $name != "") {
        $where .= " and a.name like '%$name%'";
    }

    if ($cate && $cate != -1) {
        $where .= " and a.cate='$cate'";
    }

    //  if ($status != -1) {
    //     $where .= " and a.status='$status'";
    //  }

    $pstart = isset($_REQUEST['pstart']) ? intval($_REQUEST['pstart']) : 1;
    $psize = $_REQUEST['psize'] ? intval($_REQUEST['psize']) : 10;
    $limit = (($pstart - 1) * $psize) . "," . $psize;

    //  $datas = $db->get_relations_info(
    //       'form__bjzh_disaster',
    //       'form__bjzh_subscribe',
    //       $where,
    //       array('limit' => $limit),
    //       ' order by recordid DESC',
    //       $fields = 'a.recordid,a.name,a.cate,a.address,a.volunteerid,a.addtime,a.status,b.name as vname,b.mobile'
    //    );

    $datas = $db->get_association_info(
        'form__bjzh_disaster',
        'form__bjzh_subscribe',
        'form__bjzh_disaster_cate',
        $where,
        array('limit' => $limit),
        ' order by recordid DESC',
        $fields = 'a.recordid,a.name,a.cate,a.address,a.volunteerid,a.addtime,a.status,b.name as vname,b.mobile,c.name as cname'
    );

    foreach ($datas as $k => $v) {
        $datas[$k]['adddate'] = date('Y-m-d', $v['addtime']);
    }

    if (empty($datas)) {
        returnJson(1, '未搜索到信息');
    } else {
        returnJson(0, 'ok', $datas);
    }
} else if ($act == "dcate") {     //灾情种类
    $datas = $db->getall('form__bjzh_disaster_cate', '', array('limit' => '0,999999'), 'recordid as value ,name as text', ' order by listorder asc');
    returnJson(0, 'ok', $datas);
} elseif ($act == "dinfo") {   //灾害详情
    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
    if ($rid == 0) {
        returnJson(1, '参数有误');
    }
    $where = ' a.volunteerid = b.recordid and a.cate = c.recordid';
    $where .= ' and a.recordid = ' . $rid;
    $info = $db->get_association_info(
        'form__bjzh_disaster',
        'form__bjzh_subscribe',
        'form__bjzh_disaster_cate',
        $where,
        array('limit' => '0,1'),
        ' order by recordid DESC',
        $fields = 'a.*,b.name as vname,b.mobile,c.name as cname'
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