<?php

include_once ("user.php");

/**
 * 
 * 志愿者首页类
 */
class UserIndex extends user {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function getCurrentUserInfo(){
		$recordid=$this->getUser(0);
		return $this->db->get_one("form__bjhh_volunteermanage_volunteerbasicinfo", " recordid='$recordid' "); 
	}

	public function getNextTime__back(){
		$one=$this->getCurrentUserInfo();
		$currentTime=$one['allservertime'];
		$curr=array();
		if($currentTime<0) return false;
		if($currentTime>=0 && $currentTime<100) {$curr['star']=0;$curr['next']=100-$currentTime;}
		else if($currentTime>=100 && $currentTime<300) {$curr['star']=1;$curr['next']=300-$currentTime;}
		else if($currentTime>=300 && $currentTime<600) {$curr['star']=2;$curr['next']=600-$currentTime;}
		else if($currentTime>=600 && $currentTime<1000) {$curr['star']=3;$curr['next']=1000-$currentTime;}
		else if($currentTime>=1000 && $currentTime<1500) {$curr['star']=4;$curr['next']=1500-$currentTime;}
		else if($currentTime>=1500 ) {$curr['star']=5;$curr['next']=0;}
		if($_SESSION['starlevel']!=$curr['star']){
			//推送星级消息
			$uid=$this->getUser(0);
			$stars=$this->db->getall('form__bjhh_message', " toid=$uid and status=25 and isdone=0 ");
			$maxStar=0;
			foreach($stars as $key=>$val){
				if($val['starlevel']>$maxStar) $maxStar=$val['starlevel'];
			}
			if($maxStar!=$curr['star']) {
				$this->sendMsg($curr['star'],$maxStar);
			}
			$_SESSION['starlevel']=$curr['star'];
		}
		return $curr;
	}
	public function getNextTime(){
		$one=$this->getCurrentUserInfo();
		$currentTime=$one['allservertime'];
		$curr=array();
		if($currentTime<0) return false;
		if($currentTime>=0 && $currentTime<100) {$curr['star']=0;$curr['next']=100-$currentTime;}
		else if($currentTime>=100 && $currentTime<300) {$curr['star']=1;$curr['next']=300-$currentTime;}
		else if($currentTime>=300 && $currentTime<600) {$curr['star']=2;$curr['next']=600-$currentTime;}
		else if($currentTime>=600 && $currentTime<1000) {$curr['star']=3;$curr['next']=1000-$currentTime;}
		else if($currentTime>=1000 && $currentTime<1500) {$curr['star']=4;$curr['next']=1500-$currentTime;}
		else if($currentTime>=1500 ) {$curr['star']=5;$curr['next']=0;}
		$curr['time'] = $currentTime;
		if($_SESSION['starlevel']!=$curr['star']){
			//推送星级消息
			$uid=$this->getUser(0);
			$stars=$this->db->getall('form__bjhh_message', " toid=$uid and status=25 and isdone=0 ");
			$maxStar=0;
			foreach($stars as $key=>$val){
				if($val['starlevel']>$maxStar) $maxStar=$val['starlevel'];
			}
			if($maxStar!=$curr['star']) {
				$this->sendMsg($curr['star'],$maxStar);
			}
			$_SESSION['starlevel']=$curr['star'];
		}
		return $curr;
	}

	public function sendMsg($starlevel,$prelevel){
		$data['fromid']=0;
		$data['fromname']='System';
		$data['status']=25;
		$data['date']=time();
		$data['toid']=$this->getUser(0);
		$data['toname']=$this->getUser(1);
		$data['starlevel']=$starlevel;
		if($prelevel > $starlevel){
			$data['content']="遗憾的是，您从 $prelevel 星级 掉到了 $starlevel 星级！";
			$uid=$this->getUser(0);
			$changeStars=$this->db->getall('form__bjhh_message', " toid=$uid and status=25 and isdone=0 and starlevel>=$starlevel ");
			foreach($changeStars as $key=>$val) {
				$d['isdone']='1';
				$this->db->edit('form__bjhh_message',$d, " recordid=".$val[recordid]);
			}
		} else {
			$data['content']="恭喜您从 $prelevel 星级 升到了 $starlevel 星级！";
		}
		$this->db->add('form__bjhh_message', $data) ;
	}
	
	public function getNotreadCount(){
		$toid=$this->getUser(0);
		$q="  toid='".$toid."'  and isread='0' and isdel='0' ";
	   return $this->db->get_count('form__bjhh_message', $q);
	}

	public function active($recordid){
		$data['status']="1000";
		return $this->db->edit("form__bjhh_volunteermanage_volunteerbasicinfo", $data, "recordid=$recordid");
	}

}

?>