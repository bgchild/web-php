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
	<form action='' method='get' class="searchFrom" id="myform" style="/*height:155px*/">
  			<fieldset class="searchFieldSet" style="/*height:150px;*/">
    			<legend>统计条件</legend>
                <div class="searchDivInFieldset">
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
						<td class="listright" width="80">统计维度：</td>
						<td width="140">
							<select name="ctype" id="ctype">
								<?php foreach($ctype as $k=>$v){?>
									<option value="<?php echo $k.'"'; if($k==$infos['ctype']){echo "selected=selected";}?>"><?php echo $v;?></option >
								<?php }?>
						</td>
	    				<td class="listright "  width="80">统计时间起：</td>
	    				<td width="140"><input type="text" name="time_start" id="time_start" class="input" onclick="WdatePicker()" readonly="readonly" value="<?php echo $infos['time_start'];?>" id="time_start" /></td>
	    				<td class="listright" width="80">统计时间止：</td>
	    				<td width="140"><input type="text" name="time_stop" id="time_stop" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['time_stop'];?>" id="time_stop" /></td>
                    	<!--<td class="listright" width="80">服务队类别：</td>
                    	<td width="140">
						<select name="ctype" id="ctype">
                    	<option value="">请选择</option >
						<?php /*foreach($ctype as $v){*/?>
						  <option value="<?php /*echo $v['id'].'"'; if($v['id']==$infos['ctype']){echo "selected=selected";}*/?>"><?php /*echo $v['name'];*/?></option >
						<?php /*}*/?>
						</select>
						</td>-->
    				</tr>
    				<tr>
    					<td class="listright"  width="80">组织机构：</td>
	    				<td width="140">
   <select name="secity" id="organ">
   <?php foreach($level as $k=>$v){?>
   <option value="<?php echo $v['sign'].'"'; if($infos[secity]==$v['sign']){echo "selected=selected";}?>"><?php echo $v['name']?></option >
   <?php }?>
   </select>
                        </td>
                        <td></td>
                        <td colspan="2">
							<input type="checkbox" checked="checked" disabled="disabled"/>本级&nbsp;&nbsp;
							<?php if(count($level)!=1){?>
							<?php if (($infos['secity'] && $infos['secity'] != 'all') || !$isClub) { ?>
								<input type="checkbox" name="lower" value="1" <?php if($infos[lower]==1){echo 'checked="checked"';}?>/>下级
							<?php } ?>
							<?php }?>
						</td>
                        <!--<td class="listright" width="80">活动名称：</td>
                        <td width="140"><input type="text" class="input" name="actcityname" value="<?php /*echo $infos['actcityname'];*/?>"/></td>-->
						<td align="right" colspan="2">
							<input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
							<a href="serviceobjCount.php" class="btn" role="button"><span class="add"></span>重置</a>
						</td>
    				</tr>
                    <!--<tr>
						<td class="listright" width="80">志愿服务队：</td>
                        <td width="140"><input type="text" class="input" name="team" value="<?php /*echo $infos['team']*/?>"/></td><td colspan="3"><input type="button"  class="btn" value="检索" onclick="checkteam()"/>
						<div id="hid_rel"></div></td>
                        <td align="right" ><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
    					<a href="serviceobjCount.php" class="btn" role="button"><span class="add"></span>重置</a>
						</td>
					</tr>-->
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


	<?php if(empty($infos['ctype']) || $infos['ctype']==1) { ?>
		<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
				<th align="center" >组织机构</th>
				<!--<th align="center" width="30%">志愿者服务活动项目</th>-->
				<th align="center" width="40%">服务队</th>
				<th align="center" width="20%">受益人次</th>
			</tr>
			<?php $num_team = 0; $num=0; foreach($counts as $ck=>$c){?>
				<tr>
					<td align="left"  class="omit1"><a style="text-decoration:none;"><?php echo $c[organ];?></a></td>
					<!--<td align="left" width="30%" class="omit2"><?php /*echo $c[name];*/?></td>-->
					<td align="center" class="omit2"><?php echo $c[num_team];?></td>
					<td align="center" class="omit2"><?php echo $c[num];?></td>
				</tr>
				<?php $num_team+=$c['num_team'];  $num+=$c[num];} if(!$counts){?>
				<tr>
					<td colspan="4">暂无数据</td>
				</tr>
			<?php }else{ ?>
				<tr>
					<td><font color="#FF0000">总计</font></td>
					<td align="center"><?php echo $num_team; ?></td>
					<td align="center"><?php echo $num; ?></td>
				</tr>
			<?php } ?>
		</table>
	<?php } else if($infos['ctype'] == 2) { ?>
	<div style="width:100%; overflow-x: scroll;">
		<div style="width: 2000px;">
			<table class="list-table" cellspacing="1" cellpadding="2">
				<tr>
					<th align="center">组织机构</th>
					<?php $num = array(); ?>
					<?php foreach($activitytype as $key=>$val) {?>
						<?php $num[$key] = 0; ?>
						<th align="center" width="10%"><?php echo $val['name']; ?></th>
					<?php } ?>
				</tr>
				<?php foreach($counts as $v) { ?>
					<tr>
						<td align="left"  class="omit1"><a style="text-decoration:none;"><?php echo $v['name'];?></a></td>
						<!--<td align="left" class="omit2"><?php /*echo $v['name'];*/?></td>
						<td align="center" class="omit2"><?php /*echo $v['num'];*/?></td>-->

						<?php foreach($v['serverItems'] as $key1=>$val1) {?>
							<td align="center" width="10%"><?php echo $val1['num']?></td>
							<?php $num[$key1] += $val1['num']; ?>
						<?php } ?>
					</tr>
				<?php } ?>
				<?php if(!$counts) { ?>
					<tr>
						<td colspan="11">暂无数据</td>
					</tr>
				<?php } else {?>
					<tr>
						<!--<td></td>
						<td><font color="#FF0000">总计</font></td>
						<td align="center"><?php /*echo array_sum($num); */?></td>-->

						<td><font color="#FF0000">总计</font></td>
						<?php foreach($activitytype as $key=>$val) {?>
							<td align="center"><?php echo $num[$key]; ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>

	<?php } ?>




      <table width="750"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
        </div>
 
</div>
</div>
</div>
</div>
<script type="text/javascript">
	$(function(){
		$("#hid_btn").live("click", function(){
			$("#hid_abs").hide();
		});
		$("#tname").live("click", function(){
			var tname=$(this).html();
			$("input[name='team']").val(tname);
			$("#hid_abs").hide();
		});
	})
	function checkteam(){

		var keywords=$("input[name='team']").val();
		var stime=$("#time_start").val();
		var etime=$("#time_stop").val();
		var organ=$("#organ").val();
		var ctype=$("#ctype").val();
		var next=$("input[name='lower']").is(':checked');
		//alert(keywords+"=="+stime+"=="+etime+"=="+organ+"=="+ctype+"=="+next);
		if(next){next=1}else{next=2}
		$.ajax({type:'POST',
			url:'servicetimeCount.php',
			data:{act:'steam',teamkey:keywords,stime:stime,etime:etime,organ:organ,ctype:ctype,next:next},
			success:function(msg){
				$('#hid_rel').html(msg);
				$("#hid_abs").show();
			}})

	}



	/*$(function() {
		showTab($('#ctype'));
	});
	function showTab(o) {
		var index = o.get(0).selectedIndex;
		$('.list-table').hide();
		$('.list-table').eq(index).show();
	}*/

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
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>