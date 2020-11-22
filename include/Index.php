<?php
include_once ("Login.php");
/**
 * 
 * 首页index.php
 */
class Index extends Login{
  
	public function __construct() {
    	parent::__construct();
    	$this->daily();
	}
	/**
	 * 志愿服务活动
	 */
	public function getActivity($num='8', $sign=""){
		$table='form__bjhh_activityexamine_activityinfo';
		if ( !empty($sign) ) {
			$where="status='3' and deltag='0' and sign='$sign'";
		} else {
			$where="status='3' and deltag='0' and sign='$_SESSION[sign]'";
		}

		$limt=array(limit=>"0,$num");
		$order="order by creattime  DESC";
		$activity=$this->db->getall($table,$where,$limt ,$fields = '*',$order);
	    return $activity;
	}
	/**
	 * 志愿服务队
	 */
	public function getTeam($num='8', $sign=""){
		$table="form__bjhh_serviceteammanage_addserviceteam";
		if ( $sign ) {
			$where="agree='2' and deltag='0' and sign='$sign'";
		} else {
			$where="agree='2' and deltag='0' and sign='$_SESSION[sign]'";
		}

		$limt=array(limit=>"0,$num");
		$order="order by foundingtime  DESC";
		$team=$this->db->getall($table,$where,$limt ,$fields = '*',$order);
	    return $team;
	}
	/**
	 * 获取flash信息
	 */
	public function getflash($num='5', $sign=""){
	   $table="form__bjhh_flash";
		if ( $sign ) {
			$where="sign='$sign'";
		} else {
			$where="sign='$_SESSION[sign]'";
		}

	   $limit=array(limit=>"0,$num");
	   $order=" order by orderlist  ASC";
	   $info=$this->db->getall($table,$where,$limit,'*',$order);
	   if(!$info)  $info=$this->db->getall($table,"sign='www'",$limit,'*',$order);
	   return $info;
	}
	
	public function getContactInfo($sign=""){
		if ( !empty($sign) ) {
			$where="sign='$sign'";
		} else {
			$where="sign='$_SESSION[sign]'";
		}

		return $this->db-> get_one('form__bjhh_contact',$where);
	}
	public function getAboutInfo($sign=""){
		if ( !empty($sign) ) {
			$where="sign='$sign'";
		} else {
			$where="sign='$_SESSION[sign]'";
		}
		return $this->db-> get_one('form__bjhh_about',$where);
	}
	public function checkLogin() {
		if(isset($_SESSION['code'])){
			$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
			if(isset($arg[0]) && isset($arg[1]) && isset($arg[2])) return $this->getUser(1);
			else return false;
		}
		else return false;
	}
	
   public function getUser($i){
		$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
		return $arg[$i];
	}
	
	public function daily(){
		if(!isset($_SESSION['checktime'] )) $_SESSION['checktime'] =time();
		if(time()>=$_SESSION['checktime'] ) {
			$_SESSION['checktime'] =time()+60*60;
			set_time_limit(0);
			ignore_user_abort(true);
			$nowtime=time();
			$arr=$this->db->getall("form__bjhh_activityexamine_activityinfo", " deltag='0' and status='3' and activityEndDate<$nowtime" );
			foreach($arr as $k=>$v) {
			/*	$v['status']=4;
				$this->db->edit("form__bjhh_activityexamine_activityinfo", $v, " recordid=".$v['recordid']);
				$v2['status']=4;
				$this->db->edit("form__bjhh_activity_personadd", $v2, " uid=".$v['recordid']." and status='2' ");*/
				$sarr[]=$v['recordid'];
			}
			if($sarr){
				/*$str=implode(',',$sarr);
				$data['status']=4;
				$this->db->edit("form__bjhh_activityexamine_activityinfo",$data,"recordid in ".'('.$str.')');
				$this->db->edit("form__bjhh_activityexamine_activityinfo",$data,"recordid in ".'('.$str.') and status=2');*/
			}

			$arr=$this->db->getall("form__bjhh_volunteermanage_volunteerbasicinfo", " status='001' and allservertime >= 20 " );
			foreach($arr as $k=>$v) {
				/*$v['status']='010';
				$this->db->edit("form__bjhh_volunteermanage_volunteerbasicinfo", $v, " recordid=".$v['recordid']);*/
				$varr[]=$v['recordid'];
			}
			if($varr){
				$vstr=implode(',',$varr);
				$data['status']='010';
				$this->db->edit("form__bjhh_volunteermanage_volunteerbasicinfo",$data,"recordid in ".'('.$vstr.')');
			}
	 }
	}
	
}
   
	?>