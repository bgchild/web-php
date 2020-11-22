<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/serviceTeamManage.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script  type="text/javascript"   src="templates/js/common_table.js"></script>
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
		
		
		<a href="serviceTeamAdd.php" class="addbtn btn_alone" role="button"><span class="add"></span>新建服务队</a>
		
		
		
		<form action='serviceTeamManage.php' method='post' class="searchFrom" id="myform">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
                <div class="searchDivInFieldset">
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
	    				<td class="listright "  width="80">创建日期起：</td>
	    				<td width="140"><input type="text" name="foundingtime_start" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['foundingtime_start'];?>" id="foundingtime_start" /></td>
	    				<td class="listright" width="80">创建日期止：</td>
	    				<td width="140"><input type="text" name="foundingtime_stop" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['foundingtime_stop'];?>" id="foundingtime_stop" /></td>
    					<td class="listright" width="80">服务队名称：</td><td width="140"><input type="text" name="serviceteamname" class="input" value="<?php echo $infos['serviceteamname'];?>" id="serviceteamname" /></td>
    				</tr>
    				<tr align="right">
    					<td colspan='5'><input type="hidden" name="tag" value="<?php echo $tag;?>" /></td>
    					<td colspan='1'><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
    					<a href="serviceTeamManage.php" class="btn">重置</a>
    				</tr>
    			</table>
                </div>
  			</fieldset>
		</form>
		<div class="tabContent">	
		<div class="tab">
			<ul>
				<li  <?php echo $tabact1;?>><a href="serviceTeamManage.php?<?php $infos['tag']=1;echo "info=".set_url($infos);?>">申请中</a></li>
				<li <?php echo $tabact2;?>><a href="serviceTeamManage.php?<?php $infos['tag']=2;echo "info=".set_url($infos);?>">已通过</a></li>
				<li <?php echo $tabact3;?>><a href="serviceTeamManage.php?<?php $infos['tag']=3;echo "info=".set_url($infos);?>">未通过</a></li>
			</ul>	
		</div>
		<div class="tab_item">
			<table class="list-table tab_none table_1 " cellspacing="1" cellpadding="2">
				<tr>
					<th align="center" width="290">服务队名称</th>
					<th align="center" width="150">创建日期</th>
					<th align="center" width="150">修改日期</th>
					<th align="center" width="130">操作</th>
				</tr>
				<?php foreach ($ser_list as $proce) {?>
				<tr>
					<td align="left" class="omit1" width="290"><a href="serviceTeamAdd.php?recordid=<?php echo set_url($proce['recordid']);?>" style="color:red; text-decoration:none;" title="<?php echo $proce['serviceteamname'];?>"><?php echo $proce['serviceteamname'];?></a></td>
					<td align="center" width="150"><?php echo $proce['foundingtime'];?></td>
					<td align="center" width="150"><?php echo $proce['edittime'];?></td>
					<td align="center" width="130"><a href="serviceTeamAdd.php?recordid=<?php echo set_url($proce['recordid']);?>"><img src="templates/images/manage/icon_edit.gif" alt="修改"/></a><a href="javascript:if(confirm('确定要删除一条数据吗?')) location.href='serviceTeamManage.php?deleteid=<?php echo set_url($proce['recordid']);?>';" ><img src="templates/images/manage/icon_drop.gif" alt="删除"/></a></td>
				</tr>
				<?php } if(!$ser_list){?><tr><td colspan='5'>查无数据</td></tr><?php }?>
			</table>
			<table class="list-table tab_none table_2 " cellspacing="1" cellpadding="2">
				<tr>
					<th align="center" width="120">服务队名称</th>
					<th align="center" width="140">创建日期</th>
					<th align="center" width="140">审核通过日期</th>
					<th align="center" width="70">队员人数</th>
					<th align="center" width="90">申请加入人数</th>
					<th align="center" width="70">操作</th>
				</tr>
				<?php foreach($ser_list as $pass) {
					if (isset($_GET['info'])) {
						$spm['recordid'] = $pass['recordid'];
						$spm['info'] = get_url($_GET['info']);
						$url=set_url($spm);
						$spm2['recordid'] = $pass['recordid'];
						$spm2['tag'] = $tag;
						$url2 = set_url($spm2);	
						$spm3['recordid'] = $pass['recordid'];
						$spm3['tag'] = $tag;
						if ($_GET['page'])  {
							$spm3['page'] = $_GET['page'];
						}
						$url3 = set_url($spm3);	
						
					}
					
				?>
				<tr>
					<td align="left" class="omit2" width="120">
						<a href="serviceTeamAuditPass.php?spm=<?php echo $url;?>" style="color:red; text-decoration:none;" title="<?php echo $pass['serviceteamname'];?>"><?php echo $pass['serviceteamname'];?></a>
					</td>
					<td align="center" width="140"><?php echo $pass['foundingtime'];?></td>
					<td align="center" width="140"><?php echo $pass['edittime'];?></td>
					<td align="center" width="70"><?php echo $pass['passNum'];?></td>
					<td align="center" width="90">
						<a href="serviceTeamPersonnelAudit.php?act=<?php echo set_url('init');?>&serviceid=<?php echo set_url($pass['recordid']);?>&info=<?php echo $_GET['info'];if($_GET['page']){echo '&page='.$_GET['page'];}?>" style="color:red; text-decoration:none;"><?php echo $pass['auditNum'];?></a>
					</td>
					<td align="center" width="70">
					<a href="serviceTeamAdd.php?spm=<?php echo $url2;?>"><img src="templates/images/manage/icon_view.gif" alt="查看" /></a>&nbsp;<a href="serviceTeamPicture.php?spm=<?php echo $url3;?>"><img src="templates/images/manage/icon_add.gif" alt="服务队展示图片添加" title="服务队展示图片添加" /></a>
					<a href="javascript:if(confirm('确定要解散此服务队?')) location.href='serviceTeamManage.php?cancelid=<?php echo set_url($pass['recordid']);?>';" ><img src="templates/images/manage/icon_drop.gif" alt="解散"/></a>
					</td>
				</tr>
				<?php } if(!$ser_list){?>	<tr><td colspan='7'>查无数据</td></tr><?php }?>
			</table>
			<table class="list-table tab_none table_3 " cellspacing="1" cellpadding="2">
				<tr>
					<th align="center" width="240">服务队名称</th>
					<th align="center" width="240">创建日期</th>
                    <th align="center" width="240">未通过原因</th>
				</tr>
				<?php foreach ($ser_list as $fail) {?>
				<tr>
					<td align="left" width="240" class="omit3"><a href="serviceTeamAdd.php?recordid=<?php echo set_url($fail['recordid']);?>&tag=<?php echo set_url($tag);?>" style="color:red; text-decoration:none;" title="<?php echo $fail['serviceteamname'];?>"><?php echo $fail['serviceteamname'];?></a></td>
					<td align="center" width="240"><?php echo $fail['foundingtime'];?></td>
                    <td width="240" class="omit4"><a title="<?php echo $fail['fail_name'];?>"><?php echo $fail['fail_name'];?></a></td>
				</tr>
				<?php } if(!$ser_list){?>	<tr><td colspan='3'>查无数据</td></tr><?php }?>
			</table>

		</div>
		</div>
 <?php include 'page.php'?>
		
<script type="text/javascript">
$(function(){ 
	var tag=<?php echo $tag;?>;
	$(".table_"+tag).removeClass("tab_none"); 
	
	$("#myform").submit(function(){
		var start_time = $("#foundingtime_start").val();
		var stop_time = $("#foundingtime_stop").val();
		
		if (compareDate(start_time,stop_time)) {
				ui.error("创建日期起不能大于创建时间止！");
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
		 
</div>


		
</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
</body>
</html>