<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<link type="text/css" rel="stylesheet" href="../templates/css/dic_base.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
  <table width="910"><tr><td  height="8"></td></tr></table>
<div class="explain-col" style="width:220px; margin-top:5px;">
<ul>
<?php foreach($tlist as $v){?>
<li  style="width:220px; float:left; margin-bottom:3px; text-align:center"><a href="dic.php?act=<?php echo set_url($v['typeCode']); ?>" class="btn" style="width:150px;"><?php echo $v['dicTypeName']?></a></li>
<?php }?>
</ul>
</div>  
<div style="float:right;width:650px; ">  
<form name="myform" id="myform" action="" method="post" >

    <div class="dic_add">
          <div style=" padding-top:10px; padding-left:20px;">
              <span >排序：<input id="dic_listorder" type="text" class="input" style=" width:50px;" value="0"/></span>
              <span >名称：<input id="dic_name" type="text" class="input" /></span>
              <select name="status" id="status" class="dic_select_status">
                   <option value="1">启用</option>
                   <option value="2">不启用</option>
              </select>
              <a class="addbtn btn_alone" id="dodic_add" role="button"><span class="add"></span>添加</a>
          </div>
    </div>
    
<table id="dic_table" class="list-table" cellspacing="1" cellpadding="2" style=" width:650px;">
			<tr>
            <th width="70px" class="dic_th">排序</th>
            <th width="240px" class="dic_th">名称</th>
            <th width="80px" class="dic_th">是否启用</th>
            <th width="180px" class="dic_th">操作</th>
            </tr>
            <?php foreach($list as $v){
				$spm=array();
				//$spm['id']=$v['recordid'];
				//$url='activity.php?act=detail&spm='.set_url($spm);
				?>
			<tr>
            <td align="center" ><input  id="line1" type="text" name="listorder[<?php echo $v['id'];?>]"  class="input" style=" width:30px;" value="<?php echo $v['listorder'];?>"/></td>
            <td id="line2"><?php echo $v['name']; ?></td>
            <td align="center" id="line3"><?php   if($v['state']=='1') echo '已启用';else echo '未启用'; ?></td>
            <td align="center"><a  class='dic_delete' role="button" onclick="editrow(this)">[修改]&nbsp;<input type="hidden" value="<?php echo $v['id'];?>"/></a><a  class='dic_delete' role="button" onclick="deleterow(this)">[删除]<input type="hidden" value="<?php echo $v['id'];?>"/></a></td>
            </tr>
            <?php }?>     
		</table>
         <div style="text-align:center; width:70px;"><input type="submit" name="dolist"  class="addbtn btn_alone" value=" 排序 "/></div>
     
     
</form>

</div>




</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>

<script type="text/javascript">

$(document).ready(function (){  
		$("#dodic_add").click(function (){ 
			 var tcode = '<?php echo $act; ?>';
			 var name=$("#dic_name").val(); 
			 var status = $("#status").val(); 	
			 if(status=='1')  var statusp='已启用';else  var statusp='未启用';
			 var listorder = $("#dic_listorder").val();
			 
			 if (name == '') {
			 alert("名称不能为空,请填写名称。");
			 return false;
			  }
			   if (listorder == '') {
			    listorder='0';
			  }
				
		   $.ajax({type      :'post',
				      url         :'ajax.php',
			          data      :{name:name,status:status,listorder:listorder,act:'pwquestion',tcode:tcode},
			          success  :function(msg){
						                  if(msg=='0') { alert('添加失败！');location.reload() ;return false;}
				                         var $tr=$("<tr><td align='center'><input id='line1' class='input' style='width:30px;' name='listorder["+msg+"]' type='text' value='"+listorder+"'/></td><td id='line2'>"+name+"</td><td align='center'>"+statusp+"</td><td align='center' id='line3'><a class='dic_delete' role='button' onclick='editrow(this)'>[修改]&nbsp;<input type='hidden' value='"+msg+"'/></a><a class='dic_delete' role='button' onclick='deleterow(this)'>[删除]<input type='hidden' value='"+msg+"'/></a></td></tr>");  
										 $("#dic_name").attr("value","");
										 $("#dic_listorder").attr("value","0");
			                              $tr.appendTo("#dic_table");
				                         }
			        });
		})		
		
/*	$(".dic_delete").live("click",function (){   
     $(this).parent().parent().remove();  
       });  */
})

