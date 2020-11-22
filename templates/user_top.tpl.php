<?php 
include_once (INCLUDE_PATH . "UserIndex.php");
$userIndex=new UserIndex();
$userinfo=$userIndex->getCurrentUserInfo();
$curr=$userIndex->getNextTime();
if($userinfo['status']=='1000') $userStatus="体验志愿者";
else if($userinfo['status']=='001') $userStatus="<span style='color:#000080'>登记志愿者</span>";
else if($userinfo['status']=='010') $userStatus="<span style='color:#000080'>注册志愿者</span>";
else if($userinfo['status']=='011') $userStatus="<span style='color:#000080'>初审被拒</span>";
else if($userinfo['status']=='100') $userStatus="<span style='color:#000080'>注销</span>";
?>

<div class="con_right_top">
		<div class="login_service"><a href="javascript:if(confirm('确定退出么？')==true) window.location='index.php?doLogout=logout';">退出</a></div>
		<div class="welcome_msg">
	【<?php echo $userIndex->getUser(1);?>】欢迎你（<?php echo $userStatus;?>），当前服务时间<span style="color:#FBD266">【<?php echo $userinfo['allservertime'];?>】</span>小时，<?php echo $curr['star']==5?"恭喜超越5级，至尊无敌" :"距离下一等级还要<span style='color:#FBD266'>【$curr[next]】</span>小时"?>，未读消息 【 <a href="userMsg.php" class="nrt" style="color:#FBD266;text-decoration:underline;"></a> 】条  <!-- ，&nbsp;&nbsp;<img src="templates/images/user-top-mail.png" class="wmail"> -->
		</div>
		<div class="moreInfo">
			<div class="moreInfoClose"></div>
			<div class="moreInfoText">您有<span class="nrt"> </span>条未读信息！<a href="userMsg.php" style="color:#425F97;">查看</a></div>
		</div>
</div>



<script type="text/javascript">
$(document).ready(function(){
	var showTip=true;
	function getCount(){
		$.getJSON("userIndex.php?t=json", function(data){
			  if(data>0 && showTip) {
			  	$(".nrt").html(data);
			  	//$(".moreInfo").show();
			  }else{
			  	$(".nrt").html(0);
			  }
			});
	}
	getCount();
	setInterval(getCount,10000);
	$(".moreInfoClose").click(function(){
		//$(".moreInfo").hide();
		//showTip=false;
	});
});
</script>