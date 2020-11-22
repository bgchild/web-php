<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/userActivationRecord.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/common.js"></script>
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
<div class="detail_title">
<h1><?php echo $one['activityName'];?></h1>
<div class="title_time">录入时间：<?php echo $one['creattime'];?></div>
</div>
<div class="detail_con">
<div class="troduction"><?php echo $one['activityProfile'];?></div>
<div class="item">活动类型：<?php echo $one['activityType'];?></div>
<div class="item">服务队：<?php echo $one['serviceteamname'];?></div>
<div class="item">计划人数：<?php echo $one['planNum'];?></div>
<div class="item">报名截止时间：<?php echo $one['signUpDeadline'];?></div>
<div class="item">活动地点：<?php echo $one['activityAddr'];?></div>
<div class="item">活动时间：<?php echo $one['activityStartDate']."至".$one['activityEndDate'];?></div>
<div class="item">联系人：<?php echo $one['cid']['name']?></div>
<div class="item">联系电话：<?php echo $one['cid']['cellphone'].'&nbsp;&nbsp;'; echo $one['cid']['telephone']?></div>
<div class="item">电子邮箱：<?php echo $one['cid']['emails']?></div>
</div>
<div class="go_back">
<a href="javascript:history.back(-1)"><div class="addbtn">返回</div></a></div>
</div>

</div>

</div>
</div>
<?php include 'footer.tpl.php'; ?>
</body>
</html>