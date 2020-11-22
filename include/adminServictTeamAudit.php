<?php
include_once ('adminBase.php');
include (INCLUDE_PATH . "search.php");
/**
 * 
 * 服务队初审
 */
class adminServictTeamAudit extends adminbase {
	private $search;
	
	public function __construct() {
		parent::__construct ();
		$this->search = new Search ();
	}
	
	/**
	 * 所有服务队
	 * @param array $gets (查询条件)
	 * @param string $agree (服务队审核状态)
	 * @return $arr (二维)
	 */
	public function init($gets, $agree) {		
		$arr = array ();
		$conditions = " delTag='0' and agree='$agree' and sign='$_SESSION[sign]' ";
		foreach ( $gets as $k => $v ) {
			if ($k == 'serviceteamname') {
				if ($v) {
					$conditions .= " and $k like '%" . $v . "%' ";
				}
				continue;
			}
			if ($k == 'foundingtime_start') {
				if ($v) {
					$v2 = strtotime ( $v . '00:00:00' );
					$conditions .= ' and foundingtime>=' . $v2;
				}
				continue;
			}
			if ($k == 'foundingtime_stop') {
				if ($v) {
					$v2 = strtotime ( $v . '23:59:59' );
					$conditions .= ' and foundingtime<=' . $v2;
				}
				continue;
			}
			if ($k == 'stype') {
				foreach ( $v as $key => $val ) {
					$conditions .= " and serviceclassification_checkbox like '%" . $val . "%'";
				}
				continue;
			}
		}
		$page = _get_page ( 10 ); //获取分页信息
		if ($agree == '1') {
			$orders = ' order by foundingtime DESC ';
		} else if ($agree == '2') {
			$orders = ' order by auditpasstime DESC ';
		}
		$page ['item_count'] = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteam', $conditions );
		$list = $this->db->getAll ( 'form__bjhh_serviceteammanage_addserviceteam', $conditions, array ('limit' => $page ['limit'] ), '*', $orders );
		foreach ( $list as $k => $v ) {
			$q = 'sp_status=2 and serviceteamid=' . $v ['recordid'];
			$passNum = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteamperson', $q );
			$q2 = " recordid='{$v['serviceteamcaptainid']}'";
			$arr2 = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $q2 );
			$list [$k] ['captainName'] = $arr2 ['name'];
			$list [$k] ['audittime'] = date ( 'Y-m-d', $v ['foundingtime'] );
			$list [$k] ['auditpasstime'] = date ( 'Y-m-d', $v ['auditpasstime'] );
			$list [$k] ['skill'] = $this->strHandle ( $v ['serviceclassification_checkbox'] );
			$list [$k] ['passNum'] = $passNum;
			unset($passNum);
			unset($arr2);
		}
		$page = _format_page ( $page );
		$arr ['list'] = $list;
		$arr ['page'] = $page;
		return $arr;
	}
	
	public function getServictTeamType($table, $tcode) {
		$checkbox = $this->db->getall ( $table, "fid=0 and tcode=$tcode" );
		return $checkbox;
	}
	
	public function filterChars($datas) {
		foreach ( $datas as $k => $v ) {
			if (is_array ( $v )) {
				foreach ( $v as $child_k => $child_v ) {
					$v [$child_k] = trim ( $child_v );
				}
				$datas [$k] = $v;
			} else {
				$datas [$k] = trim ( $v );
			}
		}
		return $datas;
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
	 * 批量通过
	 */
	public function yes() {
		/************变量初始化***************/
		//发送人数组
		$sendUser = null;
		//发送消息数组
		$sends = array ();
		//服务队信息数组
		$serArr = array ();
		//志愿者信息数组
		$userArr = array ();
		
		$ads = $_POST ['aid'];
		$backurl = $this->getBackUrl ( 'serviceTeamAudit.php' );
		if (! $ads)
			$this->db->get_show_msg ( $backurl, '请选择服务队！' );
		$datas = array ();
		$datas ['agree'] = 2;
		$datas ['reason'] = '';
		$datas ['remark'] = '';
		$datas ['auditpasstime'] = time ();
		
		/**************发消息准备*******************/
		//定义当前发消息人
		$sendUser = $this->getUser ();
		
		//定义当前发消息头
		$sends ['fromid'] = $sendUser [0];
		$sends ['fromname'] = $sendUser [1];
		$sends ['date'] = $datas ['auditpasstime'];
		//发送状态
		$sends ['status'] = 28; //服务队审核通过
		

		//修改表中服务队状态
		$ids = implode ( ',', $ads );
		$conditions = "recordid in ($ids)";
		$result = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, $conditions );
		
		//循环发送消息
		foreach ( $ads as $v ) {
			$sends ['fno'] = $v;
			$serArr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid=$v" );
			$userArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', "recordid={$serArr['creatorid']}" );
			$sends ['toid'] = $userArr ['recordid'];
			$sends ['toname'] = $userArr ['username'];
			$sends ['content'] = "您创建的服务队【" . $serArr ['serviceteamname'] . '】已经通过审核';
			$this->db->add ( 'form__bjhh_message', $sends );
			$this->search->updateInfo ( '2', $v );
		}
		//log
		$arr=array();
		$arr[type]='50';
		$arr[module]='5';
		$this->doLog($arr);
		$this->db->get_show_msg ( $backurl, '批量通过操作成功！' );
	}
	
	/**
	 * 逻辑删除
	 * @param array $id 主键
	 * @return string  空
	 */
	/*
	public function logicDel($id) {
		$backurl = $this->getBackUrl ( 'serviceTeamAudit.php' );
		if ($id) {
			$conditions = " recordid='$id' ";
			$datas ['deltag'] = '1';
			$res = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, $conditions );
			if ($res) {
				$conditions = " serviceteamid='$id' ";
				$this->db->drop ( 'form__bjhh_serviceteammanage_addserviceteamperson', $conditions );
				$this->db->get_show_msg ( $backurl, '删除成功！' );
			} else {
				return false;
			}
		} else {
			return false;
		}
	
	}
	*/
	public function auditReason($table, $tcode) {
		$arr = $this->db->getall ( $table, "fid=0 and tcode=$tcode" );
		return $arr;
	}
	
	/**
	 * 服务队审核拒绝
	 * @param array $post
	 * @return $affected ture|false
	 */
	public function sendReason($post) {
		/***************变量初始化*********************/
		$datas = array ();
		$recordid = null;
		$serArr = array ();
		$sends = array ();
		$serArr2 = array ();
		$userArr = array ();
		
		$datas ['reason'] = $post ['nopass'];
		$datas ['remark'] = trim ( $post ['sumup'] );
		$datas ['agree'] = '3';
		$recordid = ltrim ( $post ['sid'], '^' );
		$serArr = explode ( '^', $recordid );
		
		/**************发消息准备*******************/
		//定义当前发消息人
		$sendUser = $this->getUser ();
		
		//定义当前发消息头
		$sends ['fromid'] = $sendUser [0];
		$sends ['fromname'] = $sendUser [1];
		$sends ['date'] = time ();
		//发送状态
		$sends ['status'] = 29; //服务队审核拒绝
		//log
		$arr=array();
		$arr[type]='51';
		$arr[module]='5';
		$this->doLog($arr);
		//遍历服务队主键
		foreach ( $serArr as $v ) {
			//修改服务队表审核状态
			$affected = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, " recordid=$v " );
			//获取接收人id和接收人username和相应服务队id
			$sends ['fno'] = $v;
			$serArr2 = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', " recordid=$v" );
			$userArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', "recordid={$serArr2['creatorid']}" );
			$sends ['toid'] = $userArr ['recordid'];
			$sends ['toname'] = $userArr ['username'];
			$sends ['content'] = "您创建的服务队【" . $serArr2 ['serviceteamname'] . '】已经被管理员拒绝，请查看拒绝原因！';
			
			if ($affected) {
				$this->db->add ( 'form__bjhh_message', $sends );
				$this->search->updateInfo ( '2', $v );
				return $affected;
			} else {
				return false;
			}
		}
	}
	
	
	/**
	 * 服务队展示图片入库
	 * @param array $post  入库数据(图片名、路径)
	 * @param string $sid 对应服务队主键
	 * @return bool $res 返回布尔结果
	 */
	public function serTeamPicAdd($post, $sid) {
		//变量初始化
		$data = array ();
		$res = null;
		
		//去除图片名有可能出现的空格
		$post ['img_name'] = trim ( $post ['img_name'] );
		
		$data ['img_name'] = $post ['img_name'];
		$data ['img_url'] = substr ( $post ['thumb_url'], 3 );
		$data ['serverid'] = $sid;
		
		//入库
		$res = $this->db->add ( 'form__bjhh_serviceteampicture', $data );
		return $res;
	}
	
	/**
	 * 服务队图片表信息获取
	 * @param  string $sid 服务队主键
	 * @return boolean|array 返回布尔值或全部数组信息
	 */
	public function getSTPInfo($sid) {
		//变量初始化
		$order = null;
		
		//判断是否传参
		if (! $sid) {
			return false;
		}
		
		//照排序字段排序
		$orders = ' order by img_order asc';
		return $this->db->getall ( 'form__bjhh_serviceteampicture', " serverid='$sid' ", array (limit => '0,9999999' ), '*', $orders );
	
	}
	
	/**
	 * 图片删除
	 * @param string $drop_id 图片表主键
	 * @return boolean true|fales 
	 */
	public function deletePic($drop_id) {
		
		//验证传参
		if (! $drop_id) {
			return false;
		}
		
		return $this->db->drop ( 'form__bjhh_serviceteampicture', " recordid=$drop_id " );
	
	}
	
	/**
	 * 图片排序
	 * @param array $ord 排序字段数组
	 * @param array $rid 主键数组
	 * @return boolean true|false
	 */
	public function serTpOrder($ord, $rid) {
		//变量初始化
		$status = false;
		$merge = array ();
		$datas = array ();
		$where = '';
		$affset = null;
		
		//验证参数
		if (! ($ord && $rid)) {
			return false;
		}
		
		//合并数组
		$merge = array_combine ( $rid, $ord );
		
		//数组遍历修改
		foreach ( $merge as $k => $v ) {
			$datas ['img_order'] = $v;
			$where = " recordid=$k ";
			$affset = $this->db->edit ( 'form__bjhh_serviceteampicture', $datas, $where );
			if ($affset)
				$status = true;
		}
		
		return $status;
	}

}

?>



