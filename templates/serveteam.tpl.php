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
<h3>志愿者服务队</h3>
<div class="con_border">
<form  action="serveteam.php" method="get">
<div class="serach_more">
<div class="first">服务队名称： <input type="text"  class="input length_3" name="serviceteamname" value="<?php echo $info['serviceteamname'];?>"/> 　服务队内容： <input type="text"  class="input length_3" name="teamintroduction" value="<?php echo $info['teamintroduction'];?>"/> 　<input class="btn s_btn" type="submit" name="doSearch" value="查询"/></div>
</div>
</form>
<div class="content">
<?php if(!$Team){?> <div style="text-align:center; line-height:130px; color:red">查无数据</div><?php }?>
<?php foreach($Team as $val){?>
<div class="one_team">
<dl class="team_img">
<dt><?php if($val['service_thumb']){?><img src="<?php echo $val['service_thumb']?>"/><?php }else{?>暂无图片<?php }?></dt>
<dd><div class="addbtn"  rid="<?php echo $val['recordid']?>" planNum="<?php echo $val['planmembernumber'] ?>" pid="<?php echo $val['people'];?>" >申请</div></dd>
</dl>
<dl class="team_introduce">
<dt><a href="detailteam.php?rid=<?php echo $val['recordid']?>"><?php echo $val['serviceteamname'] ?></a></dt>
<dd>招收人数：<?php echo $val['planmembernumber']?>人　　已有人数：<span id="peoid_<?php echo $val['recordid']?>"><?php echo $val['people']?></span>人</dd>
<dd>服务类型：<?php echo $val['serveritem']?></dd>
<dd>所需技能：<?php echo $val['skillitem']?></dd>
<dd>所属地区：<?php echo $val['areas']?></dd>
</dl>
</div>
<?php }?>

</div>
<?php include 'page.php';?>
</div>
</div>







</div>
</div>
<script type="text/javascript">
$(function(){
//加入服务队
var num=1;
$(".addbtn").click(function(){
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
		   if(data=="yes"){ui.success( "申请成功");}
		   if(data=="isrepeat"){ui.error( "您已经申请服务队");}
		   if(data=="full") ui.error("人员已满");
	       if(data=="no") ui.error( "申请失败 ");
			}
   });
});

});
</script>
<?php include 'footer.tpl.php'; ?>



</body>
</html>