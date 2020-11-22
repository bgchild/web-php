<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/activity.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'left.tpl.php';?>


<div class="content_right">
<h3>志愿者活动</h3>
<div class="con_border">
<form  action="volunteers.php" method="get">
<div class="serach_more">
<div class="area">
<ul>
所属地区：&nbsp;<li><select name="province" id="province" >
<option value="">请选择</option>
<?php  foreach ($province as  $pro){?> 
<option value="<?php echo $pro['areaId'];?>" 
<?php if($pro['areaId']===$info['province']) echo 'selected';?>>
<?php echo $pro['areaName'];?></option>
<?php }?>
</select> <span>*</span></li>
<li id="citydiv"><select name="city" id="city">
<option value="">请选择</option>
<?php foreach ($city as $cit) {?>
<option value="<?php echo $cit['areaId'];?>"
<?php if($cit['areaId']===$info['city'])echo 'selected';?>>
<?php echo $cit['areaName'];?>
</option>
<?php }?></select></li>
<li id="areadiv"><select name="areas" id="area">
<option value="">请选择</option>
<?php foreach ($area as $are) {?>
<option value="<?php echo $are['areaId'];?>"
<?php if($are['areaId']===$info['areas'])echo 'selected';?>>
<?php echo $are['areaName'];?>
</option>
<?php }?>
</select></li></ul></div>
<div class="first">&nbsp;&nbsp;&nbsp;用户名称： <input type="text"  class="input length_3" name="username" value="<?php echo $info['username'];?>"/>   　<input class="btn s_btn" type="submit" name="doSearch" value="查询"/></div>
</div>
</form>
<div class="content">
<?php foreach($volunteer as $val){?>

<div class="one_team">
<dl class="team_img  user_img">
<dt><?php if($val['head']){?><img src="<?php echo $val['head']?>"/><?php }else{?>暂无照片<?php }?></dt>
</dl>
<dl class="team_introduce">
<dt><?php echo $val['username'] ?></dt>
<dd>专业技能：<?php echo $val['serveitem']?></dd>
<dd>服务项目：<?php echo $val['features']?></dd>
<dd>所属省份：<?php echo $val['province']?></dd>
</dl>
</div>
<?php } ?>
</div>
<?php include 'page.php';?>
</div>
</div>







</div>
</div>
<script type="text/javascript">
$(function(){
$('#province').change(function(){
 var provinceid =$('#province').val();
	$.ajax({
		   type:'get',
		   url:'ajax.php',
		   //dataType:'json',
		   cache: false,
		   data:{provinceid:provinceid,act:'provinceid',act:'provinceid'},
		   success:function(msg){
	       $('#citydiv').html(msg);
	       $('#areadiv').html('<select><option>请选择</option></select>');
			   }
		   });
});	
//
$('#city').live('change',city);
function city(){
var cityid=$('#city').val();
$.ajax({
type:'get',
url:'ajax.php',
cache: false,
data:{cityid:cityid,act:'cityid'},
success:function(msg){
  $('#areadiv').html(msg);
	}
});
}
});
</script>
<?php include 'footer.tpl.php'; ?>



</body>
</html>