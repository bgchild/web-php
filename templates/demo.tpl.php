<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/demo.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<div style="margin:0 auto; width:900px;">
<?php //include 'header.tpl.php'; ?>
<?php //include 'footer.tpl.php';?>
<div style="width:900px; height:100px; border:1px solid #0F0;float:left; margin-top:10px;">
<div style="width:900px; height:30px;">分页使用</div>
<?php include 'page.php'?>
</div>

<div style="width:900px; height:100px; border:1px solid #0F0;float:left; margin-top:10px; color:#F00; font-weight:bold">
<div style="width:900px; height:30px;">数据库调用</div>
$db->方法
具体方法在：common/common.class.php 里，用到可以查看
<br>
提示弹框:用作操作之后的提示
$db->get_show_msg();
</div>

<div style="width:900px; height:100px; border:1px solid #0F0;float:left; margin-top:10px;  font-weight:bold">
<div style="width:900px; height:30px;">日期插件使用</div>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>

<input type="text" name="demo_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"  id="demo_time" value=""  readonly="readonly" >
</div>


<div style="width:900px; height:100px; border:1px solid #0F0;float:left; margin-top:10px;">
<form action="" method="post" name="fm"  enctype="multipart/form-data">
<table width="580">
<tr>
<th>演示：</th>
<td>上传文件使用</td>
</tr>
<tr>
<th>上传文件：</th>
<td><input type="file" name="thumb" id="thumb"  style="width:300px; height:25px"/>&nbsp;<font style="color:red"><b><br />格式要求：pdf，xlsx，xls，doc，docx，ppt，gif，jpg，png，txt</b></font></td>
</tr>
<tr>
<th></th>
<td height="40"><input type="submit" name="submit" value="提交" style="width:70px; height:25px; cursor:pointer"/></td>
</tr>
</table>
</form>
</div>
<!--上传图片使用开始 最终图片地址为$_POST['thumb_url']-->
<div style="width:500px; height:300px; border:1px solid #0F0;float:left; margin-top:10px;">
<div style="width:500px; float:left; margin-bottom:5px;">
上传图片使用，如同一个页面没有文本编辑器加载，templates/js/ditor/kindeditor-min.js
<br />如果有文本文本编辑器加载:include/keditor/kindeditor-min.js</div>
<link type="text/css" rel="stylesheet" href="templates/css/imgupload.css"/>
<style>
   .thumb{ width:200px; height:200px; float:left; border:1px solid #ccc; margin-left:10px;}
   .thumb img{width:200px; height:200px; }
   </style>
<script type="text/javascript" src="include/keditor/kindeditor-min.js"></script>
<script type="text/javascript">
			KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton')[0],
					fieldName : 'imgFile',
					url : 'image_thumb.php?&time='+new Date().getTime(),
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = K.formatUrl(data.url, 'absolute');
	
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
        
    <div class="thumb">

    <div style="width:200px; height:200px; float:left; margin-left:5px; margin-top:5px; display:inline">
    200px*200px以上的图片，可以在商品列表,详情页用到该图片
    </div></div>
 <div style="width:200px; float:left; margin-left:15px; margin-top:10px; display:inline;">
    <input   type="hidden" id="thumb_url" name="thumb_url" value=""  />
    <input type="button" id="uploadButton" value="上传缩略图"  />  
</div> 

</div>
<!--上传图片使用结束 $_POST['thumb_url']-->



<!--上传头像使用开始 最终图片地址为$_POST['thumb_url']-->
<div style="width:800px;  border:1px solid #0F0;float:left; margin-top:10px;">
<div style="width:800px; float:left; margin-bottom:5px;">
上传图片使用，如同一个页面没有文本编辑器加载，templates/js/ditor/kindeditor-min.js
<br />如果有文本文本编辑器加载:include/keditor/kindeditor-min.js</div>
<link type="text/css" rel="stylesheet" href="templates/css/imgupload.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/imgareaselect-animated.css"/>

<script type="text/javascript" src="templates/js/jquery.imgareaselect.min.js"></script>
<style>
   .thumb2{ width:200px; height:200px; float:left; border:1px solid #ccc; margin-left:10px;}
   .thumb2 img{width:200px; height:200px; }
   </style>
<script type="text/javascript" src="include/keditor/kindeditor-min.js"></script>
<script type="text/javascript">
			KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton2')[0],
					fieldName : 'imgFile',
					url : 'user_thumb.php?&time='+new Date().getTime(),
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = data.url;
							$("#user_head_small").hide();
							K("#user_head_big").show();
							K('#thumb_url2').val(url);
							K('#photo').attr('src',url);
							K('#small_img').attr('src',url);
							 $('#photo').imgAreaSelect({  x1: 10, y1: 10, x2: 200, y2: 200 ,aspectRatio: '1:1', handles: true, fadeSpeed: 200, onSelectChange: preview });
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
    
    
        
     <script type="text/javascript">
function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;
    
    var scaleX = 200 / selection.width;
    var scaleY = 200 / selection.height;

    $('#preview img').css({
        width: Math.round(scaleX * 300),
        height: Math.round(scaleY * 300),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });

    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);    
}



        
       


