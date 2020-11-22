<?php
include_once('adminBase.php');
include (INCLUDE_PATH . "search.php");
/**
 * 
 * 活动管理
 */
class adminActivity extends adminbase {
	private $search;
	
	public function __construct() {
		parent::__construct ();
	    $this->search=new Search();
	}

	/**
	 * 
	 * 活动列表
	 */	
	public function init($status,$keyword){		
		$arr=array();	
		$conditions = " status!='1' and sign='$_SESSION[sign]'  ";
		if($status!=1 && $status>0 )  $conditions = " status='$status'  ";
		if($keyword)$conditions.=" and activityName like '%$keyword%' ";
		$nowtime=time();
		$t=trim($_GET['t']);
		$vol_font='0';
		if($t=='7day'){
		$begintime=$nowtime-7*24*60*60;	
		$vol_font='7';
		}
		elseif($t=='30day'){
			$begintime=$nowtime-30*24*60*60;
			$vol_font='30';	
		}
		elseif($t=='90day'){
			$begintime=$nowtime-90*24*60*60;
			$vol_font='90';	
		}
		elseif($t=='180day'){
			$begintime=$nowtime-180*24*60*60;	
			$vol_font='180';
		}
		if($t)$conditions.="  and creattime>$begintime";
		$page   =  _get_page(10);   //获取分页信息
		$list = $this->db->getAll('form__bjhh_activityexamine_activityinfo',$conditions,array('limit'=>$page['limit']),'*'," order by status , recordid desc");
		$page['item_count'] = $this->db->get_count('form__bjhh_activityexamine_activityinfo',$conditions); 
		$page = _format_page($page);
		$arr['list']=$list;
		$arr['type1']=$this->getTypes("活动审核通过原因");
		$arr['type2']=$this->getTypes("活动审核拒绝原因");
		$arr['page']=$page;
		$arr['vol_font']=$vol_font;
		return $arr;
	}	
	/**
	 * 
	 * 活动详情
	 */	
	public function detail(){
		$spm=get_url($_GET['spm']);
	    if(!$spm)$this->db->get_show_msg('activity.php','参数错误！');
	    $where="recordid='$spm[id]'";
	    $info=$this->db->get_one("form__bjhh_activityexamine_activityinfo",$where);
		if(!$info)$this->db->get_show_msg('activity.php','参数错误！');
		$arr= $this->db->get_one("form__bjhh_serviceteammanage_addserviceteam"," recordid='".$info[serviceid]."'");
		$info['serviceteamname']=$arr['serviceteamname'];
		if($info['status']==3 or $info['status']==4 or $info['status']==5)
			$info=$this->changeType2Text($info,"活动审核通过原因",'statusreason','statusreasontext');
		else if ($info['status']==6)
			$info=$this->changeType2Text($info,"活动审核拒绝原因",'statusreason','statusreasontext');
	    $info['type1']=$this->getTypes("活动审核通过原因");
		$info['type2']=$this->getTypes("活动审核拒绝原因");
	    return $info;
	}

