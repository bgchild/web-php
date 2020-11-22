<?php
include_once ("ServiceTeam.php");
/**
 * 
 * 服务队邀请
 * 
 */
class ServiceTeamInvite extends ServiceTeam {
	//分页条数
	private $count = 0;
	
	/**
	 * 继承服务队类的构造方法
	 */
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 取出所有志愿者信息
	 * @param array $query (一维) 例如：$query['servcieid']='1'
	 * @param string $limit 例如：('0,2')
	 * @return array $arr (二维)
	 */
	public function init($query, $limit, $serid) {
		//数据初始化
		$uid = $this->getUser ( 0 );
		$serInfo = array ();
		$userArr = array ();
		$useInfo = array ();
		$serStr = '';
		
		
		//取出当前登录用户的信息并过滤
		$useInfo = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='$uid' " );
		$serStr .= ",'" . $useInfo ['name'] . "'";
		
		//读取信息表信息
		if (! empty ( $serid )) {
			$serInfo = $this->db->getall ( 'form__bjhh_message', " fno='$serid' and isagree in ('0','1') and status='3' " );
		}
		
		//判断是否存在并做字符串拼接处理
		if ($serInfo) {
			foreach ( $serInfo as $k => $v ) {
				$userArr = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid='{$v['toid']}' " );
				$serStr .= ",'" . $userArr ['name'] . "'";
			}
		}
		
		//过滤左边的,符号
		$serStr = ltrim ( $serStr, ',' );
		//初始查询条件
		//$where = "a.recordid = b.rid where a.status in ('010','001') and a.name not in ($serStr) and a.sign='{$useInfo['sign']}'  ";
		$where = "where a.status in ('010','001') and a.name not in ($serStr) and a.sign='{$useInfo['sign']}'  ";
		//$where = "a.recordid = b.rid where a.status in ('010','001') and a.sign='{$useInfo['sign']}'  ";

		//搜索条件处理
		foreach ( $query as $k => $v ) {
			//服务队
			if ($k == "serviceteamname") {
				if ($v) {
					$q = " serviceteamid='$v' and sp_status='2'";
					$arr2 = $this->db->getall ( 'form__bjhh_serviceteammanage_addserviceteamperson', $q );
					
					foreach ( $arr2 as $k => $v ) {
						$val .= $v ['serviceteamcaptainid'] . ',';
					}
					
					$res = rtrim ( $val, ',' );
					
					if ($res)
						$where .= " and a.recordid in ($res) ";
					else
						$where .= " and a.recordid in ('') ";
				
				}
				
				continue;
			
			}
			//姓名
			if ($k == "name") {
				if ($v)
					$where .= " and a." . $k . " like '%" . $v . "%' ";
				;
				continue;
			}
			//专业技能
			if ($k == "features") {
				/*foreach ( $v as $val )
					$where .= " and concat(',',b.features,',')  like concat('%,','" . $val . "' ,',%') ";*/
				foreach ( $v as $val ) {
					$features[] = $val;
				}
			}
		}


		/*查询处理*/
		$sql = '';
		$sql2 = '';
		$a = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$b = 'form__bjhh_volunteermanage_volunteerextendinfo';
		//$fields = 'a.recordid,a.name,a.birthday,a.sex,a.status,a.applytime,b.rid,b.features';
		$fields = 'a.recordid,a.name,a.birthday,a.sex,a.status,a.applytime';
		$orders = "order by a.applytime  DESC";
		/*$sql = " select $fields from $a as a left join $b as b on $where $orders";
		$sql2 = "select count(*) from ($sql) as tmp";*/
		$sql = "select $fields from $a as a $where $orders";

		$this->count = $this->getNum ( $sql );
		$arr = $this->getArr ($sql);
		$map = [];
		foreach($arr as $v) {
			$ids[] = $v['recordid'];
			$map[$v['recordid']] = $v;
		}
		if (count($ids)) {
			$string = join("','", $ids);
			$sql2 = "select b.rid, b.features from $b as b where rid IN('$string')";
			$arr2 = $this->getArr ( $sql2);
			foreach($arr2 as $v) {
				if (empty($features) || (!empty($features) && in_array($v['features'], $features))) {
					$rids[] = $v['rid'];
				}
			}
		}

		$string = join("','", $rids);
		$sql = "select $fields from $a as a where recordid IN('$string') $orders";
		$sql2 = "select count(*) from ($sql) as tmp";
		$arr = $this->getArr ( $sql, array (limit => $limit ) );
		$this->count = $this->getNum ( $sql2 );

		$map = [];
		foreach($arr as $v) {
			$ids[] = $v['recordid'];
			$map[$v['recordid']] = $v;
		}
		if (!empty($arr2)) {
			foreach($arr2 as $v) {
				if ($map[$v['rid']]) {
					$map[$v['rid']]['features'] = $v['features'];
					$rids[] = $v['rid'];
				}
			}
		}

		$arr = [];
		foreach($map as $v) {
			if (empty($features) || (!empty($features) && in_array($v['features'], $features))) {
				$arr[] = $v;
			}
		}

		foreach ( $arr as $k => $v ) {
			if ($v ['sex'] == '1') {
				$v ['sex'] = '男';
			} else {
				$v ['sex'] = '女';
			}
			$v ['birthday'] = date ( 'Y', time () ) - date ( 'Y', $v ['birthday'] );
			$v ['features'] = $this->strHandle ( $v ['features'] );
			$arr [$k] = $v;
		}
		return $arr;
	}
	