$(function () {
   
	$("#save_btn").click(function(){
	var x1=	$('#x1').val();
	var y1=	$('#y1').val();
	var x2=	$('#x2').val();
	var y2=	$('#y2').val();
	var w=	$('#w').val();
	var h=	$('#h').val();
	var bigimg=	$('#thumb_url2').val();	
	if(!bigimg || !w || !h){
		return false;
		}
	$.ajax({
		type:'POST',
		url:'ajax_head.php',
		dataType:'json',
		data:{act:'dosubmit',x1:x1,x2:x2,y1:y1,y2:y2,w:w,h:h,bigimg:bigimg},
		success:function(data){
			if(data.error==0){
				$("#user_head_big").hide();
				 $('.u_head_img').hide();
				$("#user_head_small").show();
				$("#user_head_small_img").attr('src',data.url);
				
				
				}
			
			}
		});	
		
		
		});
	
});

</script>
   <style>
  .frame {
	background: #fff;
	padding: 0.8em;
	border: solid 2px #ddd;
}
   
   </style>     
   
    <div style="width:200px; float:left; margin-left:15px; margin-top:10px; display:inline;">
 
    <input   type="hidden" id="thumb_url2" name="thumb_url2" value="flower2.jpg"  />
    <input type="button" id="uploadButton2" value="上传头图"  />  
   <div class="btn" id="save_btn" style="cursor:pointer">保存</div> 
</div> 


    <div style="width:800px; display:none; float:left" id="user_head_small">
  <div style="margin: 0 1em; width: 200px; height: 200px; float:left;" class="frame">

        <img style="width: 200px; height: 200px;" id="user_head_small_img" src="flower2.jpg" >

    </div>
    </div>
    
        
    <div style="width:800px; display:none; float:left" id="user_head_big">
   
   <div style="margin: 0 0.3em; width: 300px; height: 300px; float:left;" class="frame">
      <img src="flower2.jpg" id="photo">
    </div>
    <div style="float: left; width: 50%;">
    <p style="font-size: 110%; font-weight: bold; padding-left: 0.1em;">
      裁剪头像
    </p>
  
    <div style="margin: 0 1em; width: 200px; height: 200px;" class="frame">
      <div style="width: 200px; height: 200px; overflow: hidden;" id="preview">
        <img style="width: 200px; height: 200px;" src="flower2.jpg" id="small_img">
      </div>
    </div>

   
   
  </div>

   
   


    </div>
    
                 <input type="hidden" name="x1" value="0" id="x1" />
				<input type="hidden" name="y1" value="0" id="y1" />
				<input type="hidden" name="x2" value="200" id="x2" />
				<input type="hidden" name="y2" value="200" id="y2" />
				<input type="hidden" name="w" value="200" id="w" />
				<input type="hidden" name="h" value="200" id="h" />
    


</div>
<!--上传头像使用结束 $_POST['thumb_url']-->






<div style="width:900px;  border:1px solid #0F0;float:left; margin-top:10px;">

<link rel="stylesheet" href="include/keditor/themes/default/default.css" />
<link rel="stylesheet" href="include/keditor/plugins/code/prettify.css" />
<script charset="utf-8" src="include/keditor/kindeditor-min.js"></script>
<script charset="utf-8" src="include/keditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="include/keditor/plugins/code/prettify.js"></script>
<form action="" method="post" name="myfrom"  enctype="multipart/form-data">
<table width="580">
<tr>
<th>演示：</th>
<td>文本编辑器的使用</td>
</tr>
<tr>
<th>内容：</th>
<td>
<script type="text/javascript">
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
                        <textarea style="width:500px; height:300px;" id="content" name="content"></textarea>

</td>
</tr>
<tr>
<th></th>
<td height="40"><input  type="submit" name="tj" value="提交" style="width:70px; height:25px; cursor:pointer"/></td>
</tr>
</table>
</form>
</div>


<div style="width:900px;  border:1px solid #0F0;float:left; margin-top:10px;">
<!--表格基本使用开始-->

