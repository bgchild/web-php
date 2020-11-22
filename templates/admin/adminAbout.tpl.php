<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/adminContact.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
<link rel="stylesheet" href="../admin/keditor/themes/default/default.css" />
<link rel="stylesheet" href="../admin/keditor/plugins/code/prettify.css" />
<script charset="utf-8" src="../admin/keditor/kindeditor-min.js"></script>
<script charset="utf-8" src="../admin/keditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="../admin/keditor/plugins/code/prettify.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>



<form action='' method='post' class="searchFrom" id="myform">
<table class="base_table" style="float:left">
<tbody>
<tr>
<th><span style="color: red;">*&nbsp;</span>内容：</th><td colspan="4">
<textarea name="content" id="cont" class="cont" style="width:800px; height:400px;">
<?php echo $one['con'];?></textarea></td>
</tr>
<tr>
<td></td><td><?php if($now_flag){ ?><input type="submit"  name="save"  id="save" class="btn" value="保存" /><?php } ?></td>
</tr>
</tbody>
</table>   			
</form>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
<script type="text/javascript">
	KindEditor.ready(function(K) {
		var uploadbutton = K.uploadbutton({
			button : K('#uploadButton')[0],
			fieldName : 'imgFile',
			url : '../image_thumb.php?&time='+new Date().getTime(),
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


	

	var editor;
	  KindEditor.ready(function(K) {
		  editor = K.create('textarea[name="content"]', {
			  allowFileManager : false,
			  resizeType:1,
			  items : [
					'source','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
					'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
					'insertunorderedlist', '|', 'emoticons', 'image','link','table']

		  });
	  });
</script>
</body>
</html>