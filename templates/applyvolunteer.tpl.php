<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/volunteer.css"/>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script type="text/javascript" src="templates/js/register.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con">
<div class="vtitle">志愿者申请</div>
<div class="require">
<h4>根据《中国红十字志愿者管理办法》，申请成为志愿者需具备以下基本条件：</h4>
<p>1、热心社会公益事业，具有"奉献、有爱、互助、进步"的志愿服务精神。</p>
<p>2、年满十四周岁(未满十八周岁的须经其法定监护人同意)。</p>
<p>3、具备参加志愿者服务所需要的基本能力和身体素质。</p>
<p>4、品行端正，遵守国家法律法规和志愿者组织的相关规定。</p>
<p>5、申请成为志愿者必须在常驻地区申请。</p>
</div>
<div class="explanation">
<h4 style=" background: #F3F3F3">&nbsp;</h4>
<p>6、热心社会公益事业，自愿帮助他人和服务社会。</p>
<p>7、年满十四周岁(未满十八周岁的须经其法定监护人同意)。</p>
<p>8、具备参加志愿者服务所需要的基本能力和身体素质。</p>
<p>9、品行端正，遵守国家法律法规和志愿者组织的相关规定。</p>
</div>
<form action="" method="post" enctype="multipart/form-data" id="volunteerinfo">
<div class="account_info">
<h4>账户信息</h4>
<table>
  <tr>
    <td class="fwidth">用户名：</td>
    <td><input type="text" name="username" value="<?php echo $_SESSION['userinfo']['username'];?>"  class="input length_3"/><span class="notnull">*</span></td>
    <td width="420">用户名只能由英文字母a~z(不区分大小写)、数字0~9、下划线组成，首字符必须是英文字母，长度为6~15个字符。<font color="red">请牢记用户名</font></td>
  </tr>
  <tr>
    <td align="right">密码：</td>
    <td><input type="password"  name="password"  class="input length_3" onblur="check_passwd()"/><span class="notnull">*</span></td>
    <td width="420">密码长度为8-20个字符，字母区分大小写。密码建议使用英文字母及数字以及特殊字符组合。<font color="red">请牢密码</font></td>
  </tr>
  <tr>
    <td align="right">密码确认：</td>
    <td><input  type="password" name="rpassword" class="input length_3"  onblur="check_passwd()"/><span class="notnull">*</span></td>
    <td>确认您的用户名输入无误</td>
  </tr>
  <tr>
    <td align="right">昵称：</td>
    <td><input type="text" class="input length_3" name="user[nickname]" value="<?php echo $_SESSION['userinfo']['user']['nickname'];?>"/><span class="notnull">*</span></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td align="right">密码提示问题：</td>
    <td><select name="user[question]" class="select_4">
			  <?php foreach ($question as $val){?>
			  <option value="<?php echo $val[id]?>">
			  <?php echo $val[name]?></option>
			  <?php }?>
		</select><span class="notnull">*</span></td>
    <td>当您忘记密码需要回答此问题取回密码。</td>
   </tr>
  <tr>
    <td align="right">密码提示答案：</td>
    <td><input type="text" name="user[passwordtip]" class="input length_4"/><span class="notnull">*</span></td>
    <td>答案长度至少为两个字符，汉字占2个字符，字母区分大小写</td>
  </tr>
  <tr>
    <td align="right">电子邮箱：</td>
    <td><input type="text" name="user[emails]" value="<?php echo $_SESSION['userinfo'][user][emails]?>"class="input length_4"/><span class="notnull">*</span></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div class="basic_info">
