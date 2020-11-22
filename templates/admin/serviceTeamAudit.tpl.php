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
	    				<td class="listright "  width="80">申请日期起：</td>
	    				<td width="140"><input type="text" name="foundingtime_start" class="input" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $gets['foundingtime_start'];?>" id="foundingtime_start" /></td>
	    				<td class="listright" width="80">申请日期止：</td>
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
    					<a href="serviceTeamAudit.php" class="btn" role="button"><span class="add"></span>重置</a></td>
    				</tr>
    			</table>
                </div>
  			</fieldset>
		</form>
</div>
<div class="service_middle">
	<form name="myform" id="myform" action="" method="post" >
<?php if ($now_flag) {?>
 <table class="refuse_table">
        <tr>
        	<td width="880" align="right">
			<input type="hidden"name="act" value="yes"/>
			<button class="yesbtn" type="submit"  id="yes" >批量通过</button>&nbsp;&nbsp;<input type="button" name="doRefuse" id="doRefuse" value="批量拒绝" class="nobtn" />
                <div class="refuse_fa">
                        	<div class="refuse_so">
                            	<div class="refuse_ch">
                                	<table class="refuse_tab2">
                                    	<tr>
                                        	<td width="90" align="right"><img src="../templates/images/exclamation.png" alt="" title="" /></td>
                                        	<td align="left" width="200"><span class="refuse_big">请选择不通过原因</span></td>
                                        </tr>
                                    	<tr>
                                        	<td width="90" align="right">原因：</td>
                                            <td align="left" width="200">
                                            	<select name="nopass" id="nopass" class="select length_2">
                                                	<option value="">请选择</option>
                                                    <?php foreach($reason as $v) { ?>
                                                    <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                                                    <?php } ?>
                                                </select>&nbsp;&nbsp;<span style="color:red;">*</span>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="90" align="right">备注：</td>
                                            <td width="200" align="left"><textarea  style="width:250px;" name="sumup" class="sumup"></textarea></td><td></td>
                                        </tr>
                                        <tr>
                                        	<td></td>
                                            <td align="left"><input type="button" class="btn doSumup" name="doSumup" value="确定" />&nbsp;&nbsp;<input type="button" class="btn doSumupCancel" name="doSumupCancel" value="关闭" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
            </td>
        </tr>
        <tr><td colspan="4"  height="1"></td></tr>
</table>
<?php }?>
<div class="tabContent">
<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
            <th width="30" align="center"><input type="checkbox" value="" id="check_box"  onclick="selectall('aid[]');"></th>
            <th align="center" width="120">服务队名称</th>
            <th align="center" width="90">负责人</th>
            <th align="center" width="110">成员数量</th>
            <th align="center" width="100">联系电话</th>
            <th align="center" width="100">申请日期</th>
            <th align="center" width="140">服务队分类</th>
            </tr>
            <?php foreach ($list as $v) {
            	$spm=array();
				$spm['id']=$v['recordid'];
				$url='serviceTeamMoreInfo.php?act=detail&spm='.set_url($spm);
            ?>
			<tr>
            <td align="center" width="30" style="margin:0;padding:0;"><input type="checkbox" name="aid[]"   value="<?php echo $v['recordid'];?>"></td>
            <td align="left" width="120" class="omit1"><a href="<?php echo $url;?>" style="text-decoration:none; color:red;" title="<?php echo $v['serviceteamname'];?>"><?php echo $v['serviceteamname'];?></a></td>
            <td align="left" width="90" class="omit2"><a title="<?php echo $v['responsibleperson'];?>"><?php echo $v['responsibleperson'];?></a></td>
            <td align="center" width="110"><?php echo $v['passNum'] ?  $v['passNum'] :  '暂无';?></td>
            <td align="center" width="100"><?php echo $v['telephones'];?></td>
          	<td align="center" width="100"><?php echo $v['audittime'];?></td>
          	<td align="center" width="140"><input type="text" name="skill" value="<?php echo $v['skill'];?>"  class="input" readonly="readonly" /></td>

            </tr>
            <?php } if(!$list){?><tr><td colspan='8'>查无数据</td></tr><?php }?>
		</table>
        </div>
         
       <table width="750"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
</form>
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

$(function(){ 
		   
	$("#search_btn").click(function(){
		$("#hid_abs").show();
	});
	$("#hid_btn").click(function(){
		$("#hid_abs").hide();
	});
	
	$('#yes').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
				if(this.checked==true)falg=false;
		   });	
			if(falg){
				ui.error('请选择服务队！');
				return false;
			}	
	});	
	
	$("#myform").submit(function(){
		var start_time = $("#foundingtime_start").val();
		var stop_time = $("#foundingtime_stop").val();
		
		if (compareDate(start_time,stop_time)) {
				ui.error("申请日期起不能大于申请时间止！");
				return false;	
		}
		
	});
	
	$("#doRefuse").click(function(){	
		var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
				if(this.checked==true)falg=false;
		   });	
			if(falg){
				ui.error('请选择服务队！');
				return false;
			}
		$(".refuse_so").show();

	});
	
function jump() {
	location.href ="serviceTeamAudit.php";	
}	
$(".doSumup").click(function(){
	var nopass = $("#nopass").val();
	var sumup = $(".sumup").val();
	var sid = "";	
	if (!nopass) {
		ui.error('请选择原因！');
		return false;
	}

	$("input[name='aid[]']").each(function() {							   
			if(this.checked==true){
				falg=false;
				sid+="^"+$(this).val();	
			}
	});
	
	if (nopass) {
			$.post("serviceTeamAudit.php", 
					{ doSumup:"true",
					  sumup:sumup,
					  nopass:nopass,
					  sid:sid
					 },function(data){
						 if(data.result=="yes") {
							 $(".refuse_so").hide();
							 ui.success("批量拒绝成功！");
							 setInterval(jump,3500);
						 }
						else ui.error("批量拒绝失败,请重试尝试！");
			},"json");
		}
	});

	
	$(".doSumupCancel").click(function(){
		$(".refuse_so").hide();
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