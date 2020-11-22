//提交验证
function check_passwd(){
	 var password=$("input[name='password']") .val();
	 var rpassword=$("input[name='rpassword']") .val();
	 if(!password) return false;
     if(password.length<6 || password.length>20){ ui.error('密码长度为6~20个字符'); return false;}
	 if(!rpassword) return false;
	 else if(password != rpassword){ui.error('密码输入不一致'); return false;}
	   }
$(function(){
 $("input[name='username']").blur(function(){	
	        username=$(this).val();
			username=username.replace(/[ ]/g,"");
			$.ajax({
			type:'POST',
			url:'applyvolunteer.php',
			data:{username:username,act:'username'},
			success:function(msg){
			 if(msg=='no') ui.error('用户名已被注册'); return false;}
				})
					});
 $('#volunteerinfo').submit(function(){
//用户名
     var username=$("input[name='username']") .val();
     username=username.replace(/[ ]/g,"");
     if(!username){ui.error('用户名不能为空'); return false;}
	 else if(!/^[a-zA-Z]\w*$/.test(username)){ ui.error('用户名由数字、下划线组成，首字符必须是英文字母');     return false;}
	 else if(username.length<6 || username.length>15){ ui.error('用户名长度为6~15个字符'); return false;}

	 		$.ajax({
			type:'POST',
			url:'applyvolunteer.php',
			data:{username:username,act:'username'},
			success:function(msg){
			 if(msg=='no') ui.error('用户名已被注册'); return false;}
				})
    //密码
 var password=$("input[name='password']") .val();
	 var rpassword=$("input[name='rpassword']") .val();
     if(!password){ui.error('密码不能为空'); return false;}
	 else if(password.length<8 || password.length>20){ ui.error('密码长度为8~20个字符'); return false;}
	 else if(password != rpassword){ui.error('密码输入不一致'); return false;}	
    //昵称
var nickname=$("input[name='user[nickname]']") .val().replace(/[ ]/g,"");
if(!nickname){ui.error('昵称不能为空'); return false;}
if(nickname.length>20){ui.error('输入昵称过长'); return false;}
	//密码回答
 var passwordtip=$("input[name='user[passwordtip]']") .val();
 passwordtip=passwordtip.replace(/[ ]/g,"");
 if(len(passwordtip)<2){ui.error('密码提示回答至少2个字符'); return false;} 	
	 //邮箱
var emails=$("input[name='user[emails]']") .val();
    if(!/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/.test(emails)){ui.error('邮箱格式不合法'); return false;}
	var sprovince=$('#sprovince').val();
    if(!sprovince){ui.error('服务地不能为空'); return false;}
     //姓名
	 var name=$("input[name='user[name]']") .val().replace(/[ ]/g,"");
	 if(!name){ui.error('姓名不能为空');  return false;}
	 else if(name.length>15){ui.error('输入姓名过长');  return false;}
	  //证件号码
	var idnumber=$("input[name='user[idnumber]']").val().replace(/[ ]/g,"");
    var idtype=$("select[name='user[idtype]']").val();
	var idnumber_val=$('#idnumber_val').val();
    if(!idnumber){ui.error('证件号不能为空');  return false;}
	if(idtype==idnumber_val){if(!/^\d\w{17}$/.test(idnumber)){ui.error('身份证号码不正确'); return false;}}
			$.ajax({
			type:'POST',
			url:'applyvolunteer.php',
			data:{idnumber:idnumber,act:'idnumber'},
			success:function(msg){
		    if(msg=='exist') ui.error('证件号已存在'); return false;}
				})
	 var birthday=$("input[name='birthday']") .val();
	 if(!birthday){ui.error('出生日期未填写');  return false;}
     if(birthday){
         var arr = birthday.split("-");
		 //大于十四周岁
		 var mage=arr[0]*1+14;
		 var atime = new Date(mage, arr[1], arr[2]);
		 var atimes = atime.getTime();
         var now = new Date();
         var year = now.getFullYear();       //年
         var month = now.getMonth() + 1;     //月
         var day = now.getDate();            //日
		 var btime = new Date(year,month,day);
		 var btimes = btime.getTime();
         if(atimes>=btimes){ui.error('大于14周岁才可以申请会员'); return false;}
         }
    //手机固定电话
   /* var cellphone=$("input[name='user[cellphone]']") .val();
	var telephone=$("input[name='user[telephone]']") .val();
	if(!(cellphone || telephone)){ui.error('手机固定电话至少填写其中一个');  return false;}
    if(cellphone){
    if(!/^1[358]\d{9}$/.test(cellphone)){ui.error('手机号不正确');  return false; }}
	if(telephone){
    if(!/^0\d{2,3}-\d{7,8}(-\d{3,5})?$/.test(telephone)){ui.error('固定电话格式不正确'); return false;}
	}*/
	//qq
	var qq=$("input[name='user[qq]']") .val();
    if(qq) if(!/^[1-9]\d{3,10}$/.test(qq)){ui.error('qq不正确'); return false;}
	var province=$('#province').val();
    if(!province){ui.error('居住地不能为空'); return false;}
	//详细通信地址
	var detailplace=$("input[name='user[detailplace]']") .val().replace(/[ ]/g,"");
    if(detailplace.length>30){ui.error('输入详细通信地址过长'); return false;}
	//邮编
	var postcode= $("input[name='user[postcode]']") .val();
    if(postcode) if(!/^\d{6}$/.test(postcode)){ui.error('通信邮编不正确'); return false;}
	var work=$("input[name='user[work]']") .val().replace(/[ ]/g,"");
    if(work.length>30){ui.error('输入工作单位地址过长'); return false;}
	//监护人信息
    var guardername=$("input[name='user[guardername]']") .val().replace(/[ ]/g,"");
    if(guardername.length>15){ui.error('输入监护人姓名过长'); return false;}
	var guarderphone= $("input[name='user[guarderphone]']") .val();
    if(guarderphone) if(!/^\d{4,15}$/.test(guarderphone)){ui.error('监护人联系电话不正确'); return false;}
	var guarderidnumb= $("input[name='user[guarderidnumb]']") .val();
    if(guarderidnumb) if(!/^\d\w{17}$/.test(guarderidnumb)){ui.error('监护人身份证号码不正确'); return false;}
    //教育信息
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
//英文、数字、符号均为一个字节,汉字为两个。
function len(s) {
var l = 0;
var a = s.split("");
for (var i=0;i<a.length;i++) {
 if (a[i].charCodeAt(0)<299) {
  l++;
 } else {
  l+=2;
 }
}
return l;
} 

 });

