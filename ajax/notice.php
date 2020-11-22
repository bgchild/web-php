<?php
/**
 * 通知公告
 */
include_once('global.php');

$act = trim($_GET['act']);
if ( $act == "notice" ) {

    include_once(INCLUDE_PATH . "news.php");
    $responseCode = 0;
    $responseMsg = "ok";

    $sign = $_POST['sign'];
    if ( !$sign ) {
        $responseCode = 1;
        $responseMsg = "请选择您所在的地区";
    }

    if ( !$responseCode ) {
        $news = new news ();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $len = isset($_POST['len']) ? $_POST['len'] : 8;
        $index = ($page - 1) * $len;
        $limit = $index.",".$len;
        $list = $news->getList("2", $limit, $sign);

        if ( $list && count($list) ) {
            $datas = array();
            foreach($list as $key=>$val) {
                array_push($datas, array(
                    "id" => $val['recordid'],
                    "title" => $val['title'],
                    "time" => date('Y-m-d H:i:s', $val['createTime']),
                ));
            }
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if ( !$responseCode && isset($datas) ) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();

} else if( $act == "detailnotice" ) {
    include_once(INCLUDE_PATH . "news.php");

    $responseCode = 0;
    $responseMsg = "ok";

    $rid = intval($_GET['rid']);
    if ( empty($rid) ) {
        $responseCode = 1;
        $responseMsg = "访问标识(rid)不能为空";
    } else {
        $news = new news ();
        $one = $news->getOne($rid);
        //var_dump($one);

        if ( !$one ) {
            $responseCode = 2;
            $responseMsg = "查看信息不存在";
        } else {
            $datas = array(
                "title" => $one['title'],
                "creator" => $one['creator'],
                "source" => "中国红十字会",
                "time" => date('Y-m-d H:i:s', $one['createTime']),
                "content" => replaceFullImageUrl($one['content'])
            );
        }
    }


    $response = array(
        'responseCode' => $responseCode,
        'responseMsg' => $responseMsg
    );

    if ( !$responseCode && isset($datas) ) {
        $response['datas'] = $datas;
    }

    echo json_encode($response);
    exit();
}