<?php
include_once ('../global.php');
include_once (INCLUDE_PATH . 'adminDic.php');
$adminD = new adminDic ();

$act = trim ( $_POST ['act'] );
if (! $act)
	exit ();
switch ($act) {
	case 'up' :
		$process = '0';
		break;
	case 'down' :
		$process = '1';
		break;
	case '2' :
		$process = '2';
		break;
	case '3' :
		$process = '3';
		break;
	case '4' :
		$process = '4';
		break;
	case '5' :
		$process = '5';
		break;
}

/***************参数初始化********************/

//修改哪一条主键
$editid = $_POST ['editid'];
//服务队主键
$servid = $_POST ['servid'];
//志愿者主键
$uid = $_POST ['uid'];

//定义空数组
$data = array ();
$oldCap = array ();
$arr = array ();
$arr2 = array ();
$sends = array ();
$servArr = array ();
$userArr = array ();

//定义查询条件
$where = '';
$conditions = '';

//定义当前时间
$time = time ();

//定义当前发消息人
$sendUser = $adminD->getUser ();

//定义当前发消息头
$sends ['fromid'] = $sendUser [0];
$sends ['fromname'] = $sendUser [1];
$sends ['fno'] = $servid;
$sends ['date'] = $time;
$sends ['toid'] = $uid;

/************************************************/

if ($process == '0') {
	//用户id
	$sends ['toid'] = $editid;
	//获取用户名
	$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$editid' " );
	$sends ['toname'] = $userArr ['username'];
	//发送状态
	$sends ['status'] = 15; //被赋予队长资格
	//发送内容
	$sends ['content'] = "您已经被赋予队长资格";
	//发送消息
	$db->add ( 'form__bjhh_message', $sends );
	//log
	$arr=array();
	$arr[type]='30';
	$arr[module]='3';
	$uname=$db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$editid","name");
	$arr[name]=$uname[name];
	$adminD->doLog($arr);
	
	$data ['captainable'] = '1';
	$conditions = 'recordid =' . $editid;
	if ($db->edit ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $data, $conditions )) {
		echo '1';
	} else
		echo '0';

} elseif ($process == '1') {
	//用户id
	$sends ['toid'] = $editid;
	//获取用户名
	$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$editid' " );
	$sends ['toname'] = $userArr ['username'];
	//发送状态
	$sends ['status'] = 16; //被赋予队长资格
	//发送内容
	$sends ['content'] = "您已经被取消队长资格";
	//发送消息
	$db->add ( 'form__bjhh_message', $sends );
	$data ['captainable'] = '0';
	$conditions = 'recordid =' . $editid;
	//log
	$arr=array();
	$arr[type]='31';
	$arr[module]='3';
	$uname=$db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$editid","name");
	$arr[name]=$uname[name];
	$adminD->doLog($arr);
	if ($db->edit ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $data, $conditions )) {
		
	  echo '1';
	} else
		echo '0';
} elseif ($process == '2') { //设为队长
	

	//初始化查询条件并查询服务队中是否存在队长
	$where = " captain='1' and serviceteamid='$servid' ";
	$oldCap = $db->get_one ( 'form__bjhh_serviceteammanage_addserviceteamperson', $where );
	//取出服务队信息
	$servArr = $db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid='$servid' " );
	
	//判断服务队是否存在队长
	if ($oldCap) {
		//取消队长
		$arr ['captain'] = '3';
		$db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $arr, $where );
		
		//发送取消信息
		$sends ['status'] = 20; //取消队长
		$sends ['date'] = time ();
		$sends ['content'] = "您已经被撤销服务队【" . $servArr ['serviceteamname'] . "】 队长职务";
		$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='{$oldCap['serviceteamcaptainid']}' " );
		$sends ['toid'] = $oldCap ['serviceteamcaptainid'];
		$sends ['toname'] = $userArr ['username'];
		$db->add ( 'form__bjhh_message', $sends );
	}
	
	//委任服务队归属
	$arr2 ['creatorid'] = $uid;
	$arr2 ['serviceteamcaptainid'] = $uid;
	$where = " recordid='$servid' ";
	$db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $arr2, $where );
	
	//任命队长
	$data ['captain'] = '1';
	$conditions = 'recordid =' . $editid;
	//修改队员状态
	if ($db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $data, $conditions )) {
		
		//发送任命队长消息
		$sends ['status'] = 19; //任命队长
		$sends ['date'] = time ();
		$sends ['content'] = "您已经被委任服务队【" . $servArr ['serviceteamname'] . "】 队长职务";
		$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$uid' " );
		$sends ['toid'] = $uid;
		$sends ['toname'] = $userArr ['username'];
		$db->add ( 'form__bjhh_message', $sends );
		
		echo '2';
	} else
		echo '0';

} elseif ($process == '3') { //设为副队长
	//获取服务队名并定义消息内容
	$servArr = $db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid='$servid' " );
	$sends ['content'] = "您已经被委任服务队【" . $servArr ['serviceteamname'] . "】 副队长职务";
	//获取用户名
	$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$uid' " );
	$sends ['toname'] = $userArr ['username'];
	//消息表状态
	$sends ['status'] = 21; //后台服务队管理：被任命为副队长
	//添加消息
	$db->add ( 'form__bjhh_message', $sends );
	
	//修改队员状态
	$data ['captain'] = '2';
	$conditions = 'recordid =' . $editid;
	if ($db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $data, $conditions )) {
		echo '3';
	} else
		echo '0';

} elseif ($process == '4') { //取消队长
	//获取服务队名并定义消息内容
	$servArr = $db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid='$servid' " );
	$sends ['content'] = "您已经被取消服务队【" . $servArr ['serviceteamname'] . "】 队长职务";
	//获取用户名
	$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$uid' " );
	$sends ['toname'] = $userArr ['username'];
	//消息表状态
	$sends ['status'] = 20; //后台服务队管理：被取消队长
	//添加消息
	$db->add ( 'form__bjhh_message', $sends );
	
	$arr ['creatorid'] = '';
	$arr ['serviceteamcaptainid'] = '';
	$where = " recordid='$servid' ";
	$db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $arr, $where );
	$data ['captain'] = '3';
	$conditions = 'recordid =' . $editid;
	if ($db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $data, $conditions )) {
		echo '4';
	} else
		echo '0';

} elseif ($process == '5') { //取消副队长
	//获取服务队名并定义消息内容
	$servArr = $db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid='$servid' " );
	$sends ['content'] = "您已经被取消服务队【" . $servArr ['serviceteamname'] . "】 副队长职务";
	//获取用户名
	$userArr = $db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$uid' " );
	$sends ['toname'] = $userArr ['username'];
	//消息表状态
	$sends ['status'] = 22; //后台服务队管理：被取消副队长
	//添加消息
	$db->add ( 'form__bjhh_message', $sends );
	
	$data ['captain'] = '3';
	$conditions = 'recordid =' . $editid;
	if ($db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $data, $conditions )) {
		echo '5';
	} else
		echo '0';
}

exit ();

?>