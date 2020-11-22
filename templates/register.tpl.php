<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
</head>
<body>

<form action='register.php' method='post' >
用户名：<input type='text' name='username' value='' /><br />
密码：<input type='password' name='password' value='' /><br />
重复密码：<input type='password' name='rpassword' value='' /><br />
<input type='submit' name='doRegister' value='注册' />
</form>


<br /><br /><br />

<form action='register.php' method='post' >
用户名：<input type='text' name='username2' value='' /><br />
密码：<input type='password' name='password2' value='' /><br />
<input type='submit' name='doLogin' value='登录' />
</form>




</body>
</html>