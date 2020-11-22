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
              		     <span style="font-size: 16px;color: #313131;">重设密码：</span>
              		</div>
              		<div class="fpsw_con">
              		<form action="findpsw.php" method="post"  class="EndForm">
              		       <table>
              		            <tr><td align="right">请回答问题：</td><td><?php echo $question['name'];?><input type="hidden" name="questionid" value="<?php echo $question['id'];?>" /><input type="hidden" name="username" value="<?php echo $username;?>" /></td></tr>
								<tr><td align="right"><span style="color: red;margin-right:4px;">*</span>答案：</td><td><input type="text"  class="textzh" name="answer" /></td></tr>
								<tr><td align="right"><span style="color: red;margin-right:4px;">*</span>新密码：</td><td><input type="password"  class="textzh" name="newpsw" /></td></tr>
								<tr><td></td><td><span style="color: #999999;">密码长度为6-20位，区分大小写，可用英文字母、数字、特殊字符。</span></td></tr>
								<tr><td align="right"><span style="color: red;margin-right:4px;">*</span>重复新密码：</td><td><input type="password"  class="textzh" name="rnewpsw" /></td></tr>
								<tr><td align="right"><span style="color: red;margin-right:4px;">*</span>验证码：</td><td><input type="text" class="textyzm"  name="checkcode" />
										
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
													<!--<input type="image" name="doEndd" class="doEnd " value="doEndd" src="templates/images/end.png" />-->
										<div class="btn-group" style="margin-left: 40px;">
											<button  class="doEnd findpsw-btn">确定</button>
										</div>

											        <input type="hidden" name="act" value="doEnd"/>
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
$(document).ready(function(){
	$(".doEnd").click(function(){
		$(".EndForm").submit();
	});
});
</script>


</body>
</html>