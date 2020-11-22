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
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
<?php include 'user_top.tpl.php'; ?>
<div class="con_right_bottom">
<div class=""></div>
<fieldset class="list_per">
<legend>报名者列表</legend> 
            <table class="list-table tableRecord" cellspacing="1" cellpadding="2">
			<tr><th align="center">昵称</th><th align="center">操作</th></tr>
			<tr>
			<td align="left" width="350px"><?php if($pnameid==$activity['cid']){echo "<img src='templates/images/p1.png' alt='活动创建者' title='' />";}else{echo "<img src='templates/images/p3.png' alt='' title='' />";}echo "&nbsp;&nbsp;".$pname;?></td><td></td>
			</tr>
			<?php foreach ($records as $key=>$val){?>
			<tr>
			<td align="left"><?php if($val['cid']==$activity['cid']){echo "<img src='templates/images/p1.png' alt='' title='' />";}else{echo "<img src='templates/images/p3.png' alt='' title='' />";}echo "&nbsp;&nbsp;".$val[username];?></td>
			<td align="center"><a href="###" class="a_red sumupRid" rid="<?php echo $val['recordID'];?>">发送消息</a></td>
			</tr>
			<?php } ?>
		    </table> 
		<?php include 'page.php';?>
  </fieldset>
<div class="go_back">
<a href="userActivationRecord.php"><div class="addbtn">返回</div></a></div>
</div>
</div>

</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
			<div class="hiddenDiv hiddenDivSave"  >
			<table class="TimeTable" >
			    <tr><td colspan="2"><h1>发送内容</h1></td></tr>
				<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="sumup" class="sumup" id="sumup"style="width:400px;height:120px;"></textarea></td></tr>
				<tr><td><input type="hidden" name="rid" class="doSumup_rid" value="" /></td><td><input type="button" name="doSumup" class="btn doSumup" value="发送"/>&nbsp;&nbsp;<input type="button" name="doSumupCancel" class="btn doSumupCancel" value="关闭"/></td></tr>	
			</table>
	</div>
	<script type="text/javascript">
	var _rid;
	$(".sumupRid").click(function(){
		$('.hiddenDiv').each(function(){$(this).hide()});
		$('.hiddenDivSave').show();
		$("#sumup").removeAttr("value");
		 _rid=$(this).attr("rid");
		$.getJSON("userActivationPerson.php?recd="+_rid, function(data){
			//$(document.getElementsByTagName('iframe')[0].contentWindow.document.body).html("").append(data.sumup);
			$(".sumup").val(data.sumup);
			$(".doSumup_rid").val(data.recordid);
		});
	});
	$(".doSumupCancel").click(function(){
		$('.hiddenDivSave').hide();
	});


	$(".doSumup").click(function(){
		var xs=$(".sumup").val();
		if($.trim(xs)==''){
			ui.error("消息内容不能为空");
		}else if(getLength($('#sumup').val())>=2000){
			ui.error("消息内容字节不能超过2000！");
		}
			else{
		$.post("userActivationPerson.php", 
				{ doSumup:"true",
				  sumup:$(".sumup").val(), 
				  rid:_rid
			     },function(data){
				     if(data.result=="yes") {
				    	 ui.success("发送成功");
					     $(".hiddenDivSave").hide();
				     }
				    else ui.error("发送失败，请稍后再次尝试");
		},"json");
		}
	});
</script>
</body>
</html>