<?php
/**
 * 
 * 找回密码
 */
include_once ("Login.php");
class findpsw {

	public $db;
	public function __construct() {
		global $db;
		$this->db = $db;
	}
	
	//验证用户名是否存在
	public function checkUser($uname){
		//$username=get_input($username);
		$get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$uname' ") ;
		if(!$get_one) return -1;//用户名错误
		else if($get_one['status']=='100' ) return -3;//用户已注销
		else if($get_one['status']=='011') return -4;//初审被拒绝
		return 1;
	}

	// 获取用户
	public function getUserByCellphone($cellphone) {
		return $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " cellphone='$cellphone' ") ;
	}

//找到问题	
public function getTypes($uname) {
	    $get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$uname' ") ;
		if($get_one){
			$question = $this->db->get_one('form__bjhh_dictbl',  " id='$get_one[question]' ") ;
		}
		return $question;
	}

	/**
	 * 获取手机号码
	 */
	public function getCellPhone($uname) {
		$get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$uname' ") ;
		if($get_one){
			return $get_one['cellphone'];
		}
	}
	
	//改密码
	public function changePassword($username,$answer,$new_password,$repeat) {
		$uname=get_input($username);
		$answer=get_input($answer);
		$new_password=get_input($new_password);
		$repeat=get_input($repeat);
		//验证问题是否正确
		 if($username){
		 		 $get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$uname' ") ;
		 }	
         if($answer!=$get_one['passwordtip']){
         	return -1;//回答问题不对
         }else{
	 			if($new_password!=$repeat) {
					return -2;//两次输入的密码不对
				}else if(!is_password($new_password)){
					return -3;//密码格式不符合规则
				}else {
					$encrypt=get_rand_str(6);
					$datas['password']=password($new_password, $encrypt);
					$datas['encrypt']=$encrypt;
					if($this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, " username='$uname' ")>0) 
						return 1;//修改密码成功
					else return -4;//修改失败
				}
		
         }
	}


	/**
	 * 更新为新密码
	 * by itshajia
	 */
	public function changeNewPassword($username, $new_password) {
		$encrypt = get_rand_str(6);
		$datas['password'] = password($new_password, $encrypt);
		$datas['encrypt'] = $encrypt;
		if($this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, " username='$username' ")>0)
			return true;//修改密码成功
		else return false; //修改失败
	}

}

?>