<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
</head>
<body>

<?php echo "欢迎登录".$arg[1];?><br />

<br /><br /><br />

<form action='userCenter.php' method='post'>
原密码<input type='password' name="pre_password" /><br />
新密码<input type='password' name="new_password" /><br />
重复新密码<input type='password' name="repeat" /><br />
<input type="submit" name="doChangePassword" value='修改密码' />
</form>

<br /><br /><br />

<form action='userCenter.php' method='post' >
<input type='submit' name='doLogout' value='退出' />
</form>

<br /><br /><br />

<form action='userCenter.php' method='post'  id="withdrawForm">
<input type="checkbox" name="reason[]" value="由于时间原因" />由于时间原因<br />
<input type="checkbox" name="reason[]" value="由于个人原因" />由于个人原因<br />
<input type="checkbox" name="reason[]" value="由于xxx原因" />由于xxx原因<br />
<input type="checkbox" name="reason[]" id="other" value=“" />其他原因
<textarea  name="other_reason" id="other_reason" ></textarea>
<input type='submit' name='doWithdraw' value='注销' />
</form>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js" ></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#withdrawForm").submit(function(){
		if($("#other").attr("checked")==true) {
			   $val=$("#other_reason").attr("value");
			   if($val=='') {
						alert("请输入其他原因！");
						return false;
				}
			   $("#other").val($val);
			}
		return true;
	});
});
</script>


</body>
</html>