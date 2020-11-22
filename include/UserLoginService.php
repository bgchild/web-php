<?php

include_once ("user.php");

/**
 * 
 * 志愿者登陆基础服务类
 */

class UserLoginService extends user {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function logout() {
		unset($_SESSION['code']);
	}
	
	public function changePassword($pre_password,$new_password,$repeat) {
		$pre_password=get_input($pre_password);
		$new_password=get_input($new_password);
		$repeat=get_input($repeat);
		$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
		$get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  "recordid=".$arg[0]) ;
		if(password($pre_password, $get_one['encrypt'])!=$get_one['password']){
			return -1;//原密码不对
		}else if($new_password!=$repeat) {
			return -2;//两次输入的密码不对
		}else if(!is_password($new_password)){
			return -3;//密码格式不符合规则
		}else {
			$encrypt=get_rand_str(6);
			$datas['password']=password($new_password, $encrypt);
			$datas['encrypt']=$encrypt;
			if($this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, "recordid=".$arg[0])>0) 
				return 1;//修改密码成功
			else return -4;//修改失败
		}
		
	}

	public function withdraw($reasons){
		$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
		$datas['status']="100";
		$datas['logoutedtime']=time();
		$reason="";
		foreach($reasons as $val) {
			$reason.=$val."||||";
		}
		$reason=substr($reason,0,strlen($reason)-4);
		$datas['logoutedreason']=$reason;
	    if($this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, "recordid=".$arg[0])>0) {
	    	//$this->logout();
			return true;
		}else{
			return false;
		}
	}

	public function getTypes($typename) {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder desc');
	}
	public function changeType2Text($arr,$typename,$colname,$valname){
		$types=$this->getTypes($typename);
    	foreach($types as $type) 
    	 	if($arr[$colname]==$type['id'])
	    		$arr[$valname]=$type['name'];
		return $arr;
	}

	public function getUserSessionInfo() {
		return $this->xxtea->parseLoginIdentify($_SESSION['code']);
	}

	
}

?>