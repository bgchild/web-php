<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminAppraisingManage.php');
include_once(INCLUDE_PATH.'adminVolunteer.php');
$admin_op=new adminVolunteer();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$admin_manage=new adminAppraisingManage();
//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();

$info=get_url($_GET['info']);
$infos=array();
$searchItems=array('prizewinner','receivedate1','receivedate2');
if(isset($_POST['doSearch'])){
	$infos['doSearch2']="true";
	foreach($searchItems as $item)
		if(trim($_POST[$item]))
			$infos[$item]=$_POST[$item];
	header("Location:appraisingManage.php?info=".set_url($infos));
}
$query=array();
if(isset($info['doSearch2']) ){
	$infos['doSearch2']="true";
	foreach($searchItems as $item)
		if(trim($info[$item])){
			$query[$item]=$info[$item];
			$infos[$item]=$info[$item];
		}
}
$page = _get_page ( 10 );
$myaward=$admin_manage->init($query,$page['limit']);
foreach($myaward as $k=>$v){
	$myaward[$k]['receivedate'] = date("Y-m-d",$v['receivedate']);
}
$page['item_count'] = $admin_manage->getCount();
$page = _format_page($page);

    include get_admin_tpl('appraisingManage');








?>