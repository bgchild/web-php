<?php
//数据库全局类
class mysql {
	private $host;
	private $name;
	private $pass;
	private $table;
	private $ut;
	private $def;
	
	public function __construct($host, $name, $pass, $table, $ut, $def) {
		$this->host = $host;
		$this->name = $name;
		$this->pass = $pass;
		$this->table = $table;
		$this->ut = $ut;
		$this->def = $def;
		$this->connect ();
	
	}
	
	public function connect() {
		$link = mysql_connect ( $this->host, $this->name, $this->pass ) or die ( $this->error () );
		mysql_select_db ( $this->table, $link ) or die ( "没有数据库" . $this->table );
		mysql_query ( "SET NAMES '$this->ut'" );
	}
	
	public function query($sql, $type = '') {
		if (! ($query = mysql_query ( $sql )))
			$this->show ( 'Say:', $sql );
		
		// if(!($query = mysql_query($sql))) $this->show('对不起数据库链接出错！');
		return $query;
	}
	
	public function show($message = '', $sql = '') {
		//echo $message.'对不起数据库语句有错误';
		if (! $sql)
			echo $message;
		else
			echo $message . '<br>' . $sql;
	}
	
	public function affected_rows() {
		return mysql_affected_rows ();
	}
	
	public function fetch_first($sql) {
		return $this->fetch_array ( $this->query ( $sql ) );
	}
	
	public function result_first($sql) {
		return $this->result ( $this->query ( $sql ), 0 );
	}
	
	public function result($query, $row) {
		return mysql_result ( $query, $row );
	}
	
	public function num_rows($query) {
		return @mysql_num_rows ( $query );
	}
	
	public function num_fields($query) {
		return mysql_num_fields ( $query );
	}
	
	public function free_result($query) {
		return mysql_free_result ( $query );
	}
	
	public function insert_id() {
		return mysql_insert_id ();
	}
	
	public function fetch_row($query) {
		return mysql_fetch_row ( $query );
	}
	
	public function fetch_array($query) {
		return mysql_fetch_array ( $query );
	}
	
	public function version() {
		return mysql_get_server_info ();
	}
	
	public function close() {
		return mysql_close ();
	}
	
	//==============
	

	public function getTablesName() {
		$res = mysql_query ( 'SHOW TABLES FROM ' . $this->table );
		$tables = array ();
		while ( $row = mysql_fetch_row ( $res ) ) {
			$tables [] = $row [0];
		}
		
		return $tables;
	}
	public function getFields($table) {
		$res = mysql_query ( 'DESCRIBE ' . $table );
		$tables = array ();
		while ( $row = mysql_fetch_row ( $res ) )
			$tables [] = $row [0];
		mysql_free_result ( $res );
		return $tables;
	}
	
	public function db_fetch_array($sql) {
		$res = mysql_query ( $sql );
		$r = mysql_fetch_array ( $res );
		mysql_free_result ( $res );
		return $r;
	}
	
	public function fetch_assoc($sql) {
		$q3 = mysql_query ( $sql );
		$ra = array ();
		while ( $data = mysql_fetch_assoc ( $q3 ) ) {
			$ra [] = $data;
		}
		mysql_free_result ( $q3 );
		return $ra;
	}

}

?>
