<?php
include_once ( "Xxtea.php");
/**
 * 
 * 活动页面activity
 */
class Activity{
	public  $db;
	public $xxtea;
    private $count=0;
	
	public function __construct() {
	global $db;
	$this->db=$db;
	$this->xxtea=new Xxtea();
	}
/**
 * 获取审核通过的活动
 */
	function getActivity($query,$limit){
		$where="status='3' and deltag='0' and sign='$_SESSION[sign]'";
		foreach ($query as $key =>$val){
		$val=trim($val);
	    if($key=='activityName' || $key=='activityAddr') {
	    $where.=" and $key like '%".$val."%' ";
	    continue;}
       $where.=" and $key='$val' ";
		}
		$a="form__bjhh_activityexamine_activityinfo";
        $this->count=$this->db->get_count($a,$where);
		$activity= $this->db->getall($a,$where,$limit = array(limit=>$limit),$fields = '*',$orders = 'order by creattime DESC');

		$type=$this->getActivityTypes();
		//格式化活动记录信息	  
		foreach($activity as $key=>$val){
			//已报名人数
			$val['people']=$this->db->get_count("form__bjhh_activity_personadd","uid=$val[recordid]");
			foreach ($type as $k=>$v){
			if($v['id']==$val['activityType']) {
				$val['typename']=$v['name'];
				break;}
			}
		$val['activityStartDate']=date("Y-m-d",$val['activityStartDate']);
		$val['activityEndDate']=date("Y-m-d",$val['activityEndDate']);
		$activity[$key]=$val;
}
return $activity;
	}


	function getActivityAjax($query,$limit, $lng, $lat, $sign="") {
		$where = "status='3' and deltag='0' ";

		if ( !$query['activityName'] ) {
			if ( !$this->checkUserLogin() ) {
				$where .= " and sign='$sign'";
			} else {
				$_sign = $this->getUser('sign');
				//var_dump($_sign);
				$where .= " and sign='$_sign'";
			}
		} else {
			$signs = [$sign];
			if ( $this->checkUserLogin() ) {
				array_push($signs, $this->getUser('sign'));
			}
			$signs = array_unique(array_filter($signs));
			$where .= " and sign IN ('".join(",", $signs)."')";
		}


		foreach ($query as $key =>$val){
			$val=trim($val);
			if($key=='activityName' || $key=='activityAddr') {
				$where.=" and $key like '%".$val."%' ";
				continue;}
			$where.=" and $key='$val' ";
		}
		$a="form__bjhh_activityexamine_activityinfo";
		$this->count=$this->db->get_count($a,$where);
		$orders = " order by ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS(('.$lng.' * 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380";
		$activity= $this->db->getall($a,$where,$limit = array(limit=>$limit),$fields = '*', $orders);


		$type=$this->getActivityTypes();
		//var_dump($type);

		//格式化活动记录信息
		foreach($activity as $key=>$val){
			//已报名人数
			$val['people']=$this->db->get_count("form__bjhh_activity_personadd","uid=$val[recordid]");
			foreach ($type as $k=>$v){
				if($v['id']==$val['activityType']) {
					$val['typename']=$v['name'];
					break;
				}
			}
			$val['activityStartDate']=date("Y-m-d",$val['activityStartDate']);
			$val['activityEndDate']=date("Y-m-d",$val['activityEndDate']);
			$activity[$key]=$val;
		}
		return $activity;
	}



		
	   /**
		 * 获取活动类型
		 */
public function getActivityTypes($type){
		$a='form__bjhh_dictbl';
	if($type) {
		$where="tcode='008' and id='$type'";
		$arr= $this->db->get_one($a,$where);
		return $arr['name'];
		}
		$where="tcode='008'";
		return $this->db->getall($a,$where);
	}
  public function getActivityCount(){
			return $this->count;
	 }
	/**
	 * 统计报名人数并判断
	 */
	public function countPeople($recordid,$planNum){
			$table="form__bjhh_activity_personadd";
			$people=$this->db->get_count($table,"uid=$recordid and status='2'");
			if(!$planNum){
	        return $people;}
	        if($planNum){
	        if($people >= $planNum) return $people;
	        else return false;
	        	}
	}
	/**
	 * 判断有没重复加入
	 */
	public function  isRepeat($recordid){
		$table="form__bjhh_activity_personadd";
		$uid=$this->getUser('0');
		$where="uid=$recordid and pid='$uid' and status!='3'";
        $repeat=$this->db->get_one($table,$where);
		if($repeat) return true;
		else return false;
	}
	/**
	 * 判断报名有没截止
	 */
	public function endTime($end){
		if($end<time()  ) return true;
		else return false;
	}
	/**
	 * 
	 * 加入活动
	 */
	public function addActivity($data){
		foreach ($data as $key=>$val){
			$data[$key]=$val;
		}
	     $datas['uid']=$data['rid']; 
	     $pid=$this->getUser('0');
	     if($pid)$volunteerinfo=$this->db->get_one("form__bjhh_volunteermanage_volunteerbasicinfo","recordid=$pid");
         $name = $volunteerinfo['name'];
	     $datas['pid']=$pid;
	     $datas['name']=$name;
	     $datas['addDate']= time();
	     $where="uid=$data[rid] and pid='$pid'";
	     $table="form__bjhh_activity_personadd";
	     $ist=$this->db->get_one($table,$where);
	     if($ist){
	     	$datas['status']='1';
	        $affected=$this->db->edit($table, $datas, $where);
	     }else{
	     	$affected=$this->db->add($table, $datas) ;
	     }
		 
		if($affected) return $affected;
		else return false;
	}
	 /**
	  * 
	  * 检查登入否
	  */
public function checkUserLogin() {
		if(isset($_SESSION['code'])){
			$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
			if(isset($arg[0]) && isset($arg[1]) && isset($arg[2])) return true;
			else return false;
		}
		else return false;
	}
	/**
	 * 是否属于会员注册地区
	 */
public function checkSign() {
		$sign=$this->getUser('sign');
		if($sign==$_SESSION['sign']) return true;
		else return false;
	}

