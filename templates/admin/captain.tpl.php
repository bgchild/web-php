<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<link type="text/css" rel="stylesheet" href="../templates/css/admin_captain.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
<div style="width:auto; margin-top:5px; height:100px;">
    <div class="search_bar_inside">
    <form action='captain.php' method='post'>
    <span class="search_title">用户名：</span><input type="text"  name="search_username" class="input length_2" value="<?php echo $tags['search_username'];?>"/>&nbsp;&nbsp;
    <span class="search_title">姓名：</span><input type="text"  name="search_name" class="input length_2" value="<?php echo $tags['search_name'];?>"/>&nbsp;&nbsp;
    <span class="search_title">手机：</span><input type="text"  name="search_phone" class="input length_2" value="<?php echo $tags['search_phone'];?>"/>&nbsp;&nbsp;
    <span class="search_title">是否队长：</span>
    <select name="is_dz" style="width:100px">
    <option value="">全部</option>
    <option value="1"
    <?php if ($tags['is_dz']==1) echo "selected";?>
    >是</option><option value="2"
    <?php if ($tags['is_dz']==2) echo "selected";?>
    >否</option></select>&nbsp;&nbsp;
    <input  name="doresearch"value="查询" type="submit" class="btn"/>&nbsp;&nbsp;<input  name="doreset"value="重置" type="submit" class="btn"/>
    </form>
    </div>

</div>  

 <div class="admin_mamage_right adm_con">
<table class="list-table" >
 <tr>
   <th align="center" width="110">用户名</th>
   <th align="center" width="110">姓名</th>
   <th align="center" width="50">性别</th>
   <th align="center" width="150">服务地区</th>
   <th align="center" width="100">手机</th>
   <th align="center" width="120">是否队长</th>
   <?php if ($now_flag) {?><th align="center" width="113">操作</th><?php }?>
 </tr>
       <?php foreach($list as $v){
				$spm=array();
				//$spm['id']=$v['recordid'];
				//$url='activity.php?act=detail&spm='.set_url($spm);
				if($v[captainable]==1){
				$captain='是';
				$operation = '取消队长职务';}
				else {
					$captain='否' ;
					$operation = '设置为队长';}
				?>         
 <tr>
 <td align="left" width="110" class="omit1"><a title="<?php echo $v[username];?>"><?php echo $v[username];?></a></td>
 <td align="left" width="110" class="omit1"><a title="<?php echo $v[name];?>"><?php echo $v[name];?></a></td>
 <td align="center" width="50"><?php echo $v[sex]=='1' ? '男':'女';?></td>
 <td align="left" width="150" class="omit2"><a title="<?php echo $v[serveprovince],'-',$v[servecity],'-',$v[servearea];?>"><?php echo $v[serveprovince],'-',$v[servecity],'-',$v[servearea];?></a></td>
 <td align="center" width="100"><?php echo $v[cellphone];?></td>
 <td id="status" class="<?php echo $v[captainable]==1? 'cap_td_red':'cap_td';?>" width="120"><?php echo $captain;?></td>
 <?php if ($now_flag) {?><td id="operating" class="cap_td" width="113"><a  class='dic_delete' role="button" onclick="captain(this)" style="cursor:pointer;"><span><?php echo $operation;?></span><input type="hidden" value="<?php echo $v['recordid'];?>"/></a></td><?php }?>
 </tr>
           <?php }?>  
</table>
<table width="753"><tr><td  height="10"></td></tr></table>
<?php include '../templates/page.php'?>
<table width="753"><tr><td  height="10"></td></tr></table>
 </div>


</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>


<script type="text/javascript">
function captain(row){
 if(confirm("确定要修改队长设置？")){
	  var editid = $(row).find('input').val();
	  var type = $(row).parent().parent().find('#status').html();
	  
	  if(type=='是') {
		  var act = 'down';
		  var change = '否';
		  var operatag = '设置为队长';
		  var cssstyle = 'cap_td';
		  } else {  
		  var act = 'up';
		  var change = '是';
		  var operatag = '取消队长职务';
		  var cssstyle = 'cap_td_red';
		  }
	  //alert(editid);
	  	  $.ajax({type      :'post',
			         url         :'ajax_captain.php',
			         data      :{editid:editid,act:act},
			         success  :function(msg){
						                 if(msg!='0'){
												 $(row).parent().parent().find('#status').html(change);
												 $(row).parent().parent().find('#status').attr('class',cssstyle);
												 $(row).find('span').html(operatag);
											 } else { 
											 	ui.error('设置失败！');
											 }
								}
			   });
	 }
}
</script>

</body>
</html>