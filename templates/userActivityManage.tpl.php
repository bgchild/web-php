<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />

<link type="text/css" rel="stylesheet" href="templates/css/userActivityManage.css"/>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script  type="text/javascript"   src="templates/js/common_table.js"></script>
<script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>

<link rel="stylesheet" href="include/keditor/themes/default/default.css" />
<link rel="stylesheet" href="include/keditor/plugins/code/prettify.css" />
<script charset="utf-8" src="include/keditor/kindeditor-min.js"></script>
<script charset="utf-8" src="include/keditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="include/keditor/plugins/code/prettify.js"></script>

</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">

		<a href="userActivityAdd.php" class="addbtn btn_alone" role="button" style="clear: none;"><span class="add"></span>新建活动</a>
		<?php if($largeid) { ?>
		<a href="userActivityAdd.php?largeid=<?php echo set_url($largeid); ?>" class="addbtn btn_alone" role="button" style="clear: none; margin-left: 5px;"><span class="add"></span>新建子集活动</a>
		<?php } ?>

		
		<form action='userActivityManage.php' method='post' class="searchFrom">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
    			<div class="searchDivInFieldset">
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr>
						<td class="listright " width="80">活动名称：</td>
						<td width="140">
							<input type="hidden" name="tag" value="<?php echo $tag;?>" />
							<?php if($largeid) { ?>
							<input type="hidden" name="largeid" value="<?php echo set_url($largeid); ?>" />
							<?php } ?>
							<input type="text" name="activityName" class="input length_20 activityName" value="<?php echo $infos['activityName'];?>"/>
						</td>
						<td class="listright" width="80">活动类型：</td>
						<td width="140">
							<select name='activityType' id='activityType' class='select_20'><option value='0'>请选择</option><?php foreach($types as $key=>$val) {?><option class="activityType_search_option" value='<?php echo $val['id']?>' <?php if($infos[activityType]==$val['id']) echo "selected='selected'";?>><?php echo $val[name]?></option><?php }?></select>
						</td>
						<td class="listright" width="80">活动时长：</td>
						<td width="140"><input type="text" name="activitytime" class="input length_20 activitytime" value="<?php echo $infos['activitytime'];?>"/></td>
					</tr>
    				<tr>
						<td class="listright">活动地点：</td>
						<td><input type="text" name="activityAddr" class="input length_20 activityAddr" value="<?php echo $infos['activityAddr'];?>"/></td>
						<td class="listright">活动日期起：</td>
						<td><input type="text" name="activityStartDate" class="input length_20 activityStartDate" onclick="WdatePicker()" readonly="readonly" value="<?php echo $infos['activityStartDate'];?>"/></td>
						<td class="listright">活动日期止：</td>
						<td><input type="text" name="activityEndDate" class="input length_20 activityEndDate" onclick="WdatePicker()" readonly="readonly"  value="<?php echo $infos['activityEndDate'];?>"/></td>
					</tr>
    				<tr>
						<td class="listright">预招募人数：</td>
						<td><input type="text" name="planNum"class="input length_20 planNum" value="<?php echo $infos['planNum'];?>"/></td>
						<td></td>
						<td colspan='3' class="listright" >
							<div style="margin-right:10px;"><input type="submit" name="doSearch" class="btn btn_search" value="查询" />&nbsp;&nbsp;<input type="button" class="btn btn_rest" value="重置" /></div>
						</td>
					</tr>
    			</table>
    			</div>
  			</fieldset>
		</form>
		
		<div class="hiddenDiv hiddenDiv1">
			<table class="changeTimeTable">
				<tr><td>原日期:</td><td><input type="text" name="activityStartDate_pre" class="input length_20 activityStartDate_pre"  readonly="readonly" value=""/></td><td>至</td><td><input type="text" name="activityEndDate_pre" class="input length_20 activityEndDate_pre"    readonly="readonly" value=""/></td>
					<td>新日期:</td><td><input type="text" name="activityStartDate_new" class="input length_20 activityStartDate_new" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"   readonly="readonly" value=""/></td><td>至</td><td><input type="text" name="activityEndDate_new" class="input length_20 activityEndDate_new" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"   readonly="readonly" value=""/></td></tr>
				<tr><td>改期原因:</td><td colspan="3"><textarea name="changereason" class="changereason"style="width:280px;height:30px;"></textarea></td>
					<td><input type="hidden" name="rid" class="changeTime_rid" value="" /></td><td colspan="3"><input type="button" name="doChangeTime" class="btn doChangeTime" value="确定"/>&nbsp;&nbsp;<input type="button" name="doCancelChangeTime" class="btn doCancelChangeTime" value="关闭"/></td></tr>
			</table>
		</div>
		
		<div class="hiddenDiv hiddenDiv2">
			<table class="changeTimeTable">
				<tr><td>取消原因:</td><td colspan="3"><textarea name="cancelreason" class="cancelreason"style="width:280px;height:30px;"></textarea></td>
					<td><input type="hidden" name="rid" class="cancelRid_rid" value="" /></td><td colspan="3"><input type="button" name="doCancelRid" class="btn doCancelRid" value="确定"/>&nbsp;&nbsp;<input type="button" name="doCancelRidClose" class="btn doCancelRidClose" value="关闭"/></td></tr>
			</table>
		</div>
		
		<div class="hiddenDiv hiddenDiv4">
			<fieldset class="searchManSet"  style="width: 95%;">
	    			<legend>邀请查询条件</legend>
					<table class="searchManTable table">
					<tr><td width="40px" class="listright">用户名:</td><td width="80px"><input type="text" name="nickname" class="input length_202 nickname" value="" /></td><td width="50px" class="listright">服务队:</td><td width="80px"><select  name="serviceteamid" class="select_202 serviceteamid"><option value="0">请选择</option><?php foreach($teams as $k=>$v) {?><option value="<?php echo $v['recordid']?>"><?php echo $v['serviceteamname'];?></option><?php }?></select></td><td width="60px" class="listright">专业技能:</td><td width="130px"><div style="width:120px;height:70px;overflow:auto;border:1px solid #B1AEAE;"><?php foreach($skills as $k=>$v) { ?><input type="checkbox" name="skills[]" class="features" value="<?php echo $v['id'];?>"  /><?php echo $v['name'];?><br /><?php } ?></div></td>
					<td class="listright" width="120px"><input type="hidden" name="rid" class="doInvite_rid listcenter" value="" /><input type="button" name="doInviteSearch" class="btn doInviteSearch" value="查询"/>&nbsp;&nbsp;<input type="button" name="doInviteClear" class="btn doInviteClear" value="重置"/></td></tr>
				</table>
			</fieldset>
			 <input type="button" name="doInviteMsg" class="btn doInviteMsg" value="邀请" style="margin-bottom:10px;margin-top:5px"/>
			 &nbsp;&nbsp;<input type="button" name="doInviteCancel" class="btn doInviteCancel" value="返回" style="margin-bottom:10px;margin-top:5px"/>

			<table class="list-table menTable table" style="width:95%"  cellspacing="1" cellpadding="2">
			<tr><th width="35px"><input type="checkbox" name="selectall" class="selectall" /></th><th width="150px" class="listleft">姓名</th><th width="150px" class="listleft">用户名</th><th width="150px" class="listleft">昵称</th><th width="80px" class="listcenter">出生日期</th><th width="35px" class='listcenter'>性别</th><th class="listleft">专业技能</th></tr>
			</table>
			<div id="Pagination" class="pagination"></div>
		</div>

		<?php if($largeRecord){ ?>
		<div style="width: 95%; margin-left: 20px; margin-top: 20px; color: #E9423C;">
			<h3>[<?php echo $largeRecord['activityName']; ?>]</h3>
		</div>
		<?php } ?>
			
		<div class="tabContent">
			<div class="tab">
			<ul>

				<li <?php echo $tabact2;?>><a href="userActivityManage.php?<?php if($largeid) { echo "largeid=".set_url($largeid)."&"; } ?><?php $infos['tag']=2;echo "info=".set_url($infos);?>">待审核</a></li>
				<li <?php echo $tabact3;?>><a href="userActivityManage.php?<?php if($largeid) { echo "largeid=".set_url($largeid)."&"; } ?><?php $infos['tag']=3;echo "info=".set_url($infos);?>">运行中</a></li>
				<li <?php echo $tabact4;?>><a href="userActivityManage.php?<?php if($largeid) { echo "largeid=".set_url($largeid)."&"; } ?><?php $infos['tag']=4;echo "info=".set_url($infos);?>">已结束</a></li>
				<li <?php echo $tabact5;?>><a href="userActivityManage.php?<?php if($largeid) { echo "largeid=".set_url($largeid)."&"; } ?><?php $infos['tag']=5;echo "info=".set_url($infos);?>">已取消</a></li>
				<li <?php echo $tabact6;?>><a href="userActivityManage.php?<?php if($largeid) { echo "largeid=".set_url($largeid)."&"; } ?><?php $infos['tag']=6;echo "info=".set_url($infos);?>">未通过</a></li>
				<li <?php echo $tabact1;?>><a href="userActivityManage.php?<?php if($largeid) { echo "largeid=".set_url($largeid)."&"; } ?><?php $infos['tag']=1;echo "info=".set_url($infos);?>">草稿</a></li>
			</ul>	
			</div>
			<div class="tab_item">
				<!-- 已审核   -->
				<table class="list-table tab_none table_3 table"  cellspacing="1" cellpadding="2">
				<tr>
					<th class="listcenter">活动名称</th>
					<?php if (!$largeid) {?>
					<th width="60px">开展活动数</th>
					<?php } ?>
					<th width="160px" class="listcenter">活动日期</th>
					<th class="listcenter" width="120px">活动类型</th>
					<th width="70px" class="listcenter">预招募人数</th>
					<th width="50px" class="listcenter">报名人数</th>
					<th width="70px" class="listcenter">已入队人数</th>
					<th width="120px" class="listcenter">操作</th>
				</tr>
					<?php foreach($sta as $k=>$val ){?>
							<tr>
								<td ><a class="tda" width="100px" href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
								<?php if (!$largeid) {?>
								<td class="listcenter"><?php if($val['large']){ ?><a href="userActivityManage.php?largeid=<?php echo set_url($val['recordid']); ?>"><?php echo $val['childrenCount']; ?></a><?php } else {?> -- <?php } ?></td>
								<?php } ?>
								<td class="already_changeTime" class="listcenter"><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
								<td class="listleft"><?php echo $val[typename];?></td><td class="listcenter"><?php echo $val[planNum];?></td>
								<td class="listcenter"><a href="userActivityManage.php?tag=<?php echo set_url('3');?>&act=totalnums&recordid=<?php echo set_url($val['recordid']);?>"><?php echo $val[totalnums];?></a></td>
								<td class="listcenter"><a href="userActivityManage.php?act=passnums&recordid=<?php echo set_url($val['recordid']);?>&status=2"><?php echo $val[passnums];?></a></td>
								<td style="text-align: right;">
									<?php if(!$val['large']){ ?>
									<a href="###" class="a_red inviteRid" rid="<?php echo $val['recordid'];?>">邀请</a>
									<?php } ?>
									<a href="###" class="a_red changeTime" rid="<?php echo $val['recordid'];?>">改期</a>
									<a href="###" class="a_red cancelRid" rid="<?php echo $val['recordid'];?>">取消</a>
									<a href="###" class="a_red stopRid" rid="<?php echo $val['recordid'];?>" endDate="<?php echo $val[trueactivityEndDate];?>">结束</a></td>
							</tr>
					<?php } if(!$sta){?>	<tr><td colspan='7'>查无数据</td></tr><?php }?>
				</table>
				<!-- 待审核   -->
				<table class="list-table tab_none table_2 table" cellspacing="1" cellpadding="2">
				<tr>
					<th class="listcenter">活动名称</th>
					<?php if (!$largeid) {?>
					<th width="60px">开展活动数</th>
					<?php } ?>
					<th width="160px" class="listcenter">活动日期</th>
					<th class="listcenter" width="120px">活动类型</th>
					<th width="70px" class="listcenter">预招募人数</th>
				</tr>
					<?php foreach($sta as $k=>$val ){?>
							<tr>
								<td><a class="tda" width="280px" href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
								<?php if (!$largeid) {?>
								<td class="listcenter"><?php if($val['large']){ ?><a href="userActivityManage.php?largeid=<?php echo set_url($val['recordid']); ?>"><?php echo $val['childrenCount']; ?></a><?php } else {?> -- <?php } ?></td>
								<?php } ?>
								<td class="listcenter"><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
								<td class="listleft"><?php echo $val[typename];?></td>
								<td class="listcenter"><?php echo $val[planNum];?></td>
							</tr>
					<?php } if(!$sta){?>	<tr><td colspan='5'>查无数据</td></tr><?php }?>
				</table>
				<!-- 草稿   -->
				<table class="list-table tab_none table_1 table" cellspacing="1" cellpadding="2">
				<tr>
					<th class="listcenter">活动名称</th>
					<?php if (!$largeid) {?>
					<th width="60px">开展活动数</th>
					<?php } ?>
					<th width="160px" class="listcenter">活动日期</th>
					<th class="listcenter" width="120px" >活动类型</th>
					<th width="70px" class="listcenter">预招募人数</th>
					<th class="listcenter" width="60px">操作</th>
				</tr>
					<?php foreach($sta as $k=>$val ){?>
							<tr>
								<td><a class="tda" width="260px" href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
								<?php if (!$largeid) {?>
								<td class="listcenter"><?php if($val['large']){ ?><a href="userActivityManage.php?largeid=<?php echo set_url($val['recordid']); ?>"><?php echo $val['childrenCount']; ?></a><?php } else {?> -- <?php } ?></td>
								<?php } ?>
								<td class="listcenter"><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
								<td class="listleft"><?php echo $val[typename];?></td>
								<td class="listcenter"><?php echo $val[planNum];?></td>
								<td class="listcenter"><a href="userActivityAdd.php?recordid=<?php echo set_url($val['recordid']);?>"><img src="templates/images/manage/icon_edit.gif" alt="修改"/></a><a href="javascript:if(confirm('确定删除么？最后的机会！！Last Chance!!')) location.href='userActivityManage.php?act=delete&tag=<?php echo set_url($tag);?>&recordid=<?php echo set_url($val['recordid']);?>';" ><img src="templates/images/manage/icon_drop.gif" alt="删除"/></a></td>
							</tr>
					<?php } if(!$sta){?>	<tr><td colspan='5'>查无数据</td></tr><?php }?>
				</table>
				<!-- 已结束   -->
				<table class="list-table tab_none table_4 table" cellspacing="1" cellpadding="2">
				<tr>
					<th class="listcenter">活动名称</th>
					<?php if (!$largeid) {?>
					<th width="60px">开展活动数</th>
					<?php } ?>
					<th width="160px" class="listcenter">活动日期</th>
					<th width="120px" class="listcenter">活动类型</th>
					<th width="70px" class="listcenter">预招募人数</th>
					<th width="50px" class="listcenter">参与人数</th>
					<th width="80px" class="listcenter">操作</th>
				</tr>
					<?php foreach($sta as $k=>$val ){?>
							<tr>
								<td><a class="tda" width="140px" href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
								<?php if (!$largeid) {?>
								<td class="listcenter"><?php if($val['large']){ ?><a href="userActivityManage.php?largeid=<?php echo set_url($val['recordid']); ?>"><?php echo $val['childrenCount']; ?></a><?php } else {?> -- <?php } ?></td>
								<?php } ?>
								<td class="listcenter"><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
								<td class="listleft"><?php echo $val[typename];?></td><td class="listcenter"><?php echo $val[planNum];?></td>
								<td class="listcenter"><a href="userActivityManage.php?act=passnums&recordid=<?php echo set_url($val['recordid']);?>&status=4"><?php echo $val[gonums];?></a></td>
								<td class="listcenter"> <a href="javascript:if(confirm('确定删除么？最后的机会！！Last Chance!!')) location.href='userActivityManage.php?act=delete&tag=<?php echo set_url($tag);?>&recordid=<?php echo set_url($val['recordid']);?>';" class="a_red">删除</a>&nbsp;&nbsp;<a href="###" class="a_red sumupRid" rid="<?php echo $val['recordid'];?>">总结</a></td>
							</tr>
					<?php } if(!$sta){?>	<tr><td colspan='6'>查无数据</td></tr><?php }?>
				</table>
				<!-- 已取消   -->
				<table class="list-table tab_none table_5 table" cellspacing="1" cellpadding="2">
				<tr>
					<th class="listcenter">活动名称</th>
					<?php if (!$largeid) {?>
					<th width="60px">开展活动数</th>
					<?php } ?>
					<th width="160px" class="listcenter">活动日期</th>
					<th class="listcenter" width="120px">活动类型</th>
					<th width="70px" class="listcenter">预招募人数</th>
				</tr>
					<?php foreach($sta as $k=>$val ){?>
							<tr>
								<td><a class="tda" width="330px" href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
								<?php if (!$largeid) {?>
								<td class="listcenter"><?php if($val['large']){ ?><a href="userActivityManage.php?largeid=<?php echo set_url($val['recordid']); ?>"><?php echo $val['childrenCount']; ?></a><?php } else {?> -- <?php } ?></td>
								<?php } ?>
								<td class="listcenter"><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
								<td class="listleft"><?php echo $val[typename];?></td>
								<td class="listcenter"><?php echo $val[planNum];?></td>
							</tr>
					<?php } if(!$sta){?>	<tr><td colspan='4'>查无数据</td></tr><?php }?>	
				</table>
				<!-- 退回   -->
				<table class="list-table tab_none table_6 table" cellspacing="1" cellpadding="2">
				<tr>
					<th class="listcenter">活动名称</th>
					<?php if (!$largeid) {?>
					<th width="60px">开展活动数</th>
					<?php } ?>
					<th width="160px" class="listcenter">未通过原因</th>
					<th width="160px" class="listcenter">活动日期</th>
					<th class="listcenter" width="120px">活动类型</th>
					<th width="70px" class="listcenter">预招募人数</th>
					<th width="60px" class="listcenter">操作</th>
				</tr>
					<?php foreach($sta as $k=>$val ){?>
							<tr>
								<td><a class="tda" width="270px" href="userActivityDetail.php?show=<?php echo set_url($val['recordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
								<?php if (!$largeid) {?>
								<td class="listcenter"><?php if($val['large']){ ?><a href="userActivityManage.php?largeid=<?php echo set_url($val['recordid']); ?>"><?php echo $val['childrenCount']; ?></a><?php } else {?> -- <?php } ?></td>
								<?php } ?>
								<td><?php echo $val['statusreasontext'];?></td>
								<td class="listcenter"><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
								<td class="listleft"><?php echo $val[typename];?></td>
								<td class="listcenter"><?php echo $val[planNum];?></td>
								<td class="listcenter"><a href="userActivityAdd.php?recordid=<?php echo set_url($val['recordid']);?>"><img src="templates/images/manage/icon_edit.gif" alt="修改"/></a><a href="javascript:if(confirm('确定删除么？最后的机会！！Last Chance!!')) location.href='userActivityManage.php?act=delete&tag=<?php echo set_url($tag);?>&recordid=<?php echo set_url($val['recordid']);?>';" ><img src="templates/images/manage/icon_drop.gif" alt="删除"/></a></td>
							</tr>
					<?php } if(!$sta){?>	<tr><td colspan='5'>查无数据</td></tr><?php }?>	
				</table>
			</div>
		</div>
 <?php include 'page.php'?>

 <div class="hiddenDiv hiddenDiv3">
			<table class="changeTimeTable">
				<tr><td width="30px">总结:</td><td width="550px"><textarea name="sumup" class="sumup"style="width:500px;height:300px;"></textarea></td>
					<td><input type="hidden" name="rid" class="doSumup_rid" value="" /><input type="button" name="doSumup" class="btn doSumup" value="确定"/>&nbsp;&nbsp;<input type="button" name="doSumupCancel" class="btn doSumupCancel" value="关闭"/></td>
				</tr>
			</table>
