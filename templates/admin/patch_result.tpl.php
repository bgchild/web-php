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
#notice { 
	float:left;
	width:100%;
	margin-top:10px;
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



<div id="notice">
	<?php if(count($check_false)>0) {?>
	<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
	            <th width="60">行数</th>
	            <th>结果</th>
            </tr>
            <?php foreach($check_false as $v){
			?>
			<tr>
            <td align="center"><?php echo $v[0];?></td>
            <td><?php echo $v[1];?></td>
            </tr>
            <?php }?>     
	</table>
	<?php } ?>
   
	<?php if(count($error)>0) {?>
	<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
	            <th width="60">行数</th>
	            <th>结果</th>
            </tr>
            <?php foreach($error as $v){
			?>
			<tr>
            <td align="center"><?php echo $v[0];?></td>
            <td><?php echo $v[1];?></td>
            </tr>
            <?php }?>     
	</table>
	<?php }?>
</div>

<div class="btns">
<a href="volunteerManage.php" class="btn">返回志愿者管理</a>
</div>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
	
<script type="text/javascript">

$(document).ready(function(){

});
</script>
	
