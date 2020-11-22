<?php
include_once ("ServiceTeam.php");
/**
 * 
 * 服务队人员审核
 * 
 */
class ServiceTeamPersonnelAudit extends ServiceTeam {
	
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 
	 * 申请人员列表
	 */
	public function init($recordid, $name) {
		$arr = array ();
		$conditions = 'a.serviceteamcaptainid = b.recordid';
		$conditions .= " and sp_status='1'  ";
		if ($recordid) {
			$conditions .= " and serviceteamid=$recordid ";
		}
		if ($name) {
			$conditions .= " and name like '%$name%' ";
		}
		$page = _get_page ( 10 ); //获取分页信息
		$table_left = 'form__bjhh_serviceteammanage_addserviceteamperson'; //服务队人员表
		$table_right = 'form__bjhh_volunteermanage_volunteerbasicinfo'; //志愿者表
		$orders = 'order by srecordid DESC';
		$fields = 'a.*,b.*,a.recordid as srecordid';
		$page ['item_count'] = $this->db->get_relations_count ( $table_left, $table_right, $conditions );
		$list = $this->db->get_relations_info ( $table_left, $table_right, $conditions, array ('limit' => $page ['limit'] ), $orders, $fields );
		$page = _format_page ( $page );
		$arr ['list'] = $list;
		$arr ['page'] = $page;
		return $arr;
		$this->db->db->close ();
	}

	public function initAjax($recordid, $limit) {
		$conditions = 'a.serviceteamcaptainid = b.recordid';
		$conditions .= " and sp_status='1'  ";
		if ($recordid) {
			$conditions .= " and serviceteamid=$recordid ";
		}

		$table_left = 'form__bjhh_serviceteammanage_addserviceteamperson'; //服务队人员表
		$table_right = 'form__bjhh_volunteermanage_volunteerbasicinfo'; //志愿者表
		$orders = 'order by srecordid DESC';
		$fields = 'a.*,b.*,a.recordid as srecordid';
		$list = $this->db->get_relations_info ( $table_left, $table_right, $conditions, array ("limit" => $limit ), $orders, $fields );
		return $list;
	}
	
	/**
	 * 
	 * 申请人详细信息
	 */
	public function detail() {
		$spm = get_url ( $_GET ['spm'] );
		if (! $spm)
			$this->db->get_show_msg ( 'serviceTeamPersonnelInfo.php', '参数错误！' );
		$conditions = 'a.recordid = b.rid';
		$conditions .= " and a.recordid=" . $spm ['id'] . " ";
		$table_left = 'form__bjhh_volunteermanage_volunteerbasicinfo'; //志愿者基本信息表
		$table_right = 'form__bjhh_volunteermanage_volunteerextendinfo'; //志愿者扩展信息表
		$fields = 'a.*,b.*,b.recordid as krecordid';
		$info = $this->db->get_relations_one ( $table_left, $table_right, $conditions, $fields );
		if (! $info)
			$this->db->get_show_msg ( 'serviceTeamPersonnelInfo.php', '参数错误！' );
		
		$info ['province'] = $this->getAdressandEudinfo ( 'pubmodule_area_tbl', $info ['province'] );
		$info ['city'] = $this->getAdressandEudinfo ( 'pubmodule_area_tbl', $info ['city'] );
		$info ['area'] = $this->getAdressandEudinfo ( 'pubmodule_area_tbl', $info ['area'] );
		$info ['race'] = $this->getAdressandEudinfo ( 'form__bjhh_dictbl', $info ['race'] );
		$info ['nationality'] = $this->getAdressandEudinfo ( 'form__bjhh_dictbl', $info ['nationality'] );
		$info ['idtype'] = $this->getAdressandEudinfo ( 'form__bjhh_dictbl', $info ['idtype'] );
		$info ['politicalstatus'] = $this->getAdressandEudinfo ( 'form__bjhh_dictbl', $info ['politicalstatus'] );
		$info ['birthday'] = date ( 'Y', time () ) - date ( 'Y', $info ['birthday'] );
		$info ['idnumber'] = $this->addStar ( $info ['idnumber'] );
		if ($info ['sex'] == '1') {
			$info ['sex'] = '男';
		} else {
			$info ['sex'] = '女';
		}
		if ($info ['isstudent '] == '1') {
			$info ['isstudent '] = '是';
		} else {
			$info ['isstudent '] = '否';
		}
		$info ['lasteducation'] = $this->getAdressandEudinfo ( 'form__bjhh_dictbl', $info ['lasteducation'] );
		$info ['features'] = $this->strHandle ( $info ['features'] );
		$info ['serveitem'] = $this->strHandle ( $info ['serveitem'] );
		$sert = $this->db->get_one ( 'form__bjhh_service_time', 'recordid=' . $info ['krecordid'] );
		$info ['am'] = explode ( ',', $sert ['am'] );
		$info ['pm'] = explode ( ',', $sert ['pm'] );
		$info ['night'] = explode ( ',', $sert ['night'] );
		return $info;
	}
	
