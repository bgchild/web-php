<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/adminServiceTeam.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
<script  type="text/javascript"   src="../templates/js/jsdate/WdatePicker.js"></script>

</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>

<div class="service_top">
	<form action='' method='get' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>统计条件</legend>
                <div class="searchDivInFieldset">
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
	    				<td class="listright "  width="80">统计时间起：</td>
	    				<td width="140"><input type="text" name="time_start" id="time_start" class="input" onclick="WdatePicker()" readonly="readonly" value="<?php echo $infos['time_start'];?>" id="time_start" /></td>
	    				<td class="listright" width="80">统计时间止：</td>
	    				<td width="140"><input type="text" name="time_stop" id="time_stop" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['time_stop'];?>" id="time_stop" /></td>
                         <td class="listright" width="80"></td>
                    <td width="140"></td>
    				</tr>
                    
    				<tr>
    					<td class="listright"  width="80">组织机构：</td>
	    				<td width="140" colspan='2'>
   <select name="secity">
   <?php foreach($level as $k=>$v){?>
   <option value="<?php echo $v['sign'].'"'; if($infos[secity]==$v['sign']){echo "selected=selected";}?>"><?php echo $v['name'];?></option >
   <?php }?>
   </select>
                        </td>
                        <td colspan="2">
							<input type="checkbox" checked="checked" disabled="disabled"/>本级&nbsp;&nbsp;
							<?php if(count($level)!=1){?>
							<?php if (($infos['secity'] && $infos['secity'] != 'all') || !$isClub) { ?>
								<input type="checkbox" name="lower" value="1" <?php if($infos[lower]==1){echo 'checked="checked"';}?>/>下级
							<?php } ?>
							<?php }?>
						</td>
    					<td align="right" colspan='2'><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
    					<a href="serviceteamCount.php" class="btn" role="button"><span class="add"></span>重置</a></td>
    				</tr>
    			</table>
                </div>
  			</fieldset>
		</form>
</div>
<div class="service_middle">
<?php if ($now_flag) {?>
<table>
<tbody><tr>
<td style="width:835px;"></td>
<td><button class="yesbtn" type="button" id="batch_exp" >导出</button></td>
</table>
<?php }?>
<div class="tabContent">
	<div style="width:100%; overflow-x: scroll;">
		<div style="width: 2000px;">
			<table class="list-table" cellspacing="1" cellpadding="2">
				<tr>
					<th align="center" >组织机构</th>
					<?php $num = array(); ?>
					<?php foreach($severtype as $key=>$val) {?>
						<?php $num[$key] = 0; ?>
						<th align="center" width="10%"><?php echo $val['name']; ?></th>
					<?php } ?>
					<!--<th align="center" width="20%">数量</th>-->
				</tr>
				<?php  foreach($counts as $ck=>$c){?>
					<tr>
						<td align="left"  class="omit1"><a style="text-decoration:none;"><?php echo $c['name'];?></a></td>
						<!--<td align="left" width="40%" class="omit2"><?php /*echo $c[name];*/?></td>
						<td align="center" width="20%"><?php /*echo $c[num]*/?></td>-->

						<?php foreach($c['serverItems'] as $key1=>$val1) {?>
						<td align="center" width="10%"><?php echo $val1['num']?></td>
						<?php $num[$key1] += $val1['num']; ?>
						<?php } ?>
					</tr>
					<?php } if(!$counts){?>
					<tr>
						<td colspan="11">暂无数据</td>
					</tr>
					<?php }else{?>
					<tr>
						<td><font color="#FF0000">总计</font></td>
						<?php foreach($severtype as $key=>$val) {?>
							<td align="center"><?php echo $num[$val['id']]; ?></td>
						<?php } ?>
					</tr>


				<?php }?>
			</table>
		</div>
	</div>

</div>
<table width="750"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
</div>
</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>
<script type="text/javascript">
$("#myform").submit(function(){
		var start_time = $("#time_start").val();
		var stop_time = $("#time_stop").val();
		
		if (compareDate(start_time,stop_time)) {
				ui.error("开始时间不能大于结束时间！");
				return false;	
		}
		
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
//导出
$("#batch_exp").click(function(){
	location.href = location.href +"?info=<?php echo set_url($infos); ?>&act=batch_exp";
	});	
</script>