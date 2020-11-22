<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/userActivationRecord.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/common.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<style>
.btn_alone {
    margin: 10px;
    margin-left: 20px;
    float: left;
    clear: both;
}
</style>
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
<?php include 'user_top.tpl.php'; ?>
	
	
<div class="con_right_bottom">
    <a href="userActivityAdd.php" class="addbtn btn_alone" role="button"><span class="add"></span>参加更多活动</a>
<fieldset class="inquire">
<legend>查询条件</legend> 
<form action="userActivationRecord.php" method="post">
<div class="searchDivInFieldset" style=" float:left">
<table>
  <tr>
    <td align="right">活动日期起：</td>
    <td><input type="text" name="activityStartDate" class="input length_2" onclick="WdatePicker()"   readonly="readonly" value="<?php echo $info['activityStartDate'];?>"/></td>
    <td align="right">活动日期止：</td>
    <td><input type="text"  class="input length_2" name="activityEndDate" onclick="WdatePicker()"   value="<?php echo $info['activityEndDate'];?>"  readonly="readonly" ></td>
    <td align="right">服务队名称：</td>
    <td><input type="text" class="input length_2" name="serviceteamname"  value="<?php echo $info['serviceteamname']?>"/></td>
  </tr>
  <tr>
    <td align="right">活动类型：</td>
    <td><select class='select_2' name="activityType"><option value="0">请选择</option><?php foreach($activityType as $key=>$val) {?><option value='<?php echo $val['id']?>' <?php if($info[activityType]==$val['id']) echo "selected='selected'";?> ><?php echo $val['name']?></option><?php }?></select></td>
    <td align="right">状态：</td>
    <td><select class='select_2' name="status"><option value="0">请选择</option>
    <option value="1" <?php if($info[status]=='1') echo "selected='selected'";?>>报名中</option>
    <option value="2" <?php if($info[status]=='2') echo "selected='selected'";?>>已通过</option>
    <option value="3" <?php if($info[status]=='3') echo "selected='selected'";?>>未通过</option>
    <option value="4" <?php if($info[status]=='4') echo "selected='selected'";?>>已参加</option>
    </select></td>
    <td></td><td class="endtd"><input type="submit" name="doSearch" class="btn s_btn" value="查询"/><a class="btn r_btn" href="userActivationRecord.php">重置</a></td><td><a class="btn r_btn" href="javascript:;" id="Export">志愿服务记录证明</a></td>
  </tr>
</table>
</div>
</form>
</fieldset>
<div class="a_table">
    <form action="userActivationRecord.php" method="post" id="Eword">
    <input type="hidden" name="doEword" value="导出"/>
	<table class="list-table tableRecord" cellspacing="1" cellpadding="2">
			<tr style="text-align:center;"><th></th><th>活动名称</th><th width="160px">活动日期</th><th>活动类型</th><th style="width:150px;">服务队名称</th><th>报名人数</th><th>状态</th><th>操作</th></tr>
			<?php foreach ($records as $key=>$val){?>
			<tr style="text-align:center;">
            <td><input type="checkbox" name="chose" value="<?php echo $val['brecordid'];?>"/></td><td class="onetd"><a href="userActivityDetail.php?show=<?php echo set_url($val['brecordid']);?>" title="<?php echo $val[activityName];?>"><?php echo $val[activityName];?></a></td>
            <td><?php echo $val[activityStartDate];?> ~ <?php echo $val[activityEndDate];?></td>
            <td><span  title=<?php echo $val[typename];?> class="tdstyle"><?php echo $val['typename'];?></span></td><td><span title=<?php echo $val[serviceteamname];?> class="tdstyle stdstyle"><?php echo $val['serviceteamname']?></span></td>
            <td><a href="userActivationPerson.php?uid=<?php echo set_url($val[uid]);?>" title="发送消息">
			<?php echo $val[applyNum];?></a></td>
            <td  style="width:60px;"><?php echo $val[astatus];?></td>
			<td style="width:40px;"><?php if( $val[opp]!="删除"&&$val[opp]!="取消"){?><a  class="a_red sumupRid" rid="<?php echo $val['recordID'];?>" title="<?php echo $val[opp]; ?>"> <?php }else{?> <a  title="<?php echo $val[opp]; ?>" href="javascript:if(confirm('确定<?php echo$val[opp]; ?>么?')) location.href='userActivationRecord.php?recordid=<?php echo set_url($val['recordID']);?>' " class="del" > <?php }?> <?php echo $val[opp];?></a></td></tr>
			<?php } if (!$records){?><tr><td colspan="7"><?php echo "查无数据";?></td></tr><?php }?>
		   </table> 
		   <?php include 'page.php';?>
    </form>
</div>
</div>

</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
			<div class="hiddenDiv hiddenDivSave"  >
			<table class="TimeTable" >
			    <tr><td colspan="2"><h1>原因</h1></td></tr>
				<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="sumup" class="sumup"style="width:400px;height:120px;"></textarea></td></tr>
				<tr><td><input type="hidden" name="rid" class="doSumup_rid" value="" /></td><td><input type="button" name="doSumup" class="btn doSumup" value="确定"/>&nbsp;&nbsp;<input type="button" name="doSumupCancel" class="btn doSumupCancel" value="关闭"/></td></tr>	
			</table>
	</div>
	<script type="text/javascript">
    /*checkbox(only one)*/
    $(function(){
        $("input[name='chose']").click(function(){
            $("input[name='chose']").attr('checked',false);
            $(this).attr('checked',true);
        })
    /*Export*/
   $('#Export').click(function(){
       var isChecked=false;
       $("input[name='chose']").each(function(index){
           if($(this).is(':checked')==true){
               isChecked = true;
               return;
           }
       })
       if(!isChecked){
           ui.error("请选择一项活动！");
           return false;
       }
       $('#Eword').submit();
        })
    })
	$("input[name='doSearch']").click(function(){
	 var activityStartDate=$("input[name='activityStartDate']") .val();
	 var activityEndDate=$("input[name='activityEndDate']") .val();
         var arrs = activityStartDate.split("-");
		 var stime = new Date(arrs[0], arrs[1], arrs[2]);
		 var stimes = stime.getTime();
         var arre =activityEndDate.split("-");
         var etime = new Date(arre[0], arre[1], arre[2]);
         var etimes = etime.getTime();
         if(stimes>etimes){ui.error('起始日期大于结束日期，请重新输入'); return false;}  
											  });
	var _rid;
	var _a;
	$(".sumupRid").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$('.hiddenDivSave').show();
		 _rid=$(this).attr("rid");
		 _a=$(this).parent().parent();
	});
	$(".doSumupCancel").click(function(){
		$('.hiddenDivSave').hide();
	});


	$(".doSumup").click(function(){
		var sumup=$(".sumup").val().replace(/[ ]/g,"");
	    if(!sumup){ui.error('放弃原因不能为空');  return false;};
       	if(sumup.length>300){ui.error('字符长度不能超过300，请精简！'); return false;}
		$.post("userActivationRecord.php", 
				{ doSumup:"true",
				  sumup:$(".sumup").val(), 
				  rid:_rid
			     },function(data){
				     if(data.result=="yes") {
				    	 ui.error("提交成功");
					     $(_a).remove();
					     $(".hiddenDivSave").hide();
				     }
				    else ui.error("保存失败或内容没有更改，请稍后再次尝试或改变内容再保存");
		},"json");
	});
</script>
</body>
</html>