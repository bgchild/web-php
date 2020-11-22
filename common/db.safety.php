<?php
function quotesGPC() {
	$_POST = array_map ( "addSlash", $_POST );
	$_GET = array_map ( "addSlash", $_GET );
	$_COOKIE = array_map ( "addSlash", $_COOKIE );
}
function addSlash($el) {
	if (is_array ( $el ))
		return array_map ( "addSlash", $el );
	else
		return addslashes ( $el );
}
function common_htmlspecialchars($str) {
	$str = preg_replace ( '/&(?!#[0-9]+;)/s', '&amp;', $str );
	$str = str_replace ( array ('<', '>', '"' ), array ('&lt;', '&gt;', '&quot;' ), $str );
	
	return $str;
}

//递归方式的对变量中的特殊字符进行转义 
function daddslashes($string, $force = 0) {
	! defined ( 'MAGIC_QUOTES_GPC' ) && define ( 'MAGIC_QUOTES_GPC', get_magic_quotes_gpc () );
	if (! MAGIC_QUOTES_GPC || $force) {
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string [$key] = daddslashes ( $val, $force );
			}
		} else {
			$string = addslashes ( $string );
		}
	
	}
	return $string;
}

/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value) {
	if (empty ( $value )) {
		return $value;
	} else {
		return is_array ( $value ) ? array_map ( 'addslashes_deep', $value ) : addslashes ( $value );
	}
}

/**
 * 将对象成员变量或者数组的特殊字符进行转义
 *
 * @access   public
 * @param    mix        $obj      对象或者数组
 *
 * @return   mix                  对象或者数组
 */
function addslashes_deep_obj($obj) {
	if (is_object ( $obj ) == true) {
		foreach ( $obj as $key => $val ) {
			$obj->$key = addslashes_deep ( $val );
		}
	} else {
		$obj = addslashes_deep ( $obj );
	}
	
	return $obj;
}

/**
 * 递归方式的对变量中的特殊字符去除转义
 *
 * @access  public
 * @param   mix     $value
 * @return  mix
 */
function stripslashes_deep($value) {
	if (empty ( $value )) {
		return $value;
	} else {
		return is_array ( $value ) ? array_map ( 'stripslashes_deep', $value ) : stripslashes ( $value );
	}
}

foreach ( $_POST as $id => $v ) {
	$_POST [$id] = common_htmlspecialchars ( $v );
}
foreach ( $_GET as $id => $v ) {
	$_GET [$id] = common_htmlspecialchars ( $v );
}
foreach ( $_COOKIE as $id => $v ) {
	$_COOKIE [$id] = common_htmlspecialchars ( $v );
}
?>