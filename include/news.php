<?php
/**
 * 
 * 新闻类
 * 
 */
class news {
	
	public $db;
	public function __construct() {
		global $db;
		$this->db = $db;
	}
	
	/**
	 * 获取新闻列表
	 * @param string $fd (父id)
	 * @return array $arr (二维)
	 */
	public function getNewsInfo($fid) {
		$array = array ();
		$where = " fid='$fid' and sign='{$_SESSION['sign']}' ";
		$page = _get_page ( 10 ); //获取分页信息
		$page ['item_count'] = $this->db->get_count ( 'form__bjhh_news', $where );
		$orders = 'order by createTime desc';
		$list = $this->db->getall ( 'form__bjhh_news', $where, array ('limit' => $page ['limit'] ) , '*', $orders );
		foreach ( $list as $k => $v ) {
			$list [$k] ['ctime'] = date ( 'Y-m-d', $v ['createTime'] );
		}
		$page = _format_page ( $page );
		$arr ['list'] = $list;
		$arr ['page'] = $page;
		return $arr;
	}
	
	/**
	 * 获取大事件和事件名
	 * @param string $id (主键)
	 * @return array||string $arr (字符串或者二维数组)
	 */
	public function getColumn($id) {
		$arr = array ();
		if ($id) {
			$where = " recordid='$id' ";
			$arr = $this->db->get_one ( 'form__bjhh_column', $where );
			return $arr ['name'];
		} else {
			$arr = $this->db->getall ( 'form__bjhh_column'," category='2' " );
			return $arr;
		}
	}
	
	/**
	 * 获取一条新闻信息
	 * @param string $id
	 * @return array $arr(一维)
	 */
	public function getOneNewInfo($id) {
		$where = " recordid='$id' ";
		$arr = $this->db->get_one ( 'form__bjhh_news', $where );
		$arr ['createTime'] = date ( 'Y-m-d H:i:s', $arr ['createTime'] );
		$arr ['pictures'] = substr ( $arr ['pictures'], 3 );
		return $arr;
	}

	/**
	 * 获取一条新闻信息
	 */
	public function getOne($id) {
		$where = " recordid='$id' ";
		return $this->db->get_one ( 'form__bjhh_news', $where );
	}
	
	/**
	 * 主页新闻列表
	 * @param string $fid (父id)
	 * @param string $limit (取几条)
	 * @return array $arr (二维)
	 */
	public function getList($fid, $limit, $sign="") {
		if ( !empty($sign) ) {
			$where = " fid='$fid' and sign='{$sign}' ";
		} else {
			$where = " fid='$fid' and sign='{$_SESSION['sign']}' ";
		}

		$orders = 'order by createTime desc';
		$arr = $this->db->getall ( 'form__bjhh_news', $where, array (limit => $limit ), '*', $orders );
		foreach ( $arr as $k => $v ) {
			$v ['pictures'] = substr ( $v ['pictures'], 3 );
			$arr [$k] = $v;
		}
		return $arr;
	}
	
	/**
	 * 
	 * 获得返回地址
	 * @param  $url 如果没有$_SERVER['HTTP_REFERER']就返回$url;
	 */
	public function getBackUrl($url) {
		return $_SERVER ['HTTP_REFERER'] ? $_SERVER ['HTTP_REFERER'] : $url;
	}

}

?>