<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/activity.css"/>
<link rel="stylesheet" type="text/css" href="templates/css/jquery.bxslider.css"> 
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script type="text/javascript" src="templates/js/jquery.bxslider.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'left.tpl.php';?>
<div class="content_right">
<h3>服务队详细</h3>
<div class="detail_title">
<h1><?php echo $one['serviceteamname'];?></h1>
<div class="title_time">录入时间：<?php echo $one['foundingtime'];?></div>
</div>
<div class="detail_con">
<div class="item">志愿团体：<?php echo $one['serviceteamname'];?></div>
<div class="item">所属地区：<?php echo $one['areas'];?></div>
<div class="item">招收人数：<?php echo $one['planmembernumber'];?>人</div>
<div class="item">成员人数：<?php echo $one['member'];?>人</div>
<div class="item">成立日期：<?php echo $one['foundingtime'];?></div>
<div class="item">负责人：<?php echo $one['responsibleperson'];?></div>
<div class="item">联系人：<?php echo $one['relationperson'];?></div>
<div class="item">联系电话：<?php echo $one['mobile_telephone']."&nbsp;&nbsp;"; echo $one['telephones'];?></div>
<div class="item">电子邮箱：<?php echo $one['emails']?></div>
<div class="item">详细通讯地址：<?php echo $one['detailed_address']?></div>
<div class="item">邮编：<?php echo $one['postcodes']?></div>
<div class="item">传真：<?php echo$one['fax']?></div>
<div class="item">服务类型：<?php echo $one['serveitem']?></div>
<div class="item">所需技能：<?php echo $one['skillitem']?></div>
<div class="item">目前或计划开展服务：<?php echo $one['others']?></div>
<div class="item">简要服务经历：<?php echo $one['teamintroduction']?></div>
<?php if($tem_pic){?>
<ul class="bxslider">      
<?php foreach($tem_pic as $val){?>
 <li><img src="<?php echo $val[img_url]?>"/></li>    
 <?php }?>   
</ul> 
<?php }else{ echo "<font color=\"#FF0000\"><b>暂无服务队图片</b></font>";}?>
</div>

<div class="team_activity">过往活动：
        <table class="list-table" cellspacing="1" cellpadding="2">
			<tr><th>活动名称</th><th>活动类别</th><th>开始时间</th><th>结束日期</th><th>活动状态</th></tr>
			<?php if(!$serveteamactivity){?><tr><td colspan='5'>查无数据</td></tr><?php }?>
			<?php foreach($serveteamactivity as $val){?>
			<tr><td class="onetd"><a title="<?php echo $val['activityName']?>" href="detailactivity.php?rid=<?php echo $val['recordid']?>"><?php echo $val['activityName']?></a></td><td><?php echo $val['typename'];?></td><td style="text-align:center"><?php echo $val['activityStartDate']?></td><td style="text-align:center"><?php echo $val['activityEndDate']?></td><td><?php echo $val['applystatus'];?></td></tr>
		    <?php }?>
      </table><?php include 'page.php';?></div>
<div class="apply_add">
<div class="addbtn" id="apply"  rid="<?php echo $_GET['rid']?>" planNum="<?php echo $one['planmembernumber'] ?>" pid="<?php echo $val['people'];?>">申请加入</div>

<a href="javascript:history.back(-1)"><div class="addbtn">返回</div></a></div>

</div>
</div>
</div>
<script type="text/javascript">
//加入服务队
$("#apply").click(function(){
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
		   if(data=="isrepeat"){ui.error( "您已经申请该服务队");}
		   if(data=="full") ui.error("人员已满");
	       if(data=="no") ui.error( "加入失败 ");
}
   });
});

$(function(){
	$('.bxslider').bxSlider({
		 mode: 'vertical',
  		 slideMargin: 5
	});
});


</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>