<?php
include_once ('adminBase.php');
include (INCLUDE_PATH . "search.php");
/**
 * 
 * 服务队详细信息
 */
class adminServiceTeamMoreInfo extends adminbase {
	
	//默认省、市、区 parentid和地区表
	public $de_province_pid = '000001';
	public $de_city_pid = '000100010001';
	public $de_area_pid = '0001000100010001';
	public $cityTable = 'pubmodule_area_tbl';
	private $search;
	
	public function __construct() {
		parent::__construct ();
		$this->search = new Search ();
	}
	
	public function detail($id) {
		$where = "recordid='$id'";
		$info = $this->db->get_one ( "form__bjhh_serviceteammanage_addserviceteam", $where );
		$info ['foundingtime'] = date ( 'Y-m-d H:i:s', $info ['foundingtime'] );
		$info ['serviceclassification_checkbox'] = explode ( ',', $info ['serviceclassification_checkbox'] );
		$info ['skills_checkbox'] = explode ( ',', $info ['skills_checkbox'] );
		$info ['service_thumb'] = $info ['service_thumb'];
		return $info;
	}
	
	public function defaultCityArray($cityName) {
		$arr = $this->db->getall ( $this->cityTable, 'parentid=' . $this->{de_ . $cityName . _pid} );
		return $arr;
	}
	
	public function checkboxArray($tableName, $tcode) {
		$checkbox = $this->db->getall ( $tableName, "fid=0 and tcode=$tcode" );
		
		foreach ( $checkbox as $k => $v ) {
			$cid = $v ['id'];
			$checkbox_list = $this->db->getall ( $tableName, "fid=$cid" );
			$checkbox [$k] ['child'] = $checkbox_list;
		}
		
		return $checkbox;
	
	}
	
	
	public function OneCityArray($cid) {
		$arr = $this->db->getall ( 'pubmodule_area_tbl', "parentId=$cid" );
		return $arr;
	}
	
	/**
	 * 志愿者列表
	 * @param string $nickname (昵称)
	 * @return array $arr(二维)
	 */
	public function init($nickname = '', $limit = array(limit=>'0,9999999')) {
		$where = "a.sign='$_SESSION[sign]' and a.recordid=b.rid and a.status in ('001','010') and a.captainable=1";
		if ($nickname)
			$where .= " and a.nickname like '%" . $nickname . "%' ";
		$a = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$b = 'form__bjhh_volunteermanage_volunteerextendinfo';
		$fields = 'a.*,b.*,a.recordid as precordid';
		$orders = " order by a.applytime  DESC";
		$count = $this->db->get_relations_count ( $a, $b, $where );
		
		$list = $this->db->get_relations_info ( $a, $b, $where, $limit, $orders, $fields );
		foreach ( $list as $k => $v ) {
			if ($v ['sex'] == '1') {
				$v ['sex'] = '男';
			} else {
				$v ['sex'] = '女';
			}
			$v ['birthday'] = date ( 'Y', time () ) - date ( 'Y', $v ['birthday'] );
			$v ['features'] = $this->strHandle ( $v ['features'] );
			$list [$k] = $v;
		}
		return $list;
	}
	
	/**
	 * 
	 * 字符串处理
	 */
	public function strHandle($str) {
		if ($str) {
			if (! strpos ( $str, ',' )) {
				$arr = $this->db->get_one ( 'form__bjhh_dictbl', "id=$str" );
				$res = $arr ['name'];
			} else {
				$arr = explode ( ',', $str );
				foreach ( $arr as $k => $v ) {
					$arr = $this->db->get_one ( 'form__bjhh_dictbl', "id=$v" );
					$val .= $arr ['name'] . ',';
				}
				$res = rtrim ( $val, ',' );
			}
			return $res;
		} else {
			return '';
		}
	
	}
	
