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
<h3>志愿者活动</h3>
<div class="con_border">
<div class="serach_more">
<form  action="activity.php" method="get">
<div class="first">活动名称： <input type="text" name="activityName" class="input length_3" value="<?php echo $info['activityName'];?>"/> 　活动地址： <input type="text" name="activityAddr"  class="input length_3" value="<?php echo $info['activityAddr'];?>" /> 　<input class="btn s_btn" type="submit" name="doSearch" value="查询"/></div>
</form>
</div>

<div class="content">
<?php if(!$activity){?> <div style="text-align:center; line-height:130px; color:red">查无数据</div><?php }?>
<?php foreach($activity as $key =>$val){?>
<div class="one_activity">
<dl>
<dt><a href="detailactivity.php?rid=<?php echo $val['recordid']?>"><?php echo $val['activityName'] ?></a></dt>
<dd>预计人数：<?php echo $val['planNum']?>人　　已报名人数：<span id="peoid_<?php echo $val['recordid']?>"><?php echo $val['people']?></span>人</dd>
<dd>活动日期：<?php echo $val['activityStartDate']?>至<?php echo $val['activityEndDate']?></dd>
</dl>
<div class="add_activity"><p>活动类型：<?php echo $val['typename']?></p>
<div class="addbtn" name="add_btn"  rid="<?php echo $val['recordid']?>" planNum="<?php echo $val['planNum'] ?>"  pid="<?php echo $val['people'];?>" end="<?php echo $val['signUpDeadline']?>">加入</div>
</div>
</div>
<?php } ?>
</div>
<?php include 'page.php';?>
</div>
</div>



</div>
</div>

<?php include 'footer.tpl.php'; ?>

<script type="text/javascript">
var num=1;
$(".addbtn").click(function(){
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
			   if(data=="sign") ui.error("请选择您归属的城市");
			   if(data=="power") ui.error("您还未通过审核");
			   if(data=="end") ui.error("对不起，报名已截止");
			   if(data=="yes"){ui.success( "加入成功"); $("#peoid_"+_rid).empty(); $("#peoid_"+_rid).append(_apid);}
			   if(data=="isrepeat"){ui.error( "您已经加入了这个活动");}
			   if(data=="full") ui.error("人员已满");
		       if(data=="no") ui.error( "加入失败 ");
	   }
	});
});  
</script>



</body>
</html>