<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminindex.php');
include_once(INCLUDE_PATH.'adminActivity.php');
$admin_op=new adminindex();
$admin_act=new adminActivity();
$mes=array();
$mes['status']='n';
$mes['mes']='操作失败';
$act=$_POST['act'];
$id=$_POST['id'];
$statusreason=$_POST['statusreason'];
if(!$act || !$id) echo json_encode($mes);
if($act=='yes'){
	$datas=array();
	$datas['status']=3;
	$datas['statusreason']=$statusreason;
	$datas['statusremark']=$statusremark;
	$datas['auditor']=$admin_op->getUserName();
	$conditions="recordid=$id";
	$result=$db->edit('form__bjhh_activityexamine_activityinfo', $datas, $conditions);
	//给活动对应的服务队队员发送邀请消息
	$activity=$db->get_one("form__bjhh_activityexamine_activityinfo"," recordid=$id ");
	$persons= $db->getall("form__bjhh_serviceteammanage_addserviceteamperson"," serviceteamid=$activity[serviceid]");
	$rids=array();
	foreach($persons as $per) {$rids[]=$per['serviceteamcaptainid'];}
	$admin_act->invite2Activity($rids,$id);
	$admin_act->sendPassMsg('pass',$id);
    $mes['status']='y';
    $mes['mes']='该活动审核通过操作成功';
    echo json_encode($mes);  
}elseif ($act=='no'){
    $datas=array();
	$datas['status']=6;
	$datas['statusreason']=$statusreason;
	$datas['statusremark']=$statusremark;
	$datas['auditor']=$admin_op->getUserName();
	$conditions="recordid=$id";
	$result=$db->edit('form__bjhh_activityexamine_activityinfo', $datas, $conditions);
	$admin_act->sendPassMsg('notpass',$id);
    $mes['status']='y';
    $mes['mes']='该活动审核不通过操作成功';	
    echo json_encode($mes); 	
}
    
exit();
?>