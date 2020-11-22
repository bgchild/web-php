<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />

<link type="text/css" rel="stylesheet" href="templates/css/userActivityDetail.css"/>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>

<link rel="stylesheet" href="include/keditor/themes/default/default.css" />
<link rel="stylesheet" href="include/keditor/plugins/code/prettify.css" />
<script charset="utf-8" src="include/keditor/kindeditor-min.js"></script>
<script charset="utf-8" src="include/keditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="include/keditor/plugins/code/prettify.js"></script>

<script  type="text/javascript"   src="templates/js/common_table.js"></script>
<style type="text/css">
.listright{text-align:right;}
.listleft{text-align:left;}
.listcenter{text-align:center;}
.table {table-layout:fixed;}
.tda{display:block;overflow:hidden; white-space:nowrap;text-overflow:ellipsis;}
</style>

</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
	
		<div class="activityAddDiv">
			
			<table class="activityAddTable table">
				<tr>
					<td class="listright" width="110px">活动名称：</td><td width="260px"><?php echo $one['activityName'];?></td>
					<td width="110px" class="listright">活动类型：</td><td ><?php foreach($types as $k=>$v) { if( $one['activityType']==$v['id']) echo $v['name'];}?></td>
				</tr>
				<tr>
					<td class="listright" >活动地点：</td><td ><?php echo $one['activityProvinceName'].$one['activityCityName'].$one['activityAreaName'].$one['activityAddr']; ?></td>
					<td class="listright">计划人数：</td><td ><?php echo $one['planNum'];?></td>
				</tr>
				<tr>
					<td class="listright" >预计志愿服务时间：</td><td ><?php echo $one['predictHour'];?>&nbsp;小时</td>
					<td class="listright">活动时长：</td><td ><?php echo $one['activitytime'];?>&nbsp;小时</td>
				</tr>
				<tr>
					<td class="listright" >活动时间：</td><td ><?php echo date("Y-m-d H:i:s",$one['activityStartDate']);?>&nbsp;至&nbsp;<?php echo date("Y-m-d H:i:s",$one['activityEndDate']);?></td>
					<td class="listright">创建时间：</td><td ><?php  echo trim($one['creattime'])?date("Y-m-d H:i:s",$one['creattime']):"";?></td>
				</tr>
				<tr>
					<td class="listright" >报名截止时间：</td><td><?php echo date("Y-m-d H:i:s",$one['signUpDeadline']);?></td>
					<td class="listright">服务队：</td><td><?php foreach($teams as $k=>$v) { if( $one['serviceid']==$v['recordid']) echo $v['serviceteamname'];}?></td>
				</tr>
				<tr>
					<td class="listright" >预算经费：</td><td><?php echo $one['actysmoney']?$one['actysmoney'].'元':"未填写";?></td>
					<td class="listright" >受益人次：</td><td><?php echo $one['actysobjnum'].'&nbsp;人';?></td>
				</tr>
				<tr>
					<td class="listright" >参加活动要求：</td><td colspan='3' ><?php echo $one['remarks']?$one['remarks']:"未填写";?></td>
				</tr>
				<tr>
					<td class="listright" >活动简介：</td><td colspan='3'><?php echo $one['activityProfile']?$one['activityProfile']:"未填写";?></td>
				</tr>
				<tr>
					<td class="listright" >活动附件：</td><td colspan='3'><?php if($one['filename']) {?><a href="userActivityManage.php?filepath=<?php echo $one[filepath];?>&filename=<?php echo $one[filename];?>" style="text-decoration:underline;"><?php echo $one['filename'];?></a><?php }else {echo "未上传";}?></td>
				</tr>
				<tr>
					<td class="listright" >活动图片：</td><td colspan='3'><img src="<?php echo $one['imgpath']?>" style="width:250px;height:150px;"/></td>
				</tr>
				<tr>
					<td></td><td colspan="3"><a href="<?php echo $msgurl;?>" class="btn">返回</a></td>
				</tr>
			</table>

		</div>
		
	</div>

</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
</body>
</html>