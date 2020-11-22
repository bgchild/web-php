<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/adminUser.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
 <?php include 'admin_top.tpl.php'; ?> 
<div class="adm_user">

<form name="myform" method="post" action="" id="adminuser" >
<table class="contact_table">
<tr>
<td class="list-right">用户名：</td>
<td><input name="u_name"  class="input length_3" type="text" value="<?php echo $adminuserOne['u_name'];?>" /></td>
</tr>
<tr>
<td class="list-right">更新时间：</td>
<td><input name="time"  class="input length_3" type="text" value="<?php echo date("Y-m-d H:i:s",$adminuserOne['last_time']);?>" /></td>
</tr>
<tr>
<td class="list-right">最近登录IP：</td>
<td><input name="ip"  class="input length_3" type="text" value="<?php echo $adminuserOne['last_ip'];?>" /></td>
</tr>

<tr>
<td></td>
<td><a href="adminuser.php?spm=<?php echo set_url($adminuserOne['recordid']);?>" style="text-decoration: none;" class="addbtn btn_alone" >修改用户名或密码</a></td>

</tr>

</table>
</form>
</div>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>

</body>
</html>