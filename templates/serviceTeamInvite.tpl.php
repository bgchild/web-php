<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/serviceTeamInvite.css"/>
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
		<form action='' method='get' class="searchFrom">
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
                <div class="searchDivInFieldset">
    			<table cellspacing="1" cellpadding="2">
    				<tr>
	    				<td class="listright "  width="90" rowspan="2" >专业技能：</td>
	    				<td width="140" rowspan="2">
                            <div class="server_skill">
                            	<ul>
                                	<?php foreach ($skill as $k=>$v) {?>
                                	<li><input type="checkbox" name="features[]"  value="<?php echo $v['id'];?>" <?php if(in_array($v['id'], $infos['features'])) echo"checked";?> /><?php echo $v['name'];?></li>
                                    <?php  }?>
                                </ul>
                            </div>
                        </td>
	    				<td class="listright" width="80">姓名：</td>
	    				<td width="140"><input type="text" name="name" class="input length_20"  id="name" value="<?php echo $infos['name'];?>" /></td>
    					<td class="listright" width="80">服务队名称：</td>
                        <td width="140">
                        	<select name="serviceteamname" class="select length_2">
                            	<option value="">请选择</option>
                        		<?php foreach ($serverTAll as $k=>$v) {?>
                            	<option value="<?php echo $v['recordid'];?>" <?php if($v['recordid'] == $infos['serviceteamname']) echo 'selected';?> ><?php echo $v['serviceteamname'];?></option>
								<?php } ?>
                            </select>
                        </td>
    				</tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="hidden" name="serviceTeamId" id="serviceTeamId" value="<?php if (! $query['serviceTeamId']) {echo $spm;} else {echo $query['serviceTeamId'];}?>" /></td>
                        <td><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
							<a href="serviceTeamInvite.php?spm=<?php echo set_url($query['serviceTeamId']);?>" class="btn" role="button"><span class="add"></span>重置</a></td>
                    </tr>
    			</table>
                </div>
  			</fieldset>
		</form>
	
    <div class="tabContent">	
     <div class="ust">
    	<div class="invite_btn"><input type="button" value="批量邀请" class="yesbtn" id="doInvite" name="doInvite" /></div>
		<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
				<th align="center" width="50"><input type="checkbox" value="" id="check_box"  onclick="selectall('aid[]');"></th>
				<th align="center" width="120">姓名</th>
				<th align="center" width="120">年龄</th>
				<th align="center" width="120">性别</th>
				<th align="center" width="310">专业技能</th>
			</tr>
			<?php foreach ($ser_list as $k=>$v) {?>
			<tr>
				<td align="center" width="50" style="margin:0;padding:0;"><input type="checkbox" name="aid[]"   value="<?php echo $v['recordid'];?>" id="aid_<?php echo $v['recordid'];?>" <?php if(in_array($v['recordid'], $seArr)) echo"checked";?>></td>
				<td align="left" width="120" class="omit1"><a title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a></td>
				<td align="center" width="120"><?php echo $v['birthday'];?></td>
				<td align="center" width="120"><?php echo $v['sex'];?></td>
				<td align="left" width="310" class="omit2"><a title="<?php echo $v['features'];?>"><?php echo $v['features'];?></a></td>
			</tr>
			<?php } ?>
		</table>
		<table width="720"><tr><td  height="10"><input type="hidden" name="num" id="num" value="" /></td></tr></table>
		<?php include 'page.php'?>
		<table width="720"><tr><td  height="10"></td></tr></table>
        <div class="sub">
       		<div class="team_url"><a href="serviceTeamAuditPass.php?tag=<?php echo set_url($urlArr);if($urlArr['pn']){echo '&page='.$urlArr['pn'];}?>" class="btn" >返回</a></div>
       </div> 
</div>
</div>
       
        
        
        
        
	</div>

</div>
</div>
</div>
<script type="text/javascript">
$(function(){ 
	$("#doInvite").click(function(){			
		//定义接收checkbox标识变量
		var num = $("#num").val();
		//服务队id
		var ser_id = $("#serviceTeamId").val();
		//判断是否选中checkbox 并发送邀请
		if (num == 0 || num== '') {
			ui.error('请选择志愿者！');
		} else {
			$.ajax({
			   type:'post',
			   url:'serviceTeamInvite.php',
			   dataType:'json',
			   data:{doInvite:'true',ser_id:ser_id},
			   success:function(msg){
				    if(msg.result=="yes") {
				    	 ui.success("邀请成功");
						 setInterval(jump,3500);
				     } else {
				    	 ui.error("已经邀请！");
				    	 setInterval(jump,3500);
					}
				}
	 		});
		}
	});
	
	$("input[id^='aid']").click(function(){						   
			var aid_id = $(this).val();
			
			if ($("#aid_"+aid_id).attr("checked")) {
               set_session($(this).val(),'');
            } else if (!$("#aid_"+aid_id).attr("checked")){
               set_session($(this).val(),'');
            }
	});
	
		   
});

//checkbox全选/取消
function selectall(name) {
	//拼接变量
	var checkids = '';
	
	//checkbox取消
	if ($("#check_box").is(':checked')==false) {
		$("input[name='"+name+"']").each(function() {
			//全取消后 过滤单个选中的情况									  
			if (this.checked==true) {
				checkids+="^"+$(this).val();
			}
			//判断当前是否为全取消，全取消则全选中并拼接其值
			if (this.checked==false) {
				this.checked = true;
				checkids+="^"+$(this).val();
				return true;
			}
			//全取消
			this.checked=false;
			
		});
		//checkbox选中事件ajax提交传参
		set_session(checkids);
		
	} else {
		//checkbox选中
		$("input[name='"+name+"']").each(function() {
			//全选后 过滤单个取消的情况									  
			if (this.checked==false) {
				checkids+="^"+$(this).val();
			}
			//判断当前是否全选，是全选则全部取消并拼接其值
			if (this.checked==true) {
				this.checked = false;
				checkids+="^"+$(this).val();
				return true;
			}
			//全选
			this.checked=true;
			
		});
		//checkbox选中事件ajax提交传参
		set_session(checkids);
	}
}

//页面刷新事件
function jump() {
	location.reload();
}

//checkbox选中事件ajax提交
function set_session(single) {
	$.ajax({
		   type:'POST',
		   dataType:'json',
		   url:'serviceTeamInvite.php',
		   data:{doSet:'true',single:single},
		   success:function(msg){
				$("#num").attr("value",msg.num);
			   }
		  	})
}


</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>