	/**
	 * 
	 * 获取省市区名和最高学历
	 */
	public function getAdressandEudinfo($table, $id) {
		
		if ($id) {
			if ($table == 'pubmodule_area_tbl') {
				$conditions = 'areaId=' . $id;
			} else {
				$conditions = 'id=' . $id;
			}
			$arr = $this->db->get_one ( $table, $conditions );
			if ($table == 'pubmodule_area_tbl') {
				$arr ['areaName'] = preg_replace ( "/\s|　/", "", $arr ['areaName'] );
				$res = $arr ['areaName'] ? $arr ['areaName'] : '';
			} else {
				$res = $arr ['name'] ? $arr ['name'] : '';
			}
			return $res;
		} else {
			return '';
		}
	
	}
	
	/**
	 * 
	 * 身份证加密
	 */
	public function addStar($str) {
		if ($str) {
			$newstr = substr ( $str, 0, - 4 );
			$newstr = $newstr . '****';
			return $newstr;
		} else {
			return '';
		}
	
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
					$val .= $arr ['name'] . ' ';
				}
				$res = rtrim ( $val, ' ' );
			}
			return $res;
		} else {
			return '';
		}
	
	}
	
	/**
	 * 
	 * 批量通过
	 */
	public function yes() {
		//参数初始化
		$ads = $_POST ['aid']; 
		$ser_id = $_POST['server_id'];
		$datas = array (); 
		$sends = array();
		$arr = array();
		$arr2 = array();
		$arr3 = array();
		$time = time();
		
		//设置跳转页面
		$backurl = $this->getBackUrl ( 'serviceTeamPersonnelAudit.php' );
		//防止传参被篡改
		if (! $ads)
			$this->db->get_show_msg ( $backurl, '请选志愿者！' );
		
		//循环发送消息
		$sends ['fromid'] = $this->getUser ( 0 );
		$sends ['fromname'] = $this->getUser ( 1 );
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$ser_id'" );
		$sends ['fno'] = $arr['recordid'];
		$sends ['content'] = "你已经被批准加入服务队 【" . $arr ['serviceteamname'] . "】 ";
		$sends['status'] = 17;  //17: 同意加入某个服务队
		$sends ['date'] = $time;
		foreach ($ads as $k=>$v) {
			$arr2 = $this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson',"recordid='$v'");
			$arr3 = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='{$arr2['serviceteamcaptainid']}'");
			$sends['toid'] = $arr2['serviceteamcaptainid'];
			$sends['toname'] = $arr3['username'];
			$this->db->add('form__bjhh_message', $sends);
		}
		
		//批量通过
		$datas ['sp_status'] = 2;
		$datas ['joinserviceteamdate'] = $time;
		$ids = implode ( ',', $ads );
		$conditions = "recordid in ($ids)";
		$result = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $datas, $conditions );
		$this->db->get_show_msg ( $backurl, '批量通过操作成功！' );
	}

	public function yesAjax($ids, $serverId) {
		$datas = array ();
		$sends = array();
		$time = time();

		//循环发送消息
		$sends ['fromid'] = $this->getUser(0);
		$sends ['fromname'] = $this->getUser(1);
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$serverId'" );
		$sends ['fno'] = $arr['recordid'];
		$sends ['content'] = "你已经被批准加入服务队 【" . $arr ['serviceteamname'] . "】 ";
		$sends['status'] = 17;  //17: 同意加入某个服务队
		$sends ['date'] = $time;
		foreach($ids as $k=>$v) {
			$arr2 = $this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson',"recordid='$v'");
			$arr3 = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='{$arr2['serviceteamcaptainid']}'");
			$sends['toid'] = $arr2['serviceteamcaptainid'];
			$sends['toname'] = $arr3['username'];
			$this->db->add('form__bjhh_message', $sends);
		}

		$datas ['sp_status'] = 2;
		$datas ['joinserviceteamdate'] = $time;
		$ids = implode ( ',', $ids );
		$conditions = "recordid in ($ids)";
		$result = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $datas, $conditions );
		return $result;
	}
	
	/**
	 * 
	 * 批量拒绝
	 */
	public function no() {
		//参数初始化
		$ads = $_POST ['aid']; 
		$ser_id = $_POST['server_id'];
		$datas = array (); 
		$sends = array();
		$arr = array();
		$arr2 = array();
		$arr3 = array();
		$time = time();
		
		//设置跳转页面
		$backurl = $this->getBackUrl ( 'serviceTeamPersonnelAudit.php' );
		//防止传参被篡改
		if (! $ads)
			$this->db->get_show_msg ( $backurl, '请选志愿者！' );
		
		//循环发送消息
		$sends ['fromid'] = $this->getUser ( 0 );
		$sends ['fromname'] = $this->getUser ( 1 );
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$ser_id'" );
		$sends ['fno'] = $arr['recordid'];
		$sends ['content'] = "你已经被拒绝加入服务队 【" . $arr ['serviceteamname'] . "】 ";
		$sends['status'] = 18;  //18: 拒绝加入某个服务队
		$sends ['date'] = $time;
		foreach ($ads as $k=>$v) {
			$arr2 = $this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson',"recordid='$v'");
			$arr3 = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='{$arr2['serviceteamcaptainid']}'");
			$sends['toid'] = $arr2['serviceteamcaptainid'];
			$sends['toname'] = $arr3['username'];
			$this->db->add('form__bjhh_message', $sends);
		}
		
		//批量拒绝
		$datas ['sp_status'] = 3;
		$datas ['joinserviceteamdate'] = $time;
		$ids = implode ( ',', $ads );
		$conditions = "recordid in ($ids)";
		$result = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $datas, $conditions );
		$this->db->get_show_msg ( $backurl, '批量拒绝操作成功！' );
	}

	public function noAjax($ids, $serverId) {
		$datas = array ();
		$sends = array();
		$time = time();

		//循环发送消息
		$sends ['fromid'] = $this->getUser(0);
		$sends ['fromname'] = $this->getUser(1);
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$serverId'" );
		$sends ['fno'] = $arr['recordid'];
		$sends ['content'] = "你已经被拒绝加入服务队 【" . $arr ['serviceteamname'] . "】 ";
		$sends['status'] = 18;  //18: 拒绝加入某个服务队
		$sends ['date'] = $time;
		foreach($ids as $k=>$v) {
			$arr2 = $this->db->get_one('form__bjhh_serviceteammanage_addserviceteamperson',"recordid='$v'");
			$arr3 = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='{$arr2['serviceteamcaptainid']}'");
			$sends['toid'] = $arr2['serviceteamcaptainid'];
			$sends['toname'] = $arr3['username'];
			$this->db->add('form__bjhh_message', $sends);
		}

		//批量拒绝
		$datas ['sp_status'] = 3;
		$datas ['joinserviceteamdate'] = $time;
		$ids = implode ( ',', $ids );
		$conditions = "recordid in ($ids)";
		$result = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteamperson', $datas, $conditions );
		return $result;
	}
	
}

?>