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
<script  type="text/javascript" src="../templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="../include/keditor/kindeditor-min.js"></script>
<style type="text/css">
.listright{text-align:right;}
.table {table-layout:fixed;width:100%;}
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
		<table class="base_table table"  cellspacing="1" cellpadding="2">
        <tr>
        <td colspan="1" class="listright">志愿者编码：</td>
        <td colspan="3"><input type="text" name="hnumber" class="input" style=" width:200px;" id="hnumber" value="<?php echo $detail['hnumber'];?>"></input></td>
        <td width="270" rowspan="7" colspan='2' style="text-indent:70px;"><img src="<?php if($detail['head']) echo '../'.$detail['head'];else echo '../templates/images/face.jpg'?>" width="180" height="200"/></td>
        </tr>
        <tr>
         <td width="100" class="listright">用户名：</td>
        <td width="120"><?php echo $detail['username'];?></td>
        <td width="100" class="listright">姓名：</td>
        <td ><input type="text" name="name" class="input" style=" width:200px;" id="name" value="<?php echo $detail['name'];?>"></input></td>
        </tr>
        <tr>
        <td class="listright">昵称：</td>
        <td ><?php echo $detail['nickname'];?></td>
        <td class="listright">性别：</td>
        <td ><?php echo $detail['sex']=='1'?'男':'女';?></td>
        </tr>
        <tr>
        <td class="listright">出生日期：</td>
        <td >
        <?php echo date('Y-m-d',$detail['birthday']);?>
        </td>
        <td  class="listright">服务时间：</td>
        <td ><?php echo $detail['allservertime'];?></td>
        </tr> 
        <tr>
        <td class="listright">申请时间：</td>
        <td >
        <input type="text" name="applytime" id="applytime" class="input" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo date('Y-m-d H:i',$detail['applytime']);?>"  readonly="readonly"/>
        </td>
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
        <td class="listright">电子邮箱：</td>
        <td><?php echo $detail['emails'];?></td>
        </tr>
        <tr>
        <td class="listright">毕业院校：</td>
        <td ><?php echo $detail['graduatecollege'];?></td>
        <td  class="listright">专业：</td>
        <td><?php echo $detail['major'];?></td>
        <td  class="listright" >最高学位：</td>
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
        <tr>
        <td class="listright" >相关资料：</td>
        <td colspan="3"><a href="volunteer.php?down=<?php echo $detail['moduleName'];?>&filename=<?php echo $detail[filename];?>" style="text-decoration:underline;"><?php echo $detail['filename'];?></a></td>
        <td></td>
        <td></td>
        </tr>
        <?php if($detail['status']=='100') {?>
        <tr>
        <td class="listright" >注销原因：</td>
        <td colspan="3"><?php 
            $reasons=split("\|\|\|\|", $detail['logoutedreason']);
            foreach($reasons as $reason) {
                echo " • ".$reason."<br />";
            }
        ?></td>
        <td></td>
        <td></td>
        </tr>
        <?php }?>
         <tr class="hid" style="display:none">
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">初审拒绝原因：</font></font></td><td colspan="5"><textarea name="refusedreason" class="refusedreason"  rows="4" cols="79"></textarea></td>
        </tr >
         <tr class="hid" style="display:none">
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">初审拒绝备注：</font></font></td><td colspan="5"><textarea name="refusedremark" class="refusedremark"  rows="4" cols="79"></textarea> </td>
        </tr >  
        <?php if($detail['status']=='011') {?>
        <tr >
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">初审拒绝原因：</font></td><td colspan="5"><div style="word-wrap:break-word;word-break:break-all;"><?php echo $detail["refusedreason"] ?></div></td>
        </tr >
         <tr >
          <td class="listright"><font color="#ff0000">*</font> <font color="#FF0000">初审拒绝备注：</font></td><td colspan="5"><div style="word-wrap:break-word;word-break:break-all;"><?php echo $detail["refusedremark"] ?></div></td>
        </tr > 
        <?php }?>
        </table>
        <table>
        <tbody><tr>
        <td style="width:460px;"></td>
        <?php if ($now_flag) {?>
         <td>
            <input type="hidden" name="recordid" id="recordid" value="<?php echo $detail['recordid'];?>"/>
            <input type="button" id="repassword" value="重置密码" class="btn"/>
         	<input type="button" id="saveinfo" value="保存" class="btn"/>

         </td>
          <?php } ?>
         <td><a href="<?php echo $backurl;?>" class="btn">返回</a></td>
         <?php if ($now_flag) {?>
         <?php if($detail['status']=='001') {?>
          <td width="10"></td>
        <td><button class="yesbtn" id="yesbtn2" type="button">通过终审</button></td>
        <?php } else if($fromurl=='volunteer') {?>
          <td width="10"></td>
        <td><?php if($detail['status']=='1000') {?><button class="yesbtn" id="yesbtn" type="button">初审通过</button><?php }?></td>
        <td width="10"></td>
         <td><?php if($detail['status']=='1000') {?><button class="nobtn" id="nobtn" type="button">初审拒绝</button><?php }?></td>
        <?php }?>
        <?php }?>
        </tr>
        <tr><td colspan="4"  height="1"></td></tr>
        </table>
		</div>


