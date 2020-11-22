<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminVolunteer.php');
$admin_op=new adminVolunteer();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();

if(isset($_GET['down'])) {
	$down="..".$_GET['down'];
	$filename=$_GET['filename'];
    $result=filedown($down,$filename);
    if(!$result) $admin_op->db->get_show_msg($admin_op->getBackurl(),"文件不存在！！");
    exit(0);
}

$saveact=$_POST['saveact'];
$id=$_POST['id'];
if($saveact && $id){
	$user=$admin_op->getUser();
	if($saveact=='yes'){
		$datas=array();
		$datas['status']='001';
		$datas['auditor']=$user[0];
		$datas['refusedreason']=$_POST['refusedreason'];
		$datas['refusedremark']=$_POST['refusedremark'];
		$conditions=" recordid=$id ";
		$result=$admin_op->edit($datas, $conditions);
		$mes['status']='y';
		$mes['mes']='该志愿者初审通过操作成功';
	    echo json_encode($mes);  
	}elseif ($saveact=='no'){
		$datas=array();
		$datas['status']='011';
		$datas['auditor']=$user[0];
		$datas['refusedreason']=$_POST['refusedreason'];
		$datas['refusedremark']=$_POST['refusedremark'];
		$conditions=" recordid=$id ";
		$result=$admin_op->edit($datas, $conditions);
		$mes['status']='y';
		$mes['mes']='该志愿者初审拒绝操作成功';
		echo json_encode($mes); 	
		}
	exit();
}


$act=trim($_GET['act'])?trim($_GET['act']):trim($_POST['act']);
if(!$act) $act='init';
switch ($act) {
	case 'init':
	$name=trim($_GET['name']);
	$status=trim($_GET['status']);	
	$arr=$admin_op->init($status,$name);
    $list=$arr['list'];
    $page=$arr['page'];
    include get_admin_tpl('volunteer');
	break;
	
	case 'detail':	
	$detail=$admin_op->detail();
	$spm=get_url($_GET['spm']);
    $fromurl=$spm[fromurl];
	$backurl=$admin_op->getBackUrl('volunteer.php');
    include get_admin_tpl('volunteer_detail');
	break;
	
	case 'yes':
		//log
		$arr=array();
		$arr[type]='10';
		$arr[module]='1';
		$admin_op->doLog($arr);
	$detail=$admin_op->yes();	
	break;
	case 'no':
	//log
	$arr=array();
	$arr[type]='11';
	$arr[module]='1';
	$admin_op->doLog($arr);
	$detail=$admin_op->no();	
	break;
	
	default:
		;
	break;
}


?>