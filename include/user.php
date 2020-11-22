<?php
/**
 * 
 * 志愿者基础类
 */


include_once ( "Xxtea.php");

class user {

	public  $db;
	public $xxtea;
	
	public function __construct($ajax = false) {
		global $db;
		$this->db=$db;
		$this->xxtea=new Xxtea();
        if (!$ajax) {
            if (!$this->checkUserLogin()) {
                $db->get_show_msg("index.php", "请先登录！Please login first !");
            }
        }
	}

	public function checkUserLogin() {
		if(isset($_SESSION['code'])){
			$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
			if(isset($arg[0]) && isset($arg[1]) && isset($arg[2])) return true;
			else return false;
		}
		else return false;
	}
	
	public function checkCaptain(){
		$_user=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=".$this->getUser(0)) ;
		if(!$_user['captainable']){
			//没有队长资格不能访问特定区域
			return false;
		} else if($_user['status']=='100'){
			//注销用户也不可访问特定区域
			return false;
		}
		return true;
	}
	
   public function getUser($i){
   		$userArr = array();
		$arg=$this->xxtea->parseLoginIdentify($_SESSION['code']);
		$userArr = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid={$arg[0]}");	
		$arg['sign'] = $userArr['sign'];
		$arg['parentid'] = $userArr['parentid'];
		return $arg[$i];
	}
	
	/**
	 * 
	 * 获得返回地址
	 * @param  $url 如果没有$_SERVER['HTTP_REFERER']就返回$url;
	 */
	public function getBackUrl($url){
		return $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$url;
	}
	
	public function sendMsg($toid,$toname,$status,$fno,$content){
		$data['fromid']=$this->getUser(0);
		$data['fromname']=$this->getUser(1);
		$data['toid']=$toid;
		$data['toname']=$toname;
		$data['date']=time();
		$data['status']=$status;
		$data['fno']=$fno;
		$data['content']=$content;
		return $this->db->add('form__bjhh_message', $data);
	}

	/**
	 * 获取当前登录用户 总会/省/市 信息
	 * @return array $arr 例:Array([sign]=>www,[parentid]=>0,[areaid]=>1)
	 */
	/*public function getCityInfo() {
		$useInfo = array ();
		$adminInfo = array ();
		$arr = array ();
		$useInfo = $this->xxtea->parseLoginIdentify ( $_SESSION ['code'] );
		//超级管理员查看各省数据
		if($useInfo[1]=='admin'){
			$arr ['sign'] ='www';
			$arr ['parentid'] = 0;
			$arr ['areaid'] = 1;
			$arr ['def'] = 1;
		}else{
			$adminInfo = $this->db->get_one ( 'form__bjhh_admin', "u_name='{$useInfo[1]}'" );
			$arr ['sign'] = $adminInfo ['sign'];
			$arr ['parentid'] = $adminInfo ['parentid'];
			$arr ['areaid'] = $adminInfo ['areaid'];
			$arr ['def'] = $adminInfo ['def'];
		}
		return $arr;
	}*/


	/**
	 * 操作日志
	 * $data=>array('module'=>1,'type'=>10,'name'=>'操作对象');
	 * 志愿者初审->初审通过
	 */
	public function doLog($data){
		if(!$data) return false;
		//动作操作日志
		$tag=array();
		//志愿者初审
		$tag[1]='志愿者初审';
		$tag[10]='初审通过';
		$tag[11]='初审拒绝';
		//志愿者管理
		$tag[2]='志愿者管理';
		$tag[20]='批量导出志愿者';
		$tag[21]='批量导入志愿者';
		$tag[22]='添加志愿者';
		$tag[23]='通过终审';
		$tag[24]='工时调整';
		$tag[25]='注销志愿者';
		$tag[26]='激活志愿者';
		$tag[27]='删除志愿者';
		//队长管理
		$tag[3]='队长管理';
		$tag[30]='设置为队长';
		$tag[31]='取消队长职务';
		//活动审核
		$tag[4]='活动审核';
		$tag[40]='活动批量通过';
		$tag[41]='活动批量拒绝';
		//服务队管理
		$tag[5]='服务队管理';
		$tag[50]='服务队批量通过';
		$tag[51]='服务队批量拒绝';
		$tag[52]='添加服务队';
		$tag[53]='修改服务队';
		$tag[54]='注销服务队';
		//评优管理
		$tag[6]='评优管理';
		$tag[60]='添加评优';
		$tag[61]='修改评优';
		//管理员管理
		$tag[7]='管理员管理';
		$tag[70]='添加管理员';
		$tag[71]='删除管理员';
		$tag[72]='修改管理员密码';
		//联系方式
		$tag[8]='联系方式';
		$tag[80]='修改联系方式';
		//关于我们
		$tag[9]='关于我们';
		$tag[90]='修改关于我们';
		//培训管理
		$tag[10] = '培训管理';
		$tag[100] = '添加培训';
		$tag[101] = '修改培训';
		$userinfo=$this->getUser(0);
		//$cityinfo=$this->getCityInfo();
		$logs=array();
		$logs['logintime']=date("Y-m-d H:i:s",time());
		$logs['sign']=$userinfo['sign'];
		$logs['loginip']=get_ip();
		$logs['username']=$userinfo['1'];
		$logs['type']=$tag[$data[type]];
		$logs['module']=$tag[$data[module]];
		$logs['remark']=$logs['username']."于".$logs['logintime']."操作:".	$logs['module']."<br/>结果：";
		if($data[name])$logs['remark'].=$data[name]."->";
		$logs['remark'].=$logs['type'];
		$this->db->add("form__bjhh_loginlog", $logs);
	}

}

?>