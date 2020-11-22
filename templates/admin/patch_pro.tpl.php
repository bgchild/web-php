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
#imggif{
float:left;
width:100%;
margin-top:10px;
clear:both;
}
#notice { 
	overflow: auto; 
	float:left;
	width:98%;
	margin-top:10px;
	padding: 5px; 
	height: 300px; 
	border: 1px solid #B5CFD9; 
	text-align: left;
}
.btns{
	width:100%;
	float:left;
	margin-top:10px;
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



<div id="imggif">
<img src="../templates/images/load-121.gif"  /><br />
数据正在处理中，请勿关闭浏览器
</div>
<div id="notice"></div>

<div class="btns">
<!-- <a href="patch.php?showResult=1" class="btn">查看导入结果报表</a> -->
<a href="volunteerManage.php" class="btn">返回志愿者管理</a>
</div>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
	
<script type="text/javascript">
function showmessage(message) {
    document.getElementById('notice').innerHTML += message + '<br/>';
    document.getElementById('notice').scrollTop = 100000000;
}
function sendInfo(filename,i){
	$.getJSON("patch.php?fileName="+filename+"&i="+i, function(data){
	  if(data.has_false=='true'){
	  	for(var j in data.check_false){
	  		showmessage(data.check_false[j][1]);
	  	}
	  }	
	  showmessage(data.msg);
	  if(data.isdone=="true"){
	  	//showmessage("导入文件遍历完成！！！！如要了解详细信息，请查看导入结果报表。");
	  	$("#imggif").hide();
	  	$(".btns").show();
	  } else{
	  	sendInfo(filename,data.i);
	  }
	});
}
$(document).ready(function(){
	$(".btns").hide();
});
</script>
	
