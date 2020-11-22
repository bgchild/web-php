<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description"
	content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/userBasIcinfo.css" />
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
<div class="u_title">用户信息</div>
<form method="post" action="userBasicInfo.php" enctype="multipart/form-data" id="basicinfo">
<table class="table1">
<tr>
		<td align="right">用户名：</td>
		<td><?php echo $info['username'];?></td>
		<td align="right">性别：</td>
		<td><input type="radio" name="user[sex]" disabled="disabled" value="1"
		 checked="checked"  /> 男 <input
			type="radio" name="user[sex]" value="2"
			<?php if ($info['sex']=='2'){?> checked="checked" <?php }?> disabled="disabled" /> 女</td>
</tr>
<tr>
		<td align="right">昵称：</td>
		<td><input type="text" class="input length_2" name="user[nickname]"
			value="<?php echo $info['nickname']?>" /></td>
		<td align="right">姓名：</td>
		<td><input type="text" class="input length_2" name="name"
			value="<?php echo $info['name']?>" disabled="disabled" /></td>
</tr>
<tr>
		<td align="right">政治面貌：</td>
		<td><select class="select_2" name="user[politicalstatus]">
				<?php foreach ($politicalstatus as $val){ ?>
	            <option value="<?php echo $val[id]?>"<?php if($info[politicalstatus]== $val[id])echo "selected" ?>>
	            <?php echo $val[name]?></option>
	            <?php }?>
		       </select>
		</td>
		<td align="right">出生日期：</td>
		<td><input type="text" name="birthday"  class="input length_2"  readonly="readonly" value="<?php echo date("Y-m-d",$info['birthday'])?>"/><span class="notnull">*</span></td>
</tr>
<tr>
		<td align="right">证件类型：</td>
		<td><select name="idtype" class="select_2" disabled="disabled">
			  <?php foreach ($idtype as $val){?>
			  <option value="<?php echo $val[id]?>" <?php if($info[idtype]== $val[id])echo "selected" ?>>
			  <?php echo $val[name]?></option>
			  <?php }?>
		</select></td>
		<td align="right">民族：</td>
		<td><select class="select_2" name="user[race]">
            <?php foreach ($race as $val){ ?>
            <option value="<?php echo $val[id]?>"<?php if($info[race]== $val[id])echo "selected" ?>>
            <?php echo $val[name]?></option>
            <?php }?>
</select></td>
</tr>
<tr>
		<td align="right">证件号码：</td>
		<td><input type="text" class="input length_3" name="idnumber"
			value="<?php echo $info['idnumber']?>" disabled /></td>
			<td align="right">固定电话：</td>
		<td><input type="text" class="input length_3" name="user[telephone]"
			value="<?php echo $info['telephone']?>" /></td>		
</tr>
<tr><td align="right">服务地：</td>
    <td>
        <ul>
            <li><select name="fwprovince" id="fwprovince">
                    <?php  foreach ($province as  $pro){?> <option value="<?php echo $pro['areaId'];?>"
                        <?php if($pro['areaId']===$info['serveprovince'])echo 'selected';?> ><?php echo $pro['areaName'];?></option>
                    <?php }?>
                </select></li>
            <li id="fwcitydiv">
                <select name="fwcity" id="fwcity" <?php if(!$fwcity) echo "style=display:none"?>>
                    <?php foreach ($fwcity as $cit) {?>
                        <option value="<?php echo $cit['areaId'];?>"
                            <?php if($cit['areaId']===$info['servecity'])echo 'selected';?> ><?php echo $cit['areaName'];?>
                        </option>
                    <?php }?></select></li>
            <li id="fwareadiv"><select name="fwarea" id="fwarea" <?php if(!$fwarea) echo "style=display:none"?>>
                    <?php foreach ($fwarea as $val) {?>
                        <option value="<?php echo $val['areaId'];?>"
                            <?php if($val['areaId']===$info['servearea']) echo 'selected';?> ><?php echo $val['areaName'];?>
                        </option>
                    <?php }?>
                </select></li><span class="notnull" style="padding-left:0px">*</span></ul>
    </td>
    <td align="right">手机：</td>
    <td><input type="text" class="input length_3" name="user[cellphone]"
               value="<?php echo $info['cellphone']?>" /></td>
