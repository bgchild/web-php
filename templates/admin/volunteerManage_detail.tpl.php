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
		<table class="base_table"  cellspacing="1" cellpadding="2">
        <tr>
        <td width="110" class="listright">用户名：</td>
        <td width="160"><?php echo $detail['username'];?></td>
        <td width="100" class="listright">姓名：</td>
        <td width="170"><?php echo $detail['name'];?></td>
        <td width="270" rowspan="7" colspan='2' ><img src="<?php if($detail['head']) echo '../'.$detail['head'];else echo '../templates/images/face.jpg'?>" width="180" height="200"/></td>
        </tr>
        <tr>
        <td class="listright">昵称：</td>
        <td ><?php echo $detail['nickname'];?></td>
        <td class="listright">性别：</td>
        <td ><?php echo $detail['sex']=='1'?'男':'女';?></td>
        </tr>
        <tr>
        <td class="listright">出生日期：</td>
        <td ><?php echo date('Y-m-d',$detail['birthday']);?></td>
        <td  class="listright">服务时间：</td>
        <td ><?php echo $detail['allservertime'];?></td>
        </tr> 
        <tr>
        <td class="listright">申请时间：</td>
        <td ><?php echo date('Y-m-d H:i',$detail['applytime']);?></td>
        <td class="listright">申请状态：</td>
        <td >
            <?php if($detail['status']=='1000') $stu="申请";
                else if($detail['status']=='001') $stu="初审通过";
                else if($detail['status']=='011') $stu="初审被拒";
                else if($detail['status']=='010') $stu="终审通过";
                else if($detail['status']=='100') $stu="注销";
                echo '<span style="color:red;">'.$stu."</span>";
            ?>
        </td>
        </tr>
        <tr>
        <td  class="listright">证件类型：</td>
        <td ><?php echo $detail['idtype'];?></td>
        <td class="listright">证件号码：</td>
        <td ><?php echo $detail['idnumber'];?></td>
        </tr>
        <tr>
        <td  class="listright">国籍：</td>
        <td><?php echo $detail['nationality'];?></td>
        <td  class="listright">民族：</td>
        <td ><?php echo $detail['race'];?></td>
        </tr>
        <tr>
        <td  class="listright">政治面貌：</td>
        <td ><?php echo $detail['politicalstatus'];?></td>
        <td class="listright" >电子邮箱：</td>
        <td ><?php echo $detail['emails'];?></td>
        </tr>
        <tr>
        <td class="listright">毕业院校：</td>
        <td ><?php echo $detail['graduatecollege'];?></td>
        <td class="listright">专业：</td>
        <td><?php echo $detail['major'];?></td>
        <td class="listright" width="100">最高学位：</td>
        <td width="170"><?php echo $detail['lasteducation'];?></td>
        </tr>
        <tr>
        <td class="listright" >居住地：</td>
        <td colspan="3"><?php echo $detail['province']." - ".$detail['city']." - ".$detail['area'];?></td>
        <td  class="listright">是否学生：</td>
        <td ><?php echo $detail['isstudent']==1?"是":"否";?></td>
        </tr>
        <tr>
        <td class="listright">服务地点：</td>
        <td colspan="3"><?php echo $detail['serveprovince']." - ".$detail['servecity']." - ".$detail['servearea'];?></td>
        <td  class="listright">队长资质：</td>
        <td ><?php echo $detail['captainable']==1?"有":"无";?></td>
        </tr>
        <tr>
        <td class="listright" >工作单位：</td>
        <td colspan="3"><?php echo $detail['work'];?></td>
        <td class="listright">通信邮编：</td>
        <td ><?php echo $detail['postcode'];?></td>
        </tr>
        <tr>
        <td class="listright" >通信地址：</td>
        <td colspan="3"><?php echo $detail['detailplace'];?></td>
        <?php if($detail['cellphone']) {?>
        <td  class="listright">手机：</td>
        <td><?php echo $detail['cellphone'];?></td>
        <?php }else {?>
        <td  class="listright">固定电话：</td>
        <td><?php echo $detail['telephone'];?></td>
        <?php }?>
        </tr>
        <tr>
        <td class="listright" >技能特长：</td>
        <td colspan="3"><?php echo $detail['features'];?></td>
        <td  class="listright">QQ：</td>
        <td><?php echo $detail['qq'];?></td>
        </tr>
        <tr>
        <td class="listright" >服务项目：</td>
        <td colspan="3"><?php echo $detail['serveitem'];?></td>
        <td></td>
        <td></td>
        </tr>
        <?php if($detail['status']=='011'){?>   
        <tr>
          <td class="listright"><font color="#FF0000">初审拒绝原因：</font></td>
          <td colspan="5"><?php echo $detail['refusedreason'];?></td>
        </tr>
         <tr>
          <td  class="listright"><font color="#FF0000">初审拒绝备注：</font></td>
          <td colspan="5"><?php echo $detail['refusedremark'];?> </td>
        </tr>  
        <?php }else if($detail['status']=='100'){?>   
        <tr>
          <td  class="listright"><font color="#FF0000">注销原因：</font></td>
          <td colspan="5"><?php $reasons=explode("||||",$detail['logoutedreason']);foreach($reasons as $k=>$r) {$ki=$k+1;$reason.="$ki.".$r." ";}echo $reason;?></td>
        </tr> 
        <?php }?>
        </table>
        <table>
        <tbody><tr>
        <td style="width:400px;"></td>
         <td><a href="<?php echo $backurl;?>" class="btn">返回上一页</a></td>
         <?php if($detail['status']=='001') {?>
          <td width="10"></td>
        <td><button class="yesbtn" id="yesbtn" type="button">通过终审</button></td>
        <?php }?>
        </tr>
        <tr><td colspan="4"  height="1"></td></tr>
        </table>
		</div>


<script type="text/javascript">
$(function(){
 
	$('#yesbtn').click(function(){	
			setstatus('yes');			
							
	});
	function setstatus(act){
			var url='volunteerManage.php';  					
			$.ajax({
				   type:'POST',
				   dataType:'json',
				   url:url,
				   cache:false,
				   data:{saveact:act,id:<?php echo $detail['recordid']?>},
			        success:function(data){
			        if(data.status=='y'){
						ui.success(data.mes);
						}else{
						ui.error(data.mes);	
						}
                    setTimeout("location.href='volunteerManage.php'",3000);																		
	          }});
		
		}   
		   
		   
		   });

</script>


         

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>