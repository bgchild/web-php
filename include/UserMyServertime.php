<?php

include_once ("user.php");
/**
 * 
 * 我的志愿服务时间
 */

class UserMyServertime extends user {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function getActivityTypes($typename='活动类型') {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ", $limit = array(limit=>'0,9999999'),' order by b.listorder desc');
	}

	
	public function getOneRecords($tag,$query, $limt){	
		$pid = $this->getUser ( 0 );
		if($tag=="1"){

		$where = "a.uid=b.recordid and b.serviceid=c.recordid and a.pid='$pid' and a.delstatus='0' and b.delTag='0' and a.status=4";
		
		foreach ( $query as $key => $val ) {
			$val = trim ( $val );
			if ($key == 'serviceteamname') {
				$where .= " and $key like '%" . $val . "%' ";
				continue;
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
			if ($key == 'activityType') {
				$where .= " and $key='$val' ";
			}
		}
		
		$a = "form__bjhh_activity_personadd";
		$b = "form__bjhh_activityexamine_activityinfo";
		$c = "form__bjhh_serviceteammanage_addserviceteam";
		$fields = "a.recordid as recid,a.*,b.*,c.*";
		$this->count = $this->db->get_association_count ( $a, $b, $c, $where );
		$order = " order by adddate  DESC";
		$records = $this->db->get_association_info ( $a, $b, $c, $where, $limit = array (limit => $limt ), $order, $fields );
		
		$type = $this->getActivityTypes ();
		  
		foreach ( $records as $key => $val ) {

			$val ['activityStartDate'] = date ( "Y-m-d", $val ['activityStartDate'] );
			$val ['activityEndDate'] = date ( "Y-m-d", $val ['activityEndDate'] );
			
			$records [$key] = $val;
		}
		
		return $records;
			
		}else if($tag=="2"){
			  $condition = "pid=".$pid;
			  $this->count=$this->db->get_count('form__bjhh_workinghours', $condition);
			  $mytime = $this->db->getall( 'form__bjhh_workinghours', $condition, array(limit=>$limt), $fields = '*',' order by date DESC');
			  return $mytime;
		}else{
			return false;
		}
	}
	
	
	
	public function getRecordsCount() {
		return $this->count;
	}

	
	public function editRecord($data){
		foreach($data as $key=>$val) $data[$key]=trim($val);
		if(isset($data['content'])) $datas['content']=jsformat($data['content']);
		$affected=$this->db->get_one('form__bjhh_activity_personadd'," recordID=".$data['recordid']) ;
		$datas[fromid] = $affected[pid];
		$person = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo'," recordid=".$datas['fromid']) ;
		$datas[fromname] = $person[username];
		$datas[fno] = $affected[uid];

		$activity = $this->db->get_one('form__bjhh_activityexamine_activityinfo'," recordid=".$datas['fno']) ;
		$datas[toid] = $activity[cid];
   		//$isno = $this->db->get_one('form__bjhh_message',"toid=$datas[toid] and fromid=$datas[fromid] and fno=$datas[fno] and isread=0") ;
   		//if($isno)	return false;
   		$p2 = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=" . $datas ['toid'] );
		$datas ['toname'] = $p2 ['username'];
		$datas[status] = 1;
		$datas[date] = time();
		$end = $this->db->add('form__bjhh_message',$datas) ;
		if($end) return $end;
		else return false;
	}

	
	public function getOneRecord($recordid){
		return  $this->db->get_one('form__bjhh_activity_personadd', " recordID=".$recordid) ;
	}
	
	public function getMyServertime($id){
		  $person = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=".$id);
		  return $person['allservertime'];
	}
    /**
     *志愿者服务证明信息
     */
    public function fwinfo(){
    $uid=$this->getUser ( 0 );
    $arr=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=".$uid,'name,idtype,idnumber,allservertime,sign');
    $data=array();
    $data['name']=$arr['name'];
    $data['bh']=$this->fwcode($uid,$arr['sign']);
    $idtype=$this->db->get_one('form__bjhh_dictbl',"id=".$arr['idtype'],'name');
    $data['idtype']=$idtype['name'];
    $data['idno']=$arr['idnumber'];
    $data['fwtime']=$arr['allservertime'];
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