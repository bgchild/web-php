<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/demo2.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/userWithdraw.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#withdrawForm").submit(function(){
		if($(":checkbox[checked=true]").length==0) {
			alert("请至少选择1个原因！");
			return false;
		}
		if($("#other").attr("checked")=="checked") {
			   val=$("#other_reason").attr("value");
			   if(val=='') {
						alert("请输入其他原因！");
						return false;
				}
			   $("#other").val(val);
			}
		return true;
	});
});
</script>

</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
	
			<p>亲爱的志愿者<?php echo $arg[1];?>,您好</p>
			<p>首先感谢你对社会的奉献，如果您已决定退出，我们真诚的希望了解您退出的原因。您的建议和意见是我们不断进步的动力！</p>
			<p>感谢您对我们的关注和支持！</p>
			
	
			<form action='userWithdraw.php' method='post'  id="withdrawForm">
			<?php $index=0;foreach($types as $type) { $index++;?>
				<div><input type="checkbox" name="reason[]"  value="<?php echo $type['name']?>" />&nbsp;&nbsp;<?php echo $index;?>.<?php echo $type['name'];?></div>
			<?php } $index++;?>
				<div><input type="checkbox" name="reason[]"  id="other" value="" />&nbsp;&nbsp;<?php echo $index;?>.其他原因
							<textarea  name="other_reason" id="other_reason" style="width:200px;height:50px"></textarea></div>
				<div>
					<input type='submit' name='doWithdraw' value='确定注销' class="btn" />&nbsp;
					<input type='reset'  value='重置' class="btn"/>&nbsp;
					<a href="<?php echo $url;?>" class="btn">返回</a>&nbsp;
				</div>
			</form>

	
		
	</div>

</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
</body>
</html>