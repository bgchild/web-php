<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/findpsw.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
	<div class="con">
              <div class="findpsw">
              		<div class="fpsw_head">
              		     <span style="font-size: 16px;color: #313131;">找回密码：</span>
              		</div>
              		<div class="fpsw_con">
              		<form action="findpsw.php" method="post"  class="NextForm">
              		       <table>
								<tr>
									<td align="right">
										<span style="color: red;margin-right:4px;">*</span>账号：</td>
									<td>
										<input type="text"  class="textzh" name="username"  onblur="javascript:on_blur1();" value="<?php echo $uname;?>" />
										<span class="alert_emtry" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;请输入帐号</span>
										<span class="alert_error" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;您输入的帐号有误</span>
									</td>
								</tr>
								<tr>
									<td align="right">
										<span style="color: red;margin-right:4px;">*</span>验证码：</td>
									<td>
										<input type="text" class="textyzm"  name="checkcode" onblur="javascript:on_blur2();" />
										<span class="alert_yzmemtry" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;请输入验证码</span>
										<span class="alertyzm_error" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;您输入的验证码有误</span>
										
										</td></tr>
											<tr><td></td><td>
											<span style="color:#999999;padding-left:8px;">请输入图中字符，不区分大小写</span>
											</td>
								</tr>
								<tr><td></td><td><img src="include/Checkcode.class.php" id="checkcode"  style="width:130px; height:50px;padding-left:8px;"/>
													<a href="javascript:document.getElementById('checkcode').src='include/Checkcode.class.php?time='+Math.random();void(0);">
													看不清，换一张
										</a></td>
								</tr>
								<tr><td colspan=2 class="l_btn">
													<!--<input type="image" name="doNext" class="doNext " src="templates/images/next.png" />-->
										<div class="btn-group" style="margin-left: 40px;">
											<button class="doNext findpsw-btn">下一步</button>
										</div>

											        <!--<input type="hidden" name="act" value="doNext"/>-->
													<input type="hidden" name="act" value="choose"/>
													</td>
								</tr>
							</table>
							</form>
              		</div>
              </div>
	</div>
</div>
<?php include 'footer.tpl.php'; ?>

<script type="text/javascript">

function on_blur1(){
	if ($(".textzh").val() == "")
	{
						$(".alert_emtry").attr('style','margin-left:8px;color: red;');
						$(".alert_yzmemtry").attr('style','margin-left:8px;color: red;display:none');	
						return false;	
	} else{
						$(".alert_emtry").attr('style','margin-left:8px;color: red;display:none');	
						return false;
		       }

	
}
function on_blur2(){
	if ($(".textyzm").val() == "")
	{
						$(".alert_yzmemtry").attr('style','margin-left:8px;color: red;');
						return false;		
	} else{
						$(".alert_yzmemtry").attr('style','margin-left:8px;color: red;display:none');	
						return false;	
		       }
	
}

$(document).ready(function(){
	$(".doNext").click(function(){
		if($(".textzh").val()==''){
			$(".alert_emtry").attr('style','margin-left:8px;color: red;');	
			return false;
		}
		if($(".textyzm").val()==''){
			$(".alert_yzmemtry").attr('style','margin-left:8px;color: red;');	
			return false;
		}
		$(".NextForm").submit();
	});
});
</script>


</body>
</html>