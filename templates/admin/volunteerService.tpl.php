<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
 <?php include 'admin_top.tpl.php'; ?> 


<table width="750"><tr><td  height="8"></td></tr></table>
   <div style="height:60px;margin-left:0px;">
   
   
          <div style=" padding-top:10px; padding-left:0px;">
              <span >栏目名称：<input id="column_name" type="text" class="input length_4" maxlength="26"/></span>
             <?php if($now_flag){?>  <a class="addbtn btn_alone" id="docolumn_add" role="button"><span class="add"></span>添加</a><?php }?>
          </div>
    </div>
<div style="height:30px;line-height:30px;">
<span style="color:#2D8DD3; "><b>志愿者帮助栏目列表</b></span>
</div>


	<table id="column_table" class="list-table" cellspacing="1" cellpadding="2">
			<tr><th align="center">栏目名称</th><th align="center">管理操作</th></tr>
			<?php 	foreach ($list as $v){ ?>
			
			<tr>
			<td align="center" id="line2"><?php echo $v['name'];?></td>
			<td align="center" width="220px">
				   <?php if($now_flag){?><a href="volunteerService.php?rid=<?php echo set_url($v['recordid']);?>&act=edit "  style="text-decoration:none;">修改</a><?php }?>
				<a href="volunteerServiceList.php?rid=<?php echo set_url($v['recordid']);?>"  style="text-decoration:none;">文章列表</a>
				  <?php if($now_flag){?><a href="volunteerService.php?rid=<?php echo set_url($v['recordid']);?>&act=add"  style="text-decoration:none;">添加文章</a><?php }?>
				 <?php if($now_flag){?><a href="javascript:if(confirm('确定要删除该条数据（包括相关文章）吗？')) location.href='volunteerService.php?rid=<?php echo set_url($v['recordid']);?>&act=delete'"  style="text-decoration:none;">删除</a><?php }?>
			</td>
			</tr>
			
     <?php }?>
		</table>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
<script type="text/javascript">
$(document).ready(function (){  
	$("#docolumn_add").click(function (){ 
		 var name=$("#column_name").val(); 
		 if ( $.trim(name) == '') {
			 ui.error('栏目名称不能为空！');
		 return false;
		  }
	   $.ajax({type      :'post',
			      url         :'ajax_indexManage.php',
			      dataType:'json',
		          data      :{name:name,act:'add_columnV'},
		          success  :function(msg){
					                  if(msg=='0') { alert('添加失败！');location.reload() ;return false;}
			                         var $tr=$("<tr><td align='center' id='line2'>"+name+"</td><td align='center'><a href='volunteerService.php?rid="+msg.id+"&act=edit'  style='text-decoration:none;'>修改</a>&nbsp;<a href='volunteerServiceList.php?rid="+msg.id+"'  style='text-decoration:none;'>文章列表</a>&nbsp;<a href='volunteerService.php?rid="+msg.id+"&act=add'  style='text-decoration:none;'>添加文章</a>&nbsp;<a href='volunteerService.php?rid="+msg.id+"&act=delete'  onclick='return deletecolumn()'  style='text-decoration:none;'>删除</a>   </td></tr>");  
									 $("#column_name").attr("value","");
		                              $tr.appendTo("#column_table");
			                         }
		        });
	})		

})

function deletecolumn(){
	 if(confirm("确定要删除该条数据（包括相关文章）吗？")){
			return true;
	 }else{
		 return false;
	 }
}

</script>
</body>
</html>