</tr>
<tr>
		<td align="right">居住地：</td>
		<td>
<ul>
<li><select name="province" id="province">
<?php  foreach ($province as  $pro){?> <option value="<?php echo $pro['areaId'];?>"
<?php if($pro['areaId']===$info['province'])echo 'selected';?> ><?php echo $pro['areaName'];?></option>
<?php }?>
</select></li>
<li id="citydiv">
<select name="city" id="city" <?php if(!$city) echo "style=display:none"?>>
<?php foreach ($city as $cit) {?>
<option value="<?php echo $cit['areaId'];?>"
<?php if($cit['areaId']===$info['city'])echo 'selected';?> ><?php echo $cit['areaName'];?>
</option>
<?php }?></select></li>
<li id="areadiv"><select name="area" id="area" <?php if(!$area) echo "style=display:none"?>>
<?php foreach ($area as $val) {?>
<option value="<?php echo $val['areaId'];?>"
<?php if($val['areaId']===$info['area']) echo 'selected';?> ><?php echo $val['areaName'];?>
</option>
<?php }?>
</select></li><span class="notnull" style="padding-left:0px">*</span></ul>
		</td>
    <td align="right">电子邮箱：</td>
    <td><input type="text" class="input length_3" name="user[emails]"
               value="<?php echo $info['emails']?>" /><span class="notnull">*</span></td>
</tr>
<tr>
		<td align="right">详细通信地址：</td>
		<td><input type="text" class="input length_3" name="user[detailplace]"
			value="<?php echo  $info['detailplace']?>" /></td>
		<td align="right">通信邮编：</td>
		<td><input type="text" class="input length_3" name="user[postcode]"
			value="<?php echo $info['postcode']?>" /></td>
</tr>
<tr>
		<td align="right">工作单位：</td>
		<td><input type="text" class="input length_3" name="user[work]"
			value="<?php echo $info['work']?>" /></td>
		<td align="right">QQ：</td>
		<td><input type="text" class="input length_3" name="user[qq]"
			value="<?php echo $info['qq']?>" /></td>
</tr>
<tr>
<td align="right">国籍：</td>
		<td><select class="select_3" name="user[nationality]">
				<?php foreach ($nationality as $val){ ?>
	            <option value="<?php echo $val[id]?>"<?php if($info[nationality]== $val[id])echo "selected" ?>>
	            <?php echo $val[name]?></option>
	            <?php }?>
		       </select>
	  </td>
    <td align="right">身份编码：</td>
    <td><?php echo $info['hnumber']; ?>
    </td>
</tr>
<tr>
<td align="right"></td>
		<td><input type="checkbox" name="user[istrain]" value="1" <?php if($info[istrain]) echo"checked";?>/>是否参加过内部培训</td></tr>
</table>
<div class="u_title">监护人信息</div>
<table class="table2 table3">
<tr>
<td align="right">姓名：</td>
<td><input type="text" name="user[guardername]" class="input length_3" value="<?php echo $info['guardername'];?>"/></td>
</tr>
<tr>
<td align="right">联系电话：</td>
<td><input type="text" name="user[guarderphone]" class="input length_3" value="<?php echo $info['guarderphone'];?>"/></td></tr>
<tr><td align="right">身份证号：</td>
<td><input type="text" name="user[guarderidnumb]" class="input length_3" value="<?php echo $info['guarderidnumb'];?>"/></td></tr>
</table>
<div class="u_title">教育信息</div>
<table class="table3">
<tr>
<td align="right">是否是高校在校学生</td>
<td><input type="radio" name="more[isstudent]" value="1"
			 checked="checked"  />
		是 <input type="radio" name="more[isstudent]" value="2"
			<?php if ($extendinfo['isstudent']=='2'){?> checked="checked" <?php }?> />
		否</td>
</tr>
<tr>
    <td align="right">毕业高校：</td>
    <td><input type="text" name="more[graduatecollege]" class="input length_3" value="<?php echo $extendinfo['graduatecollege']; ?>"/></td>
