<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminDic.php');
$admin_op=new adminDic();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$conditions = " 1=1 ";
$tlist=$db->getAll('form__bjhh_dictype',$conditions,array('limit'=>'0,20'),'*'," order by tid DESC ");

if(isset($_POST[dolist])){
	foreach($_POST['listorder'] as $id => $listorder){
		  $db->edit('form__bjhh_dictbl',array('listorder'=>$listorder),"id = '$id' ");	
		
	}
}

$act=get_url($_GET['act']);
$act=trim($act);
if(!$act)$act='009';


if($act=='007'){
	$detail=$admin_op->serviceitem();
	$list=$detail;
    include get_admin_tpl('dic_serviceitem');	
}else {
	$arr=$admin_op->pwquestion($act);
    $list=$arr['list'];
    include get_admin_tpl('dic_pwquestion');
	
}

if(isset($_POST['doAdd'])){
	
}



?>