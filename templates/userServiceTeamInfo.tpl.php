<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/userServiceTeamInfo.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
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
    	
		<div class="tab">
			<ul>
				<li  <?php echo $tabact1;?>><a href="userServiceTeamInfo.php?tag=<?php echo $tagurl1;?>">服务队信息</a></li>
				<?php if( $spm ['sp_status'] == '2' || $ntag ['sp_status'] == '2') {?>
				<li <?php echo $tabact2;?>><a href="userServiceTeamInfo.php?tag=<?php echo $tagurl2;?>">队员列表</a></li>
				<?php }?>
			</ul>	
		</div>
       <?php if($tabact1) { ?>
       <div id="serviceTeamInfo">
         <div class="server_top">
                	<table class="server_tab">
                	<tr>
                    	<td width="90" align="right">服务队名称：</td>
                            <td width="160"><input type="text" name="ser_tname" class="input" id="ser_tname" value="<?php echo $ser_one['serviceteamname'];?>" /></td>
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
                            	<select name="city" id="city" class="select">
                               		 <option value="">请选择</option>
                                	<?php foreach ($city as $cvar) {?>
                            		<option value="<?php echo $cvar['areaId'];?>" <?php if($cvar['areaId']===$ser_one['city'])echo 'selected';?>><?php echo $cvar['areaName'];?></option>
                            		<?php }?>
                                </select>
                                </div>
                                
                               <div id="areadiv">
                            	<select name="area" id="area" class="select">
                                	<option value="">请选择</option>
                                	 <?php foreach ($area as $avar) {?>
                            		<option value="<?php echo $avar['areaId'];?>" <?php if($avar['areaId']===$ser_one['areas'])echo 'selected';?>><?php echo $avar['areaName'];?></option>
                            		<?php }?>
                                </select>
                                </div>
                            </td>
                    </tr>
					<tr>
                    	<td width="90" align="right">成立日期：</td>
                            <td width="160"><input type="text" name="foundingtime" class="input" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $ser_one['foundingtime'];?>"  readonly="readonly" id="foundingtime" /></td>
                            <td width="70" align="right">负责人：</td>
                            <td width="180"><input type="text" name="principal" class="input" id="principal" value="<?php echo $ser_one['responsibleperson'];?>" /></td>
                            <td width="70" align="right">联系人：</td>
                            <td width="160"><input type="text" name="linkman" class="input" id="linkman" value="<?php echo $ser_one['relationperson'];?>"   /></td>
                        </tr>
                        <tr>
                        	<td width="90" align="right">计划人数：</td>
                            <td width="160"><input type="text" name="plan_num" class="input" id="plan_num" value="<?php echo $ser_one['planmembernumber'];?>"  /></td>
                            <td width="70" align="right">手机：</td>
                            <td width="180"><input type="text" name="mobile_telephone" class="input" id="mobile_telephone" value="<?php echo $ser_one['mobile_telephone'];?>" /></td>
                            <td width="70" align="right">固定电话：</td>
                            <td width="160"><input type="text" name="telephones" class="input" id="telephones" value="<?php echo $ser_one['telephones'];?>" /></td>
                        </tr>
                        <tr>
                    		<td width="90" align="right">传真：</td>
                            <td width="160"><input type="text" name="fax" class="input" id="fax" value="<?php echo $ser_one['fax'];?>"  /></td>
                            <td width="70" align="right">邮编：</td>
                            <td width="180"><input type="text" name="postcodes" class="input" id="postcodes" value="<?php echo $ser_one['postcodes'];?>" /></td>
                            <td width="70" align="right">电子邮箱：</td>
                            <td width="160"><input type="text" name="emails" class="input" id="emails" value="<?php echo $ser_one['emails'];?>" /></td>
                    </tr>
                    <tr>
                        	<td width="90" align="right">详细通信地址：</td>
                            <td colspan="3"><input type="text" name="detailed_address" class="input address" id="detailed_address" value="<?php echo $ser_one['detailed_address'];?>" /></td>
                        </tr>
					
                </table>

                
            </div>
            
            <div class="server_thumb">
           		<div class="top_left"><div class="cate_left_top">服务队图片：</div></div>
                <div class="top_right">
                	<table>
                    	<tr>
                        	<td width="350"><div class="thumb"><img src="<?php echo $ser_one['service_thumb']?>" > </div></td>
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
                    	<textarea name="others" class="textarea"><?php echo $ser_one['others'];?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="server_desc">
            	<div class="top_left"><div class="cate_left_top">服务队简介：</div></div>
                <div class="top_right">
                	<div class="desc_text">
                    	<textarea name="ser_intro" class="textarea" id="ser_intro"><?php echo $ser_one['teamintroduction'];?></textarea>
                    </div>
                </div>
            </div>
            
          <div class="sub">
    			<p>
                    <a href="<?php if($_GET['formmsg']) $msgurl='userMsg.php?tag='.set_url(2);else if ($tag2 ['page']) $msgurl='userBelongServiceTeam.php?&page='.$tag2 ['page']; else $msgurl='userBelongServiceTeam.php'; echo $msgurl; ?>" class="btn" >返回</a>
                </p>
            </div>
          <div class="sub_buttom"></div>
         </div>
		<?php } ?>
        <?php if($tabact2) { ?>
        	<div id="team_list">
            	<form name="myform" id="myform" action="" method="post" >
					<div class="batch_btn"><input type="button" name="sumupRid" value="批量发送消息" class="btn sumupRid" /></div>

<div class="tab_item">
<table class="list-table" cellspacing="1" cellpadding="2" style="width:95%;">
			<tr>
                <th width="60" align="center"><input type="checkbox" value="" id="check_box"  onclick="selectall('aid[]');"></th>
                <th align="center" width="220">姓名</th>
                <th align="center" width="170">电子邮箱</th>
                <th align="center" width="170">手机号码</th>
                <th align="center" width="100">队内职务</th>
            </tr>
			<?php foreach ($list as $k=>$v) {
				$cap = '';
				if ($v['captain'] == '1') {
					$cap = "<img src='./templates/images/p1.png' alt='' title=''  />";
				} else if ($v['captain'] == '2') {
					$cap = "<img src='./templates/images/p2.png' alt='' title=''  />";
				} else if ($v['captain'] == '3') {
					$cap = "<img src='./templates/images/p3.png' alt='' title=''  />";
				}
			?>
			<tr>
                <td align="center" width="60"><input type="checkbox" name="aid[]"   value="<?php echo $v['precordid'];?>"></td>
                <td align="left" width="220" class="omit2"><a title="<?php echo $v['name'];?>"><?php echo $cap,$v['name'];?></a></td>
                <td align="left" width="170" class="omit3"><a title="<?php echo $v['emails'];?>"><?php echo $v['emails'];?></a></td>
                <td align="center" width="170"><?php echo $v['cellphone'];?></td>
                <td align="center" width="100"><?php echo $v['duty'];?></td>
            </tr>
			<?php } ?>

		</table>
        </div>
     <table width="720"><tr><td  height="10"></td></tr></table>
     <?php include 'page.php'?>
     <table width="720"><tr><td  height="10"></td></tr></table>
</form>

            	<div class="sub">
                    <p>
                        <div class="team_url"><a href="<?php if ($ntag ['page']) {echo 'userBelongServiceTeam.php?&page='.$ntag ['page'];} else {echo 'userBelongServiceTeam.php';} ?>" class="btn" >返回</a></div>
                    </p>
                </div>
                
           	 	<div class="hiddenDiv hiddenDivSave"  >
			<table class="TimeTable" >
			    <tr><td colspan="2"><h1>发送消息</h1></td></tr>
				<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="sumup" class="sumup" style="width:400px;height:120px;"></textarea></td></tr>
				<tr><td><input type="hidden" name="sid" id="sid" value="<?php echo $ntag ['srecordid'];?>" /></td><td><input type="button" name="doSumup" class="btn doSumup" value="确定"/>&nbsp;&nbsp;<input type="button" name="doSumupCancel" class="btn doSumupCancel" value="关闭"/></td></tr>	
			</table>
	</div>
         
            </div>
    	<?php } ?>

		</div>
	</div>
