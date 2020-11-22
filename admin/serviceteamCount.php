<?php
include_once('../global.php');
include_once(INCLUDE_PATH.'serviceteamCount.php');
$admin_op=new serviceteamCount();
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
//获取组织机构
$sign=$admin_op->getCityInfo();
$level=$admin_op->getorganization($sign['areaid']);
//获取服务类别
$severtype = $db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
//var_dump($severtype);

$infos=get_url($_GET['info']);
$searchItems=array('ctype','time_start','time_stop','secity','lower'); 
if(isset($_GET['doSearch'])){
	foreach ($searchItems as $v){
		if($_GET[$v]) {
		$infos[$v]=$_GET[$v];
		echo $infos[$v]."<br/>";
		$query=$infos;
		}
		header("Location:serviceteamCount.php?info=".set_url($infos));
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
if($_GET['act']=='batch_exp') $admin_op->batch_exp($counts, $severtype);
// 不需要分页
/*$page   =  _get_page(20);
$page['item_count']=count($counts);
$page = _format_page($page);
$counts=array_chunk($counts, 20,true );
$counts = $counts[$page[curr_page]-1];*/
include get_admin_tpl('serviceteamCount');
?>