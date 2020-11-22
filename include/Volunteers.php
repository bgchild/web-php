<?php
include_once ( "Xxtea.php");
/**
 * 
 * 志愿者风采volunteers.php
 */
class Volunteers{
	public  $db;
	public $xxtea;
    private $count=0;
	
	public function __construct() {
	global $db;
	$this->db=$db;
	$this->xxtea=new Xxtea();
	}
/**
 * 获取审核通过的志愿者
 */
	function getVolunteers($query,$limit){
		$where="a.recordid=b.rid and a.status='001'";
		foreach ($query as $key =>$val){
		$val=trim($val);
	    if($key=='username') {
	    $where.=" and $key like '%".$val."%' ";
	    continue;}
        $where.=" and $key='$val' ";
		}
		$a="form__bjhh_volunteermanage_volunteerbasicinfo";
		$b="form__bjhh_volunteermanage_volunteerextendinfo";
        $this->count=$this->db->get_relations_count($a, $b, $where);
		$volunteer= $this->db->get_relations_info($a, $b, $where,$limit = array(limit=>$limit));
		//格式化个人服务信息	  
		foreach($volunteer as $key=>$val){
			$val['province']=$this->getAreas($val['province']);
			$val['serveitem'] = $this->getTypesName($val['serveitem'],2);
			$val['features'] = $this->getTypesName($val['features'],2);
		    $volunteer[$key]=$val;
         }
		return $volunteer;
	}

	/**
	 * 通过ids获取志愿者列表
	 */
	public function getVolunteersByIds($ids) {
		$where = "a.recordid = b.recordid and a.recordid in (".join($ids, ",").") and a.status='010'";
		$a = "form__bjhh_volunteermanage_volunteerbasicinfo";
		$b = "form__bjhh_volunteermanage_volunteerextendinfo";
		$volunteer= $this->db->get_relations_info($a, $b, $where);
		//格式化个人服务信息
		foreach($volunteer as $key=>$val){
			$val['province']=$this->getAreas($val['province']);
			$val['serveitem'] = $this->getTypesName($val['serveitem'],2);
			$val['features'] = $this->getTypesName($val['features'],2);
			$volunteer[$key]=$val;
		}

		return $volunteer;
	}
            public function getVolunteerCount(){
			return $this->count;
	  }

	  /**
		 * 服务项目和服务技能字串处理
		 */
public function getTypesName($str,$num){
	if($str)	
	if(!strpos($str, ',')){
		$where="id=$str and fid='0' ";
	    $types= $this->db->get_one('form__bjhh_dictbl',$where);
	    $res=$types['name'];
	}else{
		$types=explode(',', $str,$num);
		foreach ($types as $val){
		$where="fid='0' and id='$val' ";
		$types= $this->db->get_one('form__bjhh_dictbl',$where);
	    if($types['name'])   $name.=$types['name']."、";
	}
	}
		 $res=substr($name, 0 ,-3);
		 return $res;
	}
	/**
	 * 地区
	 *   
     */
public function getAreas($str){
	if($str)
	$where="areaId=$str";
	$arr=$this->db->get_one('pubmodule_area_tbl',$where);
	return $arr['areaName'];
}
  /**
   * 判断数据库是否存在传过来的$rid
   */
  public function checkrid($rid){
  	$where="recordid=$rid";
  	$result=$this->db->get_count('form__bjhh_serviceteammanage_addserviceteam',$where);
    if($result) return true;
    else return false;
  }
   /**
	 * 获取一条详细记录
	 */
/*	public function getDetailServeteam($rid){
		$a='form__bjhh_serviceteammanage_addserviceteam';
		$records=$this->db->get_one($a,"recordid='$rid'");
		//格式化服务队信息	  
		$records['member']=$this->countPeople($rid);
		$records['areas']=$this->getAreas($records['areas']);
		$records['foundingtime']=date("Y-m-d G:i:s",$records['foundingtime']);
		$records['serveitem']=$this->getTypesName($records['serviceclassification_checkbox'],30);
		$records['skillitem']=$this->getTypesName($records['skills_checkbox'],30);
		return $records;
	}*/

}

   
	?>