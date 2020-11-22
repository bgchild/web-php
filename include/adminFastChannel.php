<?php
include_once ('adminBase.php');
/**
 * 
 * 快捷通道
 */
class adminFastChannel extends adminBase {
	
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 添加快捷通道
	 * @param array $post
	 * @return int $affected(受影响的行数) 
	 */
	public function addFastChannel($post) {
		foreach ( $post as $k => $v )
			$post [$k] = trim ( $v );
		$datas = array ();
		$datas ['fast_order'] = $post ['fast_order'];
		$datas ['fast_style'] = $post ['fast_style'];
		$datas ['fast_name'] = $post ['fast_name'];
		$datas ['fast_url'] = $post ['fast_url'];
		if ($post ['recordid']) {
			$where = " fast_id=" . $post ['recordid'];
			$affected = $this->db->edit ( 'form__bjhh_fastchannel', $datas, $where );
		} else {
			$affected = $this->db->add ( 'form__bjhh_fastchannel', $datas );
		}
		return $affected;
	}
	
	/**
	 *取出所有数据
	 * @return array $arr
	 */
	public function getAllList() {
		$arr = array ();
		$orders = ' order by fast_order asc';
		$arr = $this->db->getall ( 'form__bjhh_fastchannel', '', array (limit => '0,9999999' ), '*', $orders );
		return $arr;
	}
	
	/**
	 * 取出一条数据
	 * @param string $id
	 * @return array $arr
	 */
	public function getOne($id) {
		$arr = array ();
		$where = " fast_id='$id' ";
		$arr = $this->db->get_one ( 'form__bjhh_fastchannel', $where );
		return $arr;
	}
	
	/**
	 * 删除一条数据
	 * @param string $id
	 * @return $affected (受影响的行数)
	 */
	public function deleteOne($id) {
		$where = " fast_id='$id' ";
		$affected = $this->db->drop ( 'form__bjhh_fastchannel', $where );
		return $affected;
	}
	
	/**
	 *排序
	 * @return bool $b
	 */
	public function fastOrder() {
		$b = false;
		$arr = array ();
		$datas = array ();
		$list = $_POST ['order'];
		$pid = $_POST ['pid'];
		$arr = array_combine ( $pid, $list );
		foreach ( $arr as $k => $v ) {
			$datas ['fast_order'] = $v;
			$where = " fast_id='$k' ";
			$affset = $this->db->edit ( 'form__bjhh_fastchannel', $datas, $where );
			if ($affset)
				$b = true;
		}
		return $b;
	}

}
?>