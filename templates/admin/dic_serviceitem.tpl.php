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
              <span >名称：<input id="dic_name" type="text" class="input"/></span>
              <select name="status" id="status" class="dic_select_status">
                   <option value="1">启用</option>
                   <option value="2">不启用</option>
              </select>
              <a  class="addbtn btn_alone" id="dodic_add" role="button"><span class="add"></span>添加</a>
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
            <td align="center"><input id="line1" class="input" name="listorder[<?php echo $v['id'];?>]" style=" width:30px;" type="text"  value="<?php echo $v['listorder'];?>"/></td>
            <td id="line2"><?php echo $v['name'];?></td>
            <td align="center" id="line3"><?php   if($v['state']=='1') echo '已启用';else echo '未启用'; ?></td>
            <td align="center">
            <?php if($v['fid']=='0') { ?>
            <a  class='dic_delete' role="button" onclick="editrow(this,1)">[修改]<input type="hidden" value="<?php echo $v['id'];?>"/></a>
            <a  class='dic_delete' role="button" onclick="deleterow(this)">[删除]<input type="hidden" value="<?php echo $v['id'];?>"/></a>
            <a  class='dic_delete' role="button" onclick="addchild(this)">[添加子条目]<input type="hidden" value="<?php echo $v['id'];?>"/></a> 
            <?php  } else {  ?> 
            <a  class='dic_delete' role="button" onclick="editrow(this,2)">[修改]<input type="hidden" value="<?php echo $v['id'];?>"/></a>
            <a  class='dic_delete' role="button" onclick="deleterow(this)">[删除]<input type="hidden" value="<?php echo $v['id'];?>"/></a>
            <?php  }   ?>           
            </td>
            </tr>
            <?php }?>     
		</table>
         <div style="text-align:center; width:70px;"><input type="submit" name="dolist"  class="addbtn btn_alone"  value=" 排序 "/></div>
     
     
</form>

</div>




</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>

<script type="text/javascript">

$(document).ready(function (){  
		$("#dodic_add").click(function (){ 
			 var name=$("#dic_name").val(); 
			 var status = $("#status").val(); 	
			 if(status=='1')  var statusp='已启用';else  var statusp='未启用';
			 var listorder = $("#dic_listorder").val();
			 
			 if (name == '') {
			alert("名称不能为空,请填写名称。");
			return false;
			  }
			   if (listorder == '') {
			listorder = '0';
			  }
				
		  $.ajax({type      :'post',
				     url         :'ajax.php',
			         data      :{name:name,status:status,listorder:listorder,act:'serviceitem'},
			         success  :function(msg){
				                         var $tr=$("<tr><td align='center'><input  id='line1' class='input' style='width:30px;' type='text' name='listorder["+msg+"]'   value='"+listorder+"'/></td><td id='line2'>"+name+"</td><td align='center' id='line3'>"+statusp+"</td><td align='center'><a class='dic_delete' role='button' onclick='editrow(this,1)'>[修改]<input type='hidden' value='"+msg+"'/></a><a class='dic_delete' role='button' onclick='deleterow(this)'>[删除]<input type='hidden' value='"+msg+"'/></a><a class='dic_delete' role='button' onclick='addchild(this)'>[添加子条目]<input type='hidden' value='"+msg+"'/></a></td></tr>");  
			                              $tr.appendTo("#dic_table");
				                         }
			        });
		})		
		
/*	$(".dic_delete").live("click",function (){   
     $(this).parent().parent().remove();  
       });  */
})

function deleterow(row){
	  var deleteid = $(row).find('input').val();
	 if(confirm("确定要删除该条数据吗？")){ 
	  $.ajax({type      :'post',
			     url         :'ajax.php',
			     data      :{deleteid:deleteid,act:'delete'},
			     success  :function(msg){
						                 if(msg!='0'){
											 $(row).parent().parent().remove();  
											 }
								}
			   });  }
	}
	
	
function addchild(row){
	 var addid = $(row).find('input').val();
	 //alert(addid);
	 var $trs=$("<tr><td align='center'> <input id='listorder2' name='listorder2' class='input' style=' width:30px;' type='text' value='0'/></td><td>└─<input  id='name2' type='text' class='input'/></td><td align='center'><select id='status2' ><option value='1'>启用</option><option value='2'>不启用</option></select></td><td align='center'><input class='addbtn btn_alone'  type='button' onclick='confirmchild(this)' value='添加'><input id='hideid' type='hidden' value='"+addid+"'/>&nbsp;<a class='addbtn btn_alone' onclick='cancelchild(this)' type='button' role='button'>取消<a/></td></tr>");  
	 $(row).parent().parent().after($trs)
	}
	
	
