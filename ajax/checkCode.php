<?php
/**
 * 验证码
 */
include_once('global.php');
$act = trim($_GET['act']);
if ( $act == "checkCode" ) {
    session_start();
    include_once (INCLUDE_PATH . "CheckCode.php");

    // 防止重复提交
    if ( $_GET['time'] && $_SESSION['checkcodetime'] && ($_GET['time'] == $_SESSION['checkcodetime']) ) {
        exit();
    }

    if ( isset($_GET['len']) && intval($_GET['len']) ) {
        $len = intval($_GET['len']);
    } else {
        $len = 4;
    }
    if ($len > 8 || $len <2) {
        $len = 4;
    }

    if ( isset($_GET['size']) && intval($_GET['size']) ) {
        $size = intval($_GET['size']);
    } else {
        $size = 20;
    }

    if ( isset($_GET['w']) && intval($_GET['w']) ) {
        $width = intval($_GET['w']);
    } else {
        $width = 130;
    }

    if ( isset($_GET['h']) && intval($_GET['h'])) {
        $height = intval($_GET['h']);
    } else {
        $height = 50;
    }

    if ( isset($_GET['color']) && trim(urldecode($_GET['color'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['color']))) ) {
        $color = trim(urldecode($_GET['color']));
    }

    if ( isset($_GET['bg']) && trim(urldecode($_GET['bg'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['bg']))) ) {
        $bg = trim(urldecode($_GET['bg']));
    } else {
        $bg = "#EDF7FF";
    }


    $checkCode = new CheckCode();
    $checkCode->code_len = $len;
    if ( isset($size) ) {
        $checkCode->font_size = $size;
    }

    $checkCode->width = $width;
    $checkCode->height = $height;
    if ( isset($color) ) {
        $checkCode->font_color = $color;
    }
    $checkCode->background = $bg;
    $checkCode->doimage();

    if ( $_GET['time'] ) {
        $_SESSION['checkcodetime'] = $_GET['time'];
    }
    $_SESSION['checkcode'] = $checkCode->get_code();
} else if ( $act == "getCheckCode" ) {
    session_start();
    echo $_SESSION['checkcode'];
    exit();
}