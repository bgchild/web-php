<?php

include_once ("user.php");

/**
 * 
 * 用户消息管理类
 *
 *   1.服务时间异议 
 *   3.邀请加入服务队 
 *   4.邀请加入活动 
 *   5.服务队队员之间的消息 
 *   6.活动报名者之间的消
 *   7.活动报名者放弃信息
 *   8.拒绝加入某个服务队
 *   9.拒绝加入某个活动
 *   10.同意加入某个服务队
 *   11.同意加入某个活动
 *   12.活动被取消
 *   13.活动被改期
 *	 14.活动人员被批准或被拒绝加入活动  
 *	 15.被授予队长资格  
 *	 16.被取消队长资格  
 *	 17.服务队同意某人加入 
 *	 18.服务队拒绝某人加入 
 *   19.被任命为队长 
 *	 20.被取消队长 
 *	 21.被任命为副队长 
 *	 22.被取消副队长 
 *	 23.删除队员 	
 *	 24.退出服务队 
 *	 25.星级信息改变推送消息
 *
 */
class UserMsg  extends user{
	
	private $count=0;
	
	public function __construct() {
		parent::__construct ();
	}

	
	public function getRecordsByIsread($isread,$limit){
		$toid=$this->getUser(0);
		$q2="  toid='".$toid."' and isdel='0' ";
		$isread=$isread?$isread:0;
		$q2.="  and isread='".$isread."'";
		$this->count=$this->db->get_count('form__bjhh_message', $q2);
		$records= $this->db->getall( 'form__bjhh_message', $q2, array(limit=>$limit),'*',' order by recordid DESC');
		foreach($records as $k=>$v) {
			$v['date']=date("Y-m-d H:i:s ",$v['date']);
			$v['truecontent']=$v['content'];
			$acti1=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteam', " recordid='".$v['fno']."' ");
			$acti2=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid='".$v['fno']."' ");
			if($v['status']=='1'){
		        $v['content']="志愿者【$v[fromname]】对活动【".$acti2[activityName]."】有服务时间异议 ！";
			}
			if($v['status']=='5') {
				$sp=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson', " serviceteamcaptainid='".$v['fromid']."' and serviceteamid='".$v['fno']."'");
		        if($sp['captain']=='1') $stitle='队长';
		        else if($sp['captain']=='2') $stitle='副队长';
		        else if($sp['captain']=='3') $stitle='队员';
		        $v['content']="服务队【".$acti1['serviceteamname']."】中$stitle 【".$v['fromname']."】给您发送了一条消息！";
			}
			if($v['status']=='6'){
		        $v['content']="活动【".$acti2[activityName]."】中队员【".$v['fromname']."】给您发送了一条消息！";
			}
			if($v['status']=='7'){
		        $v['content']="活动队员【".$v['fromname']."】放弃了活动【".$acti2[activityName]."】！";
			}
			if($v['status']=='12'){
		        $v['truecontent']=$acti2['cancelreason'];
			}
			if($v['status']=='13'){
				$start=date("Y-m-d H:i",$acti2[activityStartDate]);
				$end=date("Y-m-d H:i",$acti2[activityStartDate]);
		        $v['truecontent']="活动【$acti2[activityName]】因为【$acti2[changereason]】，所以日期变更为 【 $start 至 $end 】 ";
			}
			if($v['status']=='15'){
		        $v['content']="您被管理员授予队长资格";
		        $v['truecontent']="恭喜恭喜，您被管理员授予队长资格";
			}
			if($v['status']=='16'){
		        $v['content']="您被管理员取消了队长资格";
		        $v['truecontent']="很遗憾的通知您，您被管理员取消了队长资格";
			}
			if($v['status']=='17'){
		        $v['content']="服务队【".$acti1['serviceteamname']."】同意您加入了";
		        $v['truecontent']="服务队【".$acti1['serviceteamname']."】同意您加入了，恭喜恭喜！希望您能多为服务队【".$acti1['serviceteamname']."】做贡献，发光发热！";
			}
			if($v['status']=='18'){
		        $v['content']="服务队【".$acti1['serviceteamname']."】拒绝您加入了";
		        $v['truecontent']="很遗憾，服务队【".$acti1['serviceteamname']."】拒绝您加入了，亲 ，不要气馁，可以再次尝试！";
			}
			if($v['status']=='19'){
		        $v['content']="您已经成为服务队【".$acti1['serviceteamname']."】的队长了";
		        $v['truecontent']="恭喜恭喜，您已经成为服务队【".$acti1['serviceteamname']."】的队长了";
			}
			if($v['status']=='20'){
		        $v['content']="您已经不再是服务队【".$acti1['serviceteamname']."】的队长了";
		        $v['truecontent']="很遗憾的通知您，您已经不再是服务队【".$acti1['serviceteamname']."】的队长了";
			}
			if($v['status']=='21'){
		        $v['content']="您已经成为服务队【".$acti1['serviceteamname']."】的副队长了";
		        $v['truecontent']="恭喜恭喜，您已经成为服务队【".$acti1['serviceteamname']."】的副队长了";
			}
			if($v['status']=='22'){
		        $v['content']="您已经不再是服务队【".$acti1['serviceteamname']."】的副队长了";
		        $v['truecontent']="很遗憾的通知您，您已经不再是服务队【".$acti1['serviceteamname']."】的副队长了";
			}

			if($v['status']=='3') 
			    $act=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson', " serviceteamcaptainid='".$v['toid']."' and serviceteamid='".$v['fno']."' and sp_status in ('1','2') ");
			if($v['status']=='4') 
				$act=$this->db->get_one('form__bjhh_activity_personadd', " pid='".$v['toid']."' and uid='".$v['fno']."' and status in ('1','2','4')");
			if($act) {
					$v['act']='已加入';
					//避免阅读消息之前在其他地方加入活动或服务队而造成的数据不一致
					if(!$v['isdone']) {
						$datas['isdone']=1;
						$this->db->edit('form__bjhh_message', $datas, " recordid='".$v['recordid']."'");
					}
			}
			else if($v['isdone'] && !$act) $v['act']='已拒绝';
			else if(!$v['isdone'] && !$act) $v['act']="未操作";
			$records[$k]=$v;
		}
		return $records;
	}
	
