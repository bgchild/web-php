<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/serviceTeamAudit.css"/>
<script  type="text/javascript"   src="../templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
<div class="admin_mamage_right adm_con">

  <div class="tab" style="margin-top:10px;">
       	<ul>
				<li><a href="teanManageDetail.php?act=edit&spm=<?php echo $_GET['spm'];?>">基本信息</a></li>
				<li><a href="teanManageDetail.php?act=member&spm=<?php echo $_GET['spm'];?>">服务队人员</a></li>
				<li class="tabact"><a href="teanManageDetail.php?act=activity&spm=<?php echo $_GET['spm'];?>">开展活动</a></li>
			</ul>	
  </div>

  <div class="manage_content ">
  
       <div class="service_top">
	<form action='teanManageDetail.php' method='get' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
                <input type="hidden" value="activity" name="act"/>
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
	    				<td class="listright "  width="80">活动日期起：</td>
	    				<td width="140"><input type="text" name="startTime" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php if($startTime) echo date('Y-m-d', $startTime);?>" id="foundingtime_start" /></td>
	    				<td class="listright" width="80">活动日期止：</td>
	    				<td width="140"><input type="text" name="finishTime" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php if($finishTime) echo date('Y-m-d', $finishTime);?>" id="foundingtime_stop" /></td>
    					<td class="listright" width="80">活动名称：</td><td width="140"><input type="text" name="activityName" class="input length_20" value="<?php echo $activityName;?>" id="serviceteamname" /></td>
    				</tr>
    				<tr>
    					<td class="listright "  width="80">活动类型：</td>
	    				<td width="140" colspan='4'>
                        <select name="activityType">
                       <option value='0'>请选择</option>
					   <?php foreach($types as $key=>$val) {?>
                       <option class="activityType_search_option" value='<?php echo $val['id']?>' <?php if($activityType==$val['id']) echo "selected='selected'";?>><?php echo $val[name] ; ?></option>
					   <?php }?>
                        </select>
                        </td>
    					<td colspan='2' align="right"><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;<input type="hidden" name="spm" value="<?php echo $_GET['spm'];?>" />
    					<a href="teanManageDetail.php?act=activity&spm=<?php echo $_GET['spm'];?>" class="btn" role="button"><span class="add"></span>重置</a></td>
    				</tr>
    			</table>
  			</fieldset>
		</form>
</div>
       <div class="tabContent">
      <div class="manage_content_list tab_item">
      <table class="list-table table_2 " cellspacing="1" cellpadding="2">
			<tr>
                <th align="center" width="120">活动名称</th>
                <th align="center" width="160">活动日期</th>
                <th align="center" width="200">活动类型</th>
                <th align="center" width="230">活动地点</th>
            </tr >
            <?php foreach($list as $v) { 
				$spm=array();
				$spm['id']=$v['recordid'];
				$url='activity.php?act=detail&spm='.set_url($spm);
			?>
			<tr>
            <td align="left" width="120" class="omit1"><a href="<?php echo $url;?>" style="text-decoration:none;" title="<?php echo $v['activityName'];?>"><?php echo $v['activityName'];?></a></td>
            <td align="center" width="160"><?php echo date('Y-m-d',$v['activityStartDate']);?>--<?php echo date('Y-m-d',$v['activityEndDate']);?></td>
            <td align="left" width="200"><?php foreach($types as $key=>$val)  {if($v['activityType']==$val['id']) echo $val['name'];}?></td>
            <td align="left" width="230" class="omit2"><a title="<?php echo $v['activityAddr'] ; ?>"><?php echo $v['activityAddr']; ?></a></td>
            </tr>
            <?php } ?>     
		</table>
       <table width="720"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="720"><tr><td  height="5"></td></tr></table>
      </div>
      </div>
      <div class="manage_content_back"><a href="serviceTeamMessage.php" class="btn" >返回</a></div>
  </div>




</div>  



</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>


<script type="text/javascript">
$(function(){ 
		   
	$("#myform").submit(function(){
		var start_time = $("#foundingtime_start").val();
		var stop_time = $("#foundingtime_stop").val();
		
		if (compareDate(start_time,stop_time)) {
				ui.error("活动日期起不能大于活动时间止！");
				return false;	
		}
		
	});	   
})

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


function captain(row){
 if(confirm("确定要修改队长设置？")){
	  var editid = $(row).find('input').val();
	  var type = $(row).parent().parent().find('#status').html();
	  if(type=='是') {
		  var act = 'down';
		  var change = '否';
		  var operatag = '设置为队长';
		  var cssstyle = 'cap_td';
		  } else {  
		  var act = 'up';
		  var change = '是';
		  var operatag = '取消队长职务';
		  var cssstyle = 'cap_td_red';
		  }
	  //alert(editid);
	  	  $.ajax({type      :'post',
			         url         :'ajax_captain.php',
			         data      :{editid:editid,act:act},
			         success  :function(msg){
						                 if(msg!='0'){
											 $(row).parent().parent().find('#status').html(change);
											 $(row).parent().parent().find('#status').attr('class',cssstyle);
											 $(row).find('span').html(operatag);
                                              
											 } else { alert('设置失败！');}
								}
			   });
	 }
}
</script>

</body>
</html>