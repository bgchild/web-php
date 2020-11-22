<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminDownload.php');
$admin_op=new adminDownload();
$types=$admin_op->getActivityTypes();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

if(isset($_POST['submit'])){
if(!$_FILES['thumb']['name']) $db->get_show_msg($admin_op->getBackurl("adminDownload.php"),"请选择文件！！");
include (PC_PATH . 'include/' . "fileupload.php"); //上传文件
$db_img=new file_upload();
$datas['filename']=$_FILES['thumb']['name'];
$datas['filetype']=strrchr ( $datas['filename'] , "." );
$datas['filename']=substr($datas['filename'],0,strpos($datas['filename'],$datas['filetype']));
$datas['filetype']=substr($datas['filetype'], 1);
$file=$db_img->upload_file($_FILES['thumb'],'file');
$datas['filepath']=substr($file, 1);
$datas['moduleid']=$_POST['moduleid'];
$datas['uploaddate']=time();
if($admin_op->insertFileInfo($datas)) 
	$db->get_show_msg($admin_op->getBackurl("adminDownload.php"),"上传成功！！");
else $db->get_show_msg($admin_op->getBackurl("adminDownload.php"),"上传失败！！");
}

$conditions=array();
if(isset($_GET['tj'])) {
	$moduleid=trim($_GET['moduleid_search']);
	if($moduleid>0) $conditions['moduleid']=$moduleid;
}

$arr=$admin_op->init($conditions);
$list=$arr['list'];
$page=$arr['page'];

if(isset($_GET['act'])) {
	$delTag=trim($_GET['delTag'])=="1"?0:1;
	$d['delTag']=$delTag;
	$d['recordid']=$_GET['recordid'];
	if($admin_op->editRecord($d)) $ret['delTag']=$delTag;
	else $ret['data']="no";
	echo  json_encode($ret);
	exit(0);
}

include get_admin_tpl('adminDownload');
?>