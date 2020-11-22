<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />

<link type="text/css" rel="stylesheet" href="templates/css/userMsg.css"/>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script  type="text/javascript"   src="templates/js/common_table.js"></script>
<script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>

<link rel="stylesheet" href="include/keditor/themes/default/default.css" />
<link rel="stylesheet" href="include/keditor/plugins/code/prettify.css" />
<script charset="utf-8" src="include/keditor/kindeditor-min.js"></script>
<script charset="utf-8" src="include/keditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="include/keditor/plugins/code/prettify.js"></script>

<style type="text/css">
.listright{text-align:right;}
.listleft{text-align:left;}
.listcenter{text-align:center;}
.table {table-layout:fixed;}
.tda{display:block;overflow:hidden; white-space:nowrap;text-overflow:ellipsis;}
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
	
	
	 <div class="truecontent">
		<div class="tccontent"></div>
		<div class="tc-btn"><input type="button" class="btn " value="关闭" /></div>
	</div>
		
		<div class="tab">
			<ul>
				<li  <?php echo $tabact1;?>><a href="<?php $infos['tag']=1;echo "userMsg.php?info=".set_url($infos);?>" >未读消息</a></li>
				<li <?php echo $tabact2;?>><a href="<?php $infos['tag']=2;echo "userMsg.php?info=".set_url($infos);?>" >已读消息</a></li>
			</ul>	
		</div>
		<div class="tab_item">
			<table class="list-table tab_none table_1 table" cellspacing="1" cellpadding="2">
			<tr><th width="150" class="listcenter">消息日期</th><th>消息内容</th><th width="100" class="listcenter">操作</th></tr>
				<?php foreach($statusmsg as $k=>$val ){?>
						<tr class="isunread">
							<td class="listcenter"><?php echo $val['date'];?></td>
							<td><a class="doisread "  mid=<?php echo $val['recordid'];?> fno=<?php echo set_url($val['fno']);?> spm="<?php $spm['srecordid'] = $val['fno']; echo set_url($spm);?>"  status=<?php echo $val['status'];?> href="javascript:void(0);" truec="<?php echo $val['truecontent'];?>" ><?php echo $val['content'];?> </a></td>
							<td class="listcenter"><?php  if($val['act']=="未操作" && ($val['status']=='3' || $val['status']=='4') ){?><a href="<?php $param['act']='addin';$param['status']=$val['status'];$param['recordid']=$val['recordid']; echo"userMsg.php?info=".set_url($param);?>">加入</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php $param['act']='refuse';$param['status']=$val['status'];$param['recordid']=$val['recordid']; echo"userMsg.php?info=".set_url($param);?>" >拒绝</a><?php }else if ($val['status']=='3' || $val['status']=='4') echo $val['act'];?>
						</td></tr>
				<?php } if(!$statusmsg){?>	<tr><td colspan='3'>查无数据</td></tr><?php }?>
			</table>
			<table class="list-table tab_none table_2  table" cellspacing="1" cellpadding="2">
			<tr><th width="150" class="listcenter">消息日期</th><th>消息内容</th><th width="100">状态</th><th width="50" class="listcenter">操作</th></tr>
				<?php foreach($statusmsg as $k=>$val ){?>
						<tr>
							<td class="listcenter"><?php echo $val['date'];?></td><td><a  class="doisread"  mid=<?php echo $val['recordid'];?> fno=<?php echo set_url($val['fno']);?> spm="<?php $spm['srecordid'] = $val['fno'];echo set_url($spm);?>"  status=<?php echo $val['status'];?> href="javascript:void(0);" truec="<?php echo $val['truecontent'];?>"><?php echo $val['content'];?></a> </td>
							<td ><?php if($val['act']=="未操作" &&($val['status']=='3' || $val['status']=='4' )){?><a href="<?php $param['act']='addin';$param['status']=$val['status'];$param['recordid']=$val['recordid']; echo"userMsg.php?info=".set_url($param);?>">加入</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php $param['act']='refuse';$param['status']=$val['status'];$param['recordid']=$val['recordid']; echo"userMsg.php?info=".set_url($param);?>" >拒绝</a><?php }else if($val['status']=='3' || $val['status']=='4') echo $val['act'];?></td>
							<td class="listcenter"><a href="javascript:void(0);" class="delReadMsg" mid=<?php echo $val['recordid'];?> ><img src="templates/images/manage/icon_drop.gif" alt="删除"/></a></td>
					    </tr>
				<?php } if(!$statusmsg){?>	<tr><td colspan='3'>查无数据</td></tr><?php }?>
			</table>
		</div>
 <?php include 'page.php'?>
		
<script type="text/javascript">
$(document).ready(function(){
	var tag=<?php echo $tag;?>;
	$(".table_"+tag).removeClass("tab_none");
	var _this;
	$(".doisread").click(function(){
	  _this=$(this);
	  var _mid=$(this).attr("mid");
	  var _fno=$(this).attr("fno");
	  var _status=$(this).attr("status");
	  var _spm=$(this).attr("spm");
	  var _truec=$(this).attr("truec");
		$.getJSON("userMsg.php?doisread="+_mid, function(data){
			  if(data.back=="yes") {
				  if(_status==1)  {$(".truecontent").show();$(".tccontent").text("消息内容："+_truec);}
				  if(_status==3)  location.href="userServiceTeamInfo.php?spm="+_spm+"&formmsg=true";
				  if(_status==4)  location.href="userActivityDetail.php?show="+_fno+"&formmsg=true";
				  if(_status>=5)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==6)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==7)  {$(".truecontent").show();$(".tccontent").text("放弃原因： "+_truec);}
				  //if(_status==8)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==9)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==10)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==11)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==12)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status==13)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				  //if(_status>=14)  {$(".truecontent").show();$(".tccontent").text("消息内容： "+_truec);}
				}
		});
	});
	$(".delReadMsg").click(function(){
		_t=$(this);
		var _mid=$(this).attr("mid");
		$.getJSON("userMsg.php?delReadMsg="+_mid, function(data){
			  if(data.back=="yes") {
				  ui.success("删除成功！");
				  _t.parent().parent().hide();
			  }else {
			  	  ui.error("删除失败，请稍后再试");
			  }
		});
	});
	$(".tc-btn").click(function(){$(".truecontent").hide();_this.parent().parent(".isunread").hide();});
});
</script>
		 
</div>


		
</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
</body>
</html>