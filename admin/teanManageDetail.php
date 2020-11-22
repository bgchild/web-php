<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminTeamManageDetail.php');
include_once (INCLUDE_PATH . 'adminServiceTeamMoreInfo.php');
$admin_op = new adminTeamManageDetail ();
$admin_M = new adminServiceTeamMoreInfo ();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();

$act = trim ( $_GET ['act'] ) ? $_GET ['act'] : $_POST ['act'];
if (! $act)
	$act = 'edit';

if ($_POST ['dosubmit']) {
	$status = $_POST ['action'];
	if ($admin_M->serviceTeamAdd ( $_POST, $status )) {
		$admin_M->db->get_show_msg ( 'serviceTeamMessage.php', '保存服务队成功' );
	} else {
		$admin_M->db->get_show_msg ( 'serviceTeamMessage.php', '保存服务队失败' );
	}
	exit ( 0 );
}

switch ($act) {
	case 'edit' :
		//默认地区和服务项目、技能
		$province = $admin_M->defaultCityArray ( 'province' );
		$city = $admin_M->defaultCityArray ( 'city' );
		$area = $admin_M->defaultCityArray ( 'area' );
		$cate = $admin_M->checkboxArray ( 'form__bjhh_dictbl', 007 );
		$skill = $admin_M->checkboxArray ( 'form__bjhh_dictbl', 006 );
		if ($_GET ['spm']) {
			$spm = get_url ( trim ( $_GET ['spm'] ) );
			if (! $spm)
				$this->db->get_show_msg ( 'serviceTeamMessage.php', '参数错误！' );
			$ser_one = $admin_M->serviceGetOne ( $spm );
			if ($ser_one ['province'])
				$city = $admin_M->OneCityArray ( $ser_one ['province'] );
			if ($ser_one ['city'])
				$area = $admin_M->OneCityArray ( $ser_one ['city'] );
		}
		
		include get_admin_tpl ( 'teamManageEdit' );
		break;
	case 'member' :
		if ($_GET ['spm']) {
			$spm = get_url ( trim ( $_GET ['spm'] ) );
			if (! $spm)
				$this->db->get_show_msg ( 'serviceTeamMessage.php', '参数错误！' );
		}
		$arr = $admin_op->member ( $spm );
		$list = $arr ['list'];
		$page = $arr ['page'];
		include get_admin_tpl ( 'teamManageMember' );
		break;
	
	case 'activity' :
		if ($_GET ['spm']) {
			$spm = get_url ( trim ( $_GET ['spm'] ) );
			if (! $spm)
				$this->db->get_show_msg ( 'serviceTeamMessage.php', '参数错误！' );
		}
		$conditions = "serviceid ='$spm' and deltag = '0' and status='3' ";
		if (isset ( $_REQUEST ['doSearch'] )) {
			if (trim ( $_GET ['startTime'] )) {
				$startTime = strtotime ( trim ( $_GET ['startTime'] ) . '00:00:00' );
				$conditions .= ' and activityStartDate >=' . $startTime;
			}
			if (trim ( $_GET ['finishTime'] )) {
				$finishTime = strtotime ( trim ( $_GET ['finishTime'] ) . '00:00:00' );
				$conditions .= ' and activityEndDate <=' . $finishTime;
			}
			if (trim ( $_GET ['activityName'] )) {
				$activityName = trim ( $_GET ['activityName'] );
				$conditions .= " and activityName like '%" . $activityName . "%' ";
			}
			if (trim ( $_GET ['activityType'] )) {
				$activityType = trim ( $_GET ['activityType'] );
				$conditions .= ' and activityType =' . $activityType;
			}
		}
		$types = $admin_op->getActivityType ();
		$arr = $admin_op->activity ( $conditions );
		$list = $arr ['list'];
		$page = $arr ['page'];
		include get_admin_tpl ( 'teamManageActivity' );
		break;
	
	default :
		;
		break;
}

?>