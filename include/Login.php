<?php

include_once ("Xxtea.php");


/**
 * 
 * 志愿者登录注册类
 */
class Login  {
	
	public  $db;
	public $xxtea;
	
	public function __construct() {
		global $db;
		$this->db=$db;
		$this->xxtea=new Xxtea();
	}

	public function login($username,$password) {
		$username=get_input($username);
		$password=get_input($password);
		$get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$username' ") ;
		if(!$get_one) return -1;//用户名错误
		else if(password($password, $get_one['encrypt'])!=$get_one['password']) return -2;//密码错误
		//else if($get_one['status']=='100' ) return -3;//用户已注销
		else if($get_one['status']=='011') return -4;//初审被拒绝
		$_SESSION['code']=$this->xxtea->createLoginIdentify($get_one['recordid'], $username);
		//获取最后登录sessionid
		unlink(USERLOG_PATH.'ss_'.$get_one['last_session']);
		$sessionid=session_id();
		$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo',"last_session='{$sessionid}'","username='$username' ");
		$file= USERLOG_PATH.'ss_'.$sessionid;
		$userfile = fopen("$file",w);
		fclose($userfile);
		return 1;
	}

	public function loginAjax($username,$password) {
		$get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$username' ") ;
		if(!$get_one) return -1;//用户名错误
		else if(password($password, $get_one['encrypt'])!=$get_one['password']) return -2;//密码错误
		//else if($get_one['status']=='100' ) return -3;//用户已注销
		else if($get_one['status']=='011') return -4;//初审被拒绝

		$_SESSION['code']=$this->xxtea->createLoginIdentify($get_one['recordid'], $username);
		//获取最后登录sessionid
		unlink(USERLOG_PATH.'ss_'.$get_one['last_session']);
		$sessionid=session_id();
		$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo',"last_session='{$sessionid}'","username='$username' ");
		$file= USERLOG_PATH.'ss_'.$sessionid;
		$userfile = fopen("$file",w);
		fclose($userfile);
		return 1;
	}
	
	public function register($username,$password) {
		$username=get_input($username);
		$password=get_input($password);
		if(!is_username($username)) {
			return -1;//用户名不符合规定
		}
		if(!is_password($password)) {
			return -2;//密码不符合规定
		}
		$encrypt=get_rand_str(6);
		$datas['username']=$username;
		$datas['password']=password($password, $encrypt);
		$datas['applytime']=time();
		$datas['status']="1000";
		$datas['encrypt']=$encrypt;
		$get_one=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',  " username='$username' ") ;
		if($get_one ) {
			return -3;//用户名已被注册
		}
		$insert_id=$this->db->add('form__bjhh_volunteermanage_volunteerbasicinfo', $datas) ;
		if(!$insert_id) {
			return -4;//注册失败
		}
		$_SESSION['code']=$this->xxtea->createLoginIdentify($insert_id, $username);
		return $insert_id;//注册成功
	}
		
   public function logout($tips){
		setcookie('code','',time()-1,'/','.honghui.com');
		setcookie('etime','',time()-1,'/','.honghui.com');
		unset($_COOKIE['etime']);
		if(isset($_SESSION['code'])) {
		unset($_SESSION['code']);
		unset($_SESSION);
		}
		$this->db->get_show_msg("index.php","$tips");
	}
	
}

?>