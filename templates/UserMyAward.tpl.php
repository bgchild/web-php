<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/demo2.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/UserMyAward.css"/>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script  type="text/javascript"   src="templates/js/common_table.js"></script>
<script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>
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
	
	
	<form action='UserMyAward.php' method='post' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
    			<div class="searchDivInFieldset">
    			<table class="base_table">
    				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;获奖日期：</td>
				<td><input class="input length_3 mr10 J_date date" name="receivedate1" id="receivedate1"  onclick="WdatePicker()" readonly="readonly"  value="<?php echo $info['receivedate1'];?>" type="text"><span class="mr10">至</span><input class="input length_3 J_date date" name="receivedate2"  id="receivedate2" onclick="WdatePicker()" readonly="readonly"  value="<?php echo $info['receivedate2'];?>" type="text"></td><td><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;&nbsp;<a href="UserMyAward.php" class="btn" role="button">重置</a></td></tr>
    			</table>
    			</div>
  			</fieldset>
		</form>


<div class="uma">
	<table class="list-table" cellspacing="1" cellpadding="2">
			<tr><th align="center">获奖日期</th><th align="center">获奖地点</th><th align="center">获奖内容</th></tr>
			<?php 	foreach ($myaward as $k=>$v){ ?>
			
			<tr><td width="120px" align="center"><?php echo $v[receivedate];?></td><td align="left" class="tdwinaddress"><a style="cursor: pointer;" title="<?php echo $v[winaddress];?>"><?php echo $v[winaddress];?></a></td><td width="380px" align="left" class="tdwincontent"><a style="cursor: pointer;" title="<?php echo $v[wincontent];?>"><?php echo $v[wincontent];?></a></td></tr>
			<?php }
			if(!$myaward){
			?>
			
			<tr><td colspan='3'>查无数据</td></tr><?php }?>
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
			var join_start = $("#receivedate1").val();
			var join_stop = $("#receivedate2").val();
			
			if (compareDate(join_start,join_stop)) {
				ui.error("获奖日期起不能大于获奖日期止！");
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