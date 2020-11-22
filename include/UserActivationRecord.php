<?php
include_once ("user.php");
/**
 * 
 * 我的活动记录
 */
class UserActivationRecord extends user {
	private $count = 0;
	public function __construct() {
		parent::__construct ();
	}
	/**
	 * 获取个人活动记录
	 */
	function getMyRecordsByStatus($query, $limt) {
		$pid = $this->getUser ( 0 );
		$where = "a.uid=b.recordid and b.serviceid=c.recordid and a.pid='$pid' and a.delstatus='0' and b.delTag='0' and (b.status='3' or b.status='4')";
		foreach ( $query as $key => $val ) {
			$val = trim ( $val );

			if ($key == 'activityName') {
				$where .= " and $key like '%" . $val . "%' ";
				continue;
			}
			if ($key == 'serviceteamname') {
				$where .= " and $key like '%" . $val . "%' ";
				continue;
			}
			if ($key == 'status' && $val ['status'] != '0') {
				$key = 'a.' . $key;
			}
			if ($key == 'activityStartDate') {
				$val = strtotime ( $val . '00:00:00' );
				$where .= " and $key >=$val ";
				continue;
			}
			if ($key == 'activityEndDate') {
				$val = strtotime ( $val . '23:59:59' );
				$where .= " and $key <=$val  ";
				continue;
			}
			if ($val ['status'] != '0') {
				$where .= " and $key='$val' ";
			}
		}
		$a = "form__bjhh_activity_personadd";
		$b = "form__bjhh_activityexamine_activityinfo";
		$c = "form__bjhh_serviceteammanage_addserviceteam";
		$fields = "b.recordid as brecordid ,a.status as astatus ,b.status as bstatus ,a.*,b.*,c.*";
		$this->count = $this->db->get_association_count ( $a, $b, $c, $where );
		$order = " order by astatus ASC,adddate  DESC";
		$records = $this->db->get_association_info ( $a, $b, $c, $where, $limit = array (limit => $limt ), $order, $fields );
		$type = $this->getActivityTypes();
		//格式化个人活动记录信息	  
		foreach ( $records as $key => $val ) {
			$val ['applyNum'] = $this->countPeople ( $val ['brecordid'] );
			foreach ( $type as $k => $v ) {
				if ($v ['id'] == $val ['activityType']) {
					$val ['typename'] = $v ['name'];
					break;
				}
			}
			$val ['activityStartDate'] = date ( "Y-m-d", $val ['activityStartDate'] );
			$val ['activityEndDate'] = date ( "Y-m-d", $val ['activityEndDate'] );
			
			if ($val ['astatus'] == "1") {
				$val ['astatus'] = "报名中";
				$val ['opp'] = "取消";
			} elseif ($val ['astatus'] == "2") {
				$val ['astatus'] = "已通过";
				if($val[cid]!=$val[pid]) $val ['opp'] = "放弃";
			} elseif ($val ['astatus'] == "3") {
				$val ['astatus'] = "未通过";
				$val ['opp'] = "删除";
			} elseif ($val ['astatus'] == "4") {
				$val ['astatus'] = "已参加";
				$val ['opp'] = "删除";
			}
			$records [$key] = $val;
		}
		return $records;
		
	}
	
	/**
	 * 获取活动类型
	 */
	public function getActivityTypes($type) {
		$a = 'form__bjhh_dictbl';
		if ($type) {
			$where = "tcode='008' and id='$type'";
			$arr = $this->db->get_one ( $a, $where );
			return $arr ['name'];
		}
		$where = "tcode='008'";
		return $this->db->getall ( $a, $where );
	}
	
	public function getMyRecordsByStatusCount() {
		return $this->count;
	}
	/**
	 * 
	 *统计报名人数
	 */
	public function countPeople($recordid) {
		$table = "form__bjhh_activity_personadd";
		$people = $this->db->get_count ( $table, "uid='$recordid' " );
		return $people;
	}
	/**
	 * 删除一条记录
	 */
	public function deleteOneRecord($recordid) {
		$a = "form__bjhh_activity_personadd";
		$where = "recordID=$recordid";
		return $this->db->drop ( $a, $where );
	}
	/**
	 * 放弃
	 */
	public function editRecord($data) {
		$id = $this->getUser ( 0 );
		$name=$this->getUser(1);
		if (isset ( $data['cancelreason'] ))
		$datas ['content'] = jsformat ( $data['cancelreason'] );
		$datas ['fromid'] = $id;
		$datas ['fromname'] = $name;
		$personadd = $this->db->get_one ( 'form__bjhh_activity_personadd', " recordID=" . $data ['recordid'] );
		$activity=$this->db->get_one('form__bjhh_activityexamine_activityinfo',"recordid=" . $personadd['uid']);
		$datas ['fno']= $personadd['uid'];
		$datas ['toid']= $activity['cid'];
        $info=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=" . $datas ['toid']);
        $datas ['toname']= $info['username'];
        $datas ['status'] = 7;
		$datas ['date'] = time ();
		$message = $this->db->add ( 'form__bjhh_message', $datas );
		$affected=$this->db->drop ( 'form__bjhh_activity_personadd', " recordID=" . $data ['recordid'] );
		if ($affected)
			return true;
		else
			return false;
	}
	
