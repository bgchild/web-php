<?php
/**
 * 
 * 数据库操作类
 */
class common {
	public $db; //载入mysql
	public $def; //载入数据库前缀
	/*初始化*/
	function __construct($db, $def) {
		$this->db = $db;
		$this->def = $def;
	}
	
	/**
	 * 
	 * 获得所有数据
	 * @param  $table 表
	 * @param  $conditions 条件
	 * @param  $limit 条数
	 * @param  $fields 字段
	 * @param  $orders 排序
	 */
	function getall($table, $conditions = '', $limit = array(limit=>'0,9999999'), $fields = '*', $orders = '') {
		if ($conditions) {
			$sql = "select $fields from " . $this->def . $table . " where " . $conditions . $orders;
			$sql = $sql . " limit " . $limit [limit];
		} else {
			$sql = "select $fields from " . $this->def . $table . $orders;
			$sql = $sql . " limit " . $limit [limit];
		}

		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr [] = $row;
			}
			
			return $arr;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * 获得关联表数据
	 * @param  $table_left  左表
	 * @param  $table_right 右表
	 * @param $conditions  关联条件
	 * @param  $limit  条数
	 * @param  $orders 排序
	 * @param  $fields 字段
	 */
	function get_relations_info($table_left, $table_right, $conditions, $limit = array(limit=>'0,9999999'), $orders = '', $fields = '') {
		
		if ($fields == '') {
			$sql = "select  a.*,b.* from " . $this->def . $table_left . " as a," . $this->def . $table_right . " as b where " . $conditions . $orders;
		} else {
			$sql = "select " . $fields . " from " . $this->def . $table_left . " as a," . $this->def . $table_right . " as b where " . $conditions . $orders;
		}
		$sql = $sql . " limit " . $limit [limit];
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr [] = $row;
			}
			
			return $arr;
		} else {
			return false;
		}
	
	}
	/**
	 * 
	 * 获得三张表关联数据
	 * @param  $table_ a 表
	 * @param  $table_b  表
	 * @param  $table_c  表
	 * @param  $conditions  关联条件
	 * @param  $limit  条数
	 * @param  $orders 排序
	 * @param  $fields 字段
	 */
	function get_association_info($table_a, $table_b,$table_c, $conditions, $limit = array(limit=>'0,9999999'), $orders = '', $fields = '') {
		
		if ($fields == '') {
			$sql = "select  a.*,b.*,c.* from " . $this->def . $table_a . " as a," . $this->def . $table_b . " as b,". $this->def . $table_c. " as c where " . $conditions . $orders;
		} else {
			$sql = "select " . $fields . " from " . $this->def . $table_a . " as a," . $this->def . $table_b . " as b,". $this->def . $table_c. " as c where " . $conditions . $orders;
		}
		$sql = $sql . " limit " . $limit [limit];

		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr [] = $row;
			}
			
			return $arr;
		} else {
			return false;
		}
	
	}
	
	/**
	 * 
	 *获得一条关联表数据
	 * @param  $table_left  左表
	 * @param  $table_right 右表
	 * @param $conditions  关联条件
	 */
	function get_relations_one($table_left, $table_right, $conditions,$fields = '') {
		if ($fields == '') {
			$sql = "select * from " . $this->def . $table_left . " as a," . $this->def . $table_right . " as b where " . $conditions;
		} else {
			$sql = "select " . $fields . " from " . $this->def . $table_left . " as a," . $this->def . $table_right . " as b where " . $conditions;
		}
		
		
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr = $row;
			}
			
			return $arr;
		} else {
			return false;
		}
	
	}
	
	/**
	 * 
	 * 统计符合条件的两张表关联数据个数
	 * @param  $table_left  左表
	 * @param  $table_right 右表
	 * @param $conditions  关联条件
	 */
	function get_relations_count($table_left, $table_right, $conditions = '') {
		
		if ($conditions) {
			$sql = "select count(*) from " . $this->def . $table_left . " as a," . $this->def . $table_right . " as b where " . $conditions;
		} else {
			$sql = "select count(*) from " . $this->def . $table_left . " as a," . $this->def . $table_right . " as b ";
		}
		
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$row = mysql_fetch_row ( $res );
			
			if ($row !== false) {
				return $row [0];
			} else {
				return '';
			}
		} else {
			return false;
		}
	
	}