<h4>基本信息</h4>
<input type="hidden" id="idnumber_val" value="<?php echo $idnumber[0]['id']; ?>" />
<table>
<td class="fwidth">服务地：</td>
<td  colspan="2">
<ul>
<li>
<select name="serveprovince" id="sprovince">
<option value="">请选择</option>
<?php  foreach ($province as  $pro){?> 
<option value="<?php echo $pro['areaId'];?>" >
<?php echo $pro['areaName'];?></option>
<?php }?>
</select>
</li>
<li id="scitydiv" style="display:none"><select name="servecity" id="scity">
<?php foreach ($city as $cit) {?>
<option value="<?php echo $cit['areaId'];?>">
<?php echo $cit['areaName'];?>
</option>
<?php }?>
</select></li>
<li id="sareadiv" style="display:none"><select name="servearea" id="sarea">
<?php foreach ($area as $val) {?>
<option value="<?php echo $val['areaId'];?>" >
<?php echo $val['areaName'];?>
</option>
<?php }?>
</select></li><span class="notnull" style=" padding-left:0px;">*</span></ul>
</td></tr>
<tr><td></td><td colspan="3" style="color: red">请确认您页面上方的“切换城市”所在地与您填写的服务所在地一致</td></tr>
<!-- <tr><td class="fwidth">服务领域：</td> 
<td >--><select name="sdomain" style="display:none">
<?php foreach ($sdomain as $val) {?>
<option value="<?php echo $val[type] ?>"><?php echo $val[sdomain] ?></option>
<?php } ?>

</select></td></tr>
<tr><td class="fwidth">姓名：</td><td><input name="user[name]"  value="<?php echo $_SESSION['userinfo'][user][name]?>"type="text" class="input length_3"/><span class="notnull">*</span></td><td width="420">请严格与证件上姓名一致，中文姓名请使用汉字填写</td></tr>
<tr>
<td align="right">证件类型：</td>
<td><select name="user[idtype]" class="select_4">
			  <?php foreach ($idtype as $val){?>
			  <option value="<?php echo $val[id]?>">
			  <?php echo $val[name]?></option>
			  <?php }?>
		</select><span class="notnull">*</span></td><td width="420">请如实填写证件信息，如果证件号码已存在，请选择找回密码或联系在线服务志愿者寻求帮助</td></tr>
<tr><td align="right">证件号码：</td><td><input name="user[idnumber]" type="text" value="<?php echo $_SESSION['userinfo'][user][idnumber];?>" class="input length_4"/><span class="notnull">*</span></td><td></td></tr>
<tr>
<td align="right">性别：</td>
<td><input type="radio" name="user[sex]" value="1" checked="checked"  /> 男 
       <input type="radio" name="user[sex]" value="2" <?php if ($_SESSION['userinfo'][user]['sex']=='2'){?> checked="checked" <?php }?> /> 女<span class="notnull">*</span></td><td></td></tr>
<tr>
<td align="right">出生日期：</td>
<td colspan="2"><input type="text" name="birthday" value="<?php echo $_SESSION['userinfo'][birthday] ?>"class="input length_4" onclick="WdatePicker()"   readonly="readonly"/><span class="notnull">*</span></td></tr>
<tr>
<td align="right">政治面貌：</td>
<td colspan="2">
<select class="select_4" name="user[politicalstatus]">
				<?php foreach ($politicalstatus as $val){ ?>
	            <option value="<?php echo $val[id]?>">
	            <?php echo $val[name]?></option>
	            <?php }?>
		       </select><span class="notnull">*</span></td></tr>
<tr>
<td align="right">民族：</td>
<td  colspan="2">
<select class="select_4" name="user[race]">
            <?php foreach ($race as $val){ ?>
            <option value="<?php echo $val[id]?>">
            <?php echo $val[name]?></option>
            <?php }?>
</select><span class="notnull">*</span></td></tr>
<tr>
<td align="right">国籍：</td>
<td  colspan="2">
<select class="select_4" name="user[nationality]">
				<?php foreach ($nationality as $val){ ?>
	            <option value="<?php echo $val[id]?>">
	            <?php echo $val[name]?></option>
	            <?php }?>
		       </select><span class="notnull">*</span></td></tr>
