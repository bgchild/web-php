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
<div class="service_con">
<div class="service_more"><h3><span>热门服务队</span><a href="serveteam.php">更多</a></h3>
<?php foreach($team as $val){?>
<div class="service_team">
<dl class="serviceteam_img">
<dt><?php if($val['service_thumb']){?><img src="<?php echo $val['service_thumb']?>"/><?php }else{?>暂无图片<?php }?></dt>
<dd><div class="addserverteam addbtn"  rid="<?php echo $val['recordid']?>" planNum="<?php echo $val['planmembernumber'] ?>" pid="<?php echo $val['people'];?>" >申请</div></dd>
</dl>
<dl class="serviceteam_introduce">
<dt><a href="detailteam.php?rid=<?php echo $val['recordid']?>"><?php echo $val['serviceteamname'] ?></a></dt>
<dd>已有人数：<span id="peoid_<?php echo $val['recordid']?>"><?php echo $val['people']?></span>人</dd>
<dd>服务类型：<?php echo $val['serveritem']?></dd>
<dd>所需技能：<?php echo $val['skillitem']?></dd>
<dd>所属地区：<?php echo $val['areas']?></dd>
</dl>
</div>
<?php }?>
</div>
<div class="service_more"><h3><span>热门活动</span><a href="activity.php">更多</a></h3>
<?php foreach($activity as $val){?>
<div class="service_activity">
<dl>
<dt><a href="detailactivity.php?rid=<?php echo $val['recordid']?>"><?php echo $val['activityName'] ?></a></dt>
<dd>预计人数：<?php echo $val['planNum']?>人　　已报名人数：<span id="peoid_<?php echo $val['recordid']?>"><?php echo $val['people']?></span>人</dd>
<dd>活动日期：<?php echo $val['activityStartDate']?>至<?php echo $val['activityEndDate']?></dd>
</dl>
<div class="serviceadd_activity"><p>活动类型：<?php echo $val['typename']?></p>
<div class="addactivity addbtn"  name="add_btn"  rid="<?php echo $val['recordid']?>" planNum="<?php echo $val['planNum'] ?>"  pid="<?php echo $val['people'];?>" end="<?php echo $val['signUpDeadline']?>">加入</div>
</div>
</div>
<?php }?>
</div>
</div>

<div class="special_events">
<dl><dt>专题活动</dt>
<?php foreach($activityInfo as $k=>$v) {if($v['imgpath']) {?>
<dd><a href="detailactivity.php?rid=<?php echo $v['recordid'];?>"><img class="a_img" src="<?php echo $v['imgpath'];?>"/></a></dd>
<?php }}?>
</dl></div>
</div>




</div>
</div>

<?php include 'footer.tpl.php'; ?>

<script type="text/javascript">
var num=1;
$(".addserverteam").click(function(){
var _rid=$(this).attr('rid');
var _planNum=$(this).attr('planNum');
$.ajax({
	   type:'POST',
	   url:'serveteam.php',
	   data:{rid:_rid,planNum:_planNum, ajax_add:"ture"},
	   success: function(data){
		   if(data=="login") ui.error("您还没有登入");
		   if(data=="sign") ui.error("请选择您归属的城市");
		   if(data=="power") ui.error("您还未通过审核");
		   if(data=="yes") ui.success( "申请成功");
		   if(data=="isrepeat"){ui.error( "您已经申请该服务队");}
		   if(data=="full") ui.error("人员已满");
	       if(data=="no") ui.error( "申请失败 ");
}
   });
});

$(".addactivity").click(function(){
var _rid=$(this).attr('rid');
var _planNum=$(this).attr('planNum');
var _endTime=$(this).attr('end');
var _pid=$(this).attr('pid');
var _apid=_pid*1+num;
$.ajax({
	   type:'POST',
	   url:'activity.php',
	   data:{rid:_rid,planNum:_planNum,endTime:_endTime,ajax_add:"ture"}, 
	   success: function(data){
		   if(data=="login") ui.error("您还没有登入");
		   if(data=="sign")  ui.error("请选择您归属的城市");
		   if(data=="power") ui.error("您还未通过审核");
		   if(data=="end") ui.error("对不起，报名已截止");
		   if(data=="yes"){ui.success( "申请成功"); $("#peoid_"+_rid).empty(); $("#peoid_"+_rid).append(_apid);}
		   if(data=="isrepeat"){ui.error( "您已经申请该活动");}
		   if(data=="full") ui.error("人员已满");
	       if(data=="no") ui.error( "加入失败 ");
   }
});
							});  
</script>



</body>
</html>