<script type="text/javascript">

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
function trimValue(objUserName){
    var reg = /^\s*(\S+)\s*$/;
    if(reg.test(objUserName)){
      //如果用户输入的内容,开头或结尾带有空格,则将空格去掉
      return  RegExp.$1;    
    }else{
      return "";
    }
}

$(function(){
    $("#repassword").click(function(){
        if(confirm("确定要重置密码？"))
            location.href="volunteerManage.php?act=repassword&id="+$("#recordid").val();
    });
	$('#yesbtn').click(function(){	
			setstatus('yes');							
	});
    var first=true;
	$('#nobtn').click(function(){
                var refusedreason=trimValue($(".refusedreason").val());
                var refusedremark=trimValue($(".refusedremark").val());
                if(first){
                    $(".hid").show();
                    $(".yesbtn").hide();
                    first=false;
                }else if(refusedreason=="" ){
                    ui.error("初审被拒原因不能为空格");
                    $(".refusedreason").focus();
                }else if(refusedremark==""){
                    ui.error("初审被拒备注不能为空格");
                    $(".refusedremark").focus();
                }else if(getLength($(".refusedreason").val())>1000){
                    ui.error("初审被拒原因过长！");
                    $(".refusedreason").focus();
                }else if(getLength($(".refusedremark").val())>1000){
                    ui.error("初审被拒备注过长！");
                    $(".refusedremark").focus();
                }else{
                    setstatus('no');  
                }				
							
	});
	function setstatus(act){
			var url='volunteer.php';  					
			$.ajax({
				   type:'POST',
				   dataType:'json',
				   url:url,
				   cache:false,
				   data:{saveact:act,id:<?php echo $detail['recordid']?>,refusedreason:$(".refusedreason").val(),refusedremark:$(".refusedremark").val()},
			        success:function(data){
			        if(data.status=='y'){
						ui.success(data.mes);
						}else{
						ui.error(data.mes);	
						}								
						setTimeout("location.href='volunteer.php'",3000);								
	          }});
		
		}   
		   
	$('#yesbtn2').click(function(){    
            setstatus2('yes');                            
    });
    function setstatus2(act){
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

    $("#saveinfo").click(function(){
    	var url='volunteerManage.php';        
    	var hnumber = $("#hnumber").val();      
    	var applytime = $("#applytime").val();       
    	var  recordid = $("#recordid").val();
        var  name = $("#name").val();
        if(!name){ui.error("姓名不能为空！"); $("#name").focus();}
        if(!hnumber){ui.error("编码不能为空！"); $("#hnumber").focus();}
        if(!applytime){ui.error("申请时间不能为空！"); $("#applytime").focus();}
        if(!name || !hnumber || !applytime){return false;}
        $.ajax({
               type:'POST',
               dataType:'json',
               url:url,
               cache:false,
               data:{saveact:'editBasicinfo',id:recordid,hnumber:hnumber,applytime:applytime,name:name},
                success:function(data){
                if(data.status=='y'){
                    ui.success(data.mes);
                    }else{
                    ui.error(data.mes);
                    return false; 
                    }
                setTimeout("location.href='volunteer.php'",3000);                                                                     
          }});
    });

});

</script>


         

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>