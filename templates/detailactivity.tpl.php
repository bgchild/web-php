<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/activity.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'left.tpl.php';?>
<div class="content_right">
<h3>志愿者活动详细</h3>
<div class="detail_title">
<h1><?php echo $one['activityName'];?></h1>
<div class="title_time">录入时间：<?php echo $one['creattime'];?></div>
</div>
<div class="detail_con">
<div class="troduction"><?php echo $one['activityProfile'];?></div>
<div class="item">活动类型：<?php echo $one['activityType'];?></div>
<div class="item">服务队：<?php echo $one['serviceteamname'];?></div>
<div class="item">活动地点：<?php echo $one['activityAddr'];?></div>
<div class="item">活动时长：<?php echo $one['activitytime']?>&nbsp;小时</div>
<div class="item">预计志愿服务时间：<?php echo $one['predictHour']?>&nbsp;小时</div>
<div class="item">活动时间：<?php echo $one['activityStartDate']."至".$one['activityEndDate'];?></div>
<div class="item">计划人数：<?php echo $one['planNum'];?>&nbsp;人</div>
<div class="item">报名截止时间：<?php echo date("Y-m-d H:i:s ",$one['signUpDeadline']);?></div>
<div class="item">联系人：<?php echo $one['cid']['name']?></div>
<div class="item">联系电话：<?php echo $one['cid']['cellphone']."&nbsp; &nbsp"; echo $one['cid']['telephone']?></div>
<div class="item">电子邮箱：<?php echo $one['cid']['emails']?></div>
<div class="item">参与活动要求：<?php echo $one['remarks']?></div>
</div>
<div class="apply_add">
<div class="addbtn" id="apply" rid="<?php echo $_GET['rid']?>" planNum="<?php echo $one['planNum'] ?>" end="<?php echo $one['signUpDeadline'];?>">申请加入</div>
<a href="javascript:history.back(-1)"><div class="addbtn">返回</div></a></div>
</div>







</div>
</div>
<script type="text/javascript">
$("#apply").click(function(){
var _rid=$(this).attr('rid');
var _planNum=$(this).attr('planNum');
var _endTime=$(this).attr('end');

$.ajax({
	   type:'POST',
	   url:'activity.php',
	   data:{rid:_rid,planNum:_planNum,endTime:_endTime, ajax_add:"ture"}, 
	   success: function(data){
		   if(data=="login") ui.error("您还没有登入");
		   if(data=="sign") ui.error("请选择您归属的城市");
		   if(data=="power") ui.error("您还未通过审核");
		   if(data=="end") ui.error("对不起，报名已截止");
		   if(data=="yes")ui.success( "申请成功"); 
		   if(data=="isrepeat")ui.error( "您已经申请该活动");
		   if(data=="full") ui.error("人员已满");
	       if(data=="no") ui.error( "加入失败 ");

   }
});
							});  
</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>