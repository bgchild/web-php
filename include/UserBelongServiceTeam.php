<?php
include_once ("user.php");
/**
 * 
 * 我所属的服务队
 * 
 */
class UserBelongServiceTeam extends user {
	
	private $count = 0;
	//默认省、市、区 parentid和地区表
	public $de_province_pid = '00010001';
	public $de_city_pid = '000100010001';
	public $de_area_pid = '0001000100010001';
	public $cityTable = 'pubmodule_area_tbl';
	
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 
	 * 得到用户所属服务队信息
	 */
	public function getBelongServiceTeamInfo($query, $limit) {
		$uid = $this->getUser ( 0 );
		$name = $this->getUser ( 1 );
		$where = "a.username='$name' and a.recordid=b.serviceteamcaptainid and b.serviceteamid=c.recordid and a.status in ('001','010') and c.deltag='0' and c.agree='2' ";
		foreach ( $query as $key => $val ) {
			$val = trim ( $val );
			if ($key == 'serviceteamname') {
				$where .= " and $key like '%" . $val . "%' ";
				continue;
			}
			if ($key == 'status' && $val ['status'] != '0') {
				$key = 'b.sp_' . $key ."='{$val[status]}'";
			}
			if ($key == 'join_start') {
				$val2 = strtotime ( $val . '00:00:00' );
				$where .= " and b.joinserviceteamdate>='" . $val2 . "' ";
				continue;
			}
			if ($key == 'join_stop') {
				$val2 = strtotime ( $val . '23:59:59' );
				$where .= " and b.joinserviceteamdate<='" . $val2 . "' ";
				continue;
			}
			if ($val ['status'] != '0') {
				$where .= " and $key='$val' ";
			}
		}

		$a = "form__bjhh_volunteermanage_volunteerbasicinfo";
		$b = "form__bjhh_serviceteammanage_addserviceteamperson";
		$c = "form__bjhh_serviceteammanage_addserviceteam";
		$fields = "a.*,b.*,c.*,a.province as uprovince,a.city as ucity,a.recordid as vrecordid,b.recordid as sprecordid,b.serviceteamcaptainid as pserviceteamcaptainid";
		$this->count = $this->db->get_association_count ( $a, $b, $c, $where );
		$order = " order by b.sp_status asc,b.joinserviceteamdate  DESC";
		$records = $this->db->get_association_info ( $a, $b, $c, $where, $limit = array (limit => $limit ), $order, $fields );
		foreach ( $records as $key => $val ) {
			$val ['joinserviceteamdate'] = date ( "Y-m-d", $val ['joinserviceteamdate'] );
			$q = 'serviceteamid=' . $val ['serviceteamid'] . ' and sp_status=2';
			$passNum = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteamperson', $q );
			if ($uid == $val ['serviceteamcaptainid']) {
				$val ['iscaptain'] = '1';
			} else {
				$val ['iscaptain'] = '2';
			}
			if ($val ['sp_status'] == '1') {
				$val ['sp_status2'] = '申请中';
			} else if ($val ['sp_status'] == '2') {
				$val ['sp_status2'] = '已加入';
			} else {
				$val ['sp_status2'] = '未通过';
			}
			$val ['passNum'] = $passNum;
			$records [$key] = $val;
		}

		return $records;
	}
	
	public function getMyRecordsByStatusCount() {
		return $this->count;
	}
	
	public function deleteOne($id) {
		return $this->db->drop ( 'form__bjhh_serviceteammanage_addserviceteamperson', 'recordid=' . $id );
	}
	
	public function getServictTeamPersonInfo($id, $limit) {
		$where = "a.serviceteamcaptainid=b.recordid and a.serviceteamid=$id and a.sp_status=2 ";
		$a = 'form__bjhh_serviceteammanage_addserviceteamperson';
		$b = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$fields = 'a.*,b.*,b.recordid as precordid';
		$orders = " order by a.captain asc,a.joinserviceteamdate desc";
		$this->count = $this->db->get_relations_count ( $a, $b, $where );
		$arr = $this->db->get_relations_info ( $a, $b, $where, $limit = array (limit => $limit ), $orders, $fields );
		foreach ( $arr as $k => $v ) {
			if ($v ['captain'] == '1') {
				$arr [$k] ['duty'] = "<img src='./templates/images/captain.png' alt='' title=''  />";
			} else if ($v ['captain'] == '2') {
				$arr [$k] ['duty'] = "<img src='./templates/images/vicecaptain.png' alt='' title=''  />";
			} else if ($v ['captain'] == '3') {
				$arr [$k] ['duty'] = "<img src='./templates/images/player.png' alt='' title=''  />";
			}
		}
		return $arr;
	}
	
