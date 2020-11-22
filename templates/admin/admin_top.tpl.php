<?php 
$userinfo=$admin_op->xxtea->parseLoginIdentify($_SESSION['admin_identify']);
if(!$userinfo[0] || !$userinfo[1])$admin_op->db->get_show_msg('adminlogin.php','请登录管理平台！');
?>
<div class="admin_top">
<div class="wel"><?php echo $userinfo[1];?>你好&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;欢迎进入管理平台</div>
<div class="lgout"><a href="adminlogout.php"><font color="#FFFFFF">退出</font></a></div>
</div>