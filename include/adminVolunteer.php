<?php
include_once('adminBase.php');
/**
 * 
 * 志愿者管理
 */
class adminVolunteer extends adminbase {
	public function __construct() {
		parent::__construct ();
	}


	public function _setAreaName($arr,$colname) {
		$area= $this->db->get_one("pubmodule_area_tbl", " areaId='".$arr[$colname]."'");
		$arr[$colname]=$area['areaName'];
		return $arr;
	}

	public function getTypes($typename='活动类型') {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder desc');
	}
	private function _addExtInfo($arr,$tagname,$colname,$valname){
		$types=$this->getTypes($tagname);
		$skills=split(",", $arr[$colname]);
		$skillnames="";
	    foreach($skills as $p) {
	    	 foreach($types as $type) 
	    	 	if($p==$type['id'])
	    	 		$skillnames.=$type['name'].","; 
	    }
	    $arr[$valname]=substr($skillnames,0,-1)?substr($skillnames,0,-1):"无";
	    return $arr;
	}


public function init($status,$name){
	$arr=array();	
	//$conditions = " status!='010' and  status!='100' ";
	$conditions = " status='1000' and sign='$_SESSION[sign]' ";
	//if($status) $conditions .= " and status='$status'  ";
	if($name) $conditions.=" and name like '%$name%' ";
	$nowtime=time();
	$t=trim($_GET['t']);
	$vol_font='0';
	if($t=='7day'){
		$begintime=$nowtime-7*24*60*60;	
		$vol_font='7';
	}
	elseif($t=='30day'){
		$begintime=$nowtime-30*24*60*60;	
		$vol_font='30';
	}
	elseif($t=='90day'){
		$begintime=$nowtime-90*24*60*60;
		$vol_font='90';	
	}
	elseif($t=='180day'){
		$begintime=$nowtime-180*24*60*60;	
		$vol_font='180';
	}
	if($t)$conditions.="  and applytime>$begintime";
	$page   =  _get_page(10); 
	$list = $this->db->getAll('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions,array('limit'=>$page['limit']),'*'," order by recordid DESC ");
	$page['item_count'] = $this->db->get_count('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions); 
	$page = _format_page($page);
	$arr['list']=$list;
	$arr['page']=$page;
	$arr['vol_font']=$vol_font;
	return $arr;
}	

public function detail(){
	$spm=get_url($_GET['spm']);
    if(!$spm) $this->db->get_show_msg('volunteer.php','参数错误！');
    $id=$spm[id];
    $hasF=false;
    if($this->db->get_one('form__bjhh_volunteermanage_volunteerextendinfo'," rid=$id")){
    	$hasF=true;
    	$where="a.rid=b.recordid and b.recordid='$id' ";
    	$info=$this->db->get_relations_one("form__bjhh_volunteermanage_volunteerextendinfo","form__bjhh_volunteermanage_volunteerbasicinfo",$where);
    }else {
    	$info=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$id");
    }
	if(!$info)$this->db->get_show_msg('volunteer.php','参数错误！');
	$info=$this->_addExtInfo($info,"民族","race","race");
	$info=$this->_addExtInfo($info,"政治面貌","politicalstatus","politicalstatus");
	$info=$this->_addExtInfo($info,"证件类型","idtype","idtype");
	$info=$this->_addExtInfo($info,"技能特长","features","features");
	$info=$this->_addExtInfo($info,"服务项目","serveitem","serveitem");
	$info=$this->_addExtInfo($info,"学历","lasteducation","lasteducation");
	$info=$this->_addExtInfo($info,"国籍","nationality","nationality");
	$info=$this->_setAreaName($info,"province");
	$info=$this->_setAreaName($info,"city");
	$info=$this->_setAreaName($info,"area");
	$info=$this->_setAreaName($info,"serveprovince");
	$info=$this->_setAreaName($info,"servecity");
	$info=$this->_setAreaName($info,"servearea");
	$files=explode("/",substr($info['moduleName'], 1));
	$info['filename']=array_pop($files);
    return $info;
}

public function edit($datas,$conditions){
    $info=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, $conditions);
}


public  function yes($status="001"){
	$ads=$_POST['aid'];
	$backurl=$this->getBackUrl();
	if(!$ads)$this->db->get_show_msg($backurl,'请选择至少一个志愿者！');
	$datas=array();
	$datas['status']=$status;
	$user=$this->getUser();
	$datas['auditor']=$user[0];
	$ids= implode(',', $ads);
	$conditions=" recordid in ($ids)";
	$result=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, $conditions);
	$this->db->get_show_msg($backurl,'批量通过操作成功！');
}

public  function no($status="011"){
    $ads=$_POST['aid'];
	$backurl=$this->getBackUrl();
	//if(!$ads)$this->db->get_show_msg($backurl,'请选择至少一个志愿者！');
	$datas=array();
	$datas['refusedreason']=$_POST['refusedreason'];
    $datas['refusedremark']=$_POST['refusedremark'];
	$datas['status']=$status;
	$user=$this->getUser();
	$datas['auditor']=$user[0];
	$ids= implode(',', $ads);
	$conditions="recordid in ($ids)";
	$result=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, $conditions);
	//$this->db->get_show_msg($backurl,'批量通过操作成功！');
}

