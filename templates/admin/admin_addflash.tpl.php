<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_flash.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../templates/css/imgupload.css"/>
<script type="text/javascript" src="../include/keditor/kindeditor-min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>
<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
<div class="upflash">
<form action="adminaddflash.php" method="post" enctype="multipart/form-data" id="addflash">
<table>
<input type="hidden" name="rid" value="<?php echo $one['id'];?>"/>
<tr>
<td><p><span class="must">*</span>&nbsp;&nbsp;排序号：</p></td>
<td><input type="text" name="order" value="<?php echo $one['orderlist'] ?>" class="input length_1" />&nbsp;&nbsp;排序号最多为2位的正整数</td>
</tr>
<tr>
<td><p><span class="must">*</span>&nbsp;&nbsp;名　称：</p></td>
<td><input type="text" name="name" value="<?php echo $one['name'] ?>" class="input length_3"/></td>
</tr>
<tr>
<td><p><span class="must">*</span>&nbsp;&nbsp;超链接：</p></td>
<td><input type="text" name="url" value="<?php echo $one['url'] ?>"class="input length_3"/>　例如：http://www.honghui.com</td>
</tr>
<tr>
<td><p><span class="must">*</span>&nbsp;&nbsp;图　片：</p></td>
<td><div class="thumb"><?php if($one['img']){?> <img src="../<?php echo $one['img']?>" > <?php }else{ echo "建议上传1440px*415px图片(2M以内)";} ?></div></td><td><?php if($now_flag){?><input type="button" id="uploadButton" value="上传图片"  /><?php }?></td></tr>
<input type="hidden" id="thumb_url" name="thumb_url" value="<?php if($one['img']) {echo "../".$one['img']; }?>"  />
</table>
<div class="save">
<?php if($now_flag){?><input type="submit" class="addbtn" name="dosave" value="保存"/><?php }?><a href="adminflash.php"><div class="addbtn returnbtn">返回</div></a></div>
</form>

</div>
</div>
</div>
</div>
<script type="text/javascript">
			KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton')[0],
					fieldName : 'imgFile',
					url : '../flash_thumb.php?&time='+new Date().getTime(),
					afterUpload : function(data) {
						if (data.error === 0) {
						   var url ='../'+K.formatUrl(data.url);
							K('#thumb_url').val(url);
						    K('.thumb').html('<img src='+url+' />');
						} else {
							
							alert(data.message);
						}
					},
					afterError : function(str) {
						alert('自定义错误信息: ' + str);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					uploadbutton.submit();
				});
			});
			


$("#addflash").submit(function(){
var order = $("input[name='order']").val();
if(!order){	
    ui.error('排序号不能为空');
	return false;}
reg=/^[1-9]\d?$/;
if(order){
	if(!reg.test(order)){
	ui.error('排序号不正确');
	return false;
	}}
var name = $("input[name='name']").val().replace(/[ ]/g,"");
if(!name){ui.error('名称不能为空');
	return false;}
var url= $("input[name='url']").val().replace(/[ ]/g,"");
if(!url){ui.error('超链接不能为空');
	return false;}
	var photo=$('#thumb_url').val();
if(!photo){ui.error('图片不能为空');
	return false;}
});	

		</script>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>