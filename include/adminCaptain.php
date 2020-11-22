<?php
include_once ('adminBase.php');
/**
 * 队长管理
 */

class adminCaptain extends adminbase {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function init($queryin) {		
		$arr = array ();
		$conditions = " status in ('001' ,'010') and sign='$_SESSION[sign]'";
		if (isset($queryin['searchtag'])) {
			$name = trim ( $queryin['search_name'] ) != '' ? $queryin['search_name'] : '';
			$username = trim ( $queryin['search_username'] ) != '' ? $queryin['search_username'] : '';
			$cellphone = trim ( $queryin['search_phone'] ) != '' ? $queryin['search_phone'] : '';
			$captainable= trim ( $queryin['is_dz'] );
			if ($name != '') {
				$conditions .= " and name like '%" . $name . "%' ";
			}
			if ($username != '') {
				$conditions .= " and username like '%" . $username . "%' ";
			}
			if ($cellphone != '') {
				$conditions .= " and cellphone like '%" . $cellphone . "%' ";
			}
			if($captainable!=''){
				if($captainable==1){
					$conditions .= " and captainable=1";
				}else{
					$conditions .= " and captainable=0";
				}
				
			}
		}
		$page = _get_page ( 10 ); //获取分页信息
		$list = $this->db->getAll ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $conditions, array (limit => $page ['limit'] ), '*', " order by applytime desc " );
		$page ['item_count'] = $this->db->get_count ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $conditions );
		$page = _format_page ( $page );
		foreach ( $list as $k => $v ) {
			$v ['serveprovince'] = $this->getAreaName ( $v ['serveprovince'] );
			$v ['servecity'] = $this->getAreaName ( $v ['servecity'] );
			$v ['servearea'] = $this->getAreaName ( $v ['servearea'] );
			$list [$k] = $v;
		}
		$arr ['list'] = $list;
		$arr ['page'] = $page;
		return $arr;
	
	}
	
	public function getAreaName($id) {
		if ($id) {
			$arr = array ();
			$arr = $this->db->get_one ( 'pubmodule_area_tbl', " areaId='$id' " );
			return $arr ['areaName'];
		} else {
			return '';
		}
	}

}

?>