public function reactive($id){
	$datas['status']='001';//通过初审
	$datas['logoutedtime']='';
	$datas['logoutedreason']='';
	$result=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, "recordid='".$id."'");
	$uname=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$id","name");
	//log
	$arr=array();
	$arr[type]='26';
	$arr[module]='2';
	$arr[name]=$uname[name];
	$this->doLog($arr);
	$this->db->get_show_msg($this->getBackUrl("volunteerManage.php"),'激活成功！');
}

public function logout($id){
	$datas['status']='100';//注销
	$datas['logoutedtime']=time();
	$currentUser=$this->getUser();
	$datas['logoutedreason']=$currentUser[0];
	$result=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, "recordid='".$id."'");
    $uname=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$id","name");
	//log
	$arr=array();
	$arr[type]='25';
	$arr[module]='2';
	$arr[name]=$uname[name];
	$this->doLog($arr);
	$this->db->get_show_msg($this->getBackUrl("volunteerManage.php"),'注销成功！');
}
public function dlout($id){
    $uname=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$id","name");
    $this->db->drop('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid='".$id."'");
    $this->db->drop('form__bjhh_volunteermanage_volunteerextendinfo',"rid='".$id."'");
    //log
    $arr=array();
    $arr[type]='27';
    $arr[module]='2';
    $arr[name]=$uname[name];
    $this->doLog($arr);
    $this->db->get_show_msg($this->getBackUrl("volunteerManage.php"),'删除成功！');
}

/**
 * 总会专用
 **/
public function allVolunteersWithWWW($status,$name,$stime,$etime,$sign) {
	$arr=array();

	$conditions = "  1=1 ";
	//$conditions = "  1=1 and sign='$_SESSION[sign]'";
	if($stime) {
		$stime = strtotime($stime." 00:00:00");
		$conditions .= " and applytime > $stime ";
	}
	if($etime) {
		$etime = strtotime($etime." 23:59:59");
		$conditions .= " and applytime < $etime ";
	}
	if($status) $conditions .= " and status='$status'  ";
	if($name) $conditions.=" and name like '%$name%' ";
	if($sign && $sign != 'all') $conditions.=" and sign ='$sign' ";
	$nowtime=time();
	$t=trim($_GET['t']);
	$vol_font='0';
	if($t=='7day'){
		$begintime=$nowtime-7*24*60*60;
		$vol_font='7';
	}
	elseif($t=='30day'){
		$begintime=$nowtime-30*24*60*60;
		$vol_font='30';
	}
	elseif($t=='90day'){
		$begintime=$nowtime-90*24*60*60;
		$vol_font='90';
	}
	elseif($t=='180day'){
		$begintime=$nowtime-180*24*60*60;
		$vol_font='180';
	}
	if($t)$conditions.="  and applytime>$begintime";
	$page   =  _get_page(10);
	$list = $this->db->getAll('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions,array('limit'=>$page['limit']),'*'," order by recordid DESC ");
	$page['item_count'] = $this->db->get_count('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions);
	$page = _format_page($page);
	$arr['list']=$list;
	$arr['page']=$page;
	$arr['vol_font']=$vol_font;
	return $arr;
}

public function allVolunteers($status,$name,$stime,$etime,$sign){
	$arr=array();
	$conditions = "  1=1 and sign='$_SESSION[sign]'";
	if($stime) {
		$stime = strtotime($stime." 00:00:00");
		$conditions .= " and applytime > $stime ";
	}
	if($etime) {
		$etime = strtotime($etime." 23:59:59");
		$conditions .= " and applytime < $etime ";
	}
	if($status) $conditions .= " and status='$status'  ";
	if($name) $conditions.=" and name like '%$name%' ";
	if($sign) $conditions.=" and sign ='$sign' ";
	$nowtime=time();
	$t=trim($_GET['t']);
	$vol_font='0';
	if($t=='7day'){
		$begintime=$nowtime-7*24*60*60;	
		$vol_font='7';
	}
	elseif($t=='30day'){
		$begintime=$nowtime-30*24*60*60;
		$vol_font='30';	
	}
	elseif($t=='90day'){
		$begintime=$nowtime-90*24*60*60;	
		$vol_font='90';
	}
	elseif($t=='180day'){
		$begintime=$nowtime-180*24*60*60;	
		$vol_font='180';
	}
	if($t)$conditions.="  and applytime>$begintime";
	$page   =  _get_page(10); 
	$list = $this->db->getAll('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions,array('limit'=>$page['limit']),'*'," order by recordid DESC ");
	$page['item_count'] = $this->db->get_count('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions); 
	$page = _format_page($page);
	$arr['list']=$list;
	$arr['page']=$page;
	$arr['vol_font']=$vol_font;
	return $arr;
}	


/**
 * 
 * 获取导出当前页的recordid
 * @param unknown_type $status
 * @param unknown_type $name
 */
public function getPageVolunteers($status,$name,$stime,$etime,$sign){
	$arr=array();	
	$conditions = "  1=1 and sign='$_SESSION[sign]'";
	if($status) $conditions .= " and status='$status'  ";
	if($name) $conditions.=" and name like '%$name%' ";
	if($sign) $conditions.=" and sign = '$sign' ";
	if($stime) {
		$stime = strtotime($stime." 00:00:00");
		$conditions .= " and applytime > $stime ";
	}
	if($etime) {
		$etime = strtotime($etime." 23:59:59");
		$conditions .= " and applytime < $etime ";
	}
	$list = $this->db->getAll('form__bjhh_volunteermanage_volunteerbasicinfo',$conditions,array('limit'=>9999999),'recordid'," order by recordid DESC ");
	return $list;
}	


/**
 * 
 * 获取导出数据
 * @param array $ids
 */
public function batch_export($ids){
    set_time_limit(0);
    $list = array();
	foreach ($ids as $v){
		$id = $v['recordid'];
		$info = $this->get_detail($id);
		if($info){
			
			$info['sex'] = $info['sex']=='1'?'男':'女'; //性别
			$info['birthday'] = date('Y-m-d',$info['birthday']); //出生日期
			$info['applytime'] = date('Y-m-d',$info['applytime']); //申请时间
			$info['jzd'] = $info['province']?$info['province']." - ".$info['city']." - ".$info['area']:''; //居住地
			$info['isstudent'] = $info['isstudent']==1?"是":"否"; //是否学生
			$info['fwdd'] = $info['serveprovince']?$info['serveprovince']." - ".$info['servecity']." - ".$info['servearea']:''; //服务地点
			
			$info['idnumber'] = $info['idnumber']?"'".$info['idnumber']:''; //证件号
			$info['cellphone'] = $info['cellphone']?"'".$info['cellphone']:''; //手机
			$info['telephone'] = $info['telephone']?"'".$info['telephone']:''; //固定电话
			$info['qq'] = $info['qq']?"'".$info['qq']:''; //QQ

			$info['hnumber'] = $info['hnumber']?"'".$info['hnumber']:''; //志愿者编码
			if($info['sdomain']){
			  $sdmaindata = $this->db->get_one('form__bjhh_servearea','id = '.$info['sdomain'],'sdomain');
			  $info['sdomain'] = $sdmaindata['sdomain'];
			}
			$list[] = $info;
			
		}
	}
	return $list;
}
public function get_detail($id){

    $hasF=false;
    if($this->db->get_one('form__bjhh_volunteermanage_volunteerextendinfo'," rid=$id")){
    	$hasF=true;
    	$where="a.rid=b.recordid and b.recordid='$id' ";
    	$info=$this->db->get_relations_one("form__bjhh_volunteermanage_volunteerextendinfo","form__bjhh_volunteermanage_volunteerbasicinfo",$where);
    }else {
    	$info=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$id");
    }
	if(!$info) return false;
	$info=$this->_addExtInfo($info,"民族","race","race");
	$info=$this->_addExtInfo($info,"政治面貌","politicalstatus","politicalstatus");
	$info=$this->_addExtInfo($info,"证件类型","idtype","idtype");
	$info=$this->_addExtInfo($info,"技能特长","features","features");
	$info=$this->_addExtInfo($info,"服务项目","serveitem","serveitem");
	$info=$this->_addExtInfo($info,"学历","lasteducation","lasteducation");
	$info=$this->_addExtInfo($info,"国籍","nationality","nationality");
	$info=$this->_setAreaName($info,"province");
	$info=$this->_setAreaName($info,"city");
	$info=$this->_setAreaName($info,"area");
	$info=$this->_setAreaName($info,"serveprovince");
	$info=$this->_setAreaName($info,"servecity");
	$info=$this->_setAreaName($info,"servearea");
	$files=explode("/",substr($info['moduleName'], 1));
	$info['filename']=array_pop($files);
    return $info;
}
/*
	 * 添加工时
	 */
	function addWorkingHours($data){
		$uname=$this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid={$data['pid']}","name");
		//log
		$arr=array();
		$arr[type]='24';
		$arr[module]='2';
		$arr[name]=$uname[name];
		$this->doLog($arr);
		foreach($data as $key=>$val) $data[$key]=trim($val);
		$p = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=".$data['pid']);
        if($p['status']=='001'||$p['status']=='010'){
            if($data['types']==1){
                $time = $p[allservertime] + $data[workinghours];
            }else{
                $time = $p[allservertime] - $data[workinghours];
            }
			$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo',"allservertime=".$time,"recordid=".$data['pid']);
			$end = $this->db->add('form__bjhh_workinghours',$data) ;
		    if($end) return true;
		    else return false;
		}
	}
	
	
	//查询志愿者编号是否唯一
	function checkHnumber($data){
		$result = $this->db->get_one("form__bjhh_volunteermanage_volunteerbasicinfo","hnumber='".$data["hnumber"]."' and recordid != ".$data["recordid"]);
		if($result){
			return true;
		}else{
			return false;		
		}
	}
	//重置用户密码12345678
    function repassword($rid){
        $info=$this->db->get_one("form__bjhh_volunteermanage_volunteerbasicinfo","recordid = ".$rid,'encrypt');
        if(!info) return false;
        $datas=array();
        $datas['password']=password('12345678',$info['encrypt']);
        $res=$this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', $datas, " recordid=$rid ");
        if($res){
            return true;
        }else{
            return false;
        }

    }
}

?>