	public function getRecordsByIsreadCount(){
			return $this->count;
	}
	
	public function getOneRecord($recordid){
		return  $this->db->get_one('form__bjhh_message', " recordid=".$recordid) ;
	}
	
	public function editRecord($datas){
		foreach($datas as $key=>$val) $datas[$key]=trim($val);
		$affected=$this->db->edit('form__bjhh_message', $datas, " recordid=".$datas['recordid']) ;
		if($affected) return $affected;
		else return false;
	}
	
	public function addin($mid,$status) {
		$msg=$this->getOneRecord($mid);
		if($status=='3' ) {//服务队
			$datas['serviceteamid']=$msg['fno'];
			$datas['serviceteamcaptainid']=$this->getUser(0);
			$datas['joinserviceteamdate']=time();
			$datas['sp_status']='2';
			if( !$this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson', " serviceteamid='".$datas['serviceteamid']."' and serviceteamcaptainid='".$datas['serviceteamcaptainid']."' ") ) {
				$this->db->add('form__bjhh_serviceteammanage_addserviceteamperson', $datas) ;
			}else{
				$this->db->edit('form__bjhh_serviceteammanage_addserviceteamperson', $datas, " serviceteamid='".$datas['serviceteamid']."' and serviceteamcaptainid='".$datas['serviceteamcaptainid']."' ");
			}
			$edata['recordid']=$mid;
			$edata['isdone']='1';
			$edata['isread']='1';
			$edata['isagree']='1';
			$this->editRecord($edata);
			$d['fromid']=$msg['toid'];
			$d['fromname']=$msg['toname'];
			$d['toid']=$msg['fromid'];
			$d['toname']=$msg['fromname'];
			$d['date']=time();
			$d['fno']=$msg['fno'];
			$d['status']='10';
			$t=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteam', " recordid=".$d['fno']);
			$d['content']="会员 【$d[fromname]】 同意加入您的服务队 【$t[serviceteamname]】";
			$this->db->add('form__bjhh_message', $d) ;
			return true;
		}else if($status=='4' ) {//活动
			$activity=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=".$msg['fno']) ;
			$datas['pid']=$this->getUser(0);
			$datas['uid']=$msg['fno'];
			//$datas['time']=$activity['predictHour'];
			$datas['addDate']=time();
			$datas['status']='2';
			$datas['name']=$this->getUser(1);
			if( !$this->db->get_one('form__bjhh_activity_personadd', " pid='".$datas['pid']."' and uid='".$datas['uid']."' ") ) {
				$this->db->add('form__bjhh_activity_personadd', $datas) ;
				$edata['recordid']=$mid;
				$edata['isdone']='1';
				$edata['isread']='1';
				$this->editRecord($edata);
				$d['fromid']=$msg['toid'];
				$d['fromname']=$msg['toname'];
				$d['toid']=$msg['fromid'];
				$d['toname']=$msg['fromname'];
				$d['date']=time();
				$d['fno']=$msg['fno'];
				$d['status']='11';
				$t=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=".$d['fno']);
				$d['content']="会员 【$d[fromname]】 同意加入您的活动 【$t[activityName]】";
				$this->db->add('form__bjhh_message', $d) ;
				return true;
			}
		}
		return false;
	}
	
	public function refuse($mid,$status){
		if($status=='4' || $status=='3') {
				$edata['recordid']=$mid;
				$edata['isdone']='1';
				$edata['isread']='1';
				$edata['isagree']='2';
				$this->editRecord($edata);
				$rdata=$this->db->get_one('form__bjhh_message', " recordid=".$mid);
				$d['fromid']=$rdata['toid'];
				$d['fromname']=$rdata['toname'];
				$d['toid']=$rdata['fromid'];
				$d['toname']=$rdata['fromname'];
				$d['date']=time();
				$d['fno']=$rdata['fno'];
				if($status=='3') {
					$d['status']='8';
					$t=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteam', " recordid=".$d['fno']);
					$d['content']="会员 【$d[fromname]】 拒绝加入您的服务队 【$t[serviceteamname]】";
				}else if($status=='4') {
					$d['status']='9';
					$t=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=".$d['fno']);
					$d['content']="会员 【$d[fromname]】 拒绝加入您的活动 【$t[activityName]】";
				}
				$this->db->add('form__bjhh_message', $d) ;
				return true;
		}
		return false;
	}
	
}

?>