<tr>
<td align="right">手机：</td>
<td><input type="text" name="user[cellphone]" value="<?php echo $_SESSION['userinfo'][user][cellphone]?>" class="input length_4"/></td><td>例如：13665285933。手机固定电话至少填写其中一个。</td></tr>
<tr>
<td align="right">固定电话：</td>
<td><input type="text" name="user[telephone]" value="<?php echo $_SESSION['userinfo'][user][telephone]?>" class="input length_4"/></td><td>例如：010-66886688-123或不加分机号</td></tr>
<tr>
<td align="right">QQ：</td>
<td><input type="text" name="user[qq]" value="<?php echo $_SESSION['userinfo'][user][qq]?>" class="input length_4"/></td><td></td></tr>
<tr><td align="right">居住地：</td>
<td colspan="2">
<ul>
<li><select name="province" id="province">
<option value="">请选择</option>
<?php  foreach ($province as  $pro){?> 
<option value="<?php echo $pro['areaId'];?>" >
<?php echo $pro['areaName'];?></option>
<?php }?>
</select>
</li>
<li id="citydiv"><select name="city" style="display:none" id="city">
<?php foreach ($city as $cit) {?>
<option value="<?php echo $cit['areaId'];?>">
<?php echo $cit['areaName'];?>
</option>
<?php }?>
</select></li>
<li id="areadiv"><select name="area" style="display:none" id="area">
<?php foreach ($area as $val) {?>
<option value="<?php echo $val['areaId'];?>" >
<?php echo $val['areaName'];?></option><?php }?></select></li><span class="notnull" style="padding-left:0px;">*</span></ul>
 </td></tr>
<tr><td align="right">详细通信地址：</td>
<td><input type="text" name="user[detailplace]" value="<?php echo $_SESSION['userinfo'][user][detailplace]?>"  class="input length_4"/></td><td></td></tr>
<tr>
<td align="right">通信邮编：</td>
<td><input type="text"  class="input length_4" name="user[postcode]" value="<?php echo $_SESSION['userinfo'][user][postcode]?>"/></td><td></td></tr>
<tr>
<td align="right">工作单位：</td>
<td><input type="text" class="input length_4" name="user[work]" value="<?php echo $_SESSION['userinfo'][user][work]?>"/></td><td></td></tr>
<tr>
<td align="right"></td>
<td><input type="checkbox" name="user[istrain]" value="<?php echo $_SESSION['userinfo'][user][istrain]?>" />是否参加过内部培训</td>
<td></td></tr>
</table>
</div>
<div class="guardian_info">
<h4>监护人信息</h4>
<table>
<tr>
<td class="fwidth">姓名：</td>
<td><input type="text" name="user[guardername]" value="<?php echo $_SESSION['userinfo'][user][guardername]?>" class="input length_3"/></td>
</tr>
<tr>
<td align="right">联系电话：</td>
<td><input type="text" name="user[guarderphone]"  value="<?php echo $_SESSION['userinfo'][user][guarderphone]?>"class="input length_3"/></td></tr>
<tr><td align="right">身份证号：</td>
<td><input type="text" name="user[guarderidnumb]" value="<?php echo $_SESSION['userinfo'][user][guarderidnumb]?>" class="input length_3"/></td></tr>
</table>
</div>
<div class="education_info">
<h4>教育信息</h4>
<table class="table">
<tr>
<td class="fwidth">是否是高校在校学生</td>
<td><input type="radio" name="more[isstudent]" value="1"
			 checked="checked"  />
		是 <input type="radio" name="more[isstudent]" value="2"  <?php if ($_SESSION['userinfo'][more]['isstudent']=='2'){?> checked="checked" <?php }?>/>
		否<span class="notnull">*</span></td>
</tr>
<tr>
    <td align="right">毕业高校：</td>
    <td><input type="text" name="more[graduatecollege]" value="<?php echo $_SESSION['userinfo'][more][graduatecollege]?>" class="input length_4" /></td>
</tr>
    <tr>    
   <td align="right">毕业院系：</td>
   <td><input type="text" name="more[major]" value="<?php echo $_SESSION['userinfo'][more][major]?>" class="input length_4" /></td>
</tr>
<tr>
		<td align="right">最高学历：</td>
		<td><select name="more[lasteducation]" class="select_4">
				<?php foreach ($lasteducation as $val){ ?>
	            <option value="<?php echo $val[id]?>">
	            <?php echo $val[name]?></option>
	            <?php }?>
			</select></td>
            </tr>
