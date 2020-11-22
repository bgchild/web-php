<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminVolunteer.php');
include_once(INCLUDE_PATH.'adminuser.php');
$admin_op=new adminVolunteer();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$obj = new adminuser();

//获取总会/省/市 信息
$cityArr = array();
$cityArr = $admin_op->getCityInfo();

if ($_POST ['act'] == "username") {
	$username = $_POST ['username'];
	$rid = $_POST ['rid'];
	if ($obj->_check_username ( $username,$rid ))
		$ret = no;
	echo $ret;
	exit ();
}
if ($_GET['spm']) {
	$spm = get_url(trim($_GET['spm']));
	if (! $spm)
			header ( "Location: adminuserlist.php" );
	$adminuserOne = $obj->getOne($spm);
}
if(isset($_POST['doedit'])){
$url='adminuser.php';
$userinfo=array();
$username=get_input($_POST['u_name']);	
$u_pwd=get_input($_POST['u_pwd']);	
$con_pwd=get_input($_POST['con_pwd']);
$rid=get_input($_POST['rid']);
$get_one = $db->get_one ( 'form__bjhh_admin', " recordid='$rid' " );
$repeat = $obj->_check_username ( $username,$rid );
if(!$username || !$u_pwd)$db->get_show_msg($url,'参数错误');
if($u_pwd!=$con_pwd)$db->get_show_msg($url,'两次输入的密码不一样');
if(!is_username($username))$db->get_show_msg($url,'用户名含特殊字符');
if(!is_password($u_pwd))$db->get_show_msg($url,'密码长度6到20位');
$encrypt=get_rand_str(10);
$userinfo['u_name']=$username;
$userinfo['u_pwd']=password($u_pwd,$encrypt);
$userinfo['encrypt']=$encrypt;
$userinfo['creat_time']=time();
$userinfo['last_time']=time();
$userinfo['last_ip']=get_ip();

if($db->edit('form__bjhh_admin',$userinfo,"recordid=$rid")){
	$arg=$obj->getUser();
	//写入操作日志
	$arr=array();
	$arr[module]='7';
	$arr[type]='72';
	$arr[name]=$get_one['u_name'];
	$admin_op->doLog($arr);
	if($arg[1]==$get_one['u_name']){
		$db->get_show_msg('adminlogout.php','修改成功，请重新登录！');
	}else{
		$db->get_show_msg('adminuserlist.php','修改成功');
	}
		
}else{
	$db->get_show_msg($url,'修改失败');
}

}
if(isset($_POST['dosubmit'])){
$url='adminuser.php';
$userinfo=array();
$username=get_input($_POST['u_name']);	
$u_pwd=get_input($_POST['u_pwd']);	
$con_pwd=get_input($_POST['con_pwd']);
$repeat = $obj->_check_username ( $username,"" );
if ($repeat)
		$db->get_show_msg ($url, '用户名已被注册!' );	
if(!$username || !$u_pwd)$db->get_show_msg($url,'参数错误');
if($u_pwd!=$con_pwd)$db->get_show_msg($url,'两次输入的密码不一样');
if(!is_username($username))$db->get_show_msg($url,'用户名含特殊字符');
if(!is_password($u_pwd))$db->get_show_msg($url,'密码长度6到20位');
$encrypt=get_rand_str(10);
$userinfo['u_name']=$username;
$userinfo['u_pwd']=password($u_pwd,$encrypt);
$userinfo['encrypt']=$encrypt;
$userinfo['creat_time']=time();
$userinfo['last_time']=time();
$userinfo['last_ip']=get_ip();
$userinfo['sign'] = $cityArr['sign'];
$userinfo['parentid'] = $cityArr['parentid'];
$userinfo['areaid'] = $cityArr['areaid'];
$userinfo['def'] ='2';

if($db->add('form__bjhh_admin',$userinfo)){
	//写入操作日志
	$arr=array();
	$arr[module]='7';
	$arr[type]='70';
	$arr[name]=$userinfo['u_name'];
	$admin_op->doLog($arr);
	$db->get_show_msg('adminuserlist.php','添加成功');
}else{
	$db->get_show_msg($url,'添加失败');
}
//print_r($userinfo);
}
include get_admin_tpl('admin_user');

?>