<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />

<link type="text/css" rel="stylesheet" href="templates/css/userActivityTotalnums.css"/>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
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
		
				<div style="margin-bottom:10px;margin-top:10px;">
					<a href="javascript:void(0);" class="btn addin" name="addin" >批量通过</a>
					<a href="javascript:void(0);" class="btn refuse" name="refuse">批量拒绝</a> 
					<a href="userActivityManage.php?<?php $infos['tag']=3;echo "info=".set_url($infos);?>" class="btn" name="refuse" >返回</a>
				</div>
				
				<table class="list-table table" cellspacing="1" cellpadding="2">
				<tr><th width="20px" class="listcenter"><input type="checkbox" value="" id="check_box"  onclick="selectall('pid[]');" /></th><th width="100px" class="listcenter">志愿者姓名</th><th width="30px" class="listcenter">性别</th><th width="90px" class="listcenter">出生日期</th><th class="listcenter">特长</th><th width="90px" class="listcenter">报名时间</th><th width="100px" class="listcenter">操作</th></tr>
				<?php foreach($tnum as $k=>$val ){?>
						<tr><td><input type="checkbox" name="pid[]"   value="<?php echo $val['recordID'];?>" /></td><td class="tda" title="<?php echo $val[name];?>"><?php echo $val[name];?></td><td class="listcenter"><?php echo $val[sex]=='1'?'男':'女';?> </td><td class="listcenter"><?php echo date("Y-m-d",$val[birthday]);?></td><td class="tda" title="<?php echo $val[skillnames];?>"><?php echo $val['skillnames'];?></td><td class="listcenter"><?php echo date("Y-m-d",$val[addDate]);?></td><td class="listcenter"><a href="userActivityManage.php?act=pass&recordid=<?php echo set_url($val['recordID']);?>" >通过</a>&nbsp;&nbsp;<a href="userActivityManage.php?act=refu&recordid=<?php echo set_url($val['recordID']);?>" >拒绝</a></td></tr>
				<?php } if(!$tnum){?>	<tr><td colspan='7'>查无数据</td></tr><?php }?>	
			</table>
			
			 <?php include 'page.php'?>
		</div>
		
	</div>

</div>
</div>
</div>
<script type="text/javascript">
function selectall(name) {
	if ($("#check_box").is(':checked')==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}	

function getselectnums(name) {
	var nums=new Array();
	$("input[name='"+name+"']").each(function() {
		if(this.checked==true) nums.push($(this).val());
	});
	return nums;
}

$(document).ready(function(){
	$(".addin").click(function(){
		var nums=getselectnums("pid[]");
		if(nums.length==0) ui.error("请至少选择一个");
		else location.href="userActivityManage.php?act=addin&rids="+nums;
	});
	$(".refuse").click(function(){
		var nums=getselectnums("pid[]");
		if(nums.length==0) ui.error("请至少选择一个");
		else location.href="userActivityManage.php?act=refuse&rids="+nums;
	});
});
</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>