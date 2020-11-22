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
    			<legend>查询条件</legend>
                <div class="searchDivInFieldset">
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
	    				<td class="listright "  width="80">通过日期起：</td>
	    				<td width="140"><input type="text" name="foundingtime_start" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $gets['foundingtime_start'];?>" id="foundingtime_start" /></td>
	    				<td class="listright" width="80">通过日期止：</td>
	    				<td width="140"><input type="text" name="foundingtime_stop" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $gets['foundingtime_stop'];?>" id="foundingtime_stop" /></td>
    					<td class="listright" width="80">服务队名称：</td><td width="140"><input type="text" name="serviceteamname" class="input length_20" value="<?php echo $gets['serviceteamname'];?>" id="serviceteamname" /></td>
    				</tr>
    				<tr>
    					<td class="listright "  width="80">服务队分类：</td>
	    				<td width="140" colspan='4'>
                        <input type="button" name="search_btn" id="search_btn" class="btn" value="检索" />
                        <div id="hid_rel" >
                        	<div id="hid_abs">
                        		<?php foreach ($cate as $v) {?>
                            	<div class="hid_son"><input type="checkbox" name="stype[]"  value="<?php echo $v['id']?>" /><?php echo $v['name'];?></div>
                            	<?php } ?>
                                <div  id="hid_btn"><input type="button" value="确定" class="btn" /></div>
                            </div>
                        </div>
                        </td>
    					<td colspan='2' align="right"><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
    					<a href="serviceTeamMessage.php" class="btn" role="button"><span class="add"></span>重置</a></td>
    				</tr>
    			</table>
                </div>
  			</fieldset>
		</form>
</div>
<div class="service_middle">
<?php if ($now_flag) {?>
 <table>
        <tr>
        <td width="880" align="right"><a href="serviceTeamMoreInfo.php?act=add" class="addbtn btn_alone" role="button"><span class="add"></span>新增服务队</a></td>
        </tr>
        <tr><td colspan="4"  height="1"></td></tr>
        </table>
 <?php }?>
<div class="tabContent">        
<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
                <th align="center" width="80">服务队名称</th>
                <th align="center" width="80">负责人</th>
                <th align="center" width="80">服务队长</th>
                <th align="center" width="60">成员数量</th>
                <th align="center" width="120">联系电话</th>
                <th align="center" width="100">通过日期</th>
                <th align="center" width="140">服务队分类</th>
            	<?php if ($now_flag) {?><th align="center" width="120">操作</th><?php }?>
            </tr>
            <?php foreach ($list as $v) {
            	$spm=array();
				$spm2 = array();
				$spm['id']=$v['recordid'];
				$url='teanManageDetail.php?act=edit&spm='.set_url($spm['id']);
				$spm2['recordid'] = $v['recordid'];
				if ($_GET['page']) {
					$spm2['page'] = $_GET['page'];
				}
            ?>
			<tr>
                <td align="left" width="80" class="omit3"><a href="<?php echo $url;?>" style="text-decoration:none; color:red;" title="<?php echo $v['serviceteamname'];?>"><?php echo $v['serviceteamname'];?></a></td>
                <td align="left" width="80" class="omit4"><a title="<?php echo $v['responsibleperson'];?>"><?php echo $v['responsibleperson'];?></a></td>
                <td align="left" width="80" class="omit4"><a title="<?php echo $v['captainName'];?>"><?php echo $v['captainName'];?></a></td>
                <td align="center" width="60"><?php echo $v['passNum'] ?  $v['passNum'] :  '暂无';?></td>
                <td align="center" width="100"><?php echo $v['telephones'];?></td>
                <td align="center" width="120"><?php echo $v['auditpasstime'];?></td>
                <td align="center" width="140"><input type="text" name="skill" value="<?php echo $v['skill'];?>"  class="input" readonly="readonly" /></td>
                <?php if ($now_flag) {?><td align="center" width="120"><a href="serviceTeamMoreInfo.php?act=edit&recordid=<?php echo set_url($spm['id']);?>"><img src="../templates/images/manage/icon_edit.gif" alt="修改"/></a><a href="serviceTeamPicture.php?spm=<?php echo set_url($spm2);?>"><img src="../templates/images/manage/icon_add.gif" alt="服务队展示图片添加" title="服务队展示图片添加" /></a>
                <a href="javascript:if(confirm('确定要注销此服务队?')) location.href='serviceTeamMoreInfo.php?act=cancels&cancelid=<?php echo set_url($spm['id']);?>';" ><img src="/templates/images/manage/icon_drop.gif" alt="注销" title="注销服务队" /></a>
                </td><?php }?>
            </tr>
            <?php } if(!$list){?><tr><td colspan='8'>查无数据</td></tr><?php }?>
		</table>
        </div>
         
       <table width="750"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
</div>
<script type="text/javascript">
$(function(){ 
		   
	$("#search_btn").click(function(){
		$("#hid_abs").show();
	});
	$("#hid_btn").click(function(){
		$("#hid_abs").hide();
	});
	
		$("#myform").submit(function(){
		var start_time = $("#foundingtime_start").val();
		var stop_time = $("#foundingtime_stop").val();
		
		if (compareDate(start_time,stop_time)) {
				ui.error("通过日期起不能大于通过时间止！");
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
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>