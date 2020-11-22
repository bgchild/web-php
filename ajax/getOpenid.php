<?php
/**
 * 获取用户的openid
 */
include_once('../globalAjax.php');

if(!isset($_GET['code']) ){
    returnJson(1,'缺少code');
}

$code = trim($_GET['code']);

//$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);

baseAuth($code);

function baseAuth($code){

    //$appid = 'wx28eaf860364cda82';
    //$appsecret = '0168658a0de231cb9d573041d899a7ec';
    //$appsecret = '4b90fd6fe3deeec91086a3166f36e655';
	$appid = 'wx1125c65ab89adcee';
	$appsecret = 'c75a0e470a6711b2515536bc38334f0a';
    //1.准备scope为snsapi_base网页授权页面

//    $baseurl = urlencode($redirect_url);
//    $snsapi_base_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$baseurl.'&response_type=code&scope=snsapi_base&state=YQJ#wechat_redirect';

    //2.静默授权,获取code
    //页面跳转至redirect_uri/?code=CODE&state=STATE

//    $code = $_GET['code'];
//    if(!isset($code) ){
//        header('Location:'.$snsapi_base_url);
//    }

    //3.通过code换取网页授权access_token和openid
    $curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';

    $content = send_curl($curl);

    echo $content;
    exit();

    //$result = json_decode($content,true);
}