</table>
</div>
<div class="skill_info">
<h4>专业技能</h4>
<table class="table4">
<tr>
<td  align="right"rowspan="<?php echo ceil(count($skill)/$tdnumbs)?>">专业技能：</td>
<?php foreach($skill as $key=>$val){ ?>
<?php if(($key%$tdnumbs==0)&&($key!=0)){ echo "<tr>";}?>
<td><input type="checkbox" name="features[]" value="<?php echo $val['id'];?>" id="cate_<?php echo $val['id'];?>" />
<?php echo $val['name']?></td>
<?php if (($key+1)%$tdnumbs==0){ echo "</tr>";}?>
<?php }?>
<tr>
<td align="right">上传相关资料：</td>
<td colspan="<?php echo ($tdnumbs-1) ?>"><input type="file" name="filename"/></td>
</tr>
</table>
<div style="width:80%;line-height:30px; padding-left:180px;">温馨提示：只允许上传5M以内后.doc、.docx、.ppt、.xls、.xlsx、.jpg、.png、.gif、.txt的文件!</div>
</div>
<div class="items_info">
<h4>志愿者服务项目</h4>
<table class="table5">
<tr>
<td align="right" rowspan="<?php echo ceil(count($services)/$tdnumbs)?>">志愿服务意愿项目：</td>
<?php foreach($services as $key=>$item){ ?>
<?php if(($key%$tdnumbs==0)&&($key!=0)){ echo "<tr>";}?>
<td><input type="checkbox" name="serveitem[]" value="<?php echo $item['id'];?>" id="cate_<?php echo $item['id'];?>" />
<?php
		if ($item ['child']) {
			echo '<span style="color:black;">', $item ['name'], '</span>';
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
</div>
<div class="times_info">
<h4>志愿者服务时间</h4>
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
		<td id="stime_<?php echo $i?>"  ><input type="checkbox" id="che_<?php echo $i ?>" name="am[]" value="<?php echo $i?>"/></td>
		<?php }?>
	</tr>
    <tr>
		<td>下午P.m</td>
		<?php for ($i=1;$i<9;$i++){?>
		<td id="stime_2<?php echo $i?>"  ><input type="checkbox" name="pm[]" value="<?php echo $i?>" /></td>
		<?php }?>
	</tr>
	<tr>
		<td>晚上Night</td>
		<?php for ($i=1;$i<9;$i++){?>
		<td id="stime_3<?php echo $i?>"><input type="checkbox" name="night[]" value="<?php echo $i?>" /></td>
		<?php }?>
	</tr>
    
	
</table>
</div>
<div class="oath_info">
<h4>志愿者誓词</h4>
<p>我宣誓，我志愿成为一名中国红十字志愿者，自觉遵守中国的法律法规，坚持红十字运动七项基本原则，尽己所能，不计报酬，为帮助他人和服务社会而工作。</p><input  type="submit"  class="a_submit" name="a_submit"  value="申请成为志愿者"/>
</div>
</form>



</div>
</div>
<script type="text/javascript">
$(function(){
//服务地
$('#sprovince').change(function(){
 var provinceid =$('#sprovince').val();
	$.ajax({
		   type:'get',
		   url:'ajax.php',
		   dataType:'json',
		   cache: false,
		   data:{provinceid:provinceid,act:'provinceid'},
		   success:function(msg){
           re=new RegExp("name=\"city\" id=\"city\"","g"); 
           msn=msg.mes.replace(re,"name=scity id=scity"); 
	       rea=new RegExp("name=\"area\" id=\"area\"","g"); 
           msn=msn.replace(rea,"name=sarea id=sarea"); 
		   var m = msn.split("|");
		   $('#scitydiv').show();
		   $('#sareadiv').show();
	       $('#scitydiv').html(m[0]);
		   $('#sareadiv').html(m[1]);
		   if(msg.status) $('#sarea').remove();
			   }
		   });
});	
$('#scity').live('change',secity);
function secity(){
var cityid=$('#scity').val();
$.ajax({
type:'get',
url:'ajax.php',
dataType:'json',
cache: false,
data:{cityid:cityid,act:'cityid'},
success:function(msg){
  re=new RegExp("name=\"area\" id=\"area\"","g"); 
  msn=msg.mes.replace(re,"name=sarea id=sarea"); 
  $('#sareadiv').show();
  $('#sareadiv').html(msn);
	}
});
}
//居住地
$('#province').change(function(){
 var provinceid =$('#province').val();
	$.ajax({
		   type:'get',
		   url:'ajax.php',
		   dataType:'json',
		   cache: false,
		   data:{provinceid:provinceid,act:'provinceid'},
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
});
</script>
<?php include 'footer.tpl.php'; ?>




</body>
</html>