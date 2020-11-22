<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'volunteerCount.php');
$admin_op=new volunteerCount();
$name = $admin_op->getUserName();

//获取当前用户的用户名
$now_admin = $admin_op->getUserName();
// 验证是否为灾害管理员登录
if ( !preg_match("/^admin(.*)/", $now_admin) ) {
	$db->get_show_msg ( 'javascript:history.back(0)', "非法访问！！" );
}

// 总会
$isClub = false;
if (($name == 'admin') && ($sign == 'www')) {
	$isClub = true;
}

//判断当前登录用户权限
$now_flag =	 NULL;
$now_flag = $admin_op->getUserAuthority();
//统计维度 类型
$ctype=array(1=>"按性别统计",2=>"按年龄统计",3=>"按服务类别统计",4=>"按学历统计",5=>"按星级统计",6=>"按服务时间");
//获取组织机构
$sign=$admin_op->getCityInfo();
$level=$admin_op->getorganization($sign['areaid']);

//获取服务类别
$severtype = $db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
//获取学历类型
$etype =$db->getall ("form__bjhh_dictbl", "tcode='005' and state='1' ",array(limit=>'0,9999999'), 'name','order by listorder ASC' );
$infos=get_url($_GET['info']);
$searchItems=array('ctype','time_start','time_stop','secity','lower'); 
if(isset($_GET['doSearch'])){
	foreach ($searchItems as $v){
		if($_GET[$v]) {
		$infos[$v]=$_GET[$v];
		$query=$infos;
		}
		header("Location:volunteerCount.php?info=".set_url($infos));
	}
}
if ( $isClub && (empty($infos) || empty($infos['secity']) ) ) {
	$infos['secity'] = 'www';
}
if ( $isClub && (empty($infos) || empty($infos['secity']) || $infos['secity'] == 'all') ) {
	$counts = $admin_op->initClub($infos);
} else {
	$counts=$admin_op->init($infos);
}

if($_GET['act']=='batch_exp'){
$exp_cfg=$admin_op->h_array($infos['ctype'], $severtype);
$admin_op->batch_exp($exp_cfg,$counts, $infos['ctype']);
}

// 总会登录,统计数据不需要分页
if ( !$isClub ) {
	$page   =  _get_page(20);
	$page['item_count']=count($counts);

	// 工时统计,不是统计每页的,但也需要分页
	if($infos['ctype'] == 6) {
		$totalNumNan = 0;
		$totalNumNv = 0;
		foreach($counts as $v){
			$totalNumNan += $v['nan'];
			$totalNumNv += $v['nv'];
		}
	}
	$page = _format_page($page);
	$counts=array_chunk($counts, 20,true );
	$counts = $counts[$page[curr_page]-1];
}

include get_admin_tpl('volunteerCount');
?>