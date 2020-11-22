<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'serviceobjCount.php');
$admin_op=new serviceobjCount();
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

// 统计维度 类型
$ctype = array(1 => "按服务队统计", 2 => "按服务类别统计");

//服务类别
//$ctype=$db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
//获取组织机构
$sign=$admin_op->getCityInfo();
$level=$admin_op->getorganization($sign['areaid']);
$activitytype = $db->getall ("form__bjhh_dictbl", "tcode='008' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
$infos=get_url($_GET['info']);
$searchItems=array('ctype','time_start','time_stop','secity','lower','team','actcityname'); 
if(isset($_GET['doSearch'])){
	foreach ($searchItems as $v){
		if($_GET[$v]) {
		$infos[$v]=$_GET[$v];
		$query=$infos;
		}
		header("Location:serviceobjCount.php?info=".set_url($infos));
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
//if($_GET['act']=='batch_exp') $admin_op->batch_exp($counts);
if($_GET['act']=='batch_exp') {
	$exp_cfg = $admin_op->h_array($infos['ctype'], $activitytype);
	$admin_op->batch_exp($exp_cfg, $counts, $infos['ctype']);
}


// 总会登录,统计数据不需要分页
if ( !$isClub ) {
	$page   =  _get_page(20);
	$page['item_count']=count($counts);
	$page = _format_page($page);
	$counts=array_chunk($counts, 20,true );
	$counts = $counts[$page[curr_page]-1];
}



/*if($_POST['act']=='steam'){
	$where.="deltag='0' and agree='2'";
	if($_POST['next']==1){
		$parentid=$db->get_one("form__bjhh_area","sign='{$_POST['organ']}'",'areaid');
		$where.="and (sign='{$_POST['organ']}' or parentid='{$parentid[areaid]}')";
	}else{
		$where.=" and sign='{$_POST['organ']}'";
	}
	if($_POST['teamkey'])$where.=" and serviceteamname like '%{$_POST['teamkey']}%'";
	if($_POST['stime']) {$stime=strtotime($_POST['stime'].'00:00:00'); $where.=" and foundingtime >=$stime";}
	if($_POST['etime']) {$etime=strtotime($_POST['stime'].'23:59:59'); $where.=" and foundingtime <=$etime";}
	if($_POST['ctype']) {$ctype=$_POST['ctype']; $where.=" and  ((serviceclassification_checkbox='{$ctype}') or (serviceclassification_checkbox like '{$ctype},%') or  (serviceclassification_checkbox like '%,{$ctype}') or (serviceclassification_checkbox like '%,{$ctype},%'))";}

	$cate=$db->getall('form__bjhh_serviceteammanage_addserviceteam',$where,array(limit=>'0,9999999'), 'serviceteamname');
	$html='<div id="hid_abs">';
	if(!$cate) $html.='<div class="hid_son" style="width:110px; float:left; overflow:hidden; padding-left:10px; cursor:pointer">暂无数据</div>';
	foreach ($cate as $v) {
		$html.='<div class="hid_son" style="width:110px; float:left; overflow:hidden; padding-left:10px; cursor:pointer"><a title="'.$v['serviceteamname'].'" id="tname">'.$v['serviceteamname'].'</a></div>';
	}
	$html.='<div  id="hid_btn"><input type="button" value="关闭" class="btn" /></div></div>';
	echo $html; exit();
}*/
include get_admin_tpl('serviceobjCount');
?>