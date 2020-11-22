<?php
include_once ('adminBase.php');
/**
 * 服务队管理
 * @param 
 */

class adminTeamManageDetail extends adminbase {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function member($teamid) {
		$conditions = " serviceteamid='$teamid'  and a.serviceteamcaptainid = b.recordid and a.sp_status='2' and b.status in ('001','010') ";
		$page = _get_page ( 10 );
		$orders = " order by a.captain asc,a.joinserviceteamdate desc";
		$list = $this->db->get_relations_info ( 'form__bjhh_serviceteammanage_addserviceteamperson', 'form__bjhh_volunteermanage_volunteerbasicinfo', $conditions, array ('limit' => $page ['limit'] ), $orders, 'a.recordid,a.captain,a.serviceteamid,a.joinserviceteamdate,a.serviceteamcaptainid,b.recordid as precordid,b.name,b.sex,b.emails,b.cellphone,b.birthday,b.captainable' );
		$page ['item_count'] = $this->db->get_relations_count ( 'form__bjhh_serviceteammanage_addserviceteamperson', 'form__bjhh_volunteermanage_volunteerbasicinfo', $conditions );
		$page = _format_page ( $page );
		$arr ['list'] = $list;
		$arr ['page'] = $page;
		return $arr;
	}
	
	public function activity($conditions) {
		$page = _get_page ( 10 );
		$list = $this->db->getall ( 'form__bjhh_activityexamine_activityinfo', $conditions, array ('limit' => $page ['limit'] ) );
		$page ['item_count'] = $this->db->get_count ( 'form__bjhh_activityexamine_activityinfo', $conditions );
		$page = _format_page ( $page );
		$arr ['list'] = $list;
		$arr ['page'] = $page;
		return $arr;
	}
	
	public function getActivityType() {
		return $this->db->getall ( 'form__bjhh_dictbl', "tcode = '008' " );
	
	}

}

?>