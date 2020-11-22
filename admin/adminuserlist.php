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

//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();
$obj = new adminuser();
$arg=$obj->getUser();
$def_list=$obj->getCityInfo();
$url = 'adminuserlist.php';
if ($def_list['def']=='1'){
	$list = $obj->getAllList ();
	if ($_GET ['deleteid']) {
		$did = get_url ( trim ( $_GET ['deleteid'] ) );
		$where = " recordid='$did' ";
		$info = $db->get_one( 'form__bjhh_admin', $where,$fields = 'u_name');
		if ($obj->deleteOne ( $did )) {
			//写入操作日志
			$arr=array();
			$arr[module]='7';
			$arr[type]='71';
			$arr[name]=$info['u_name'];
			$admin_op->doLog($arr);
			$obj->db->get_show_msg ($url, '删除成功' );
		} else {
			$obj->db->get_show_msg ($url, '删除失败' );
		}
		exit ( 0 );
	}
	include get_admin_tpl('admin_userlist');
}else{
	$adminuserOne = $obj->getOne($arg[0]);
	echo $adminuserOne; die();
	include get_admin_tpl('adminother_userlist');
}


?>