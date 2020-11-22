<?php
include_once ("ServiceTeam.php");
include_once (INCLUDE_PATH . "search.php");
/**
 * 
 * 服务队管理
 * 
 */
class ServiceTeamManage extends ServiceTeam {
	private $count = 0;
	private $search;
	
	public function __construct() {
		parent::__construct ();
		$this->search = new Search ();
	}
	
	public function getCount() {
		return $this->count;
	}
	
	/**
	 * 获取队长权限
	 * @param string $uid
	 * @return string $arr['captainable']
	 */
	public function getCaptainPower($uid) {
		$arr = array ();
		$where = " recordid='$uid' ";
		$arr = $this->db->getall ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $where );
		return $arr [0] ['captainable'];
	}
	
	public function init($tag, $query, $limit) {
		$creatorid = $this->getUser ( 0 );
		$q1 = " deltag='0' and creatorid='$creatorid' ";
		
		foreach ( $query as $k => $v ) {
			if ($k == 'foundingtime_start') {
				$query [$k] = strtotime ( $v . '00:00:00' );
				$q1 .= " and foundingtime>='" . $query [$k] . "' ";
			}
			if ($k == 'foundingtime_stop') {
				$query [$k] = strtotime ( $v . '23:59:59' );
				$q1 .= " and foundingtime<='" . $query [$k] . "' ";
			}
			if ($k == 'serviceteamname') {
				$q1 .= " and $k like '%" . $v . "%' ";
			}
		}
		
		if ($tag) {
			
			$q1 .= " and agree='" . $tag . "'";
			
			if (($tag == 1) || ($tag == 3)) {
				$this->count = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteam', $q1 );
				$res = $this->db->getall ( 'form__bjhh_serviceteammanage_addserviceteam', $q1, array (limit => $limit ), $fields = '*', ' order by recordid DESC' );
			}
			if ($tag == 2) {
				$this->count = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteam', $q1 );
				$res = $this->db->getall ( 'form__bjhh_serviceteammanage_addserviceteam', $q1, array (limit => $limit ), $fields = '*', ' order by recordid DESC' );
				foreach ( $res as $k => $v ) {
					$q2 = 'serviceteamid=' . $v ['recordid'] . ' and sp_status=1';
					$q3 = 'serviceteamid=' . $v ['recordid'] . ' and sp_status=2';
					$auditNum = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteamperson', $q2 );
					$passNum = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteamperson', $q3 );
					$res [$k] ['auditNum'] = $auditNum;
					$res [$k] ['passNum'] = $passNum;
				}
			}
			$fail = array();
			foreach ( $res as $k => $v ) {
				if ($tag == 3) {
					$fail = $this->db->get_one('form__bjhh_dictbl',"id={$v['reason']}");
					$v['fail_name'] = $fail['name'];
				}
				$v ['foundingtime'] = date ( 'Y-m-d H:i:s', $v ['foundingtime'] );
				$v ['edittime'] = date ( 'Y-m-d H:i:s', $v ['edittime'] );
				if ($v ['agree'] == '1') {
					$v ['agree'] = '申请中';
				} else if ($v ['agree'] == '2') {
					$v ['agree'] = '已通过';
				} else if ($v ['agree'] == '3') {
					$v ['agree'] = '未通过';
				}
				$res [$k] = $v;
			}
			return $res;
		
		}
	
	}
	
	public function deleteOne($deleteid) {
		$datas ['deltag'] = '1';
		$this->search->delInfo ( '2', $deleteid );
		return $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, "recordid=$deleteid" );
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
		$data ['img_url'] = $post ['thumb_url'];
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