	public function sendMessage($post) {
		$datas = array ();
		$datas ['fromid'] = $this->getUser ( 0 );
		$datas ['fromname'] = $this->getUser ( 1 );
		foreach ( $post as $k => $v )
			$post [$k] = trim ( $v );
		$datas ['fno'] = $post ['sid'];
		$datas ['toid'] = $post ['checkids'];
		$datas ['content'] = $post ['sumup'];
		$datas ['toid'] = ltrim ( $datas ['toid'], '^' );
		$datas ['date'] = time ();
		$datas ['status'] = '5';
		if (! strpos ( $datas ['toid'], '^' )) {
			$arr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', 'recordid=' . $datas ['toid'] );
			if ($datas ['fromname'] === $arr ['username']) {
				return false;
			}
			$datas ['toname'] = $arr ['username'];
			$affected = $this->db->add ( 'form__bjhh_message', $datas );
		} else {
			$arr = explode ( '^', $datas ['toid'] );
			foreach ( $arr as $k => $v ) {
				$list = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', 'recordid=' . $v );
				if ($datas ['fromname'] === $list ['username']) {
					continue;
				}
				$datas ['toname'] = $list ['username'];
				$datas ['toid'] = $v;
				$affected = $this->db->add ( 'form__bjhh_message', $datas );
			}
		}
		if ($affected)
			return $affected;
		else
			return false;
	}
	
	public function serviceGetOne($rid) {
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid=$rid" );
		$arr ['foundingtime'] = date ( 'Y-m-d H:i:s', $arr ['foundingtime'] );
		$arr ['serviceclassification_checkbox'] = explode ( ',', $arr ['serviceclassification_checkbox'] );
		$arr ['skills_checkbox'] = explode ( ',', $arr ['skills_checkbox'] );
		return $arr;
	}
	
	public function OneCityArray($cid) {
		$arr = $this->db->getall ( 'pubmodule_area_tbl', "parentId=$cid" );
		return $arr;
	}
	
	//默认地区
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
	
	/**
	 * 我所属的服务队退出
	 * @param string $rid 服务队人员表主键
	 */
	public function serverTeamExit($rid) {
		//判断参数是否传递过来
		if (! $rid) {
			return false;
		}
		
		//初始化参数
		$serPer = array ();
		$serArr = array ();
		$useArr = array ();
		$capArr = array ();
		$capUseInfo = array ();
		$sends = array ();
		$prefix = '';
		
		//取出服务队人员表中一条记录
		$serPer = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteamperson', " recordid='$rid' " );		
		//取出服务队信息
		$serArr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid='{$serPer['serviceteamid']}' " );		
		//取出退出人的志愿者表信息
		$useArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='{$serPer['serviceteamcaptainid']}' " );		
		//取出服务队人员表中队长记录
		$capArr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteamperson', "serviceteamid='{$serPer['serviceteamid']}' and captain='1' " );
		//取出队长志愿者表中信息
		$capUseInfo = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='{$capArr['serviceteamcaptainid']}' " );
		
		//消息内容前缀
		if ($serPer ['captain'] == '2') {
			$prefix = '副队长';
		} else if ($serPer ['captain'] == '3') {
			$prefix = '队员';
		}
		
		//发消息准备
		$sends ['fromid'] = $useArr ['recordid']; //发送人ID
		$sends ['fromname'] = $useArr ['username']; //发送人用户名
		$sends ['fno'] = $serPer ['serviceteamid']; //服务队ID
		$sends ['toid'] = $capUseInfo ['recordid']; //接收人ID
		$sends ['toname'] = $capUseInfo ['username']; //接收人用户名
		$sends ['status'] = '24'; //服务队人员退出
		$sends ['date'] = time (); //时间
		$sends ['content'] = $prefix . $useArr ['username'] . "已从服务队【" . $serArr ['serviceteamname'] . "】退出"; //发送内容
		
		//服务队人员表删除操作 
		$res = $this->db->drop ( 'form__bjhh_serviceteammanage_addserviceteamperson', 'recordid=' . $rid );
		if ($res) {
			//发送消息
			$this->db->add ( 'form__bjhh_message', $sends );
			return $res;
		} else {
			return false;
		}
	
	}

}

?>