	/**
	 * 是否属于会员注册地区
	 */
	public function checkSignAjax($rid = 0)
	{
		$sign = $this->getUser('sign');
		$table = 'form__bjhh_activityexamine_activityinfo';
		$where = "recordid='$rid' ";
		$info = $this->db->get_one($table, $where);
		if ($sign == $info['sign']) return true;
		else return false;
	}

	/**
	 * 检查权限
	 */
public function checkPower(){
	$rid=$this->getUser('0');
	$table="form__bjhh_volunteermanage_volunteerbasicinfo";
	$arr=$this->db->get_one($table,"recordid='$rid'");
	if($arr['status']!='001' && $arr['status']!='010'  ) return true;
	else return false;
}

	/**
	 * 获取登入信息
	 */
public function getUser($i){
	 	$userArr = array();
		$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
		$userArr = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='$arg[0]'");	
		$arg['sign'] = $userArr['sign'];
		$arg['parentid'] = $userArr['parentid'];
		return $arg[$i];
	}
	
  /**
   * 判断数据库是否存在传过来的$rid
   */
  public function checkrid($rid){
  	$where="recordid='$rid'";
  	$result=$this->db->get_count("form__bjhh_activityexamine_activityinfo",$where);
    if($result) return true;
    else return false;
  }
  
	/**
	 * 获取一条详细记录
	 */
	public function getDetailActivity($rid){
		$a='form__bjhh_activityexamine_activityinfo';
		$b='form__bjhh_serviceteammanage_addserviceteam';
        $fields="a.recordid as arecordid ,a.*,b.*";
        $where = "a.recordid='$rid' and a.serviceid=b.recordid";
        /*if ( $_SESSION[sign] ) {
            $where .= " and a.sign='$_SESSION[sign]'";
        }*/
        $records=$this->db->get_relations_one($a, $b, $where,$fields);

        if(!$records) return $records;
		//格式化个人活动记录信息	  
        $records['activityType']=$type=$this->getActivityTypes($records['activityType']);
		$records['creattime']=date("Y-m-d G:i:s",$records['creattime']);
	    $records['activityStartDate']=date("Y-m-d G:i",$records['activityStartDate']);
		$records['activityEndDate']=date("Y-m-d G:i",$records['activityEndDate']);
        $records['cid']=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='$records[cid]'");
        return $records;

		}

}

   
	?>