</div>
		
<script type="text/javascript">
$(document).ready(function(){

	var editor;
	  KindEditor.ready(function(K) {
		  editor = K.create('textarea[name="sumup"]', {
			  allowFileManager : false,
			  resizeType:1,
			  items : [
					'source','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
					'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
					'insertunorderedlist', '|', 'emoticons', 'image','link','table'],
			  afterCreate : function(){ 
			              this.sync();   
			       },
			  afterChange: function(){ 
			              this.sync();   
			       },
			   afterBlur : function(){ 
			           this.sync(); 
			       }  						
		  });
	  });

	function DateCompare(d1,d2){
		var date1;   
	    var date2;
		if(d1=="now") date1=new Date();
		else date1=new Date(Date.parse(d1.replace(/-/g,"/")));
		if(d2=="now") date2=new Date();
		else date2=new Date(Date.parse(d2.replace(/-/g,"/"))); 
	    if(date1>date2)  return true;
	    else return false;
	}

	function getLength(s) {
	    var len = 0;
	    var a = s.split("");
	    for (var i=0;i<a.length;i++) {
	        if (a[i].charCodeAt(0)<299) {
		    len++;
			} else {
			    len+=2;
			}
	    }
	    return len;
	}

	var tag=<?php echo $tag;?>;
	$(".table_"+tag).removeClass("tab_none");
	$(".btn_rest").click(function(){
		$(".activityName").removeAttr("value");
		$(".activitytime").removeAttr("value");
		$(".activityAddr").removeAttr("value");
		$(".activityStartDate").removeAttr("value");
		$(".activityEndDate").removeAttr("value");
		$(".planNum").removeAttr("value");
		$("#activityType").val("0");
		$(".btn_search").click();
	});
	$(".searchFrom").submit(function(){
		if(DateCompare($(".activityStartDate").val(),$(".activityEndDate").val())) {
			ui.error("活动日期起不能大于活动日期止！");
			return false;
		}
		return true;
	});
	var changeTimeA;
	$(".changeTime").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$('.hiddenDiv1').show();
		var rid=$(this).attr("rid");
		changeTimeA=this;
		$.getJSON("userActivityManage.php?recd="+rid, function(data){
			$(".activityStartDate_pre").val(data.activityStartDate);
			$(".activityEndDate_pre").val(data.activityEndDate);
			//$(".activityStartDate_new").val(data.activityStartDate);
			//$(".activityEndDate_new").val(data.activityEndDate);
			$(".changereason").val(data.changereason);
			$(".changeTime_rid").val(data.recordid);
		});
	});
	$(".doCancelChangeTime").click(function(){
		$('.hiddenDiv1').hide();
	});
	$(".doChangeTime").click(function(){
		if($(".activityStartDate_new").val()==""){
			ui.error("活动开始时间不能为空");
			$(".activityStartDate_new").focus();
		}else if($(".activityEndDate_new").val()==""){
			ui.error("活动结束时间不能为空");
			$(".activityEndDate_new").focus();
		}else if(DateCompare($(".activityStartDate_new").val(),"now")==false){
	    	ui.error("活动开始时间不能小于当前时间");
			$(".activityStartDate_new").focus();
		}else if(DateCompare($(".activityEndDate_new").val(),"now")==false){
	    	ui.error("活动结束时间不能小于当前时间");
			$(".activityEndDate_new").focus();
		}else if(DateCompare($(".activityStartDate_new").val(),$(".activityEndDate_new").val())==true) {
			ui.error("活动开始时间不能大于活动结束时间");
			$(".activityStartDate_new").focus();
	    }else if(getLength($(".changereason").val()) > 300){
	    	ui.error("改期原因过长");
			$(".changereason").focus();
		}else{
	    	$.post("userActivityManage.php", 
				{ doChangeTime:"true",
				  activityStartDate_new: $(".activityStartDate_new").val(), 
				  activityEndDate_new: $(".activityEndDate_new").val(),
				  changereason:$(".changereason").val(), 
				  rid:$(".changeTime_rid").val()
				 },function(data){
				     if(data.result=="yes") {
				    	 $(changeTimeA).parent().siblings(".already_changeTime").html(data.activityStartDate+" ~ "+data.activityEndDate);
				    	 ui.success("保存成功");
					     $(".hiddenDiv1").hide();
				     } else {
						 ui.error( data.msg || "保存失败或内容没有更改，请稍后再次尝试或改变内容再保存")
					 }
			},"json");
		}
	});
	////////////////////////////////////////////////
	$(".stopRid").click(function(){
		var rid=$(this).attr("rid");
		var _stop=$(this).parent().parent();
		if(confirm("确定要结束该活动么？")){
			$.getJSON("userActivityManage.php?stopRid="+rid, function(data){
				if(data.result=="yes") {
					ui.success("手动结束成功！");
					_stop.hide();
				}

				if (data.result=="no") {
					ui.error(data.msg || "手动结束失败！");
				}
			});
		}
	});
	///////////////////////////////////////////////////////
	var _cancel;
	$(".cancelRid").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$('.hiddenDiv2').show();
		var rid=$(this).attr("rid");
		_cancel=$(this).parent().parent();
		$.getJSON("userActivityManage.php?recd="+rid, function(data){
			$(".cancelreason").val(data.cancelreason);
			$(".cancelRid_rid").val(data.recordid);
		});
	});
	$(".doCancelRidClose").click(function(){
		$('.hiddenDiv2').hide();
	});
	$(".doCancelRid").click(function(){
	    if(getLength($(".cancelreason").val()) > 300){
	    	ui.error("取消原因过长");
			$(".cancelreason").focus();
		}else{
			$.post("userActivityManage.php", 
				{ doCancelRid:"true",
				  cancelreason:$(".cancelreason").val(), 
				  rid:$(".cancelRid_rid").val()
			     },function(data){
				     if(data.result=="yes") {
				    	 ui.success("保存成功");
					     $(".hiddenDiv2").hide();
					     $(_cancel).remove();
				     } else {
						 ui.error(data.msg || "保存失败或内容没有更改，请稍后再次尝试或改变内容再保存");
					 }
			},"json");
		}
	});
	///////////////////////////////////////////////////////////////////////////
	$(".sumupRid").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$('.hiddenDiv3').show();
		var rid=$(this).attr("rid");
		$.getJSON("userActivityManage.php?recd="+rid, function(data){
			$(document.getElementsByTagName('iframe')[0].contentWindow.document.body).html("").append(data.sumup);
			$(".sumup").val(data.sumup);
			$(".doSumup_rid").val(data.recordid);
		});
	});
	$(".doSumupCancel").click(function(){
		$('.hiddenDiv3').hide();
	});
	$(".doSumup").click(function(){
	    if($(".sumup").val()=='') {
	    	ui.error("不能空保存！");
		}else {
			$.post("userActivityManage.php", 
				{ doSumup:"true",
				  sumup:$(".sumup").val(), 
				  rid:$(".doSumup_rid").val()
			     },function(data){
				     if(data.result=="yes") {
				    	 ui.success("保存成功");
					     $(".hiddenDiv3").hide();
				     }
				    else {
				    	ui.success("保存成功");
				    	$(".hiddenDiv3").hide();
					}
			},"json");
		}
	});
	////////////////////////////////////////////////////////////////////////////
	var men_total;
	var _per_page;
	function getFeatures(){
		var _features="";
		$(".features:checked").each(function(){_features+=$(this).val()+",";});
		return _features;
	}
	function pageInit(men_total,_per_page,pageselectCallback){
		$("#Pagination").pagination(men_total, {
		    num_edge_entries: 2,
		    num_display_entries: 10,
		    callback: pageselectCallback,
		    items_per_page:_per_page,
		    prev_text: "前一页",
			next_text: "后一页"
		});
	}
	$(".inviteRid").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$(".searchFrom").hide();
		$(".tab").hide();
		$(".tab_item").hide();
		$(".addbtn").hide();
		$('.hiddenDiv4').show();
		var rid=$(this).attr("rid");
		$.getJSON("userActivityManage.php?pageInit_rid="+rid, function(data){
			$(".doInvite_rid").val(data.activityId);
			men_total=data.men_total;
	        _per_page=data.men_per;
			pageInit(men_total,_per_page,pageselectCallback);
		});
	});
	var selectids=new Array();
	$(".selecteach").live("click",function(){
		if(this.checked) selectids.push($(this).val());
    });
	function pageselectCallback(page_index, jq){
		var _features=getFeatures();
		$.post("userActivityManage.php", 
				{ doAPage:"true",
			      page_index:page_index,
			      activityId:$(".doInvite_rid").val(),
			      nickname:$(".nickname").val(),
			      serviceteamid:$(".serviceteamid").val(),
			      features:_features
			     },function(data){
			    	 var _th=$(".menTable tr:eq(0)");
					 $(".menTable").empty().append(_th);
					 for (var x in data){
				     	  var checkedstr="";
				          for(var j=0;j<selectids.length;j++) {
				          	 if(data[x].recordid==selectids[j]) {checkedstr=" checked='checked' ";break; }
				     	   }
						  var _html="<tr><td class='listcenter'><input type='checkbox' name='selecteach[]' class='selecteach ' value='"+data[x].recordid+"' "+checkedstr+"/></td><td style='overflow:hidden; white-space:nowrap;text-overflow:ellipsis;' title='"+data[x].name+"'>"+data[x].name+"</td><td style='overflow:hidden; white-space:nowrap;text-overflow:ellipsis;' title='"+data[x].username+"'>"+data[x].username+"</td><td style='overflow:hidden; white-space:nowrap;text-overflow:ellipsis;' title='"+data[x].nickname+"'>"+data[x].nickname+"</td><td class='listcenter'>"+data[x].birthday+"</td><td class='listcenter'>"+data[x].sex+"</td><td>"+data[x].pnames+"</td></tr>";
						  $(".menTable").append(_html);
					  }
				},"json");
	}
	$(".doInviteCancel").click(function(){
		$('.hiddenDiv4').hide();
		$(".searchFrom").show();
		$(".tab").show();
		$(".tab_item").show();
		$(".addbtn").show();
	});
	$(".doInviteClear").click(function(){
		$(".nickname").val("");
		$(".serviceteamid").val("0");
		$(".features:checked").each(function(){$(this).removeAttr("checked");});
		$(".doInviteSearch").click();
	});
	$(".doInviteSearch").click(function(){
		var _features=getFeatures();
		$.post("userActivityManage.php", 
				{ doInviteSearch:"true",
				  activityId:$(".doInvite_rid").val(),
				  nickname:$(".nickname").val(),
				  serviceteamid:$(".serviceteamid").val(),
				  features:_features
			     },function(data){
			    	men_total=data.men_total;
					pageInit(men_total,_per_page,pageselectCallback);
		},"json");
	});
	$(".selectall").live("click",function(){
		 if($(".selectall").attr("checked")=="checked") $(".selecteach").each(function(){$(this).attr("checked","checked");});
		 else $(".selecteach").each(function(){$(this).removeAttr("checked");});
	});
	$(".doInviteMsg").click(function(){
		   var aid=$(".doInvite_rid").val();
			//var _recd="";
			//$(".selecteach").each(function(){if($(this).attr("checked")=="checked") _recd+=$(this).val()+",";});
			var _recd=selectids.join(",");
			if(_recd=="") {
				ui.error("请至少选择一个");
			}else {
				$.getJSON("userActivityManage.php?aid="+aid+"&_recd="+_recd, function(data){
					ui.success("邀请成功！");
					$('.hiddenDiv4').hide();
					$(".searchFrom").show();
					$(".tab").show();
					$(".tab_item").show();
					$(".addbtn").show();
				});
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