<?php
include_once('../global.php');
if (isset($_SESSION['admin_identify']) && $_SESSION['admin_identify']) header('Location:indexManage.php');

if (isset($_POST['dosubmit'])) {
    $url = 'adminlogin.php';
    $username = get_input($_POST['u_name']);
    $u_pwd = get_input($_POST['u_pwd']);
    $nowTime = date('Y-m-d H:i:s',strtotime('now'));
	if ($nowTime< $_SESSION['error_time'] && $_SESSION['error_count']>5){
		$db->get_show_msg($url, '登录次数过多，请5分钟后再试！');
	}
    if (!$username || !$u_pwd) $db->get_show_msg($url, '登录名,密码不能为空！');
    if (!is_username($username)) $db->get_show_msg($url, '用户名含特殊字符！');
    $where = "u_name='$username' ";
    $info = $db->get_one('form__bjhh_admin', $where);
    if (!$info) $db->get_show_msg($url, '用户不存在！');
    if ($info['u_pwd'] != password($u_pwd, $info['encrypt'])){
		$_SESSION['error_time'] = date('Y-m-d H:i:s',strtotime('+5minute'));
		$_SESSION['error_count'] = $_SESSION['error_count']+1;
		$db->get_show_msg($url, '密码不正确！');
	}
    include_once(INCLUDE_PATH . 'Xxtea.php');
    $xxtea = new Xxtea();
    $code = $xxtea->admincreateLoginIdentify($info['recordid'], $info['u_name']);
    $_SESSION['admin_identify'] = $code;

    /*判断是否越级登陆*/
    $login_info = $xxtea->parseLoginIdentify($_SESSION ['admin_identify']);
    $login_infos = $db->get_one('form__bjhh_admin', "u_name='$login_info[1]'");
    if ($login_infos['areaid'] != '1') {
        if (($login_infos['parentid'] == '1' && ($login_infos['areaid'] != $_SESSION['fid']) && $login_infos['areaid'] != $_SESSION['areaid']) || ($login_infos['parentid'] != '1' && $login_infos['areaid'] != $_SESSION['areaid'])) {
            $_SESSION['admin_identify'] = '';
            $db->get_show_msg($url, '对不起您无权登陆！');
        }
    }
	$_SESSION['error_count'] = 0;
    //登录日志
    $logs = array();
    $logs['logintime'] = date("Y-m-d H:i:s", time());
    $logs['sign'] = $login_infos['sign'];
    $logs['loginip'] = get_ip();
    $logs['username'] = $login_infos['u_name'];
    $logs['type'] = '登陆';
    $logs['module'] = '登陆';
    $logs['remark'] = $logs['username'] . "于" . $logs['logintime'] . $logs['type'];
    $db->add("form__bjhh_loginlog", $logs);

    if (strpos($username, 'zbadmin') === 0) {
        header('Location:indexDisasterManage.php');
    }else{
        header('Location:indexManage.php');
    }

}
include get_admin_tpl('admin_login');


?>