function confirmchild(row){
	var addid = $(row).parent().find('#hideid').val();
	var name = $(row).parent().parent().find('#name2').val();
	var status = $(row).parent().parent().find('#status2').val();
	 if(status=='1')  var statusp='已启用';else  var statusp='未启用';
	var listorder = $(row).parent().parent().find('#listorder2').val();
	//alert(addid);
	
	 if (name == '') {
	 alert("名称不能为空,请填写名称。");
	 return false;
			  }
	  if (listorder == '') {
	  listorder='0';
			  }
	
	$.ajax({
		    type      :'post',
		    url         :'ajax.php',
		    data      :{addid:addid,name:name,status:status,listorder:listorder,act:'newchild'},
			success  :function(msg){
                             var $trs=$("<tr><td align='center'><input id='line1' class='input' style=' width:30px;' name='listorder["+msg+"]' type='text' value='"+listorder+"'/></td><td id='line2'>└─"+name+"</td><td align='center' id='line3'>"+statusp+"</td><td align='center'><a class='dic_delete' role='button' onclick='editrow(this,2)'>[修改]&nbsp;<input type='hidden' value='"+msg+"'/></a><a class='dic_delete' role='button' onclick='deleterow(this)'>[删除]<input type='hidden' value='"+msg+"'/></a></td></tr>");
							 $(row).parent().parent().after($trs);
							 $(row).parent().parent().remove();
								}
		   })
	
	
	}
	
	
function cancelchild(row){
	$(row).parent().parent().remove();
	}
	
function editrow(row,type){
	var editid = $(row).find('input').val();
	var name = $(row).parent().parent().find('#line2').html();
	
	var status = $(row).parent().parent().find('#line3').html();
	 if(status=='已启用'){ 
	      var option="<option value='1' selected='selected'>启用</option><option value='2' >不启用</option>";
		  } else {
			  var option="<option value='1' >启用</option><option value='2' selected='selected'>不启用</option>";
			  }
	var listorder = $(row).parent().parent().find('#line1').val();
	if(type=='1'){var childtag='';var subname = name; var hidetype='1';} else {var childtag='└─';var subname = name.substr(2);var hidetype='2';}
	//alert (editid+'|'+name+'|'+status+'|'+listorder+'|'+type);
	
	var $trs=$("<tr><td align='center'> <input id='line1' name='listorder2' class='input' style=' width:30px;' type='text' value='"+listorder+"'/></td><td>"+childtag+"<input  id='name2' type='text' class='input' value='"+subname+"'/></td><td align='center'><select id='status2' >"+option+"</select></td><td align='center'><input class='addbtn btn_alone'  type='button' onclick='confirmedit(this)' value='确定'><input id='hideid' type='hidden' value='"+editid+"'/><input id='hidetype' type='hidden' value='"+hidetype+"'/>&nbsp;<a href='dic.php?act=czozOiIwMDciOw==' class='addbtn btn_alone'  style='text-decoration:none;'>取消<a/></td></tr>");  
	 $(row).parent().parent().after($trs);
	 $(row).parent().parent().remove();	
	}
	
	
function confirmedit(row){
	var editid = $(row).parent().find('#hideid').val();
	var type = $(row).parent().find('#hidetype').val();
	var name = $(row).parent().parent().find('#name2').val();
	var status = $(row).parent().parent().find('#status2').val();
	if(status=='1')  var statusp='已启用';else  var statusp='未启用';
	var listorder = $(row).parent().parent().find('#line1').val();
	var type = $(row).parent().find('#hidetype').val();
	var tcode = '007';
	//alert (editid+'|'+name+'|'+status+'|'+listorder+'|'+type);
	
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
		    data      :{editid:editid,name:name,status:status,listorder:listorder,tcode:tcode,act:'edit'},
			success  :function(msg){
                             var $trs=$("<tr><td align='center'><input id='line1' class='input' style=' width:30px;' name='listorder["+msg+"]' type='text' value='"+listorder+"'/></td><td id='line2'>└─"+name+"</td><td align='center' id='line3'>"+statusp+"</td><td align='center'><a class='dic_delete' role='button' onclick='editrow(this,2)'>[修改]&nbsp;<input type='hidden' value='"+editid+"'/></a><a class='dic_delete' role='button' onclick='deleterow(this)'>[删除]<input type='hidden' value='"+editid+"'/></a></td></tr>");
							 $(row).parent().parent().after($trs);
							 $(row).parent().parent().remove();
								}
		   })
	
	 }
	}

</script>


</body>
</html>


