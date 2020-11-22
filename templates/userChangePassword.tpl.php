<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/demo2.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/userChangePassword.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
			
			<form action='userChangePassword.php' method='post' class="userChangePasswordForm">
				<table  class="changeTable">
					<tr><td class="listright">原密码:</td><td><input type='password' name="pre_password" class="input length_3 pre_password" /></td>
						<td class="liststart"><span style="color:red">*</span></td><td>只有确认原密码正确，才能更换新密码</td></tr>
					<tr><td class="listright">新密码:</td><td><input type='password' name="new_password" class="input length_3 new_password" /></td>
						<td class="liststart"><span style="color:red">*</span></td><td>密码长度为6-20个字符，字母区分大小写，可以使用英文字母及数字及特殊字符组合</td></tr>
					<tr><td class="listright">重复新密码:</td><td><input type='password' name="repeat" class="input length_3 repeat" /></td>
						<td class="liststart"><span style="color:red">*</span></td><td>重复上面的新密码</td></tr>
					<tr>
						<td colspan="2" class="listright2">
							<input type="button" class="btn doChangePassword" name="doChangePassword" value='提交修改' />
							<input type="reset"  class="btn" value='重置' />
							<a href="<?php echo $url;?>" class="btn">返回</a>
						</td>
						<td colspan="2" class=""><a class="forget-password-btn" target="_blank" href="findpsw.php?act=choose">忘记密码?</a></td>
					</tr>
				</table>
			</form>
			
	</div>

</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".doChangePassword").click(function(){
		if($(".pre_password").val()=='') {
			ui.error("请输入原密码");
			$(".pre_password").focus();
		}else if($(".new_password").val()=='') {
			ui.error("请输入新密码");
			$(".new_password").focus();
		}else if($(".repeat").val()=='') {
			ui.error("请输入重复新密码");
			$(".repeat").focus();
		}else {
			$(".userChangePasswordForm").submit();
		}
	});
});
</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>