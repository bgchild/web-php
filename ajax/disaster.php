<?php
include_once('../global.php');
include_once('../globalAjax.php');

//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);

$act = trim($_GET['act']);
$datas = array();
$actions = array(
    'flash',
    'notice',
    'news',
    'noticelist',
    'newslist',
    'noticeinfo',
    'newsinfo',
    'pdisaster',
    'userinfo',
    'puser',
    'dlist',
    'phelp',
    'hlist',
    'dcate',
    'dinfo',
    'hinfo',
    'about',
    'contact',
);

if (in_array($act, $actions)) {
    include_once('./disaster/flash.php');
    include_once('./disaster/notice.php');
    include_once('./disaster/news.php');
    include_once('./disaster/disaster.php');
    include_once('./disaster/help.php');
    include_once('./disaster/user.php');
    include_once('./disaster/about.php');
    include_once('./disaster/contact.php');
} else {
    returnJson(404, '请求地址不存在');
}


