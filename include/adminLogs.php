<?php
include_once ('adminBase.php');
class adminLogs extends adminbase {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function Logslist($query) {		
		$arr = array ();
		$where = "1=1";
		if (isset($query)) {
	    foreach ($query as $k=>$v){
	    	if(!$v) continue;
	    	if($k=='username'){
	    		$where.=" and username like '%{$v}%' ";
	    	}
	    	if($k=='ip'){
	    		$where.=" and loginip like '%{$v}%'";
	    	}
	    	if($k=='start_time'){
	    		$where.=" and `logintime` >'{$v}'";
	    	}
	    	if($k=='end_time'){
	    		$where.=" and `logintime` <'{$v}'";
	    	}
	    }
		}
		$page = _get_page ( 15 ); //获取分页信息
		$orders=" order by loginid desc";
		$list = $this->db->getall ( 'form__bjhh_loginlog', $where, array (limit => $page ['limit'] ), '*', $orders );
		foreach($list as $k=>$v){
        $cityname=$this->db->get_one ( "form__bjhh_area", "sign='{$v['sign']}'" );
		$list[$k]['name']=$cityname['name'];
		}
		$page ['item_count'] = $this->db->get_count ( 'form__bjhh_loginlog', $where );
		$page = _format_page ( $page );
		$arr['list']=$list;
		$arr[page]=$page;
		return $arr;
	}
	
	
	/**
	 * 删除一个月前的日志
	 */
	public function deletelog(){
		$t = date("Y-m-d H:i:s",  time()-2592000);
		$where="logintime < '{$t}'";
		$res=$this->db->drop('form__bjhh_loginlog',$where);
		if($res){
			return true;
		}else{
			return false;
		}
	}
}

?>