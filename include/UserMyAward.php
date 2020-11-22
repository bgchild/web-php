<?php

include_once ("user.php");

/**
 * 
 * 我的获奖信息
 */

class UserMyAward extends user {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function getRecords($query, $limit,$arg) {
		$q1 = "winnerid=$arg[0]";
		foreach ( $query as $key => $val ) {
			$val = trim ( $val );
			if ($key == 'receivedate1') {
				$val=strtotime($val);
				$q1.=" and receivedate >=$val ";continue;
			}
			if ($key == 'receivedate2') {
				$val=strtotime($val);
				$q1.=" and receivedate <=$val ";continue;
			}
			$q1 .= " and $key='$val' ";
		}
		$this->count = $this->db->get_count ( 'form__bjhh_superiormanage_addwinner', $q1 );
		return $this->db->getall('form__bjhh_superiormanage_addwinner',$q1,array ('limit' => $limit ),'*'," order by recordID DESC ");
	}
	
	public function getCount(){
		return $this->count;
	}

}

?>