<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/UserServertime.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/common.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>

<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">


<a href="UserAddServertime.php" class="addbtn btn_alone" role="button"><span class="add"></span>新增</a>

		<form action='UserServertime.php' method='post' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
    			<div class="searchDivInFieldset">
    			<table  class="base_table">
    			<tbody>
    				<tr>
    				<td align="right">活动日期起：</td>
    				<td><input name="activityStartDate" id="activityStartDate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_3 mr10 J_date date" value="<?php echo $info['activityStartDate'];?>" /></td>
    				<td align="right">活动日期止：</td>
    				<td width="140"><input name="activityEndDate" id="activityEndDate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_3 mr10 J_date date" value="<?php echo $info['activityEndDate'];?>" /></td>
    				</tr>
    				<tr>
    				<td align="right">活动名称：</td>
    				<td><input type="text" name="activityName"  value="<?php echo $info['activityName'];?>" class="input length_3"/></td>
    				<td align="right">志愿者姓名：</td>
    				<td><input type="text" name="name"  value="<?php echo $info['name'];?>" class="input length_3"/></td>
    				<td><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;&nbsp;<a href="UserServertime.php" class="btn" role="button">重置</a></td>
    				</tr>
    				</tbody>
    			</table>
    			</div>
  			</fieldset>
		</form>
		
		<div class="ust">
		<table class="list-table" cellspacing="1" cellpadding="2">
			<tr><th align="center">活动名称</th><th align="center">活动日期</th><th align="center">基础志愿服务时间</th><th align="center">活动总志愿服务时间</th><th align="center">操作</th></tr>
			<?php 	foreach ($servertime as $k=>$v){ ?>	
			<tr>
			<td align="left" class="tdactivityName"><a href="userActivityDetail.php?show=<?php echo set_url($v['recordid']);?>" style="cursor: pointer;" title="<?php echo $v[activityName];?>"><?php echo $v[activityName];?></a></td>
			<td width="150px" align="center"><?php echo $v[activityStartDate]."~".$v[activityEndDate];?></td>
			<td width="108px" align="center"><?php echo $v['basePredictHour'];?></td>
			<td width="108px" align="center"><?php echo $v[activitytime];?></td>
			<td align="center" width="80px;"><a style="text-decoration: none;" href="UserTimeUpdate.php?id=<?php echo set_url($v[recordid]);?>">人员时间微调</a></td>
			</tr>
			<?php }
			if(!$servertime){
			?>
			
			<tr><td colspan='5'>查无数据</td></tr><?php }?>
			
			
		</table>
		<?php include 'page.php'?>
		
</div>
</div>
	
	</div>

</div>
</div>
<script type="text/javascript">
	$(function(){ 

		$("#myform").submit(function(){
				var join_start = $("#activityStartDate").val();
				var join_stop = $("#activityEndDate").val();
				
				if (compareDate(join_start,join_stop)) {
					ui.error("活动日期起不能大于活动日期止！");
					return false;	
				}
		});

			   
	});

	function compareDate(DateOne,DateTwo)
	{
		var OneMonth = DateOne.substring(5,DateOne.lastIndexOf ("-"));
		var OneDay = DateOne.substring(DateOne.length,DateOne.lastIndexOf ("-")+1);
		var OneYear = DateOne.substring(0,DateOne.indexOf ("-"));
		var TwoMonth = DateTwo.substring(5,DateTwo.lastIndexOf ("-"));
		var TwoDay = DateTwo.substring(DateTwo.length,DateTwo.lastIndexOf ("-")+1);
		var TwoYear = DateTwo.substring(0,DateTwo.indexOf ("-"));

		if (Date.parse(OneMonth+"/"+OneDay+"/"+OneYear) >Date.parse(TwoMonth+"/"+TwoDay+"/"+TwoYear)) {
			return true;
		} else {
			return false;
		}

	}
</script>
<?php include 'footer.tpl.php'; ?>
</body>
</html>