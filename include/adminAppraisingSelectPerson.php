<?php
include_once('adminBase.php');
/**
 * 
 * 评优管理
 */
class adminAppraisingSelectPerson extends adminbase {
	public function __construct() {
		parent::__construct ();
	}


public function init($query,$limit){

	    $q1 = "status in ('001','010')";
		foreach ( $query as $key => $val ) {
			$val = trim ( $val );
			if ($key == 'name' || $key == 'guarderidnumb') {
				$q1 .= " and $key like '%".$val."%' ";
			}
		}
		$this->count = $this->db->get_count ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $q1 );
		return $this->db->getall('form__bjhh_volunteermanage_volunteerbasicinfo',$q1,array ('limit' => $limit ),'*'," order by recordid DESC ");


	}
	
	public function getCount(){
		return $this->count;
	}
	
}

?>