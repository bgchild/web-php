<?php
if ($act == "userinfo") {
    $openid = trim($_GET['openid']);
    if (isset($openid) && $openid != '') {
        $user = $db->get_one('form__bjzh_subscribe', "openid='$openid'");
        if (empty($user)) {
            returnJson(1, "用户不存在", $user);
        }
        returnJson(0, "ok", $user);
    } else {
        returnJson(2, "参数有误");
    }
} else if ($act == "puser") {
    //提交用户资料
    $post_data = array();
    $post_data['openid'] = trim($_POST['openid']);
    if ($post_data['openid'] == '') {
        returnJson(2, "缺失微信标识");
    }

    $post_data['name'] = trim($_POST['name']);
    if ($post_data['name'] == '') {
        returnJson(2, "请填写名称");
    }

    $post_data['sex'] = trim($_POST['sex']);
    if ($post_data['sex'] == '' || $post_data['sex'] == 0) {
        returnJson(2, "请选择性别");
    }

//    $post_data['cardno'] = trim($_POST['cardno']);
//    if ($post_data['cardno'] == '') {
//        returnJson(2, "请填写身份证号码");
//    }

    $post_data['mobile'] = trim($_POST['mobile']);
    if ($post_data['mobile'] == '') {
        returnJson(2, "请填写手机号码");
    }

    if (!checkMobile('mobile')) {
        returnJson(3, "手机号码已经存在");
    }

    $post_data['email'] = trim($_POST['email']);
    if ($post_data['email'] == '') {
        returnJson(2, "请填写邮箱地址");
    }

    $post_data['sign'] = trim($_POST['sign']);
    if ($post_data['sign'] == '') {
        returnJson(2, "请填写区域标识");
    }

//    $post_data['address'] = trim($_POST['address']);
//    if ($post_data['address'] == '') {
//        returnJson(2, "请填写地址");
//    }

    $post_data['addtime'] = time();

    $user = $db->get_one('form__bjzh_subscribe', "openid='$openid'");

    if (empty($user)) {
        if ($db->add('form__bjzh_subscribe', $post_data)) {
            returnJson(0, 'ok');
        } else {
            returnJson(1, '提交失败');
        }
    } else {
        if ($db->edit('form__bjzh_subscribe', $post_data, "openid='$openid'")) {
            returnJson(0, 'ok');
        } else {
            returnJson(1, '提交失败');
        }
    }
}

/** 检验手机号是否存在
 * @param $mobile
 * @return bool
 */
function checkMobile($mobile)
{
    global $db;
    $user = $db->get_one('form__bjzh_subscribe', "mobile='$mobile'");
    if (empty($user)) {
        return true;
    }
    return false;
}