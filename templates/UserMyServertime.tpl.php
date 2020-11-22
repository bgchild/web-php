<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/UserMyServertime.css"/>
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

		<form action='UserMyServertime.php' method="post" class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
    			<div class="searchDivInFieldset">
    			<table class="base_table">
    			<tbody>
    				<tr><td align="right">活动日期起：</td><td><input name="activityStartDate" id="activityStartDate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_3 mr10 J_date date" value="<?php echo $info['activityStartDate'];?>" /></td><td align="right">活动日期止：</td><td><input name="activityEndDate" id="activityEndDate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_3 mr10 J_date date" value="<?php echo $info['activityEndDate'];?>" /></td></tr>
    				<tr><td align="right">活动类型：</td><td><select name='activityType' class='select_3'  ><option value='0' class="activityType_search_option ">请选择</option><?php foreach($types as $key=>$val) {?><option class="activityType_search_option" value='<?php echo $val['id']?>' <?php if($info[activityType]==$val['id']) echo "selected='selected'";?>><?php echo $val[name]?></option><?php }?></select></td><td align="right">所属服务队：</td><td><input type="text" name="serviceteamname"  value="<?php echo $info['serviceteamname'];?>" class="input length_3"/></td><td><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;&nbsp;<a href="UserMyServertime.php" class="btn" role="button"><span class="add"></span>重置</a>&nbsp;&nbsp;&nbsp;<input type="submit" name="doEword" class="btn" value="志愿服务记录证明" /></td></tr>
    				</tbody>
    			</table>
    			</div>
  			</fieldset>
		</form>



<div class="allmyservertime">
累计 <span style="color:red;"><?php echo $allmyservertime;?> </span>志愿服务时间
</div>
<div class="tabContent">
			<div class="tab">
			<ul>
				<a href="UserMyServertime.php?<?php $infos['tag']=1;echo "info=".set_url($infos);?>"><li  <?php echo $tabact1;?>>活动服务时间</li></a>
				<a href="UserMyServertime.php?<?php $infos['tag']=2;echo "info=".set_url($infos);?>"><li <?php echo $tabact2;?>>新增服务时间</li></a>
			</ul>	
			</div>
			<div class="tab_item">
				<!-- 活动服务时间   -->
	       <?php if($tag==1){?>
		   	<table class="list-table" cellspacing="1" cellpadding="2">
			<tr id="product1"><th align="center" >活动名称</th><th align="center">活动日期</th><th align="center">所属服务队</th><th align="center">志愿服务时间</th><th align="center">操作</th></tr>
			<?php 	foreach ($mytime as $k=>$v){ ?>
			<tr>
			<td align="left" width="210px" class="tdact"><a href="userActivityDetail.php?show=<?php echo set_url($v['uid']);?>" style="cursor: pointer;" title="<?php echo $v[activityName];?>"><?php echo $v[activityName];?></a></td>
			<td width="150px" align="center"><?php echo $v[activityStartDate]."~".$v[activityEndDate];?></td>
			<td align="left" class="tdteam"><a style="cursor: pointer;" title="<?php echo $v[serviceteamname];?>"><?php echo $v[serviceteamname];?></a></td>
			<td width="100px"  align="center"><?php echo $v[time];?></td>
			<td width="80px" align="center"><?php $ci=$db->get_relations_one('form__bjhh_activity_personadd', 'form__bjhh_activityexamine_activityinfo', "a.uid=b.recordid and uid=$v[uid]");if($ci[cid]!=$arg[0]){?><a href="###" class="a_red sumupRid" rid="<?php echo $v['recid'];?>">异议</a><?php }?></td>
			</tr>	
			<?php }
			if(!$mytime){
			?>
				<tr><td colspan='5'>查无数据</td></tr><?php }?>
		</table>
		<?php }?>
				<!-- 新增服务时间   -->
				<?php if($tag==2){?>
		   	<table class="list-table" cellspacing="1" cellpadding="2">
			<tr id="product1"><th align="center">新增日期</th><th align="center" >新增工时</th><th align="center">新增原因</th></tr>
			<?php 	foreach ($mytime as $k=>$v){ ?>
			
			<tr><td width="180px"  align="center"><?php echo date("Y-m-d H:i:s",$v[date]);?></td><td width="100px"  align="center"><?php echo $v[workinghours];?></td><td align="left" class="omit"><a style="cursor: pointer;" title="<?php echo $v[reason];?>"><?php echo $v[reason];?></a></td>

			</tr>	
			<?php }
			if(!$mytime){
			?>
				<tr><td colspan='2'>查无数据</td></tr><?php }?>
		</table>
		
		<?php }?>
			</div>
	</div>
	<?php include 'page.php'?>
	</div>

</div>
	
</div>
</div>



<?php include 'footer.tpl.php'; ?>
			<div class="hiddenDiv hiddenDivSave"  >
	    
			<table class="TimeTable" >
			    <tr><td colspan="2"><h1>原因</h1></td></tr>
				<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="sumup" class="sumup" id="sumup" style="width:400px;height:120px;"></textarea></td></tr>
				<tr><td><input type="hidden" name="rid" class="doSumup_rid" value="" /></td><td><input type="button" name="doSumup" class="btn doSumup" value="确定"/>&nbsp;&nbsp;<input type="button" name="doSumupCancel" class="btn doSumupCancel" value="关闭"/></td></tr>	
			</table>
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

	

	
	var _rid;
	$(".sumupRid").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$('.hiddenDivSave').show();
		$("#sumup").removeAttr("value");
		 _rid=$(this).attr("rid");
		//$.getJSON("UserMyServertime.php?recd="+_rid, function(data){
			//$(document.getElementsByTagName('iframe')[0].contentWindow.document.body).html("").append(data.sumup);
			//$(".sumup").val(data.sumup);
			//$(".doSumup_rid").val(data.recordid);
		//});
	});
	$(".doSumupCancel").click(function(){
		$('.hiddenDivSave').hide();
	});


	$(".doSumup").click(function(){
		var xs=$(".sumup").val();
		if($.trim(xs)==''){
			ui.error("消息内容不能为空！");
			}else if(getLength($('#sumup').val())>=2000){
				ui.error("消息内容字节不能超过2000！");
			}else{
				$.post("UserMyServertime.php", 
						{ doSumup:"true",
						  sumup:$(".sumup").val(), 
						  rid:_rid
					     },function(data){
						     if(data.result=="yes") {
						    	 ui.success("保存成功"); 	 
							     $(".hiddenDivSave").hide();
							     
							     
						     }
						    else ui.error("保存失败，请稍后再次尝试");
				},"json");
			}
	});

</script>
</body>
</html>