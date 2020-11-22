<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/index.css"/>
<script type="text/javascript" src="templates/js/jquery-1.8.3.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div class="index_falsh">
<script type="text/javascript" src="templates/js/jquery.jslides.js"></script>
<div id="full-screen-slider">
	<ul id="slides">
    <?php foreach($flash as $v){?>
		<li style=" background:url(<?php echo $v['img'];?>) no-repeat center top"><a href="<?php echo $v['url'] ?>"></a></li>
    <?php }?>
	</ul>
</div>
</div>
<div class="index_box">
<div class="index_con">
<div class="a_left">
<?php include 'login.tpl.php';?>
</div>
<div class="a_mid">
<div class="volunteer_sever volunteer_sever-x clearfix">
<div class="more_title">
	<span>志愿服务活动<a href="activity.php" title="更多">&gt;</a></span>
</div>
<ul>
<?php foreach($activity as $val){?>
<li><a href="detailactivity.php?rid=<?php echo $val['recordid']?>"><?php echo $val['activityName']?></a></li>
<?php }?></ul>
</div>
</div>
<div class="a_right">
<div class="volunteer_sever volunteer_sever-x clearfix">
<div class="more_title">
	<span>志愿服务队<a href="serveteam.php" title="更多">&gt;</a></span>
</div>
<ul>
<?php foreach ($team as $val){?>
<li><a href="detailteam.php?rid=<?php echo $val['recordid']?>"><?php echo $val['serviceteamname']?></a></li>
<?php }?></ul>
</div>
</div>
</div>
</div>
<div class="index_all">
<div class="index_box">
<div class="index_con">
<div class="a_left">
<ul class="fast_tract">
<?php foreach ($flist as $k=>$v) {?>
<a href="<?php echo $v['fast_url'];?>" target="_blank"><li class="f_<?php echo $v['fast_style'];?>"><?php echo $v['fast_name'];?></li></a>
<?php }?></ul>
</div>
<div class="a_mid">
<div class="volunteer_sever">
<div class="more_title"><span><?php echo $name1;?></span><a href="newslist.php?spm=<?php echo set_url(1);?>"title="更多"></a></div>
<ul>
<?php foreach ($list1 as $k=>$v) {
	$url = 'newsDetail.php?spm='.set_url($v['recordid']);
?>
<li><a href="<?php echo $url;?>"><?php echo $v['title'];?></a></li>
<?php } ?>
<!--
<ul>
<?php foreach($activity as $val){?>
<li><a href="detailactivity.php?rid=<?php echo $val['recordid']?>"><?php echo $val['activityName']?></a></li>
<?php }?>
-->
</ul>
</div>
</div>
<div class="a_right">
<div class="" style="float:left; padding:40px 70px 0 0;">
<a href="http://www.kankanews.com/a/2015-11-19/0017234991.shtml?fromvsogou=1" target='_blank' title="第三方视频链接">
<!--
<img src="/templates/images/video.png" />
-->
<img src="/templates/images/revideo.jpg" height="197" width="329">
</div>
</div>
</div>
</div>
</div>
<div class="index_box">
<!--
<div class="index_con" style=" padding-bottom:0px">
<table style=" margin:0 auto">
<tr><td><div class="more_title"><span>专题活动</span><a href="activity.php" title="更多"></a></div></td></tr>
</table>
<div class="slogan">只要人人都献上一片爱，世界将变成美好的人间！</div>
<div class="s_activity">
<div class="s_activity_box">
<?php foreach($activityImg as $v){?>
<dl class="t_img">
<a href="detailactivity.php?rid=<?php echo $v['recordid'];?>">
<dd><img src="<?php echo $v['imgpath'];?>"></dd><dt><?php echo $v['activityName']?></dt>
</a>
</dl>
<?php }?>
</div>
</div>
</div> -->
</div>
<?php include 'footer.tpl.php'; ?>

<script type="text/javascript">
$(function(){ 
	$('.t_img').hover(function(){
		var q=$(this).find('dt').show();
	    },function(){
		$(this).find('dt').hide();
		} )  
	})
</script>
</body>
</html>