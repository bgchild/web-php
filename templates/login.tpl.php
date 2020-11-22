<!--登陆开始-->
<?php 
include_once (INCLUDE_PATH . "Index.php");
$index=new Index();
$username=$index->checkLogin();
?>
<div class="index_login">
<h2>志愿者登陆</h2>
<?php if(!$username) {?>
<form action="index.php" method="post" class="LoginForm">
<table>
<tr><td>用户名：</td><td colspan="2"><input type="text" class="index_text" name="username"  id="username" value="<?php echo $_SESSION[username] ?>"/></td></tr>
<tr><td>密　码：</td><td colspan="2"><input type="password" class="index_text" name="password"/></td></tr>
<tr><td>验证码：</td><td><input type="text" class="index_text code"  name="checkcode" /></td><td><a style="margin-left:5px; outline:none" href="javascript:document.getElementById('checkcode').src='include/Checkcode.class.php?time='+Math.random();void(0);">
<img src="include/Checkcode.class.php" id="checkcode"  style="width:80px; height:25px; float:left; margin-left:6px; display:inline"/>
</a></td></tr>
<tr class="findpsw"><td colspan="3" align="right"><a href="findpsw.php">忘记密码？</a></td></tr>
<tr>
<td colspan=3>
<a href="agree.php"><img class="index_l_btn doRegister"src="templates/images/r_btn.png" /></a>
<input type="hidden" name="doLoginValue" value="doLogin"/>
<input type="image" name="doLogin" class="index_l_btn doLogin" src="templates/images/l_btn.png" />
</td></tr>
</table>
</form>
<?php }else { 
include_once (INCLUDE_PATH . "UserBasicInfo.php");
$user=new UserBasicInfo();
$userinfo=$user->getBasicInfo('form__bjhh_volunteermanage_volunteerbasicinfo');
?>
<div class="allogin" style="padding-top:30px">
<div class="allogin_img_div" ><img src="<?php  if($userinfo['head']) echo $userinfo['head'];else echo 'templates/images/face.jpg';?>"  class="allogin_img"/></div>
<div class="allogin_left_div" >
<div class="allogin_left_div_1"  ><?php echo $username;?>,欢迎您</div>
</div>
<div class="allogin_but_div" style="padding-top:30px;">
<a href="userIndex.php" ><img src="templates/images/login_center.png" /></a>&nbsp;&nbsp;<a href="javascript:if(confirm('确定退出么？')==true) window.location='index.php?doLogout=logout';" ><img src="templates/images/login_logout.png" /></a>
</div>
</div>	
<?php }?>
</div>
<script type="text/javascript">
$(document).ready(function(){

	$(".link").click(function(){
	 uname=$("#username").val();	
     $(this).attr('href','findpsw.php?uname='+uname);		
	});
	$(".doLogin").click(function(){
		$(".LoginForm").submit();
	});
	
});
</script>
<!--登陆结束-->