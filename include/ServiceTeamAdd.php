<?php
include_once ("ServiceTeam.php");
include_once (INCLUDE_PATH . "search.php");
/**
 * 
 * 服务队添加
 * 
 */
class ServiceTeamAdd extends ServiceTeam {
	
	//默认省、市、区 parentid和地区表
	public $de_province_pid = '000001';
	public $de_city_pid = '000100010001';
	public $de_area_pid = '0001000100010001';
	public $cityTable = 'pubmodule_area_tbl';
	private $count = 0;
	private $search;
	
	public function __construct() {
		parent::__construct ();
		
		$this->search = new Search ();
	}
	
	/**
	 * 服务队添加或修改
	 * @param array $post 表单提交的数据
	 * @param array $session session中数据
	 * @return int|boolean $insert_id(int 取得上一步 INSERT 操作产生的 ID)  $affected(bool)
	 */
	public function serverAdd($post) {
		$creatorid = $this->getUser ( 0 );
		$sign = $this->getUser ( 'sign' );
		$parentid = $this->getUser ( 'parentid' );
		
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
		if ($post ['thumb_url']) {
			$datas ['service_thumb'] = $post ['thumb_url'];
		} else {
			$datas ['service_thumb'] = 'templates/images/No_photo.jpg';
		}
		$datas ['serviceclassification_checkbox'] = implode ( ',', $post ['stype'] );
		$datas ['skills_checkbox'] = implode ( ',', $post ['skills'] );
		$datas ['others'] = $post ['others'];
		$datas ['teamintroduction'] = $post ['ser_intro'];
		$datas ['edittime'] = strtotime ( $post ['foundingtime'] );
		$datas ['fax'] = $post ['fax'];
		$datas ['mobile_telephone'] = $post ['mobile_telephone'];
		$datas ['creatorid'] = $creatorid;
		if ($post ['recordid']) {
			$datas ['edittime'] = time ();
			$where = 'recordid=' . $post ['recordid'];
			$affected = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, $where );
			if ($affected) {
				if ($post ['tid'] == '3') {
					$datas ['agree'] = '1';
					$this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, $where );
				}
				return $affected;
			} else {
				return false;
			}
		
		} else {
			$datas ['sign'] = $sign;
			$datas ['parentid'] = $parentid;
			$datas ['serviceteamcaptainid'] = $creatorid;
			$insert_id = $this->db->add ( 'form__bjhh_serviceteammanage_addserviceteam', $datas );
			if ($insert_id) {
				$arr = array ();
				$arr ['serviceteamid'] = $this->db->db->insert_id ();
				$arr ['captain'] = '1';
				$arr ['joinserviceteamdate'] = time ();
				$arr ['serviceteamcaptainid'] = $creatorid;
				$arr ['sp_status'] = '2';
				$insert_id = $this->db->add ( 'form__bjhh_serviceteammanage_addserviceteamperson', $arr );
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
	
	//默认地区
	public function defaultCityArray($cityName) {
		$arr = $this->db->getall ( $this->cityTable, 'parentid=' . $this->{de_ . $cityName . _pid} );
		return $arr;
	}
	
	public function OneCityArray($cid) {
		$arr = $this->db->getall ( 'pubmodule_area_tbl', "parentId=$cid" );
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
	
	public function auditReason($table, $tcode) {
		$arr = $this->db->getall ( $table, "fid=0 and tcode=$tcode" );
		return $arr;
	}
	
	public function getServictTeamPersonInfo($id, $limit) {
		$where = "a.serviceteamcaptainid=b.recordid and a.serviceteamid='$id' and a.sp_status='2' ";
		$a = 'form__bjhh_serviceteammanage_addserviceteamperson';
		$b = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$fields = 'a.*,b.*,a.recordid as arecordid';
		$orders = " order by a.captain asc,a.joinserviceteamdate desc";
		$this->count = $this->db->get_relations_count ( $a, $b, $where );
		$arr = $this->db->get_relations_info ( $a, $b, $where, $limit = array (limit => $limit ), $orders, $fields );
		foreach ( $arr as $k => $v ) {
			$v ['joinserviceteamdate'] = date ( 'Y-m-d', $v ['joinserviceteamdate'] );
			$v ['birthday'] = date ( 'Y', time () ) - date ( 'Y', $v ['birthday'] );
			if ($v ['sex'] == '1') {
				$v ['sex'] = '男';
			} else {
				$v ['sex'] = '女';
			}
			$arr [$k] = $v;
		}
		return $arr;
	}
	
	public function getMyRecordsByStatusCount() {
		return $this->count;
	}
	
	public function dtChange($sid, $vid, $cap) {
		//参数初始化
		$sends = array ();
		$servArr = array ();
		$userArr = array ();
		
		//发送消息准备
		$sends ['fromid'] = $this->getUser ( 0 ); //发送人ID
		$sends ['fromname'] = $this->getUser ( 1 ); //发送人用户名
		$sends ['fno'] = $sid;
		$sends ['toid'] = $vid;
		$sends ['date'] = time ();
		
		//服务队信息
		$servArr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$sid'" );
		//志愿者信息
		$userArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$vid' " );
		$sends ['toname'] = $userArr ['username'];
		
		//判断状态
		if ($cap === '3') {
			$sends ['status'] = 22; //后台服务队管理：被取消副队长
			$sends ['content'] = "您已经被取消服务队【" . $servArr ['serviceteamname'] . "】 副队长职务";
		} else {
			$sends ['status'] = 21; //被任命为副队长
			$sends ['content'] = "您已经被委任服务队【" . $servArr ['serviceteamname'] . "】 副队长职务";
		}
		
		$datas ['captain'] = $cap;
		$conditions = "serviceteamid='$sid' and serviceteamcaptainid='$vid' ";
		$affected = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $datas, $conditions );
		if ($affected) {
			$this->db->add ( 'form__bjhh_message', $sends );
		}
		return $affected;
	}
	
	/**
	 * 删除一条队员数据
	 * @param string $serviceid(服务队主键)
	 * @param string $volunteerid(志愿者表主键) 
	 * @return int $affected_rows(受影响的行数)
	 */
	public function deleteOnePlayer($serviceid, $volunteerid) {
		//参数初始化
		$sends = array ();
		$servArr = array ();
		$userArr = array ();
		
		//发送消息准备
		$sends ['fromid'] = $this->getUser ( 0 ); //发送人ID
		$sends ['fromname'] = $this->getUser ( 1 ); //发送人用户名
		$sends ['fno'] = $serviceid;
		$sends ['toid'] = $volunteerid;
		$sends ['date'] = time ();
		
		//服务队信息
		$servArr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$serviceid'" );
		//志愿者信息
		$userArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$volunteerid' " );
		$sends ['toname'] = $userArr ['username'];
		
		$sends ['status'] = 23; //服务队管理：删除队员
		$sends ['content'] = "您已经被服务队【" . $servArr ['serviceteamname'] . "】 移出";
		
		$table = 'form__bjhh_serviceteammanage_addserviceteamperson';
		$conditions = " serviceteamid='$serviceid' and serviceteamcaptainid='$volunteerid' ";
		$affected_rows = $this->db->drop ( $table, $conditions );
		
		if ($affected_rows) {
			$this->db->add ( 'form__bjhh_message', $sends );
		}
		return $affected_rows;
	}

}
?>