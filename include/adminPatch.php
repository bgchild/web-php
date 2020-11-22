<?php
include_once('adminBase.php');
require_once ('../admin/PHPExcel.php');

class adminPatch extends adminbase {

	public function __construct() {
		parent::__construct ();
	}

	public function getTypes($typename) {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder desc');
	}

	public function checkType($type_name,$val){
		$types=$this->getTypes($type_name);
		foreach($types as $k=>$v){
			if($v['name']==$val) return $v['id'];
		}
		return false;
	}

	public function check($arr){
		//必填的为空不能入库
		//数据库中已经有的不能入库-->在addInfo中判断
		//不满足数据格式的不能入库
		for($i=0;$i<10;$i++){
			if(!$arr[$i]) {
				$arr['emsg']= '请检查必填项';
				return $arr;
			}
		}
		$arr['emsg'] = 'pass';
		$birthday=$arr[3];
	    $pattern="/^((?:19|20)\d\d)-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/";
		if(!preg_match ($pattern ,$birthday)){
			$arr['emsg']= '出生年月有误';
			return $arr;
			} 
		//判断志愿者编码是否为22位
		if(!$arr['27']){
			$arr['emsg']= '志愿者编码有误';
			return $arr;
			}
		$length = strlen($arr['27']);
		if($length!='22'){
			$arr['emsg']= '志愿者编码22位';
			return $arr;
			}
		$nationality=$this->checkType('国籍',trim($arr[5]));
		if($nationality) $arr['5']=$nationality;
		$race=$this->checkType('民族',trim($arr[6]));
		if($race) $arr['6']=$race;
		$idtype=$this->checkType('证件类型',trim($arr[7]));
		if($idtype) $arr['7']=$idtype;
		return $arr;
	}

	public function addInfo($arr){
		$data=array();
		$encrypt=get_rand_str(6);
		$data['encrypt']=$encrypt;
		$data['password']=password('123456', $encrypt);
		$data['status']='001';
		$data['applytime']=time();
		$data['name']=trim($arr[0]);
		$data['sex']=($arr[1]=='男')?1:2;
		$data['username']=trim($arr[2]);
		$data['nickname']=trim($arr[2]);
		$data['birthday']=intval(strtotime($arr[3]));
		$data['detailplace']=trim($arr[4]);
		$data['nationality']=trim($arr[5]);
		$data['race']=trim($arr[6]);
		$data['idtype']=trim($arr[7]);
		$data['idnumber']=trim($arr[8]);
		$data['emails']=trim($arr[9]);
		$data['cellphone']=trim($arr[10]);
		$data['telephone']=trim($arr[11]);
		$politicalstatus=$this->checkType('政治面貌',$arr[12]);
		if($politicalstatus) $data['politicalstatus']=$politicalstatus;
		$data['postcode']=trim($arr[13]);
		$data['qq']=trim($arr[14]);
		$data['province']=trim($arr[15]);
		$data['city']=trim($arr[16]);
		$data['area']=trim($arr[17]);
		$data['serveprovince']=trim($arr[18]);
		$data['servecity']=trim($arr[19]);
		$data['servearea']=trim($arr[20]);
		if($arr[25])$data['allservertime']=trim($arr[25]);
		$data['sdomain']=trim($arr[26]);
		$data['hnumber']=trim($arr[27]);
		$data['sign']=$_SESSION[sign];
		$data['parentid']=$_SESSION['fid'];
		if($this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo'," idtype='".$arr[7]."' and idnumber='".$arr[8]."' or username='".trim($arr[2])."' or hnumber='".trim($arr[27])."'" )) return false;
		$insert_id=$this->db->add('form__bjhh_volunteermanage_volunteerbasicinfo',$data);
		if($insert_id<=0) return false;
		$cdata=array();
		$cdata['isstudent']=($arr[21]=='是')?1:2;
		$cdata['lasteducation']=$this->checkType('学历',$arr[22]);
		$cdata['graduatecollege']=trim($arr[23]);
		$cdata['major']=trim($arr[24]);
		$cdata['rid']=$insert_id;
		$this->db->add('form__bjhh_volunteermanage_volunteerextendinfo',$cdata);
		return true;
	}

}

?>