	/**
	 * 获取一条详细记录
	 */
	public function getDetailActivity($rid) {
		$a = 'form__bjhh_activityexamine_activityinfo';
		$b = 'form__bjhh_serviceteammanage_addserviceteam';
		$fields = "a.recordid as arecordid ,a.*,b.*";
		$records = $this->db->get_relations_one ( $a, $b, "a.recordid='$rid' and a.serviceid=b.recordid", $fields );
		//格式化个人活动记录信息	  
		$records ['activityType'] = $type = $this->getActivityTypes ( $records ['activityType'] );
		$records ['creattime'] = date ( "Y-m-d G:i:s", $records ['creattime'] );
		$records ['signUpDeadline'] = date ( "Y-m-d ", $records ['signUpDeadline'] );
		$records ['activityStartDate'] = date ( "Y-m-d G:i", $records ['activityStartDate'] );
		$records ['activityEndDate'] = date ( "Y-m-d G:i", $records ['activityEndDate'] );
		$records ['cid'] = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', "recordid='$records[cid]'" );
		return $records;
	}
	
	public function getOneRecord($recordid) {
		return $this->db->get_one ( 'form__bjhh_activity_personadd', " recordID=" . $recordid );
	}
	
	public function getPerson($id, $limt) {
		$pid = $this->getUser ( 0 );
		$this->personCount = $this->db->get_count ( 'form__bjhh_activity_personadd', "uid=$id and pid!=$pid" );
		$per = $this->db->getall ( 'form__bjhh_activity_personadd', "uid=$id and pid!=$pid", $limit = array (limit => $limt ) );
		foreach ( $per as $k => $v ) {
			$von = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$v[pid]" );
			$per [$k] [username] = $von [nickname];
			$per [$k] [cid] = $von [recordid];
		}
		return $per;
	}
	public function getPCount() {
		return $this->personCount;
	}
	
	public function addRecord($data) {
		$id = $this->getUser ( 0 );
		foreach ( $data as $key => $val )
			$data [$key] = trim ( $val );
		if (isset ( $data ['content'] ))
		$datas ['content'] = jsformat ( $data ['content'] );
		$datas ['fromid'] = $id;
		$p1 = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=" . $id );
		$datas ['fromname'] = $p1 ['username'];
		$affected = $this->db->get_one ( 'form__bjhh_activity_personadd', " recordID=" . $data ['recordid'] );
		$datas ['toid'] = $affected ['pid'];
		$datas ['fno'] = $affected ['uid'];
		$p2 = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=" . $datas ['toid'] );
		$datas ['toname'] = $p2 ['username'];
		$datas ['status'] = 6;
		$datas ['date'] = time ();
		$end = $this->db->add ( 'form__bjhh_message', $datas );
		if ($end)
			return $end;
		else
			return false;
	}
    /**
     *志愿者服务证明信息
     */
    public function fwinfo($chose){
        $uid=$this->getUser ( 0 );
        $arr=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=".$uid,'name,idtype,idnumber,allservertime,sign');
        //活动信息
        $activty=$this->db->get_one('form__bjhh_activityexamine_activityinfo',"recordid=".$chose,'activityName');
        //活动服务时间
        $fwtime=$this->db->get_one('form__bjhh_activity_personadd',"pid=$uid and uid=".$chose,'time');
        $data=array();
        $data['name']=$arr['name'];
        $data['bh']=$this->fwcode($uid,$arr['sign']);
        $idtype=$this->db->get_one('form__bjhh_dictbl',"id=".$arr['idtype'],'name');
        $data['idtype']=$idtype['name'];
        $data['idno']=$arr['idnumber'];
        $data['fwtime']=$fwtime['time'];
        $data['fwcon']= $activty['activityName'];
        return $data;
    }
    /**
     * 志愿者服务证明编码
     */
    public function fwcode($uid,$sign){
        if(!($uid && $sign)) return false;
        $porder=$this->db->get_one('form__bjhh_fwbm',"uid=$uid","porder");
        $dq=$this->db->get_one('form__bjhh_area',"sign='{$sign}'","listorder");
        if($porder[porder]){
            $order=$porder[porder];
        }else{
            $pdatas=array();
            $pdatas['uid']=$uid;
            $pdatas['sign']=$sign;
            $porder=$this->db->get_one('form__bjhh_fwbm',"sign='{$sign}'","sum(sign='$sign') as a");
            $pdatas['porder']=sprintf("%05d",$porder[a]+1);
            $this->db->add('form__bjhh_fwbm', $pdatas);
            $order=$pdatas['porder'];
        }
        $fwbm=$dq['listorder'].$order;
        return $fwbm;
    }
}

?>