</div>
</div>
<?php include 'footer.tpl.php'; ?>
<script type="text/javascript">
$(function(){
	$("#serviceTeamInfo :input").each(function(){
		$(this).attr("disabled",true);
	});
			
	$(".sumupRid").click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
				if(this.checked==true)falg=false;
		   });	
			
			if(falg){
				ui.error('请选择队员！');
			} else {
				$('.hiddenDiv').each(function(){$(this).hide()});
				$('.hiddenDivSave').show();
			}						  							  
	});
	$(".doSumupCancel").click(function(){
		$('.hiddenDivSave').hide();
	});
	
	$(".doSumup").click(function(){
		var checkids="";
		var sid = $("#sid").val();
		var sumup = $(".sumup").val();
		if (!$.trim(sumup)) {
			ui.error("发送消息不能为空！");
			return false;	
		}
		if (sumup.length > 1000) {
			ui.error("输入内容过长！");
			return false;
		}
			
		$("input[name^='aid']").each(function(){
			if (this.checked==true) {
				checkids+="^"+$(this).val();
			}
		}); 
		$.post("userServiceTeamInfo.php", 
				{ doSumup:"true",
				  sumup:sumup,
				  checkids:checkids,
				  sid:sid
			     },function(data){
				     if(data.result=="yes") {
				    	 ui.success("提交成功");
					    $(".hiddenDivSave").hide();
						setInterval(jump,3500);
				     }
				    else ui.error("发送失败！请检查发送人是否为自己");
		},"json");
	});
		   

});
function jump() {
	location.reload();
}
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



</script>
</body>
</html>