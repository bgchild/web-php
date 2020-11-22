<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/UserAddServertime.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>
<script  type="text/javascript"   src="templates/js/common_table.js"></script>
</head>

<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">

<div class="changservertime">
<form action="UserAddServertime.php" method="post"  id="addUserServertime" enctype="multipart/form-data">
<fieldset class="searchFieldSet">
	<legend>新建志愿服务时间</legend>
	<table class="TimeTable" >
	<tr style="display:none;height:0px;"><td width="135px" ><input type="hidden"  id="recid" name="recordid" value="<?php echo $one['recordid'];?>" /><input type="hidden"  id="addtime" name="addtime" value="<?php echo time();?>" /></td></tr>
			    <tr><th align="right">活动名称：</th><td><input type="text" name="activityName"  id="activityName"  readonly="readonly" value="<?php echo $one['activityName'];?>" class="input length_3"/></td><td><input type="button" name="doAddServertime" value="检索" class="btn butLeft" /></td></tr>
				<tr><th align="right">基础志愿服务时间：</th><td><input type="text" name="basePredictHour"  id="basePredictHour" value="<?php echo $one['predictHour'];?>" class="input length_3"/></td></tr>
				<tr><td><input type="hidden" name="rid" class="doSumup_rid" value="" /></td><td><input type="hidden" name="isSubmit" value="true" /><input type="submit" name="doSave"  id="dosaveOne" class="btn doSave" value="确定" />&nbsp;&nbsp;<a href="UserServertime.php" style="text-decoration: none;" class="addbtn btn_alone" >返回</a></td></tr>
	
			</table>
</fieldset>
</form>
</div>


<div class="hiddenChooseDiv">

	<input type="hidden" id="isShow" value="<?php echo $isShow?>" />
	<form action='UserAddServertime.php' method='post' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet2">
    			<legend>查询条件</legend>
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
    				<td class="listright "  width="80">活动名称：</td>
    				<td width="140"><input type="text" name="activityName"  id="activityName" class="input length_201 activityName" value="<?php echo $info['activityName'];?>"/></td>
    				<td class="listright" width="80">活动类型：</td>
    				<td width="140"><select name='activityType' id="activityType" class='select_201 activityType_search'  ><option value='0' class="activityType_search_option ">请选择</option><?php foreach($types as $key=>$val) {?><option class="activityType_search_option" value='<?php echo $val['id']?>' <?php if($info[activityType]==$val['id']) echo "selected='selected'";?>><?php echo $val[name]?></option><?php }?></select></td>
    				<td class="listright" width="80">活动时长：</td>
    				<td width="140"><input type="text" name="activitytime" class="input length_201 activitytime" value="<?php echo $info['activitytime'];?>"/></td>
    				</tr>
    				<tr>
    				<td class="listright" width="80">活动地点：</td>
    				<td width="140"><input type="text" name="activityAddr" class="input length_201 activityAddr" value="<?php echo $info['activityAddr'];?>"/></td>
    				<td class="listright">活动日期起：</td>
    				<td><input type="text" name="activityStartDate" id="activityStartDate" class="input length_201 activityStartDate" onclick="WdatePicker()"   readonly="readonly" value="<?php echo $info['activityStartDate'];?>"/></td>
    				<td class="listright">活动日期止：</td>
    				<td><input type="text" name="activityEndDate" id="activityEndDate" class="input length_201 activityEndDate"  onclick="WdatePicker()"   readonly="readonly"  value="<?php echo $info['activityEndDate'];?>"/></td>
    				</tr>
    				<tr>
    				<td colspan='5' ></td>
    				<td colspan='2' class="listleft"><input type="submit" name="doSearch" class="btn btn_search" value="查询" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn_rest" value="重置" /></td>
    				</tr>
    			</table>
  			</fieldset>
			</form>
			<table class="list-table table-95 " cellspacing="1" cellpadding="2">
			<tr><th width="10px"></th><th align="center">活动名称</th><th align="center">活动日期</th><th align="center">活动类型</th><th align="center">活动地点</th></tr>
				<?php foreach($activitys as $k=>$val ){?>
			<tr>
			<td align="center" width="10px"><input type="radio" class="chooseRecord" value="<?php echo $val['recordid']?>" /></td>
			<td align="left" class="tdactivityName"><a href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" style="cursor: pointer;" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
			<td align="center" width="150px"><?php echo $val[activityStartDate];?>~<?php echo $val[activityEndDate];?></td>
			<td align="left" width="90px" class="tdtypename"><a style="cursor: pointer;" title="<?php echo $val[typename];?>"><?php echo $val[typename];?></a></td>
			<td align="left" width="160px" class="tdactivityAddr"><a style="cursor: pointer;" title="<?php echo $val[activityAddr];?>"><?php echo $val[activityAddr];?></a></td>
			</tr>
				<?php } if(!$activitys){?>	<tr><td colspan='8'>查无数据</td></tr><?php }?>
			</table>
			 <?php include 'page.php'?>
			 <br/><br/>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="yesbtn" value="确定" />
	</div>
	
	<script type="text/javascript">
	$(function(){ 

		$("#myform").submit(function(){
				var join_start = $("#activityStartDate").val();
				var join_stop = $("#activityEndDate").val();
				
				if (compareDate(join_start,join_stop)) {
					ui.error("活动时间起不能大于活动时间止！");
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
	
	
	if($("#isShow").val()=='1') $('.hiddenChooseDiv').show();
	$(".butLeft").click(function(){
		if($('.hiddenChooseDiv').css('display')=='none') $('.hiddenChooseDiv').show();else $('.hiddenChooseDiv').hide();
	});
	$(".chooseRecord").click(function(){
		$(".chooseRecord").each(function(){$(this).removeAttr("checked");});
		$(this).attr("checked","checked");
	});

	$(".yesbtn").click(function(){
		var recd=$(".chooseRecord:checked").val();
		$.getJSON("UserAddServertime.php?recd="+recd, function(data){
			 $("#activityName").val(data.activityName);
			 $("#recid").val(data.recordid);
			 $("#basePredictHour").val(data.predictHour);
		});
		$('.hiddenChooseDiv').hide();
	});
	$(".btn_rest").click(function(){
		$(".activityName").removeAttr("value");
		$(".activitytime").removeAttr("value");
		$(".activityAddr").removeAttr("value");
		$(".activityStartDate").removeAttr("value");
		$(".activityEndDate").removeAttr("value");
		$("#activityType").val("0");
		$(".btn_search").click();
	});


	$(function(){
		
		$('#dosaveOne').click(function(){
				if(!$('#activityName').val()){
					ui.error('请检索活动！');
					return false;
					}
				var a = $("#basePredictHour");
				var value = a.val();
				 if(!(/^(\+|-)?\d+$/.test( value ))|| value<=0){
					 ui.error('请输入正整数！');
					 return false;
				 }
				});
		
		
	});
	
	</script>
	
</div>
</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
</body>
</html>