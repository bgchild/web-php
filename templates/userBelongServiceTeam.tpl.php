<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/userBelongServiceTeam.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/common.js"></script>
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
		<form action='' method='get' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
                 <div class="searchDivInFieldset">
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
	    				<td class="listright "  width="80">加入日期起：</td>
	    				<td width="140"><input type="text" name="join_start" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['join_start'];?>" id="join_start" /></td>
	    				<td class="listright" width="80">加入日期止：</td>
	    				<td width="140"><input type="text" name="join_stop" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['join_stop'];?>" id="join_stop" /></td>
    					<td class="listright" width="80">服务队名称：</td><td width="140"><input type="text" name="serviceteamname" class="input length_20" value="<?php echo $infos['serviceteamname'];?>" id="serviceteamname" /></td>
    				</tr>
    				<tr>
    					<td class="listright "  width="80">状态：</td>
    					<td width="140" colspan="4">
    						<select name="status" class="select length_2" id="status">
    							<option value="0">请选择</option>
    							<option value="2" <?php if($info['status']=='2') echo "selected='selected'";?>>已加入</option>
    							<option value="1" <?php if($info['status']=='1') echo "selected='selected'";?>>申请中</option>
    							<option value="3" <?php if($info['status']=='3') echo "selected='selected'";?>>未通过</option>
    						</select>
    					</td>
    					<td align="right">
    						<input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
							<a href="userBelongServiceTeam.php" class="btn" role="button"><span class="add"></span>重置</a>
						</td>
    				</tr>
    			</table>
                </div>
  			</fieldset>
		</form>
		
     <div class="ust">
		<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
				<th align="center" width="120">服务队名称</th>
				<th align="center" width="90">联系人</th>
				<th align="center" width="120">电话</th>
				<th align="center" width="110">加入日期</th>
                <th align="center" width="100">队员人数</th>
				<th align="center" width="100">状态</th>
				<th align="center" width="80">操作</th>
			</tr>
			<?php foreach ($records as $key=>$val){
				$spm['srecordid']=$val['recordid'];
				$spm['sp_status']=$val['sp_status'];
				$spm['page'] = $_GET['page'] ? $_GET['page'] :'';
				$url=set_url($spm);
			?>
			<tr>
				<td align="left" class="omit1" width="120"><a href="userServiceTeamInfo.php?spm=<?php echo $url;?>" style="color:red; text-decoration:none;" title="<?php echo $val['serviceteamname'];?>"><?php echo $val['serviceteamname'];?></a></td>
				<td align="left" width="90" class="omit2"><a title="<?php echo $val['relationperson'];?>"><?php echo $val['relationperson'];?></a></td>
				<td align="center" width="120"><?php echo $val['telephones'];?></td>
				<td align="center" width="110"><?php echo $val['joinserviceteamdate'];?></td>
                <td align="center" width="100"><?php echo $val['passNum'];?></td>
				<td align="center" width="100"><?php echo $val['sp_status2'];?></td>			
				<td align="center" width="80">
				<?php
					if ($val['sp_status'] == '2') {
						if ($val['iscaptain'] == '2') {
							echo '<a href="javascript:if(confirm(\'确定要退出此服务队吗 ?\')) location.href=\'userBelongServiceTeam.php?exit='.set_url($val['sprecordid'])."';\" style=\"color:red; text-decoration:none;\">退出</a>";
						}
					} else if ($val['sp_status'] == '1') {
						echo '<a href="javascript:if(confirm(\'确定要删除此服务队吗 ?\')) location.href=\'userBelongServiceTeam.php?deleteid='.set_url($val['sprecordid'])."';\" style=\"color:red; text-decoration:none;\">删除</a>";
					}
				?>
				</td>
			</tr>
			<?php } if (!$records){?><tr><td colspan="6"><?php echo "查无数据";?></td></tr><?php }?>
		</table>
		<table width="720"><tr><td  height="10"></td></tr></table>
		<?php include 'page.php'?>
		<table width="720"><tr><td  height="10"></td></tr></table>
		
</div>
        
        
        
        
        
	</div>

</div>
</div>
</div>
<script type="text/javascript">
$(function(){ 

	$("#myform").submit(function(){
			var sta = $("#status").val();
			var join_start = $("#join_start").val();
			var join_stop = $("#join_stop").val();
			
			if (compareDate(join_start,join_stop)) {
				ui.error("加入日期起不能大于加入时间止！");
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