<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
<style type="text/css">
.listright{text-align:right;}
</style>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>

<div class="adm_con">
		<table class="base_table"  cellspacing="1" cellpadding="2" style="table-layout:fixed;width:100%;">
        <tr>
        <td width="112" class="listright">活动名称：</td>
        <td colspan="5"><?php echo $detail['activityName'];?></td>
        </tr>
         <tr>
        <td  class="listright">计划人数：</td>
        <td width="80"><?php echo $detail['planNum'];?></td>
         <td width='112' class="listright">活动时间：</td>
        <td  colspan="3"><?php echo date('Y-m-d H:i',$detail['activityStartDate']);?>&nbsp;至&nbsp;<?php echo date('Y-m-d H:i',$detail['activityEndDate']);?></td>
        </tr>
         <tr>
         <td class="listright">活动时长：</td>
         <td ><?php echo $detail['activitytime'];?>&nbsp;小时</td>
        <td class="listright">活动地点：</td>
        <td colspan="3"><?php echo $detail['activityAddr'];?></td>
        </tr>
        <tr>
        <td  class="listright">创建时间：</td>
         <td ><?php echo date('Y-m-d H:i',$detail['creattime']);?></td>
         <td class="listright">报名截止时间：</td>
         <td colspan="3"><?php echo date('Y-m-d H:i',$detail['signUpDeadline']);?></td>
        </tr>
        <tr>
        <td class="listright"  >预计志愿服务时间：</td>
        <td><?php echo $detail['predictHour'];?>&nbsp;小时</td>
        <td class="listright">服务队：</td>
         <td colspan="3"><?php echo $detail['serviceteamname'];?></td>
        </tr>
        <td class="listright">预算经费：</td>
        <td><?php echo $detail['actysmoney']?$detail['actysmoney'].'元':"未填写";?></td>
        <td class="listright">受益人次：</td>
        <td colspan="3"><?php echo $detail['actysobjnum']."&nbsp;人";?></td>
        </tr>
         <tr>
          <td class="listright"><font color="#FF0000">参加活动要求:</font></td>
          <td colspan="5"><?php echo $detail['remarks'];?> </td>
        </tr>
         <tr>
          <td class="listright"><font color="#FF0000">活动简介:</font></td>
          <td colspan="5"><?php echo $detail['activityProfile'];?> </td>
        </tr> 
        <tr>
          <td class="listright"><font color="#FF0000">活动照片:</font></td>
          <td colspan="5"><img src="<?php echo "../".$detail['imgpath'];?>" style="width:250px;height:150px;"/> </td>
        </tr> 
        <tr class="hid1" style="display:none">
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000" >通过原因:</font></font></td>
          <td colspan="3"><select name="statusreason" class="statusreason1"  ><?php foreach($detail['type1'] as $k=>$v) { echo "<option value='$v[id]'>$v[name]</option>"; } ?></select></td>
        </tr>
        <tr class="hid1" style="display:none">
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000" >通过备注:</font></font></td>
          <td colspan="3"><textarea name="statusremark" class="statusremark1"  rows="4" cols="79"><?php echo $detail['statusremark'];?></textarea></td>
        </tr >
        <tr class="hid2" style="display:none">
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000" >拒绝原因:</font></font></td>
          <td colspan="3"><select name="statusreason" class="statusreason2"  ><?php foreach($detail['type2'] as $k=>$v) { echo "<option value='$v[id]'>$v[name]</option>"; } ?></select></td>
        </tr>
        <tr class="hid2" style="display:none">
          <td class="listright"> <font >拒绝备注:</font></font></td>
          <td colspan="3"><textarea name="statusremark" class="statusremark2"  rows="4" cols="79"><?php echo $detail['statusremark'];?></textarea></td>
        </tr >
        <?php if($detail['status'] == 3 or $detail['status'] == 4  or $detail['status'] == 5 ) {?>
        <tr >
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">通过原因:</font></td><td colspan="3"><div style="word-wrap:break-word;word-break:break-all;"><?php echo $detail["statusreasontext"] ?></div></td>
        </tr >
        <tr >
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">通过备注:</font></td><td colspan="3"><div style="word-wrap:break-word;word-break:break-all;"><?php echo $detail["statusremark"] ?></div></td>
        </tr >
        <?php } else if( $detail['status'] == 6 ) { ?>
         <tr >
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">拒绝原因:</font></td><td colspan="3"><div style="word-wrap:break-word;word-break:break-all;"><?php echo $detail["statusreasontext"] ?></div></td>
        </tr > 
        <tr >
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">拒绝原因:</font></td><td colspan="3"><div style="word-wrap:break-word;word-break:break-all;"><?php echo $detail["statusremark"] ?></div></td>
        </tr >
        <?php } ?> 
        </table>
        <table>
        <tbody><tr>
        <td style="width:400px;"></td>
         <td><a href="<?php echo $backurl;?>" class="btn">返回</a></td>
          <td width="10"></td>
        <td><?php if($now_flag) {if($detail['status']==2 && $detail['delTag']=='0') {?><button class="yesbtn" id="yesbtn" type="button">通过</button><?php }}?></td>
        <td width="10"></td>
         <td><?php if($now_flag) {if($detail['status']==2 && $detail['delTag']=='0') {?><button class="nobtn" id="nobtn" type="button">拒绝</button><?php }}?></td>
        </tr>
        <tr><td colspan="4"  height="1"></td></tr>
        </table>
		</div>


<script type="text/javascript">
$(function(){
 
    var isyes=false;
    var isno=false;
	$('#yesbtn').click(function(){	
        if(!isyes){
            isyes=true;
            $('#nobtn').hide();
            $(".hid2").hide();
            $(".hid1").show();
        }else{
            setstatus('yes',1);
        }
											
	});
	$('#nobtn').click(function(){
		if(!isno){
            isno=true;
            $('#yesbtn').hide();
            $(".hid1").hide();
            $(".hid2").show();
        }else{
            setstatus('no',2);
        }				
							
	});
	function setstatus(act,atype){
			var url='ajaxadmin.php';  
	
			$.ajax({
			    type:'POST',
			    dataType:'json',
			    url:url,
			    cache:false,
			    data:{act:act,id:<?php echo $detail['recordid']?>,statusreason:$(".statusreason"+atype).val(),statusremark:$(".statusremark"+atype).val()},
		      success:function(data){
    		    if(data.status=='y'){
    				    ui.success(data.mes);
					  }else{
				        ui.error(data.mes);	
					  }								
    				setTimeout("location.href='activity.php'",3000);									
          }
		   });
    }
})

</script>


         
      
      






</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>