	/**
	 * 服务队添加
	 * @param array $post
	 */
	public function serviceTeamAdd($post, $status) {
		//变量初始化
		$userArr = array();
		
		foreach ( $post as $k => $v ) {
			if (is_array ( $v )) {
				foreach ( $v as $child_k => $child_v ) {
					$v [$child_k] = trim ( $child_v );
				}
				$post [$k] = $v;
			} else {
				$post [$k] = trim ( $v );
			}
		}
		$datas = array ();
		$datas ['serviceteamname'] = $post ['ser_tname'];
		$datas ['province'] = $post ['province'];
		$datas ['city'] = $post ['city'];
		$datas ['areas'] = $post ['area'];
		$datas ['foundingtime'] = strtotime ( $post ['foundingtime'] );
		$datas ['relationperson'] = $post ['linkman'];
		$datas ['responsibleperson'] = $post ['principal'];
		$datas ['emails'] = $post ['emails'];
		$datas ['detailed_address'] = $post ['detailed_address'];
		$datas ['postcodes'] = $post ['postcodes'];
		$datas ['planmembernumber'] = $post ['plan_num'];
		$datas ['telephones'] = $post ['telephones'];
		$datas ['sign'] =$_SESSION[sign];
		$datas ['parentid'] =$_SESSION[fid];
		if ($post ['thumb_url']) {
			$datas ['service_thumb'] = $post ['thumb_url'];
		} else {
			$datas ['service_thumb'] = '../templates/images/No_photo.jpg';
		}
		$datas ['serviceclassification_checkbox'] = implode ( ',', $post ['stype'] );
		$datas ['skills_checkbox'] = implode ( ',', $post ['skills'] );
		$datas ['others'] = $post ['others'];
		$datas ['teamintroduction'] = $post ['ser_intro'];
		$datas ['edittime'] = strtotime ( $post ['foundingtime'] );
		$datas ['fax'] = $post ['fax'];
		$datas ['mobile_telephone'] = $post ['mobile_telephone'];
		if ($status == 'add') {
			$userArr = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo'," nickname='{$post['captainid']}' ");
			$datas ['serviceteamcaptainid'] = $userArr['recordid'];
			$datas ['auditpasstime'] = time ();
			$datas ['agree'] = '2';
			$datas ['creatorid'] = $userArr['recordid'];
		}
		if ($status == 'edit') {
			$rid = $post ['editid'];
			$where = " recordid='$rid' ";
			$datas ['edittime'] = time ();
			$affected = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, $where );
			$this->search->updateInfo ( '2', $rid );
			//写入操作日志
			$arr=array();
			$arr[module]='5';
			$arr[type]='53';
			$arr[name]=$datas[serviceteamname];
			$this->doLog($arr);
			return $affected;
		} else {
			$insert_id = $this->db->add ( 'form__bjhh_serviceteammanage_addserviceteam', $datas );
			if ($insert_id) {
				$this->search->addInfo ( '2', $insert_id );
				$arr = array ();
				$arr ['serviceteamid'] = $insert_id;
				$arr ['captain'] = '1';
				$arr ['joinserviceteamdate'] = time ();
				$arr ['serviceteamcaptainid'] = $userArr['recordid'];
				$arr ['sp_status'] = '2';
				$insert_id = $this->db->add ( 'form__bjhh_serviceteammanage_addserviceteamperson', $arr );
				//写入操作日志
				$arr=array();
				$arr[module]='5';
				$arr[type]='52';
				$arr[name]=$datas[serviceteamname];
				$this->doLog($arr);
				return $insert_id;
			} else {
				return false;
			}
		}
	
	}
	
	public function serviceGetOne($rid) {
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid=$rid" );
		$arr ['foundingtime'] = date ( 'Y-m-d H:i:s', $arr ['foundingtime'] );
		$arr ['serviceclassification_checkbox'] = explode ( ',', $arr ['serviceclassification_checkbox'] );
		$arr ['skills_checkbox'] = explode ( ',', $arr ['skills_checkbox'] );
		return $arr;
	}

	public function serviceDelOne($rid) {
		$serArr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid=$rid" );
		$rs = $this->db->drop('form__bjhh_serviceteammanage_addserviceteam'," `recordid`='$rid'");
		if($rs){
			//写入操作日志
			$arr=array();
			$arr[module]='5';
			$arr[type]='54';
			$arr[name]=$serArr['serviceteamname'];
			$this->doLog($arr);
			$this->sendPassMsg($serArr);
		}
		return $rs;
	}
	
	public function sendPassMsg($serArr){
		
		//定义当前发消息人
		$sendUser = $this->getUser ();
		$sends ['fromid'] = $sendUser [0];
		$sends ['fromname'] = $sendUser [1];
		$sends ['date'] = time();

		//发送状态
		$sends ['status'] = 30; //服务队解散
		$sends ['fno'] = $serArr['recordid'];
		
		$userArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', "recordid={$serArr['creatorid']}" );
		$sends ['toid'] = $userArr ['recordid'];
		$sends ['toname'] = $userArr ['username'];
		$sends ['content'] = "您创建的服务队【" . $serArr ['serviceteamname'] . '】 已经被解散。';
		$this->db->add ( 'form__bjhh_message', $sends );
		
	}
}

?>