<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/UserTimeUpdate.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script type="text/javascript" src="templates/js/common.js"></script>


</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
	
	
	<div style="width:758px; height:60px; margin-top:10px; color:#F00; font-weight:bold">
	<div style="width:758px; height:20px;"></div>
                             <h1 align="center"><?php echo $activity['activityName'];?></h1> 
	</div>
	
	
	<form action="UserTimeUpdate.php" method="post">
		<table class="list-table" cellspacing="1" cellpadding="2">
			<tr><th align="center">姓名</th><th align="center">昵称</th><th align="center">年龄</th><th align="center">性别</th><th align="center">已获志愿服务时间</th><th align="center">调整后志愿服务时间</th><th align="center">原因</th></tr>
			
			<?php
				
			 	foreach ($info as $k=>$v){ ?>
			
			<tr><?php if($v['status']=="100"){?><td align="left" width="100px" class="tdname"><a style="cursor: pointer;" title="<?php echo $v[name]."<span style='color:red'>【已注销】</span>";?>"><?php echo $v[name]."<span style='color:red'>【已注销】</span>";?></a></td><td align="left" width="100px" class="tdnickname"><a style="cursor: pointer;" title="<?php echo $v[nickname];?>"><?php echo $v[nickname];?></a></td><td align="center" width="35px"><?php echo $v[birthday];?></td><td align="center" width="35px"><?php if($v[sex]==1)echo "男";else echo "女";?></td><td align="center" width="120px"><?php echo $v[time];?></td><td colspan="2"></td><?php }else{?><td align="left" width="100px" class="tdname"><a style="cursor: pointer;" title="<?php echo $v[name];?>"><?php echo $v[name];?></a></td><td align="left" width="100px" class="tdnickname"><a style="cursor: pointer;" title="<?php echo $v[nickname];?>"><?php echo $v[nickname];?></a></td><td align="center" width="35px"><?php echo $v[birthday];?></td><td align="center" width="35px"><?php if($v[sex]==1)echo "男";else echo "女";?></td><td align="center" width="120px"><?php echo $v[time];?><input type="hidden" name="hidden_time[<?php echo $v[recordid];?>]" value="<?php echo $v[time];?>" /></td><td cart_td_6 align="center" width="120px"><img src="templates/images/minus.jpg" alt="minus" onclick="changeNum('<?php echo $k;?>','minus')" class="hand"/> <?php if($v[time]=="0"){?>  <input size="1"  name="ttime[<?php echo $v[recordid];?>]" id="<?php echo $k;?>" type="text"  value="<?php echo $v[basePredictHour];?>" class="num_input" readonly="readonly"/>   <?php }else{?><input size="1"  name="ttime[<?php echo $v[recordid];?>]" id="<?php echo $k;?>" type="text"  value="<?php echo $v[time];?>" class="num_input" readonly="readonly"/><?php }?> <input size="1"  name="tttime[<?php echo $v[recordid];?>]" id="<?php echo "time".$k;?>" type="hidden"  value="<?php echo $v[basePredictHour];?>" class="num_input" readonly="readonly"/><img src="templates/images/adding.jpg" alt="add" onclick="changeNum('<?php echo $k;?>','add')"  class="hand"/></td><td align="center"><input id="rea"  maxlength="60" name="reason[<?php echo $v[recordid];?>]" value="<?php echo $v[reason];?>" type="text"/></td><?php }?></tr>
			<tr><?php  $recordid = array();$recordid[$k][id]=$v[recordID];?></tr>
			<?php				
					}if(!$info){
			?>
		
			<tr><td colspan='7'>查无数据</td></tr>
			<tr><td colspan='7' style="height:40px;line-height: 40px;text-align: center;" ><a href="<?php echo $backurl;?>" style="text-decoration: none;" class="addbtn btn_alone" >返回</a></td></tr>
			
			<?php

					}else{?>
			
				<tr><td colspan="7" style="height:40px;line-height: 40px;text-align: center;">
			<input type="submit" name="doSave" class="btn" value="保存" />&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?php echo $backurl;?>" style="text-decoration: none;" class="addbtn btn_alone" >返回</a></td></tr>
			<?php }?>
		</table>




    </form>








</div>
</div>
	
	
	
	</div>

</div>

<script type="text/javascript">
function changeNum(numId,flag){
	var numId=document.getElementById(numId);
	var nnn="time"+numId.id;
	var timeId=document.getElementById(nnn);
	var add = timeId.value;
	if(flag=="minus"){
		if(numId.value<=1){
			alert("时间必须是大于0");
			return false;
			}
		else{
			numId.value=parseInt(numId.value)-1;
			productCount();
			}
		}
	else{
		if(numId.value>=parseInt(add)){
			        var addtime = parseInt(timeId.value);
					alert("时间必须是不大于预计志愿时间"+addtime);
					return false;
			}else{
					numId.value=parseInt(numId.value)+1;
					productCount();
				}
		}
	}
</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>


