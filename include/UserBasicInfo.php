<?php

include_once ("user.php");

/**
 * 
 * 我的基础信息
 */
class UserBasicInfo extends user {
	
public function __construct() {
			parent::__construct();
	}
	
/**
 * 
 * 得到用户基本信息
 */
	public function getBasicInfo($table){
		$username=$this->getUser(1);
		$where="username='$username' ";
		$info=$this->db->get_one($table,$where);
		return $info;
	}
/**
 * 获取志愿者服务意愿项目
 * 服务技能
 */
public function getTypes($tcode) {
		$a = "form__bjhh_dictbl";
		$where = "tcode=$tcode and state='1' and fid='0' ";
		$checkbox = $this->db->getall ( $a, $where,array(limit=>'0,9999999'), '*','order by listorder ASC' );
		foreach ( $checkbox as $k => $v ) {
			$rid = $v ['id'];
			$child_list = $this->db->getall ( $a, "fid=$rid ",array(limit=>'0,9999999'), '*','order by listorder ASC' );
			$checkbox [$k] ['child'] = $child_list;
		}
		return $checkbox;
	}
/**
 * 
 * 更新用户基本信息
 */
	public function edit($file){
		$username=$this->getUser("1");
		$where="username='$username' ";
	    foreach ($_POST['user'] as $k=>$val){
		   $data[$k]=trim($val);
            }	
	    if($_POST['user']['istrain']){$data['istrain']='on';}else{$data['istrain']='';}
		$data['birthday']=strtotime($_POST['birthday']);
		$data['province']=trim($_POST['province']);
		$data['city']=trim($_POST['city']);
		$data['area']=trim($_POST['area']);
        $data['serveprovince'] =trim($_POST['fwprovince']);
        $data['servecity'] =trim($_POST['fwcity']);
        $data['servearea'] =trim($_POST['fwarea']);
		$one=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $data,$where) ;
 	    $two=$this->editExtendInfo($file);
 	    $three=$this->editServicetime();
 	    if($one || $two || $three) return true;
 	    else return false; 
		}

	public function editBasicInfoAjax() {
		$username=$this->getUser("1");
		$where="username='$username' ";
		$data['nickname'] = trim($_POST['nickname']);
		$data['serveprovince'] = trim($_POST['serveprovince']);
		$data['servecity'] = trim($_POST['servecity']);
		$data['servearea'] = trim($_POST['servearea']);
		$data['sdomain'] = trim($_POST['sdomain']);
		$data['birthday'] = strtotime($_POST['birthday']);
		$data['nationality'] = trim($_POST['nationality']);
		$data['cellphone'] = trim($_POST['cellphone']);
		$data['province'] = trim($_POST['province']);
		$data['city'] = trim($_POST['city']);
		$data['city'] = trim($_POST['city']);
		$data['area'] = trim($_POST['area']);
		if ( $this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $data,$where) ) {
			return true;
		} else {
			return false;
		}
	}

	public function editExtendInfoAjax($data) {
		$recordid=$this->getUser(0);
		$where = "rid='$recordid' ";
		$table = "form__bjhh_volunteermanage_volunteerextendinfo";
		if ( $this->db->get_count($table, $where) ) {
			if ( $this->db->edit($table, $data,$where) ) {
				return true;
			}
		}

		return false;
	}
/**
 * 获取扩展信息
 */
	public function  getExtendInfo(){
		$recordid=$this->getUser(0);
		$where="rid='$recordid' ";
		$table="form__bjhh_volunteermanage_volunteerextendinfo";
		$info=$this->db->get_one($table,$where);
		return $info;
	}
/**
 * 添加或修改服务信息
 */
    public function editExtendInfo($file){
		$recordid=$this->getUser(0);
		$where="rid='$recordid' ";
		$table="form__bjhh_volunteermanage_volunteerextendinfo";
		foreach ( $_POST ['more'] as $k=>$val){
		   $data[$k]=trim($val);
            }	
		if($_POST['more'])  $data['rid']=$recordid;
		if($file) $data['moduleName']	=$file;
		$data['features']=implode(',',($_POST['features']));
        $data['serveitem']=implode(',',($_POST['serveitem']));
	    $exist =$this->db->get_count($table, $where);
        if($exist==0){
        	$affected=$this->db->add($table, $data);
	    }else{
	    	$affected=$this->db->edit($table, $data,$where);}
	   if($affected) return $affected;
	    else return false;
		}
	
/**
 * 
 * 修改服务时间
 */
    public function editServicetime(){
		$username=$this->getUser("1");
		$where="username='$username' ";
		$table="form__bjhh_service_time";
		$data['username']=$username;
		$data['am']=implode(',',($_POST['am']));
		$data['pm']=implode(',',($_POST['pm']));
		$data['night']=implode(',',($_POST['night']));
	    $exist =$this->db->get_count($table, $where);
        if($exist==0){
        	$affected=$this->db->add($table, $data);
	    }else{
	    	$affected=$this->db->edit($table, $data,$where);}
	   if($affected) return $affected;
	    else return false;
		}
}

?>
