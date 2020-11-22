<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/serviceTeamAdd.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/imgupload.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script  type="text/javascript" src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="include/keditor/kindeditor-min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
    	<form action="" method="post" name="myform" id="myform">
        
            <div class="server_top">
            	<table class="server_tab">
                	<tr>
                    	<td width="90" align="right">服务队名称：</td>
                            <td width="160"><input type="text" name="ser_tname" class="input" id="ser_tname" value="<?php echo $ser_one['serviceteamname'];?>" />&nbsp;&nbsp;<span class="must">*</span></td>
                            <td width="70" align="right">所属地区：</td>
                            <td colspan="3">
                            	<div id="provincediv">
                            	<select name="province" id="province" class="select">
                                	<option value="">请选择</option>
                              	  	<?php foreach ($province as $pvar) {?>
                            		<option value="<?php echo $pvar['areaId'];?>" <?php if($pvar['areaId']===$ser_one['province'])echo 'selected';?>><?php echo $pvar['areaName'];?></option>
                            		<?php }?>
                                </select>
                                </div>
                                
                                <div id="citydiv">
                            	<select name="city" id="city" class="select" <?php if(!$city) echo "style=display:none"?>>
                                	<?php foreach ($city as $cvar) {?>
                            		<option value="<?php echo $cvar['areaId'];?>" <?php if($cvar['areaId']===$ser_one['city'])echo 'selected';?>><?php echo $cvar['areaName'];?></option>
                            		<?php }?>
                                </select>
                                </div>
                                
                               <div id="areadiv">
                            	<select name="area" id="area" class="select" <?php if(!$area) echo "style=display:none"?>>
                                	 <?php foreach ($area as $avar) {?>
                            		<option value="<?php echo $avar['areaId'];?>" <?php if($avar['areaId']===$ser_one['areas'])echo 'selected';?>><?php echo $avar['areaName'];?></option>
                            		<?php }?>
                                </select>
                                </div>&nbsp;<span class="must">*</span>
                            </td>
                    </tr>
					<tr>
                    	<td width="90" align="right">成立日期：</td>
                            <td width="160"><input type="text" name="foundingtime" class="input" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $ser_one['foundingtime'];?>"  readonly="readonly" id="foundingtime" />&nbsp;&nbsp;<span class="must">*</span></td>
                            <td width="70" align="right">负责人：</td>
                            <td width="180"><input type="text" name="principal" class="input" id="principal" value="<?php echo $ser_one['responsibleperson'];?>" />&nbsp;&nbsp;<span class="must">*</span></td>
                            <td width="70" align="right">联系人：</td>
                            <td width="160"><input type="text" name="linkman" class="input" id="linkman" value="<?php echo $ser_one['relationperson'];?>"   />&nbsp;&nbsp;<span class="must">*</span></td>
                        </tr>
                        <tr>
                        	<td width="90" align="right">计划人数：</td>
                            <td width="160"><input type="text" name="plan_num" class="input" id="plan_num" value="<?php echo $ser_one['planmembernumber'];?>"  />&nbsp;&nbsp;<span class="must">*</span></td>
                            <td width="70" align="right">手机：</td>
                            <td width="180"><input type="text" name="mobile_telephone" class="input" id="mobile_telephone" value="<?php echo $ser_one['mobile_telephone'];?>" />&nbsp;&nbsp;<span class="must">*</span></td>
                            <td width="70" align="right">固定电话：</td>
                            <td width="160"><input type="text" name="telephones" class="input" id="telephones" value="<?php echo $ser_one['telephones'];?>" />&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                    		<td width="90" align="right">传真：</td>
                            <td width="160"><input type="text" name="fax" class="input" id="fax" value="<?php echo $ser_one['fax'];?>"  /></td>
                            <td width="70" align="right">邮编：</td>
                            <td width="180"><input type="text" name="postcodes" class="input" id="postcodes" value="<?php echo $ser_one['postcodes'];?>" />&nbsp;&nbsp;<span class="must">*</span></td>
                            <td width="70" align="right">电子邮箱：</td>
                            <td width="160"><input type="text" name="emails" class="input" id="emails" value="<?php echo $ser_one['emails'];?>" />&nbsp;&nbsp;<span class="must">*</span></td>
                    </tr>
                    <tr>
                        	<td width="90" align="right">详细通信地址：</td>
                            <td colspan="3"><input type="text" name="detailed_address" class="input address" id="detailed_address" value="<?php echo $ser_one['detailed_address'];?>" />&nbsp;&nbsp;<span class="must">*</span></td>
                        </tr>
					
                </table>
            </div>
            
           <div class="server_thumb">
           		<div class="top_left"><div class="cate_left_top">服务队图片：</div></div>
                <div class="top_right">
                	<table>
                    	<tr>
                        	<td width="350"><div class="thumb"><?php if($ser_one['service_thumb']){?> <img src="<?php echo $ser_one['service_thumb'];?>" > <?php }else{ echo "生成300px*300px缩略图";} ?></div></td>
                           <td <?php if ($tag == 2) {echo "style='display:none;'";}?>><input   type="hidden" id="thumb_url" name="thumb_url" value="<?php if($ser_one['service_thumb']) {echo $ser_one['service_thumb'];}?>" />
    <input type="button" id="uploadButton" value="上传缩略图" /></td>
                        </tr>
                    </table>
                </div>
           </div>
           
            <div class="server_category">
            
            	<div class="top_left"><div class="cate_left_top">服务类别：</div></div>
                
                <div class="top_right">
					<div class="cate_right">
                    	
                    		<?php foreach ($cate as $clist) {?>
                            
                        	<div class="cate_server">
                        		<input type="checkbox" name="stype[]" id="cate_<?php echo $clist['id'];?>" value="<?php echo $clist['id'];?>" <?php if(in_array($clist['id'], $ser_one['serviceclassification_checkbox'])) echo"checked";?> />
                        		<?php
									if ($clist['child']) {
										echo '<span class="cate_server_name">',$clist['name'],'</span>';
									} else {
										echo '<span>',$clist['name'],'</span>';
									}
                        		?>
                        		<?php if ($clist['child']) {?>
                                <div id="fa_<?php echo $clist['id'];?>" style="position:relative;">
                                	<div id="ch_<?php echo $clist['id'];?>" class="pos_ab">
                                   		<div class="so_<?php echo $clist['id'];?>">
                                        
                                    		<?php foreach ($clist['child'] as $calist) {?>
                                    		<div class="server_child"><input type="checkbox" name="stype[]" id="child_<?php echo $calist['id'];?>" value="<?php echo $calist['id'];?>" <?php if(in_array($calist['id'], $ser_one['serviceclassification_checkbox'])) echo"checked";?>  /><?php echo $calist['name']?></div>
											<?php }?>
                                        	
                                        	<div class="server_child_btn"><input type="button" id="btn_<?php echo $clist['id'];?>" value="确定" class="btn" childid="<?php echo $clist['id'];?>" /></div>
                        				</div>
                                	</div>
                               </div>    
                        	 	<?php }?>
                                
                           
                        	</div>
                        <?php } ?>
                		
                    </div>  
                    <div style="float:left;"><span class="must">*</span></div>
                </div>
            </div>
            
            <div class="server_skill">
            	<div class="top_left"><div class="cate_left_top">技能特长：</div></div>
                
                <div class="top_right">
					<div class="skill_right">
                    
    					<?php foreach ($skill as $klist) {?>
                            
                        	<div class="skill_list">
                        		<input type="checkbox" name="skills[]" id="skill_<?php echo $klist['id'];?>" value="<?php echo $klist['id'];?>" <?php if(in_array($klist['id'], $ser_one['skills_checkbox'])) echo"checked";?> />
                        		<?php echo $klist['name'];?>
                        	</div>
                        	
                        <?php } ?>
                    
                       
                    </div>
                </div>
            </div>
            
            <div class="server_other">
            	<div class="top_left"><div class="cate_left_top">服务计划：</div></div>
                <div class="top_right">
                	<div class="other_text">
                    	<div style="float:left;"><textarea name="others" class="textarea" id="others"><?php echo $ser_one['others'];?></textarea></div><div style="float:left; margin-left:20px;"><span class="must">*</span></div>
                    </div>
                </div>
            </div>
            
            <div class="server_desc">
            	<div class="top_left"><div class="cate_left_top">服务队简介：</div></div>
                <div class="top_right">
                	<div class="desc_text">
                    	<div style="float:left;"><textarea name="ser_intro" class="textarea" id="ser_intro"><?php echo $ser_one['teamintroduction'];?></textarea></div><div style="float:left; margin-left:20px;"><span class="must">*</span></div>
                    </div>
                </div>
            </div>
            <?php if ($ser_one['agree'] == 3) {?>
            <div class="server_audit">
            	<div class="top_left"><div class="cate_left_top">原因：</div></div>
                <div class="top_right">
                	<select name="ser_reason" class="select length_2">
                    	<?php foreach($reason as $v) { ?>
                    	<option <?php if($v['id']===$ser_one['reason'])echo 'selected';?>><?php echo $v['name'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="server_message">
            	<div class="top_left"><div class="cate_left_top">备注：</div></div>
                <div class="top_right">
                	<div class="desc_text">
                    	<textarea name="ser_mess" class="textarea" id="ser_mess"><?php echo $ser_one['remark'];?></textarea>
                    </div>
                </div>
            </div>
            <?php } ?>
            
          <div class="sub">
    			<p>
    				<input type="hidden" name="recordid" value="<?php echo $rid;?>" id="rid" />
                    <input type="hidden" name="tid" value="<?php echo $ser_one['agree'];?>" id="tid" />
    				<input type="hidden" name="tag" value="<?php echo $tag;?>" id="tag" />
					<?php if ($tag !== 2) {?>	
               			<input type="submit" value="保存" name="dosubmit" class="btn" />&nbsp;&nbsp;
                    	<a href="<?php echo $backurl;?>" class="btn" >返回</a>
                    <?php } else { ?>
                    	<a href="<?php echo $backurl;?>" class="btn" >返回</a>
                    <?php }?>	
                </p>
            </div>
            <div class="sub_bottom"></div>
            
            
        </form>
    </div>
    
    
	</div>

</div>
</div>

<script type="text/javascript">
$(function(){
	//市
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
						$(this).attr("checked",false);
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

		
		//提交验证
		$("#myform").submit(function(){
			//服务队名
			var ser_tname = $("#ser_tname").val();
			//成立日期
			var foundingtime = $("#foundingtime").val();
			//负责人
			var principal = $("#principal").val();
			//联系人
			var linkman = $("#linkman").val();
			//电子邮箱
			var emails = $("#emails").val();
			//详细通信地址
			var detailed_address = $("#detailed_address").val();
			//邮编
			var postcodes = $("#postcodes").val();
			//计划人数
			var plan_num = $("#plan_num").val();
			//服务队简介
			var ser_intro = $("#ser_intro").val();
			//联系电话
			var telephones = $("#telephones").val();
			//服务队图片
			var thumb_url = $("#thumb_url").val();
			var rid = $("#rid").val();
			//正则表达式
			var reg = '';
			//传真
			var fax = $("#fax").val();
			//手机
			var mobile_telephone = $("#mobile_telephone").val();
			//服务队计划
			var others = $("#others").val();
			//省
			var province = $("#province").val();
						
			if (!$.trim(ser_tname)) {
				ui.error('服务队名称不能为空!');
				return false;
			} else {
				if (ser_tname.length >20) {
					ui.error('服务队名称过长!');
					return false;
				}	
			}
			if (!province) {
				ui.error('所属地区不能为空!');
				return false;
			}

			if (!foundingtime) {
				ui.error("成立日期不能为空!");
				return false;
			}
			if (!$.trim(principal)) {
				ui.error("负责人不能为空!");
				return false;
			} else {
				if (principal.length >20) {
					ui.error('负责人过长!');
					return false;
				}
			}
			if (!$.trim(linkman)) {
				ui.error("联系人不能为空!");
				return false;
			} else {
				if (linkman.length >20) {
					ui.error('联系人过长!');
					return false;
				}	
			}
			if (!plan_num) {
				ui.error("计划人数不能为空!");
				return false;
			} else {
				reg=/^[1-9]\d*$/;
				if (!reg.test(plan_num)) {
					ui.error("计划人数,请输入正整数!");
					return false;
				}
			}
			if (!mobile_telephone) {
				ui.error("手机不能为空");
				return false;
			} else {
				reg = /^1[3|4|5|8][0-9]\d{4,8}$/;
				if (!reg.test(mobile_telephone)) {
					ui.error("请输入正确的手机号码,如：18681888188");
					return false;
				}
			}
		/*	if (!telephones) {
				ui.error("固定电话不能为空!");
				return false;
			}  else {
				reg =/^(\d{3,4}-)\d{7,8}$/i;
				if (!reg.test(telephones)) {
					ui.error("固定电话格式不正确,(例：xxx/xxxx-xxxxxxx/xxxxxxxx)");
					return false;
				}
			}*/
			
			if (fax) {
				reg = /^(\d{3,4}-)\d{7,8}$/i;
				if (!reg.test(fax)) {
					ui.error("传真格式不正确,(例：xxx/xxxx-xxxxxxx/xxxxxxxx)");
					return false;
				}
			}
			if (!postcodes) {
				ui.error("邮编不能为空!");
				return false;
			} else {
				reg = /^[0-9]{6}$/;
				if (!reg.test(postcodes)) {
					ui.error("请输入正确的邮政编码 如:225000");
					return false;
				}
			}
			if (!emails) {
				ui.error("电子邮箱不能为空!");
				return false;
			} else {
				reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
				 
				if (!reg.test(emails)) {
					ui.error("请输入合法的email地址! 如:xxx@163.com");
					return false;
				}
			}
			if (!$.trim(detailed_address)) {
				ui.error("详细通信地址不能为空!");
				return false;
			} else {
				if (detailed_address.length > 30) {
					ui.error('详细地址过长!');
					return false;
				}
			}
			/*
			if (!rid) {
				if (!thumb_url) {
					ui.error("服务队图片不能为空!");
					return false;
				}
			}*/
			
			var i=true;
			$("input[id^='cate']").each(function(){
				if($(this).is(":checked")==true){
    						i=false;
   					}									 
			});
			if (i) {
				ui.error("服务类别至少选一个");
				return false;
			} 
			if (!$.trim(others)) {
				ui.error("服务计划不能为空");
				return false;
			} else {
				if (others.length > 1000) {
					ui.error('服务计划过长!');
					return false;
				}
			}
			if (!$.trim(ser_intro)) {
				ui.error("服务队简介不能为空");
				return false;
			} else {
				if (ser_intro.length > 1000) {
					ui.error('服务队简介过长!');
					return false;
				}	
			}
				
		});
	var tag = $("#tag").val();
	if (tag == '2') {
		$(".con_right_bottom :input").each(function(){
			$(this).attr("disabled",true);
		});
		$(".must").each(function(){
			$(this).css('display','none');
		});	
		
	}
$(".server_audit :input").each(function(){
		$(this).attr("disabled",true);
	});
$(".server_message :input").each(function(){
		$(this).attr("disabled",true);
});


		
});

KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton')[0],
					fieldName : 'imgFile',
					url : 'image_thumb.php?&time='+new Date().getTime(),
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = K.formatUrl(data.url);
	
							K('#thumb_url').val(url);
						    K('.thumb').html('<img src='+url+' />');
						} else {
							
							alert(data.message);
						}
					},
					afterError : function(str) {
						alert('自定义错误信息: ' + str);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					uploadbutton.submit();
				});
			});

</script>
<?php include 'footer.tpl.php'; ?>
</body>
</html>