<?php
include_once('adminBase.php');
/**
 * 
 * 评优管理添加
 */
class adminAppraisingSaveAdd extends adminbase {
	public function __construct() {
		parent::__construct ();
	}
//隐藏选择人
public function selectInit($name = '',$guarderidnumb='',$limit = array(limit=>'0,9999999')) {
		$sign = array();
	$sign = $this->getCityInfo();
		$where = " status in ('001','010') and sign='{$sign['sign']}'  ";
		if ($name)
			$where .= " and name like '%" . $name . "%' ";
		if($guarderidnumb)
			$where .= " and idnumber like '%" . $guarderidnumb . "%' ";
		$a = 'form__bjhh_volunteermanage_volunteerbasicinfo';
		$count = $this->db->get_count ( $a,$where );
		
		$list = $this->db->getall( $a, $where ,$limit);
		foreach ( $list as $k => $v ) {
			if ($v ['sex'] == '1') {
				$v ['sex'] = '男';
			} else {
				$v ['sex'] = '女';
			}
			$v ['birthday'] = date ( 'Y', time () ) - date ( 'Y', $v ['birthday'] );
			//$v ['features'] = $this->strHandle ( $v ['features'] );
			$list [$k] = $v;
		}
		return $list;
	}
//
public function init($id){

	$q1 = "";
    if($id)$q1.="recordID=$id";
		return $this->db->get_one('form__bjhh_superiormanage_addwinner',$q1);

	}

public function editRecord($post){
			foreach($post as $key=>$val) $post[$key]=trim($val);
				$datas=array();
				$datas[prizewinner]=$post[prizewinner];	
				$datas[receivedate]=strtotime($post[receivedate]);	
				$datas[winaddress]=$post[winaddress];	
				$datas[wincontent]=$post[wincontent];	
			if($post['rid']) {
					$affected=$this->db->edit('form__bjhh_superiormanage_addwinner', $datas, " recordid=".$post['rid']) ;
				
					return true;
			}else {
			 	return false;
		}
}

public function addRecord($post,$ids){

				foreach($ids as $k=>$v){
					    $datas[$k][receivedate] = strtotime($post[receivedate]);
	                    $datas[$k][winaddress] = $post[winaddress];
	                    $datas[$k][wincontent] = $post[wincontent];
					    $person = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$v") ;
					    $datas[$k][prizewinner] = $person[name];
					    $datas[$k][winnerid] = $v;
					    $datas[$k][sign] = $_SESSION[sign];
				}
				foreach($datas as $k=>$v){
					$affected=$this->db->add('form__bjhh_superiormanage_addwinner', $v) ;
				    
				}
						
				 
			return true;
		        	

}

	

	public function showName($id){
		foreach($id as $k=>$v){
			$person[$k] = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$v");
			$name[$k] = $person[$k][name];
		}
		if($name)return $name;
		else return false;
	}

	
}

?>