<table class="base_table">
			
            
			<tbody><tr>
				<th>关键字</th>
				<td><input name="keyword" class="input length_3" placeholder="可使用通配符*" value="" type="text"></td>
				<th>所属版块</th>
				<td><select name="fid" class="select_3"><option value="0">所有版块</option><option value="1">&gt;&gt; 新分类</option><option value="2"> &nbsp;|- 新版块</option></select></td>
			</tr>
			<tr>
				<th>作者</th>
				<td><input name="author" class="input length_3" value="" type="text"></td>
				<th>发帖时间</th>
				<td><input class="input length_3 mr10 J_date date" name="created_time_start" value="" type="text"><span class="mr10">至</span><input class="input length_3 J_date date" name="created_time_end" value="" type="text"></td>
			</tr>
			<tr>
				<th>删除人</th>
				<td><input name="operator" class="input length_3" value="" type="text"></td>
				<th>删除时间</th>
				<td><input name="operate_time_start" class="input length_3 mr10 J_date date" value="" type="text"><span class="mr10">至</span><input name="operate_time_end" class="input length_3 J_date date" value="" type="text"></td>
			</tr>
		</tbody>
</table>

<button class="btn" type="submit">搜索</button>
<a href="#" class="addbtn" role="button"><span class="add"></span>添加后台用户</a>
<!--表格基本使用结束-->


	<br /><br /><br /><br /><br />
	<!-- 用表格或tab时引用common_table.js -->
	<script type="text/javascript" src="templates/js/common_table.js"></script>
   		<table class="list-table" cellspacing="1" cellpadding="2">
			<tr><th>活动名称</th><th>活动日期</th><th>活动类型</th><th>计划人数</th><th>状态</th><th>操作</th></tr>
			<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td><a href="###"><img src="templates/images/manage/icon_view.gif"/></a><a href="###"><img src="templates/images/manage/icon_edit.gif"/></a><a href="###"><img src="templates/images/manage/icon_drop.gif"/></a></td></tr>
			<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
			<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
			<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
			<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		</table>
		
			
		<br /><br /><br /><br /><br />
		
<!--tab-->			

<div class="tab">
<ul>
<li <?php echo $tabact1;?>><a href="demo.php?tag=1">常规</a></li>
<li <?php echo $tabact2;?>><a href="demo.php?tag=2">高级选项</a></li>
<li <?php echo $tabact3;?>><a href="demo.php?tag=3">栏目内容</a></li>
</ul>
<input type="hidden" id="currentTabIndex" value="0" />
<div class="tab_item">
	<table class="list-table tab_none table_1" cellspacing="1" cellpadding="2">
		<tr><th>活动名称</th><th>活动日期</th><th>活动类型</th><th>计划人数</th><th>状态</th><th>操作</th></tr>
		<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td><a href="###"><img src="templates/images/manage/icon_view.gif"/></a><a href="###"><img src="templates/images/manage/icon_edit.gif"/></a><a href="###"><img src="templates/images/manage/icon_drop.gif"/></a></td></tr>
		<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>3421412</td><td>432143 ~ 4321</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
	</table>
	<table class="list-table tab_none table_2" cellspacing="1" cellpadding="2">
		<tr><th>活动名称</th><th>活动日期</th><th>活动类型</th><th>计划人数</th><th>状态</th><th>操作</th></tr>
		<tr><td>trew</td><td>4gfdhgfd</td><td>hgfd</td><td>4321</td><td>草稿</td><td><a href="###"><img src="templates/images/manage/icon_view.gif"/></a><a href="###"><img src="templates/images/manage/icon_edit.gif"/></a><a href="###"><img src="templates/images/manage/icon_drop.gif"/></a></td></tr>
		<tr><td>trew</td><td>ghdf</td><td>gfd</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>t3trew</td><td>ghfd1</td><td>hgfd</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>t3trew</td><td>ghfd1</td><td>hgfd</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>t3trew</td><td>ghfd1</td><td>hgfd</td><td>4321</td><td>草稿</td><td></td></tr>
	</table>
	<table class="list-table tab_none table_3" cellspacing="1" cellpadding="2">
		<tr><th>活动名称</th><th>活动日期</th><th>活动类型</th><th>计划人数</th><th>状态</th><th>操作</th></tr>
		<tr><td>hgdf</td><td>hgfdhdf</td><td>43214231</td><td>4321</td><td>草稿</td><td><a href="###"><img src="templates/images/manage/icon_view.gif"/></a><a href="###"><img src="templates/images/manage/icon_edit.gif"/></a><a href="###"><img src="templates/images/manage/icon_drop.gif"/></a></td></tr>
		<tr><td>hgf</td><td>hgdfhdf</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>hgf</td><td>hgdfhdf</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>hgf</td><td>hgdfhdf</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
		<tr><td>hgf</td><td>hgdfhdf</td><td>43214231</td><td>4321</td><td>草稿</td><td></td></tr>
	</table>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var tag=<?php echo $tag;?>;
	$(".table_"+tag).removeClass("tab_none");
});
</script>

<!--tabover-->



	<br /><br /><br /><br /><br />
</div>
</body>
</html>