	/**
	 * 
	 * 批量通过操作
	 */
	public  function yes(){
		$ads=$_POST['aid'];
		$backurl=$this->getBackUrl('activity.php');
		if(!$ads)$this->db->get_show_msg($backurl,'请选择活动项目！');
		$datas=array();
		$datas['status']=3;
		$datas['auditor']=$this->getUserName();
		$datas['statusreason']=$_POST['statusreason'];
		$datas['statusremark']=$_POST['statusremark'];
		$ids= implode(',', $ads);
		$conditions="recordid in ($ids) and delTag=0 ";
		$result=$this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, $conditions);
		foreach($ads as $id) {
			$this->search->addInfo('1',$id);
			//给活动对应的服务队队员发送邀请消息
			$activity=$this->db->get_one("form__bjhh_activityexamine_activityinfo"," recordid= $id ");
			$persons= $this->db->getall("form__bjhh_serviceteammanage_addserviceteamperson"," serviceteamid=$activity[serviceid]");
			$rids=array();
			foreach($persons as $per) {$rids[]=$per['serviceteamcaptainid'];}
			$this->invite2Activity($rids,$id);
			$this->sendPassMsg('pass',$id);
		}
		//写入操作日志
		$arr=array();
		$arr[module]='4';
		$arr[type]='40';
		$this->doLog($arr);
		$this->db->get_show_msg($backurl,'批量通过操作成功！');
	}

	/**
	 * 
	 * 批量拒绝操作
	 */
	public  function no(){
	    $ads=$_POST['aid'];
		$backurl=$this->getBackUrl('activity.php');
		if(!$ads)$this->db->get_show_msg($backurl,'请选择活动项目！');
		$datas=array();
		$datas['status']=6;
		$datas['auditor']=$this->getUserName();
		$datas['statusreason']=$_POST['statusreason'];
		$datas['statusremark']=$_POST['statusremark'];
		$ids= implode(',', $ads);
		$conditions="recordid in ($ids)";
		$result=$this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, $conditions);
		foreach($ads as $id) {
			$this->sendPassMsg('notpass',$id);
		}
		//写入操作日志
		$arr=array();
		$arr[module]='4';
		$arr[type]='41';
		$this->doLog($arr);
		$this->db->get_show_msg($backurl,'批量拒绝操作成功！');
	}

	public function invite2Activity($rids,$aid){
		$activity=$this->db->get_one("form__bjhh_activityexamine_activityinfo"," recordid= $aid ");
		$per=$this->db->get_one("form__bjhh_volunteermanage_volunteerbasicinfo"," recordid= $activity[cid] ");
		$data['fromid']=$activity[cid];
		$data['fromname']=$per[username];
		$data['status']=4;
		$data['date']=time();
		$data['fno']=$aid;
		foreach($rids as $rid) {
			if($rid==$activity[cid]) continue;
			$data['toid']=$rid;
			$toperson=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=".$rid) ;
			$act=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid='".$aid."'") ;
			$data['toname']=$toperson['username'];
			$data['content']="活动 【".$act['activityName']."】 邀请您加入";
			if(!$this->db->get_one('form__bjhh_message', " fromid=".$data['fromid']." and toid=".$data['toid']." and status='4' and fno='".$aid."'") ) {
				$this->db->add('form__bjhh_message', $data) ;
			}else{
				//如果拒绝加入则继续发送邀请消息
				$msgone=$this->db->get_one('form__bjhh_message', " fromid=".$data['fromid']." and toid=".$data['toid']." and status='4' and fno='".$aid."' and isdone='1' ");
				$precord=$this->db->get_one('form__bjhh_activity_personadd',"uid='".$aid."' and pid='".$rid."' and status in('2','4')");
				if($msgone && !$precord){
					$this->db->add('form__bjhh_message', $data);
				}
			}
		}
	}

	public function sendPassMsg($pass,$activityid){
		$activityInfo=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid='".$activityid."'") ;
		$toperson=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=".$activityInfo['cid']) ;
		$sysuser=$this->getUser();
		$data['fromid']=$sysuser[0];
		$data['fromname']=$sysuser[1];
		$data['toid']=$activityInfo['cid'];
		$data['toname']=$toperson['username'];
		$data['status']=($pass=='pass'?26:27);
		$data['date']=time();
		$data['fno']=$activityid;
		if($pass=='pass') {
			$data['content']="恭喜您，您的活动 【$activityInfo[activityName]】 已经审核通过啦。。。";
		}else{
			$data['content']="抱歉，您的活动 【$activityInfo[activityName]】 没有通过审核。。。";
		}
		$this->db->add('form__bjhh_message', $data) ;
	}


	public function getTypes($typename) {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder desc');
	}
	private function changeType2Text($arr,$typename,$colname,$valname){
		$types=$this->getTypes($typename);
    	foreach($types as $type) 
    	 	if($arr[$colname]==$type['id'])
	    		$arr[$valname]=$type['name'];
		return $arr;
	}

}

?>