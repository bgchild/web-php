<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
<style type="text/css">
.intension{
	width:99%;
	height:200px;
	float:left;
	margin-top:10px;
	clear:both;
	border:1px solid #DFC383;
	background-color:#FFFFCD;
}
.patchForm{
	display:block;
	float:left;
	margin-top:20px;
}
.downFiles{
	height:40px;
	line-height:40px;
	text-indent:30px;
}
.intwords{
	line-height:30px;
	margin-left:30px;
}
</style>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>

<div class="intension">
	<div class="downFiles"><a href="patch.php?filepath=../fileuploads/model.xls&filename=模板.xls" style="color:#E95D22;text-decoration:underline">点击这里下载Excel模板</a>，请严格按照数据格式填写。&nbsp;&nbsp;<a href="patch.php?filepath=../fileuploads/demo.xls&filename=示例.xls" style="color:#E95D22;text-decoration:underline">点击这里下载示例</a></div>
	<div class="intwords">
		<font style="font-weight:bold">注意事项：</font>
		<ul>
			<li>密码默认为123456</li>
			<li>国籍、民族、证件类型等信息请先查阅数字字典</li>
			<li>模板中有*号的必填写&nbsp;<font style="color:red">严禁调整模板格式</font></li>
			<li>地区等信息请填写相关地区编号</li>
		</ul>
	</div>
</div>

<form action="patch.php" method="POST" enctype="multipart/form-data" class="patchForm">
		<input type="file" name="excelFile" ></input> &nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="doSubmit" value="开始导入" class="btn" />
</form>



</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
	
<script type="text/javascript">

</script>
	
</body>
</html>