function deleterow(row){
	 if(confirm("确定要删除该条数据吗？")){
	  var deleteid = $(row).find('input').val();
	  
	  $.ajax({type      :'post',
			     url         :'ajax.php',
			     data      :{deleteid:deleteid,act:'delete'},
			     success  :function(msg){
						                 if(msg!='0'){
											 $(row).parent().parent().remove();  
											 } else {alert('添加失败！');location.reload() ;return false;}
								}
			   });
	 }
}

function editrow(row){
	var addid = $(row).find('input').val();
	var name = $(row).parent().parent().find('#line2').html();
	var status = $(row).parent().parent().find('#line3').html();
	if(status=='已启用'){ 
	      var option="<option value='1' selected='selected'>启用</option><option value='2' >不启用</option>";
		  } else {
			  var option="<option value='1' >启用</option><option value='2' selected='selected'>不启用</option>";
			  }
	var listorder = $(row).parent().parent().find('#line1').val();
	//alert (addid+'|'+name+'|'+status+'|'+listorder);
	
	var $tr=$("<tr><td align='center'><input  id='line1' class='input' style=' width:30px;' name='listorder["+addid+"]' type='text' value='"+listorder+"'/></td><td id='line2'><input id='name2' style='width:220px;' id='' type='text' class='input' value='"+name+"'/></td><td align='center' id='line3'><select  id='status2' class='dic_select_status' style='width:70px;'>"+option+"</select></td><td align='center'><a class='addbtn btn_alone' role='button' onclick='confirmedit(this)'>确认<input type='hidden' value='"+addid+"'/></a>&nbsp;<a class='addbtn btn_alone' onclick='refre()' style='text-decoration:none;'>取消</a></td></tr>");  
	
	 $(row).parent().parent().after($tr);
	 $(row).parent().parent().remove();
		
	}
	
function confirmedit(row){
	var editid = $(row).find('input').val();
	var name = $(row).parent().parent().find('#name2').val();
	var status = $(row).parent().parent().find('#status2').val();
	var listorder = $(row).parent().parent().find('#line1').val();
	 if(status=='1')  var statusp='已启用';else  var statusp='未启用';
	//var tcode = '009';
	//alert (addid+'|'+name+'|'+status+'|'+listorder);
	
	 if (name == '') {
			 alert("名称不能为空,请填写名称。");
			 return false;
			  }
			   if (listorder == '') {
			    listorder='0';
			  }	
	
	if(confirm("确定要修改该条数据吗？")){
		 $.ajax({
				 type      :'post',
			     url         :'ajax.php',
			     data      :{editid:editid,name:name,status:status,listorder:listorder,act:'edit'},
			     success  :function(msg){
						                 if(msg=='0'){  //msg!='0'    这里用户没有修改却保存的处理
										 alert('您并没有对数据做出任何改动！');
										 location.reload() ;
										 return false;
										  } 
											 var $tr=$("<tr><td align='center'><input id='line1' class='input' style='width:30px;' name='listorder["+editid+"]' type='text' value='"+listorder+"'/></td><td id='line2'>"+name+"</td><td align='center'>"+statusp+"</td><td align='center' id='line3'><a class='dic_delete' role='button' onclick='editrow(this)'>[修改]&nbsp;<input type='hidden' value='"+editid+"'/></a><a class='dic_delete' role='button' onclick='deleterow(this)'>[删除]<input type='hidden' value='"+editid+"'/></a></td></tr>");  
											 $(row).parent().parent().after($tr);
	                                         $(row).parent().parent().remove();
											
								}
			   });		
		}
	
	}

function refre(){
	location.reload();
	}
</script>


</body>
</html>