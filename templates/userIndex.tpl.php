<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />

<link type="text/css" rel="stylesheet" href="templates/css/userIndex.css"/>
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
	
	<?php 
	$percent=floor(((120-$curr['next'])/120)*92);
	switch($curr['star']) {
	 	case 0:$newstars_width="80px";$fullbars_width="5px";$redbars_style="margin-left:5px;_margin-left:2px;width:$percent"."px";break;
	 	case 1:$newstars_width="160px";$fullbars_width="97px";$redbars_style="margin-left:97px;_margin-left:48px;width:$percent"."px";break;
	 	case 2:$newstars_width="260px";$fullbars_width="189px";$redbars_style="margin-left:189px;_margin-left:94px;width:$percent"."px";break;
	 	case 3:$newstars_width="340px";$fullbars_width="281px";$redbars_style="margin-left:281px;_margin-left:140px;width:$percent"."px";break;
	 	case 4:$newstars_width="420px";$fullbars_width="373px";$redbars_style="margin-left:373px;_margin-left:186px;width:$percent"."px";break;
	 	case 5:$newstars_width="515px";$fullbars_width="468px";$redbars_style="display:none;margin-left:468px;_margin-left:234px;width:$percent"."px";break;
	 }
	?>
			
			<div class="show_status">
				<div class="userphotoDiv">
					<?php if ($userInfo['head']){?>
		 				<img  src="<?php echo $userInfo['head'];?>" class="userphoto"/>
		 			<?php }else {?>
		 				<img  src="templates/images/face.jpg"  class="userphoto"/>
		 			<?php }?>
	 			</div>
	 			<div class="stars-show">
	 			  <div class="stars" ><div class="nowstars" style="width:<?php echo $newstars_width;?>"></div></div>
	 			  <div class="bars" ><div class="fullbars" style="width:<?php echo $fullbars_width;?>"><div class="redbars" style="<?php echo $redbars_style;?>"></div></div></div>
	 			</div>
			</div>

			<div class="userOption">
				<div class="userOpt_innder">
					<a href="userPhoto.php"  class="btn" >修改照片</a>
					<a href="userChangePassword.php"  class="btn" >修改密码</a>
					<?php if($userInfo['status']=='100') { ?>
						<input type="hidden" class="recordid" value="<?php echo $userInfo['recordid']?>" />
						<input type="button" name="active" class="btn active" value="申请激活"></input>
					<?php } else if($userInfo['status']=='001' or $userInfo['status']=='010'){ ?>
						<a href="userWithdraw.php"  class="btn" >注销</a>
					<?php } ?>
					
				</div>
			</div>
			
			<div class="msgbox">
            <div class="volunteer_sever">
<div class="more_title"><span>热门活动推荐</span><a href="activity.php" title="更多"></a></div>
<ul>
<?php foreach($activity as $val){?>
<li><a href="detailactivity.php?rid=<?php echo $val['recordid']?>"><?php echo $val['activityName']?></a></li>
<?php }?></ul>
</div>
			</div>
			
			<div class="msgbox">
            <div class="volunteer_sever">
<div class="more_title"><span>热门服务队推荐</span><a href="serveteam.php" title="更多"></a></div>
<ul>
<?php foreach ($team as $val){?>
<li><a href="detailteam.php?rid=<?php echo $val['recordid']?>"><?php echo $val['serviceteamname']?></a></li>
<?php }?></ul>
</div>		
	</div>

</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".active").click(function(){
		var con=confirm("确定申请激活么？");
		if(con) {
			$.getJSON("userIndex.php?recordid="+$(".recordid").val(), function(data){
				if(data.isdone=='yes') {
					ui.success("申请成功，请耐心等待审批。");
					$(".active").hide();
					setTimeout("location.href='userIndex.php'",2000);
				}else{
					ui.error("申请失败，请再次尝试。");
				}
			});
		}
	});
});
</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>