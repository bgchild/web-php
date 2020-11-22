<?php
include_once ("Login.php");
include_once('../global.php');
include_once(INCLUDE_PATH.'adminVolunteer.php');
/**
 * 
 * 志愿者申请	
 */
class ApplyVolunteer extends Login {
	public $db;
	public $xxtea;
	public function __construct() {
		global $db;
		$this->db = $db;
		$this->xxtea = new Xxtea ();
	}
	/**
	 * 获取志愿者服务意愿项目
	 * 服务技能
	 */
	public function getTypes($tcode) {
		$a = "form__bjhh_dictbl";
		if($tcode=='sfz'){ $where = "name='身份证' and state='1' and fid='0' ";}else{
		$where = "tcode=$tcode and state='1' and fid='0' ";}
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
	 *注册成为一名志愿者
	 */
	public function register($file) {
		$username = get_input ( $_POST ['username'] );
		$password = get_input ( $_POST ['password'] );
		if (! is_username ( $username )) {
			$this->db->get_show_msg ( 'javascript:history.back(0)', '用户名不符合规定!' );
		}
		$repeat = $this->_check_username ( $username );
		if ($repeat)
			$this->db->get_show_msg ( 'javascript:history.back(0)', '用户名已被注册!' );
		$this->_check_password ( $_POST ['password'], $_POST ['rpassword'] );
		$data=array();
       foreach ($_POST['user'] as $k=>$val){
		   $data[$k]=trim($val);
            }	
		$data ['username'] =trim($username);
		$data ['birthday'] = strtotime ( $_POST ['birthday'] );
		$data ['province'] = trim ( $_POST ['province'] );
		$data ['city'] = trim ( $_POST ['city'] );
		$data ['area'] = trim ( $_POST ['area'] );
		$data ['serveprovince'] = trim ( $_POST ['serveprovince'] );
		$data ['servecity'] = trim ( $_POST ['scity'] );
		$data ['servearea'] = trim ( $_POST ['sarea'] );
		$data ['sign'] = $_SESSION['sign'];
		$data ['parentid']=$_SESSION['fid'];
		$data ['servearea'] = trim ( $_POST ['sarea'] );
		$data ['sdomain'] = trim ( $_POST ['sdomain'] );
		$encrypt = get_rand_str ( 6 );
		$data ['password'] = password ( $password, $encrypt );
		$data ['applytime'] = time ();
		if(get_url ( $_GET ['agree'] ) == "agreed"){$data ['status'] = "001";}
		else{$data ['status'] = "1000";}
		$data ['encrypt'] = $encrypt;
		$sessionid=session_id();
		$data['last_session']=$sessionid;
		$one = $this->db->add ( "form__bjhh_volunteermanage_volunteerbasicinfo", $data );
		if($one){
			//志愿者编码
			$this->pcode($one);
			$this->addExtendInfo ($file);
			$this->addServicetime ();
			$file= USERLOG_PATH.'ss_'.$sessionid;
			$userfile = fopen("$file",w);
			fclose($userfile);
			$_SESSION ['code'] = $this->xxtea->createLoginIdentify ( $one, $username );
		}else{
			$this->db->get_show_msg ( "javascript:history.back(0)", '注册失败!' );
		}
		unset($_SESSION['userinfo']['user']);
		unset($_SESSION['userinfo']['username']);
		unset($_SESSION['userinfo']['birthday']);
    	if(get_url ( $_GET ['agree'] ) == "agree"){
		$name = set_url ( aa );
		$this->db->get_show_msg ( "userPhoto.php?name=$name", '注册成功!' );}
		if(get_url ( $_GET ['agree'] ) == "agreed"){
			//log
			$admin_op=new adminVolunteer();
			$arr=array();
			$arr[type]='22';
			$arr[module]='2';
			$admin_op->doLog($arr);
			$this->db->get_show_msg("admin/volunteerManage.php",'添加成功');
		}
	}
	
	/**
	 * 添加服务信息
	 */
	public function addExtendInfo($file) {
		if ($_POST ['username'])
			$one = $this->db->get_one ( "form__bjhh_volunteermanage_volunteerbasicinfo", "username='$_POST[username]'" );
		else
			return false;
		foreach ( $_POST ['more'] as $k=>$val){
		   $data[$k]=trim($val);
            }	
		$data ['rid'] = "$one[recordid]";
		$data ['features'] = implode ( ',', ($_POST ['features']) );
		$data ['serveitem'] = implode ( ',', ($_POST ['serveitem']) );
		if($file) $data['moduleName']	=$file;
		$table = "form__bjhh_volunteermanage_volunteerextendinfo";
		$affected = $this->db->add ( $table, $data );
		if ($affected)
			return $affected;
		else
			return false;
	}


	public function addExtendInfoAjax($username, $data) {
		if ( $username ) {
			$one = $this->db->get_one ( "form__bjhh_volunteermanage_volunteerbasicinfo", "username='$username'" );
		} else {
			return false;
		}

		$data ['rid'] = $one['recordid'];
		$table = "form__bjhh_volunteermanage_volunteerextendinfo";
		$affected = $this->db->add ( $table, $data );
		if ($affected)
			return $affected;
		else
			return false;
	}

	/**
	 * 
	 * 添加服务时间
	 */
	public function addServicetime() {
		$table = "form__bjhh_service_time";
		if ($_POST ['username'])
			$data ['username'] = trim ( $_POST ['username'] );
		else
			return false;
		$data ['am'] = implode ( ',', ($_POST ['am']) );
		$data ['pm'] = implode ( ',', ($_POST ['pm']) );
		$data ['night'] = implode ( ',', ($_POST ['night']) );
		$affected = $this->db->add ( $table, $data );
		if ($affected)
			return $affected;
		else
			return false;
	}
	/**
	 * 人员编码
	 */
	public function pcode($uid){
	    if(!$uid) return false;
		$cinfo=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$uid","applytime,sex,birthday,sign,sdomain");
		if(!$cinfo) return false; 
		$porder=$this->db->get_one('form__bjhh_porder',"sign='$cinfo[sign]'","max(porder) as a");
	    $acode=$this->db->get_one("form__bjhh_area","sign='$cinfo[sign]'",'listorder');
	    if(!$acode) return false;
		$pdatas=array();
		$pdatas[uid]=$uid;
		$pdatas[sign]=$cinfo[sign];
		$pdatas[porder]=sprintf("%05d",$porder[a]+1);
		$precord=$this->db->add('form__bjhh_porder', $pdatas);
		if(!$precord) return false;
		//6+4+4+1+2+5
		$hnumber=$acode[listorder].date("Y",$cinfo['applytime']).date("Y",$cinfo['birthday']).$cinfo[sex].$cinfo[sdomain].$pdatas[porder];
		if(strlen($hnumber)=='22'){
		$res=$this->db->edit("form__bjhh_volunteermanage_volunteerbasicinfo", "hnumber=$hnumber", "recordid=$uid");
		if($res) return true;
		}
		return false;
	}
	/**
	 * 
	 * 检查登入否
	 */
	public function checkUserLogin() {
		if (isset ( $_SESSION ['code'] )) {
			$arg = $this->xxtea->parseLoginIdentify ( $_SESSION ['code'] );
			if (isset ( $arg [0] ) && isset ( $arg [1] ) && isset ( $arg [2] ))
				return true;
			else
				return false;
		 } else
			return false;
	}
/**
 * 
 *判断后台管理用户是否登录
 */
	public function checkAdminLogin() {
		if(isset($_SESSION['admin_identify']) && $_SESSION['admin_identify']){
			return true;
		}else{
		 return false;
		}
	}
	/**
	 *_check_username()判断用户名有没重复
	 */
	public function _check_username($username) {
		$table = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$get_one = $this->db->get_one ( $table, " username='$username' " );
		if ($get_one) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 *_check_idnumber()判断证件号是否存在
	 */
	public function _check_idnumber($idnumber) {
		$table = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$get_one = $this->db->get_one ( $table, " idnumber='$idnumber' " );
		if ($get_one) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 *_check_password()密码验证
	 * @access public
	 * @param string $_first_password
	 * @param string $_end_password
	 */
	public function _check_password($_first_password, $_end_password) {
		if (strlen ( $_first_password ) < 8) {
			$this->db->get_show_msg ( "javascript:history.back(0)", "密码不的小于8位" );
		} elseif (strlen ( $_first_password ) > 20) {
			$this->db->get_show_msg ( "javascript:history.back(0)", '密码不得大于20位!' );
		}
		if ($_first_password != $_end_password) {
			$this->db->get_show_msg ( "javascript:history.back(0)", '密码不一致!' );
		}
	}
}
?>
