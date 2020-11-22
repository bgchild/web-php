<?php

include_once ("user.php");

/**
 * 
 * 志愿者转入转出
 */
class UserJoin extends user {
	
public function __construct() {
			parent::__construct();
	}
	
/**
 * 
 * 得到用户信息
 */
	public function getcInfo(){
		$info=array();
		$info[uid]=$this->getUser(0);
	    $info[uname]=$this->getUser(1);
	    $info[ocity]=$this->getUser(sign);
	    $info[oname]=$this->getcityname($info[ocity]);
		return $info;
	}
/**
 * 获取城市名称
 */
	public function getcityname($sign){
		if(!$sign) return false;
		$sign=trim($sign);
	    $res=$this->db->get_one("form__bjhh_area","sign='$sign'");
	    $name=$res[name];
	    return $name;
	}
/**
 * 判断是否申请 
 * 如申请  审核结束 才能再次申请
 * 返回处理状态
 */
	public function checkJoin(){
		$uid=$this->getUser(0);
		$one=$this->db->get_one("form__bjhh_joinrecord","uid=$uid","*", " order by addtime desc");
		if($one) return $one;
		return false;
	}
}

?>
