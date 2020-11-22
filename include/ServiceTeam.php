<?php
include_once ("user.php");
/**
 * 
 * 服务队
 * 
 */
class ServiceTeam extends user {
	
	public function __construct() {
		parent::__construct ();
		$_user = $this->checkCaptain ();
		if (! $_user)
			$this->db->get_show_msg ( $this->getBackUrl ( "userIndex.php" ), "不是队长或者注销用户不能访问！" );
	}

}

?>