<?php
include_once ("login.php");

/**
 * 
 * 管理员管理
 */
class adminuser extends adminbase {
	public $db;
	public $xxtea;
	public function __construct() {
		global $db;
		$this->db = $db;
		$this->xxtea = new Xxtea ();
	}	
	
	/**
	 *取出所有数据-自愿者管的理员
	 * @return array $arr
	 * zb开头的用户名是灾害的管理员
	 */
	public function getAllList() {
		$arr = array ();
		$orders = ' order by recordid asc';
        $where=" sign='$_SESSION[sign]' and u_name not like 'zb%'";
		$arr = $this->db->getall ( 'form__bjhh_admin', $where, array (limit => '0,9999999' ), '*', $orders );
		return $arr;
	}

    /**
     *取出所有数据-灾害的管理员
     * @return array $arr
     * zb开头的用户名是灾害的管理员
     */
    public function getZbAllList() {
        $arr = array ();
        $orders = ' order by recordid asc';
        $where=" sign='$_SESSION[sign]' and u_name like 'zb%'";
        $arr = $this->db->getall ( 'form__bjhh_admin', $where, array (limit => '0,9999999' ), '*', $orders );
        return $arr;
    }

	/**
	 * 删除一条数据
	 * @param string $id
	 * @return $affected (受影响的行数)
	 */
	public function deleteOne($id) {
		$del=$this->getCityInfo();
		if ($del['def']=='1'){
				$where = " recordid='$id' ";
				$affected = $this->db->drop ( 'form__bjhh_admin', $where );
				return $affected;
		}else{
			     $this->db->get_show_msg( "javascript:history.back(0)", '对不起，您没有删除权限！' );
		}
	
	}
	/**
	 * 取出一条数据
	 * @param string $id
	 * @return array $arr
	 */
	public function getOne($id) {
		$arr = array ();
		$where = " recordid='$id' ";
		$arr = $this->db->get_one ( 'form__bjhh_admin', $where );
		return $arr;
	}
	/**
	 *_check_username()判断用户名有没重复
	 */
	public function _check_username($username,$rid) {
		$table = 'form__bjhh_admin';
		$get_one = $this->db->get_one ( $table, " u_name='$username' and recordid!='$rid' " );
		if ($get_one) {
			return true;
		} else {
			return false;
		}
	}
}
?>
