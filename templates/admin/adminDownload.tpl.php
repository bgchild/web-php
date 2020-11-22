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
.listcenter{text-align: center;}
.listright{text-align:right;}
</style>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>

<div style="width:98%; height:90px; border:1px solid #CE0404;float:left; margin:10px auto;margin-bottom:0px;">
<form action="" method="post" name="fm"  enctype="multipart/form-data">
<table style="width:95%">
<tr>
<td class="listright">文件模块:</td>
<td >
    <select name="moduleid">
         <?php $isfirst=1; foreach($types as $type){?>
               <option value="<?php echo $type['id'];?>"  <?php if($isfirst==1){echo "selected='selected'";$isfirst=0;}?>><?php echo $type['name'];?></option>
          <?php }?>
     </select>
</td>
<td class="listright">上传文件：</td>
<td style="width:460px;overflow:hidden;"><input type="file" name="thumb" id="thumb"  />&nbsp;<font style="color:red"><b><br />格式要求：pdf，xlsx，xls，doc，docx，ppt，gif，jpg，png，txt</b></font></td>
</tr>
<tr>
<td></td>
<td height="36" colspan='3'><input type="submit" name="submit" value="提交" class="btn" /></td>
</tr>
</table>
</form>
</div>

<table width="850"><tr><td  height="5"></td></tr></table>
<form name="sform" action="" method="get">
<table class="base_table" style="padding:0px;">
		<tr>
                <th>文件模块:</th>
				<td>
                <select name="moduleid_search">
                <option value="0">全部模块</option>
                <?php foreach($types as $type){?>
                	<option value="<?php echo $type['id'];?>" <?php if($type['id']==$moduleid) echo "selected=selected";?>><?php echo $type['name'];?></option>
                <?php }?>
                </select>
                </td>
                <td><button class="btn" type="submit" name="tj">查询</button></td>
			</tr>
</table>
</form>


<form name="myform" id="myform" action="" method="post" >
<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
            <th width="340">文件名</th>
            <th  width="50">文件类型</th>
            <th class="listcenter">文件模块</th>
            <th  class="listcenter" width="140">上传时间</th>
            <th  class="listcenter" width="40">操作</th>
            </tr>
			<tr>
			<?php foreach($list as $k=>$v) {?>
            <td><?php echo $v['filename'];?></td>
            <td class="listcenter"><?php echo $v['filetype'];?></td>
            <td class="listcenter"><?php echo $v['modulename'];?></td>
            <td class="listcenter"><?php echo date("Y-m-d H:i:s",$v['uploaddate']);?></td>
           <td class="listcenter"><?php if($v['delTag']==0)$msg="删除";else $msg="恢复";  echo "<a href='javascript:void(0);' class='delete' recordid=$v[recordid] delTag=$v[delTag] style='color:#CE0404'>$msg</a>";?></td>
            </tr>
            <?php }?>
            <?php if(count($list)==0) {?> <tr><td colspan='7'>查无数据</td></tr><?php }?>    
		</table>
         
       <table width="750"><tr><td  height="5"></td></tr></table>
         <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
</form>




<script type="text/javascript">


function selectall(name) {
	if ($("#check_box").is(':checked')==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}	


$(document).ready(function(){
	$(".delete").click(function(){
		var _this=$(this);
		var _recordid=$(this).attr("recordid");
		var _delTag=$(this).attr("delTag");
		$.getJSON("?act=delete&recordid="+_recordid+"&delTag="+_delTag, function(data){
			  if(data.data=="no") { 
				  ui.error("操作失败");
			  } else{
				  var _text=data.delTag=='1'?"恢复":"删除";
				  var _text2=data.delTag=='1'?"已删除":"未删除";
				  _this.attr("delTag",data.delTag);
				  _this.text(_text);
				  _this.parent().siblings(".delTagShow").text(_text2);
				  ui.success("操作成功");
			}
		});
	});
});
</script>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>