</tr>
    <tr>    
   <td align="right">毕业院系：</td>
   <td><input type="text" name="more[major]" class="input length_3" value="<?php echo $extendinfo['major'];?>" /></td>
</tr>
<tr>
		<td align="right">最高学历：</td>
		<td><select name="more[lasteducation]" class="select_3">
				<?php foreach ($lasteducation as $val){ ?>
	            <option value="<?php echo $val[id]?>"<?php if($extendinfo[lasteducation]== $val[id])echo "selected" ?> >
	            <?php echo $val[name]?></option>
	            <?php }?>
			</select></td>
            </tr>
</table>
<div class="u_title">专业技能</div>
<table class="table4">
<tr>
<td align="right" rowspan="<?php echo ceil(count($skill)/$tdnumbs)?>">专业技能：</td>
<?php foreach($skill as $key=>$val){ ?>
<?php if(($key%$tdnumbs==0)&&($key!=0)){ echo "<tr>";}?>
<td><input type="checkbox" name="features[]" value="<?php echo $val['id'];?>" id="cate_<?php echo $val['id'];?>"
<?php if(in_array($val['id'], $skills)) echo"checked";?> /><?php echo $val['name']?></td>
<?php if (($key+1)%$tdnumbs==0){ echo "</tr>";}?>
<?php }?>
	<tr>
		<td align="right">上传相关资料：</td>
		<td colspan="<?php echo ($tdnumbs-2) ?>"><input type="file" name="filename" /></td><td><?php if($extendinfo[moduleName]) echo "<a target='_blank'  href=.$extendinfo[moduleName]>查看</a>"  ?></td>
    </tr>
</table>
<div style=" float:left; width:80%;line-height:30px; padding-left:140px;">温馨提示：只允许上传5M以内后.doc、.docx、.ppt、.xls、.xlsx、.jpg、.png、.gif、.txt的文件!</div>
<div class="u_title">志愿服务意愿项目</div>
<table class="table5">
<tr>
<td align="right" rowspan="<?php echo ceil(count($services)/$tdnumbs)?>">志愿服务意愿项目：</td>
<?php foreach($services as $key=>$item){ ?>
<?php if(($key%$tdnumbs==0)&&($key!=0)){ echo "<tr>";}?>
<td><input type="checkbox" name="serveitem[]" value="<?php echo $item['id'];?>" id="cate_<?php echo $item['id'];?>"
<?php if(in_array($item['id'], $items)) echo"checked";?> />
<?php
		if ($item ['child']) {
			echo '<span style="color:red;">', $item ['name'], '</span>';
		} else {
			echo $item ['name'];
		}
?>
<?php if ($item ['child']) {?>
 <div id="fa_<?php echo $item ['id']; ?>" style="position: relative;">
<div id="ch_<?php echo $item ['id']; ?>" class="pos_ab">
<div class="so_<?php echo $item ['id'];?>">

<?php foreach ( $item ['child'] as $calist ) {?>
 <div class="server_child"><input type="checkbox" name="serveitem[]"
				id="child_<?php
				echo $calist ['id'];
				?>"
				value="<?php
				echo $calist ['id'];
				?>" /><?php
				echo $calist ['name']?></div>
<?php }?>
<div class="server_child_btn"><input type="button" id="btn_<?php echo $item ['id'];?>" value="确定"
class="btn" childid="<?php
echo $item ['id'];
			?>" /></div>
			</div>
			</div>
			</div>    
<?php }?>
</td>
<?php if (($key+1)%$tdnumbs==0){ echo "</tr>";}?>
<?php }?>
</table>
<div class="u_title">志愿者服务时间</div>
<div class="w_time">志愿服务时间：</div>
<table class="table6" cellpadding="1" cellspacing="1">
	<tr>
		<td></td>
		<td>周一</td>
		<td>周二</td>
		<td>周三</td>
		<td>周四</td>
		<td>周五</td>
		<td>周六</td>
		<td>周日</td>
		<td>节假日</td>
	</tr>
	<tr>
		<td>上午A.m</td>
		<?php for ($i=1;$i<9;$i++){?>
		<td id="stime_<?php echo $i?>"<?php foreach ($am as $val){if($i==$val){echo "class=chose";}}?>><input type="checkbox" id="che_<?php echo $i ?>" name="am[]" value="<?php echo $i?>" <?php foreach ($am as $val){if($i==$val){echo "checked";}}?> /></td>
		<?php }?>
	</tr>
    <tr>
		<td>下午P.m</td>
		<?php for ($i=1;$i<9;$i++){?>
		<td id="stime_2<?php echo $i?>"<?php foreach ($pm as $val){if($i==$val){echo "class=chose";}}?>><input type="checkbox" name="pm[]" value="<?php echo $i?>"  <?php foreach ($pm as $val){if($i==$val){echo "checked";}}?>/></td>
		<?php }?>
	</tr>
	<tr>
		<td>晚上Night</td>
		<?php for ($i=1;$i<9;$i++){?>
		<td id="stime_3<?php echo $i?>" <?php foreach ($night as $val){if($i==$val){echo "class=chose";}}?>><input type="checkbox" name="night[]" value="<?php echo $i?>" <?php foreach ($night as $val){if($i==$val){echo "checked";}}?>/></td>
		<?php }?>
	</tr>
    
	
