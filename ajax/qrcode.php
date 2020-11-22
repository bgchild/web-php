<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/8
 * Time: 11:43
 */

include_once('../global.php');
include_once(INCLUDE_PATH . "qrcode.php");

$act = trim($_GET['act']);

if ($act == "ewm") {
    $url = trim($_GET['url']);
    if($url){
        echo QRcode::png($url, false, 3, 6, 1);
    }
}