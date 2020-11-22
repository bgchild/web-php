<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/serviceTeamPicture.css"/>
<link type="text/css" rel="stylesheet" href="../templates/css/imgupload.css" />
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
<script  type="text/javascript"   src="../templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="../include/keditor/kindeditor-min.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
<div class="pic_top">
	<form action="serviceTeamPicture.php?spm=<?php echo set_url($spm);?>" method="post" class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>图片上传</legend>
                    <div class="searchDivInFieldset">
                        <table class="searchTable" cellpadding="0" cellspacing="0">
                          	<tr>
                            	<td align="right">图片名：</td>
                                <td><input type="text" name="img_name" class="input" id="img_name" value="" /></td>
                            </tr>
                            <tr>
                            	<td align="right">图片路径：</td>
                                <td><input type="text" name="thumb_url" id="thumb_url" value="" class="input length_5" readonly="readonly" /></td>
                                <td>&nbsp;&nbsp;<input type="button" id="uploadButton" value="选择图片" /></td>
                                <td>&nbsp;建议图片尺寸：624*300</td>
                            </tr>
                            <tr>
                            	<td colspan="1" ></td>
                                <td><input type="submit" value="提交" name="dosubmit" class="btn" /></td>
                            </tr>
                        </table>
                    </div>
  			</fieldset>
	</form>
    </div>
    <div class="pic_form">
    	<form action="serviceTeamPicture.php?spm=<?php echo set_url($spm);?>" method="post" id="or_sub">
            <table class="list-table" cellspacing="1" cellpadding="2">
                <tr>
                    <th align="center" width="80">排序号</th>
                    <th align="center" width="200">图片名</th>
                    <th align="center" width="300">图片路径</th>
                    <th align="center" width="140">操作</th>
                </tr>
                <?php foreach ($stp_info as $v) {?>
                <tr>
                    <td align="center" width="80"><input type="text" name="order[]" class="input length_0" value="<?php echo $v['img_order'];?>" maxlength="3"/></td>
                    <td align="left" width="200" class="omit1"><a title="<?php echo $v['img_name'];?>" style="text-decoration:none;"><?php echo $v['img_name'];?></a></td>
                    <td align="left" width="300" class="omit2"><a title="<?php echo $v['img_url'];?>" style="text-decoration:none;"><?php echo $v['img_url'];?></a></td>
                    <td align="center" width="140"><a href="<?php echo '../',$v['img_url'];?>"><img src="../templates/images/manage/icon_view.gif" alt="查看"/></a>&nbsp;<a href="javascript:if(confirm('确定要删除一条数据吗?')) location.href='serviceTeamPicture.php?spm=<?php echo set_url($spm);?>&deleteid=<?php echo set_url($v['recordid']);?>'" ><img src="../templates/images/manage/icon_drop.gif" alt="删除" /></a></td>
                </tr>
                <input type="hidden" name="rid[]" value="<?php echo $v['recordid']?>"/> 
                <?php } if(!$stp_info){?><tr><td colspan='4'>查无数据</td></tr><?php }?>
            </table>
            <div class="order"><input type="submit" name="or_btn"  class="btn" value="排序"/></div>
            <div class="order2"><a href="serviceTeamMessage.php<?php if($spm['page']){echo '?&page='.$spm['page'];}?>" class="btn">返回</a></div>
        </form>	
</div>
    			



<script type="text/javascript">
$(function(){ 
	//图片表单提交验证
	$("#myform").submit(function(){
		//图片名
		var img_name = $("#img_name").val();
		//图片路径
		var thumb_url = $("#thumb_url").val();
		
		//图片名判断
		if (!img_name) {
			ui.error('图片名不能为空!');
			return false;
		} else {
			if (img_name.length > 20) {
				ui.error('图片名过长！');
				return false;
			}
		}
		
		//图片路径判断
		if (!thumb_url) {
			ui.error('图片路径不能为空！');
			return false;
		}
		
	});
	
	//排序表单提交验证
	$("#or_sub").submit(function(){
		//排序校验值
		var ord = '';
		//正则匹配规则
		var reg = null;
		
		$("input[name^='order']").each(function(){
			var order=$(this).val().replace(/[ ]/g,"");
			if(!order) {
				ord='1';
			}
			reg=/^[1-9]\d?$/;
			if(!reg.test(order)){
				ord= '2';
			}
			if (order > 255) {
				ord = '3';
			}
			
		});	
		if (ord =='1') {
			ui.error('排序号必填!');
			return false;
		}
		if (ord =='2') {
			ui.error('请输入正整数！');
			return false;
		}
		if (ord == '3') {
			ui.error('正整数不能大于255！');
			return false;
		}
	});
	

});





KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton')[0],
					fieldName : 'imgFile',
					url : '../server_thumb.php?&time='+new Date().getTime(),
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = '../'+K.formatUrl(data.url);
							
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



</script>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>