	/**
	 * 取出所有服务队信息
	 * @return array $arr(二维)
	 */
	public function getAllServieTeam() {
		$arr = array ();
		$arr = $this->db->getall ( 'form__bjhh_serviceteammanage_addserviceteam' );
		return $arr;
	}
	
	/**
	 * 获取总页数
	 * @return number 
	 */
	public function getCount() {
		return $this->count;
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
	 * 服务队发送邀请
	 * @param string $servid 服务队主键
	 * @param array $seArr checkbox session数组
	 * @return bool $affected  判断发送成功状态
	 */
	public function sendInvite($servid, $seArr) {
		//变量初始化
		$datas = array ();
		$arr = array ();
		$arr2 = array ();
		$affected = null;
		
		//判断参数是否为空
		if (! $servid) {
			return false;
		}
		if (! $seArr) {
			return false;
		}
		
		//定义发送参数
		$datas ['fromid'] = $this->getUser ( 0 );
		$datas ['fromname'] = $this->getUser ( 1 );
		//根据服务队id取出服务队名
		$arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid='$servid'" );
		$datas ['content'] = "服务队 【" . $arr ['serviceteamname'] . "】 邀请您加入";
		$datas ['date'] = time ();
		$datas ['status'] = '3';
		$datas ['fno'] = $servid;
		
		//循环session 中checkbox id
		foreach ( $seArr as $k => $v ) {
			//取出志愿者表信息
			$arr2 = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', 'recordid=' . $v );
			$datas ['toid'] = $v;
			$datas ['toname'] = $arr2 ['username'];
			//判断信息是否已经发过
			$where = " fromid='{$datas ['fromid']}' and toid='{$datas ['toid']}' and fno='{$datas ['fno']}' and isagree in ('0','1') and status='3'  ";
			$affected = $this->db->get_one ( 'form__bjhh_message', $where );
			
			if (! $affected) {
				$affected = $this->db->add ( 'form__bjhh_message', $datas );
			} else {
				$affected = false;
			}
		
		}
		return $affected;
	}
	
	/**
	 * 执行sql语句,获得符合条件的数据个数  
	 * @param string $sql
	 * @return array|bool 
	 */
	private function getNum($sql) {
		$arr = array ();
		$res = $this->db->db->query ( $sql );
		if ($res !== false) {
			while ( $row = mysql_fetch_row ( $res ) ) {
				$arr = $row;
			}
			return $arr [0];
		} else {
			return false;
		}
	
	}
	
	/**
	 * 执行sql语句,获得符合条件的数组
	 * @param string $sql
	 * @param  $limit  条数
	 * @return multitype: array|boolean
	 */
	private function getArr($sql, $limit = array(limit=>'0,9999999')) {
		$arr = array ();
		$sql = $sql . " limit " . $limit [limit];
		
		$res = $this->db->db->query ( $sql );
		if ($res !== false) {
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr [] = $row;
			}
			return $arr;
		} else {
			return false;
		}
	
	}

}

?>