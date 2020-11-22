<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'adminIndexManage.php');
include_once(INCLUDE_PATH.'adminVolunteer.php');
$admin_op=new adminVolunteer();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

$admin_manage=new adminIndexManage();
$now_flag=$admin_op->getUserAuthority();




$act = trim ( $_GET ['act'] ) ? $_GET ['act'] : $_POST ['act'];
if (! $act)
	$act = 'init';

switch ($act) {
	case 'init' :
		$rid = get_url(trim($_GET['rid']));
		if(!$rid){$db->get_show_msg('volunteerService.php','参数错误！');}
		$page = _get_page ( 10 ); 
		$list = $admin_manage->news($rid,$page['limit']);
		$column = $admin_manage->fTitle($rid);
		foreach($list as $k=>$v){	
			$list[$k]['editTime'] = date("Y-m-d H:i:s",$v['editTime']);
		}
		$ftitle = $admin_manage->fTitle($rid);
        $page['item_count'] = $admin_manage->getCount(); 
		$page = _format_page($page);
		include get_admin_tpl('volunteerServiceList');
		break;
	case 'edit' :
		$rid = get_url(trim($_GET['rid']));
		if(!$rid){$db->get_show_msg('volunteerServiceList.php','参数错误！');}
		$detail =$admin_manage->zTitle($rid);
		$column = $admin_manage->fTitle($detail['fid']);
		$backurl=$admin_op->getBackUrl('volunteerServiceList.php');
		include get_admin_tpl('volunteerServiceListEdit');
		break;
	case 'delete' :
		$rid = get_url(trim($_GET['rid']));
		if(!$rid){$db->get_show_msg('volunteerServiceList.php','参数错误！');}
		$column = $admin_manage->zTitle($rid);
		$cid = set_url($column[fid]);
		$admin_manage->deleteNews($rid);
		header("Location:volunteerServiceList.php?rid=".$cid);
		break;
	case 'add' :
		$post=array();
		foreach($_POST as $k=>$v) $post[$k]=trim($v);
		$backurl=$admin_op->getBackUrl('volunteerServiceList.php');
		if($admin_manage->addNews($post)){
			$db->get_show_msg("volunteerService.php", '保存成功');
		}else{
			$db->get_show_msg($backurl, '保存失败');
		}
		break;
	case 'save' :
		$post=array();
		foreach($_POST as $k=>$v) $post[$k]=trim($v);
		$backurl=$admin_op->getBackUrl('volunteerServiceList.php');
		$column = $admin_manage->zTitle($post[rid]);
		$cid = set_url($column[fid]);
		if($admin_manage->editNews($post)){
			$db->get_show_msg("volunteerServiceList.php?rid=$cid", '保存成功');
		}else{
			$db->get_show_msg($backurl, '保存失败');
		}
		
	default :
		;
		break;
}


?>