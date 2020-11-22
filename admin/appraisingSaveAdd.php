<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminAppraisingSaveAdd.php');
include_once(INCLUDE_PATH.'adminVolunteer.php');
$admin_op=new adminVolunteer();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$admin_manage=new adminAppraisingSaveAdd();
//隐藏选择页面
$men_per = 10;
$men_total = count ( $admin_manage->selectInit () );
if (isset ( $_POST ['doAPage'] )) {
	$page_index = $_POST ['page_index'];
	$name = $_POST ['name'];
	$guarderidnumb = $_POST ['guarderidnumb'];
	$limit = ($page_index * $men_per) . "," . ($men_per);
	$limit = array (limit => $limit );
	$men_each = $admin_manage->selectInit ( $name,$guarderidnumb, $limit );
	echo json_encode ( $men_each );
	exit ( 0 );
}

if (isset ( $_POST ['doSearch'] )) {
	$name = $_POST ['name'];
	$guarderidnumb = $_POST ['guarderidnumb'];
	$men_total = count ( $admin_manage->selectInit ( $name ,$guarderidnumb) );
	$men_each ['men_total'] = $men_total;
	echo json_encode ( $men_each );
	exit ( 0 );
}
//
$id=get_url($_GET['recordid']);
if($id){
$myaward=$admin_manage->init($id);
$myaward['receivedate'] = date("Y-m-d",$myaward['receivedate']);
}
if(isset($_POST["dosubmit2"])){
	$post=array();
	foreach($_POST as $k=>$v) $post[$k]=trim($v);
		if($admin_manage->editRecord($post)){
			//写入操作日志
	 		$arr=array();
			$arr[module]='6';
			$arr[type]='61';
			$arr[name]=$post['prizewinner'];
			$admin_op->doLog($arr); 
			$db->get_show_msg('appraisingManage.php', '保存成功');
		}else{ $db->get_show_msg('appraisingSaveAdd.php', '保存失败！');}
}

if(isset($_POST["dosubmit1"])){
	$post1=array();
    $ids = $_POST[rids];
    $rids=split(",", $ids);
    $post1[receivedate] = $_POST[receivedate];
    $post1[winaddress] = $_POST[winaddress];
    $post1[wincontent] = $_POST[wincontent];
		if($admin_manage->addRecord($post1,$rids)){
			//写入操作日志
			$arr=array();
			$arr[module]='6';
			$arr[type]='60';
			$admin_op->doLog($arr);
			$db->get_show_msg('appraisingManage.php', '保存成功');
		}else{ $db->get_show_msg('appraisingSaveAdd.php', '保存失败！');}
}


if(isset($_POST['doRecd'])) {
	$_recd=$_POST['recd'];
   $rids=split(",", $_recd);
	$ret['result']='yes';
	$showname = $admin_manage->showName($rids);
	if(!$showname) {$ret['result']='no';}
	else {
		$ret['name']=$showname;
		$ret['rids']=$rids;
	}
	echo json_encode($ret);
	exit(0);
}
/*
$ads=$_POST['aid'];
if($ads){
	$showname = array();
	$showname = $admin_manage->showName($ads);
}
*/
    include get_admin_tpl('appraisingSaveAdd');








?>