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
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
 <?php include 'admin_top.tpl.php'; ?> 

<table width="750"><tr><td  height="5"></td></tr></table>
<div style="height:30px;line-height:30px;">
<span style="color:#2D8DD3; "><b>修改栏目</b></span>
</div>
<div style="margin-left:20px;margin-top:20px;">
<form action='indexManage.php' method='post' class="searchFrom">
   			<table class="base_table" style="padding:0px;">
    			<tbody>
    				<tr>
    					<th>栏目名称：</th><td><input type="text" name="name" style="height:30px;"id="name"  maxlength="6" value="<?php echo $detail['name'];?>" class="input length_4"/></td>
    				</tr>	
    	 		</tbody>
    			</table>
    			<div style="margin-top:20px;margin-left:69px;">
    				<input type="hidden"  name="rid"  class="btn" value="<?php echo $detail['recordid'];?>" /><input type="hidden"  name="act"  class="btn" value="save" /><input type="submit"  name="save" id="save" class="btn" value="保存" />
    				
    				<a style="margin-left:15px;" href="indexManage.php" class="btn">返回</a>
    			</div>
</form>
</div>

</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	
	$('#save').click(function(){
		var name=$('#name').val();
			if(!$.trim(name)){
				ui.error('栏目名称不能为空！');
				return false;
				}
	          return true;
			});
	
	
});
</script>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>