/**
	 * 
	 * 统计符合条件的三张表关联数据个数
	 * @param  $table_a  表
	 * @param  $table_b右表
	 * @param  $table_c右表
	 * @param $conditions  关联条件
	 */
	function get_association_count($table_a, $table_b,$table_c, $conditions = '') {
		
		if ($conditions) {
			$sql = "select count(*) from " . $this->def . $table_a . " as a," . $this->def . $table_b . " as b," . $this->def . $table_c . " as c where " . $conditions;
		} else {
			$sql = "select count(*) from " . $this->def . $table_a . " as a," . $this->def . $table_b . " as b, " . $this->def . $table_c . " as c";
		}
		
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$row = mysql_fetch_row ( $res );
			
			if ($row !== false) {
				return $row [0];
			} else {
				return '';
			}
		} else {
			return false;
		}
	
	}
	
	/**
	 * 
	 * 统计符合条件的数据个数
	 * @param  $table 表
	 * @param  $conditions 条件
	 */
	function get_count($table, $conditions = '') {
		
		if ($conditions) {
			$sql = "select count(*) from " . $this->def . $table . " where " . $conditions;
		} else {
			$sql = "select count(*) from " . $this->def . $table;
		}
		
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$row = mysql_fetch_row ( $res );
			
			if ($row !== false) {
				return $row [0];
			} else {
				return '';
			}
		} else {
			return false;
		}
	
	}
	

	/**
	 * 
	 * 获得一条数据
	 * @param  $table 表
	 * @param  $conditions 条件
	 * @param  $fields 字段
	 * @param  $orders 排序
	 */
	function get_one($table, $conditions = '', $fields = '*', $orders = '') {
		if ($conditions) {
			$sql = "select $fields from " . $this->def . $table . " where  " . $conditions . $orders;
		} else {
			$sql = "select $fields from " . $this->def . $table . $orders;
		}
		$sql = trim ( $sql . ' LIMIT 0,1' );
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr = $row;
			}
			
			return $arr;
		} else {
			return false;
		}
	}
	/**
	 * 
	 * 删除数据 
	 * @param  $table 表
	 * @param $conditions 条件
	 * @param $primary_id 主键
	 */
	
	function drop($table, $conditions, $primary_id) {
		//判断条件是不是数组
		if (is_array ( $conditions )) {
			if ($conditions) {
				foreach ( $conditions as $value => $key ) {
					$this->db->query ( "DELETE FROM " . $this->def . $table . " where $primary_id = '$key' " );
				}
			}
		} else {
			
			$this->db->query ( "DELETE FROM " . $this->def . $table . " where " . $conditions );
		
		}
		
		return $this->db->affected_rows ();
	}
	
	/**
	 * 
	 * 更新数据
	 * @param  $table 表
	 * @param  $datas 需要更新的数据，为数组 例如：$datas['name']='lisan';
	 * @param  $conditions 条件
	 * @param  $primary_id 主键
	 */
	function edit($table, $datas, $conditions, $primary_id) {
		//判断提交的数据是否是数组
		if (is_array ( $datas )) {
			if ($datas) { //判断是否提交数据
				foreach ( $datas as $values => $key ) {
					$val .= "$values = '$key',";
				}
				$val = rtrim ( $val, "," );
			}
		} else {
			$val = $datas;
		}
		//判断提交的数据是否是数组
		if (is_array ( $conditions )) {
			if ($conditions) //判断是否提交更新条件
{
				foreach ( $conditions as $values => $key ) {
					$sql = "UPDATE " . $this->def . $table . " SET $val WHERE $primary_id = '$key'";
					$this->db->query ( $sql );
				}
			}
		} else {
			
			$sql = "UPDATE " . $this->def . $table . " SET $val WHERE " . $conditions;
			$this->db->query ( $sql );
		
		}
		
		return $this->db->affected_rows ();
	}
	
	/**
	 * 
	 * 添加数据
	 * @param  $table 表
	 * @param  $datas 需要添加的数据，为数组 例如：$datas['name']='lisan';
	 */
	function add($table, $datas) {
		
		if ($datas) { //判断是否提交数据
			foreach ( $datas as $values => $key ) {
				$name .= "$values,";
				$value .= "'$key',";
			}
			$name = rtrim ( $name, "," );
			$value = rtrim ( $value, "," );
		}
		$this->db->query ( "insert into " . $this->def . $table . "($name) values ($value)" );
		return $this->db->insert_id ();
	}
	
	function close() {
		return mysql_close ();
	}
	

  /**
   * 
   * 执行sql语句,获得符合条件的数据个数  
   * @param  $sql 语句
   */
	function getRow($sql) {
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr = $row;
			}
			return $arr;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * 操作提示框
	 * @param  $url 跳转地址
	 * @param  $show 提示字
	 */
	function get_show_msg($url, $show = '操作已经成功') {
		$this->db->get_show_msg ( $url, $show );
	}
	
	
	/**
	 * 
	 * 获得表中的最大UID
	 * @param  $table 表
	 * @param  $primary_id  主键
	 */

	function get_uid($table, $primary_id) {
		$sql = "SELECT $primary_id FROM " . $this->def . $table . " where statics = '1' ";
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr [] = $row [$primary_id];
			}
			
			return $arr;
		} else {
			return false;
		}
	
	}


	function query($sql) {
		$res = $this->db->query ( $sql );
		if ($res !== false) {
			$arr = array ();
			while ( $row = mysql_fetch_assoc ( $res ) ) {
				$arr [] = $row;
			}
			
			return $arr;
		} else {
			return false;
		}
	}

}

?>