</table>
<input type="submit" class="t_submit" name="dosubmit" value="保存" /></form>
</div>

</div>
</div>
</div>
<script type="text/javascript">
$(function(){
    $('#fwprovince').change(function(){
        var provinceid =$('#fwprovince').val();
        $.ajax({
            type:'get',
            url:'ajax.php',
            dataType:'json',
            cache: false,
            data:{provinceid:provinceid,act:'fwprovinceid'},
            success:function(msg){
                var m = msg.mes.split("|");
                $('#fwcitydiv').html(m[0]);
                $('#fwareadiv').html(m[1]);
                if(msg.status) $('#fwarea').remove();
            }
        });
    });
    $('#fwcity').live('change',fwcity);
    function fwcity(){
        var cityid=$('#fwcity').val();
        $.ajax({
            type:'get',
            url:'ajax.php',
            dataType:'json',
            cache: false,
            data:{cityid:cityid,act:'fwcityid'},
            success:function(msg){
                $('#fwareadiv').html(msg.mes);
            }
        });
    }
$('#province').change(function(){
 var provinceid =$('#province').val();
	$.ajax({
		   type:'get',
		   url:'ajax.php',
		   dataType:'json',
		   cache: false,
		   data:{provinceid:provinceid,act:'provinceid',act:'provinceid'},
		   success:function(msg){
	       var m = msg.mes.split("|");
	       $('#citydiv').html(m[0]);
           $('#areadiv').html(m[1]);
		   if(msg.status) $('#area').remove();
			   }
		   });
});	
//
$('#city').live('change',city);
function city(){
var cityid=$('#city').val();
$.ajax({
type:'get',
url:'ajax.php',
dataType:'json',
cache: false,
data:{cityid:cityid,act:'cityid'},
success:function(msg){
$('#areadiv').html(msg.mes);
	
}
	
});
}
//服务类别
$("input[id^='cate']").click(function(){
	var cate_id = $(this).val();
	if ($("#cate_"+cate_id).attr("checked")) {
        $("#ch_"+cate_id).show();
    }else if(!$("#cate_"+cate_id).attr("checked")){
        $("#ch_"+cate_id).hide();
		$(".so_"+cate_id).find('input:checkbox').each(function(){
				$(this).attr('checked',false);
		});
    }
});
//子类选择确定按钮
$("input:button[id^='btn']").click(function(){
		var childid = $(this).attr('childid');
		var i = true;
		$(".so_"+childid).find('input:checkbox').each(function(){
				
			 if($(this).is(":checked")==true){
					i=false;
				}
			
		});

		if(i)$("#cate_"+childid).attr("checked",false) ;
		 $("#ch_"+childid).hide();
});

//服务时间
$("td[id^='stime']").click(function(){
if($(this).hasClass("chose")){
 $(this).removeClass("chose");
 $(this).find("input").attr("checked", false);   
}else{
 $(this).addClass("chose");
 $(this).find("input").attr("checked", true); 
}
});

//修改验证
$('#basicinfo').submit(function(){
	  //昵称
var nickname=$("input[name='user[nickname]']") .val().replace(/[ ]/g,"");
if(nickname.length>20){ui.error('输入昵称过长'); return false;}
	 //邮箱
     var emails=$("input[name='user[emails]']") .val();
  if(!/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/.test(emails)){ui.error('邮箱格式不合法'); return false;}
     //出生日
     var birthday=$("input[name='birthday']") .val();
	 if(!birthday){ui.error('出生日期不能为空');  return false;}
	      if(birthday){
         var arr = birthday.split("-");
		 var atime = new Date(arr[0], arr[1], arr[2]);
		 var atimes = atime.getTime();
         var now = new Date();
         var year = now.getFullYear();       //年
         var month = now.getMonth() + 1;     //月
         var day = now.getDate();            //日
		 var btime = new Date(year,month,day);
		 var btimes = btime.getTime();
         if(atimes>=btimes){ui.error('输入出生日期有误'); return false;}}
 /* //手机固定电话
	var cellphone=$("input[name='user[cellphone]']") .val();
	var telephone=$("input[name='user[telephone]']") .val();
	if(!(cellphone || telephone)){ui.error('手机固定电话至少填写其中一个');  return false;}
    if(cellphone){
    if(!/^1[358]\d{9}$/.test(cellphone)){ui.error('手机号不正确');  return false; }}
	if(telephone){
    if(!/^0\d{2,3}-\d{7,8}(-\d{3,5})?$/.test(telephone)){ui.error('固定电话格式不正确'); return false;}
	}*/
	var province=$('#province').val();
    if(!province){ui.error('居住省份不能为空'); return false;}
		var detailplace=$("input[name='user[detailplace]']") .val().replace(/[ ]/g,"");
    if(detailplace.length>30){ui.error('输入详细通信地址过长'); return false;}
	var work=$("input[name='user[work]']") .val().replace(/[ ]/g,"");
    if(work.length>30){ui.error('输入工作单位地址过长'); return false;}
	//qq
	var qq=$("input[name='user[qq]']") .val();
    if(qq) if(!/^[1-9]\d{3,10}$/.test(qq)){ui.error('qq不正确'); return false;}
	//邮编
	var postcode= $("input[name='user[postcode]']") .val();
    if(postcode) if(!/^\d{6}$/.test(postcode)){ui.error('通信邮编不正确'); return false;}
	var guardername=$("input[name='user[guardername]']") .val().replace(/[ ]/g,"");
    if(guardername.length>15){ui.error('输入监护人姓名过长'); return false;}
	var guarderphone= $("input[name='user[guarderphone]']") .val();
    if(guarderphone) if(!/^\d{3,15}$/.test(guarderphone)){ui.error('监护人联系电话不正确'); return false;}
	var guarderidnumb= $("input[name='user[guarderidnumb]']") .val();
    if(guarderidnumb) if(!/^\w{18}$/.test(guarderidnumb)){ui.error('监护人身份证号码不正确'); return false;}
	var graduatecollege=$("input[name='more[graduatecollege]']") .val().replace(/[ ]/g,"");
    if(graduatecollege.length>20){ui.error('输入毕业高校过长'); return false;}
	var major=$("input[name='more[major]']") .val().replace(/[ ]/g,"");
    if(major.length>20){ui.error('输入毕业院系过长'); return false;}
	//上传文件
    var filename=$("input[name='filename']").val();
    if(filename){
    var d=/\.[^\.]+$/.exec(filename);	
    var typearr=['.docx','.ppt','.xls','.xlsx','.jpg','.png','.gif','.txt'];
    var b=false;
    for(var i=0;i<typearr.length;i++){
	if(typearr[i]==d){
		b=true;break;
		}
	}
if(!b){ui.error('上传文件格式不对，请重新上传'); return false;}
}
	}); 
});
</script>
<?php include 'footer.tpl.php'; ?>
</body>
</html>