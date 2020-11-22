<?php

include_once ("user.php");


/**
 * 
 * 用户消息查看类 --- not captain
 */
class UserMsgShow  extends user{
	
	private $count=0;
	
	public function __construct() {
		parent::__construct ();
	}
	
	public function getActivityTypes($typename='活动类型') {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder desc');
	}
	
	private function _addExtInfo(&$arr,$tagname,$colname,$valname){
		$types=$this->getActivityTypes($tagname);
		foreach($arr as $k=>$v) {
				$skills=split(",", $v[$colname]);
				$skillnames="";
			    foreach($skills as $p) {
			    	 foreach($types as $type) 
			    	 	if($p==$type['id'])
			    	 		$skillnames.=$type['name'].","; 
			    }
			    $v[$valname]=substr($skillnames,0,-1)?substr($skillnames,0,-1):"无";
				$arr[$k]=$v;
		}
	}
	
	public function getServiceTeams($query,$limit = array(limit=>'0,9999999')){
		$q=" agree='2'  and deltag='0'  ";
		foreach($query as $key=>$val){
				$val=trim($val);
				if($val=="") continue;
				if( $key=='serviceteamname' ) {
					$q.=" and $key like '%".$val."%' ";
					continue;
				}
				if( $key=='foundingtime' ) {
					$val2= mktime(0, 0, 0, date("m",$val)  , date("d",$val)+1, date("Y",$val));
					$q.=" and $key>=$val and $key<=$val2 ";
					continue;
				}
				$q.=" and $key='$val' ";
			}
		$arr= $this->db->getall("form__bjhh_serviceteammanage_addserviceteam",$q, $limit, '*','  order by recordid DESC');
		$this->_addExtInfo($arr,"技能特长",'skills_checkbox',"skillnames");
		$this->_addExtInfo($arr,"服务项目",'serviceclassification_checkbox',"servicenames");
		return $arr;
	}
	
	public function getOneRecord($recordid){
		$one = $this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=".$recordid) ;
		if ( $one ) {
			if ( $one['activityProvince'] ) {
				$province = $this->db->get_one("pubmodule_area_tbl", " areaid=".$one['activityProvince']);
				if ( $province ) {
					$one['activityProvinceName'] = $province['areaName'];
				}
			}

			if ( $one['activityCity'] ) {
				$city = $this->db->get_one("pubmodule_area_tbl", " areaid=".$one['activityCity']);
				if ( $city ) {
					$one['activityCityName'] = $city['areaName'];
				}
			}

			if ( $one['activityArea'] ) {
				$area = $this->db->get_one("pubmodule_area_tbl", " areaid=".$one['activityArea']);
				if ( $area ) {
					$one['activityAreaName'] = $area['areaName'];
				}
			}
		}

		return $one;
	}
	
}

?>