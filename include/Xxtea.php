<?php
/**
 * 基于xxtea加密算法实现
 
 */
class Xxtea   {
	
	public $key="user_1eborbbr5hmr2mp7g#%&%__login";//密钥

/**
 * 
 * 加密函数
 * @param  $str 要加密的字符串
 * @param  $key 密钥
 */
	public function encrypt($str, $key) {
		if ($str == '') $key=$this->key;
		if (!$key || !is_string($key)) {
			return '';
		}
		$v = $this->str2long($str, true);
		$k = $this->str2long($key, false);
		if (count($k) < 4) {
			for ($i = count($k); $i < 4; $i++) {
				$k[$i] = 0;
			}
		}
		$n = count($v) - 1;
		
		$z = $v[$n];
		$y = $v[0];
		$delta = 0x9E3779B9;
		$q = floor(6 + 52 / ($n + 1));
		$sum = 0;
		while (0 < $q--) {
			$sum = $this->int32($sum + $delta);
			$e = $sum >> 2 & 3;
			for ($p = 0; $p < $n; $p++) {
				$y = $v[$p + 1];
				$mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(
					($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
				$z = $v[$p] = $this->int32($v[$p] + $mx);
			}
			$y = $v[0];
			$mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(
				($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$z = $v[$n] = $this->int32($v[$n] + $mx);
		}
		$data=$this->long2str($v, false);
		return base64_encode($data);
	}

	/**
 * 
 * 解密函数
 * @param  $str 要解密的字符串
 * @param  $key 密钥
 */
	public function decrypt($str, $key) {
		if ($str == '') $key=$this->key;
		if (!$key || !is_string($key)) {
			return '';
		}
		$str= base64_decode($str);
		$v = $this->str2long($str, false);
		$k = $this->str2long($key, false);
		if (count($k) < 4) {
			for ($i = count($k); $i < 4; $i++) {
				$k[$i] = 0;
			}
		}
		$n = count($v) - 1;
		
		$z = $v[$n];
		$y = $v[0];
		$delta = 0x9E3779B9;
		$q = floor(6 + 52 / ($n + 1));
		$sum = $this->int32($q * $delta);
		while ($sum != 0) {
			$e = $sum >> 2 & 3;
			for ($p = $n; $p > 0; $p--) {
				$z = $v[$p - 1];
				$mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(
					($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
				$y = $v[$p] = $this->int32($v[$p] - $mx);
			}
			$z = $v[$n];
			$mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(
				($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$y = $v[0] = $this->int32($v[0] - $mx);
			$sum = $this->int32($sum - $delta);
		}
		return $this->long2str($v, true);
	}

	/**
	 * 长整型转换为字符串
	 *
	 * @param long $v
	 * @param boolean $w
	 * @return string
	 */
	private function long2str($v, $w) {
		$len = count($v);
		$s = array();
		for ($i = 0; $i < $len; $i++)
			$s[$i] = pack("V", $v[$i]);
		return $w ? substr(join('', $s), 0, $v[$len - 1]) : join('', $s);
	}

	/**
	 * 字符串转化为长整型
	 *
	 * @param string $s
	 * @param boolean $w
	 * @return Ambigous <multitype:, number>
	 */
	private function str2long($s, $w) {
		$v = unpack("V*", $s . str_repeat("\0", (4 - strlen($s) % 4) & 3));
		$v = array_values($v);
		if ($w) $v[count($v)] = strlen($s);
		return $v;
	}

	/**
	 * @param int $n
	 * @return number
	 */
	private function int32($n) {
		while ($n >= 2147483648)
			$n -= 4294967296;
		while ($n <= -2147483649)
			$n += 4294967296;
		return (int) $n;
	}


	/**
	 * 创建登录标识
	 *
	 * @param  $uid 用户id
	 * @param  $username用户名称
	 * @return string
	 */
function createLoginIdentify($uid,$username){
$code = $this->encrypt($uid . "\t" . $username . "\t" . time(), $this->key);
setcookie('code',rawurlencode($code),time()+3600*24,'/','.honghui.com');
setcookie('etime',time()+1800,time()+3600*24,'/','.honghui.com');
return rawurlencode($code);
}
/**
 * 后台创建登录标识
 *
 * @param  $uid 用户id
 * @param  $username用户名称
 * @return string
 */
function admincreateLoginIdentify($uid,$username){
	$code = $this->encrypt($uid . "\t" . $username . "\t" . time(), $this->key);
	return rawurlencode($code);
}

/**
	 * 解析登录标识
	 *
	 * @param string $identify 需要解析的标识
	 * @return array array($uid, $name)
	 */
	 function parseLoginIdentify($identify) {
		$args = explode("\t", $this->decrypt(rawurldecode($identify), $this->key));
		
	    return $args;
	
	}


}

?>