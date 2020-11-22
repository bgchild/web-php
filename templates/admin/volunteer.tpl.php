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
<style type="text/css">
/*隐藏原因*/
.refuse_fa{position:relative;}
.refuse_so{position:absolute;width:450px;background:#fff;border:solid 2px #DFDFDF; display:none;left:150px;_left:-580px;z-index: 999}
.refuse_ch{float:left;padding:20px;}
.refuse_tab2{float:left;}
.refuse_big{color:red;font-size:18px;}
.refuse_tab2 tr{ height:35px; line-height:35px;}

.listright{text-align:right;}
.listleft{text-align:left;}
.listcenter{text-align:center;}
.table {table-layout:fixed;}
.tda{display:block;overflow:hidden; white-space:nowrap;text-overflow:ellipsis;}

.font-bold{font-weight:bold}
</style>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>


<div class="explain-col">
<div class="col_con">申请时间:</div>
<div class="col_con"><a href="?t=7day"  class="cl <?php if($arr[vol_font]=='7') echo 'font-bold';?> " >最近一周</a></div>
<div class="col_con"><a href="?t=30day"  class="cl <?php if($arr[vol_font]=='30') echo 'font-bold';?>">最近一个月</a></div>
<div class="col_con"><a href="?t=90day"  class="cl <?php if($arr[vol_font]=='90') echo 'font-bold';?>">最近三个月</a></div>
<div class="col_con"><a href="?t=180day"  class="cl <?php if($arr[vol_font]=='180') echo 'font-bold';?>">最近半年</a></div>
<div class="col_con"><a href="?t=0" class="cl <?php if($arr[vol_font]=='0') echo 'font-bold';?>">全部</a></div>
</div>
<table width="750"><tr><td  height="5"></td></tr></table>
<form name="sform" action="" method="get">
<table class="base_table" style="padding:0px;">
<tbody><tr>
				<th>姓名:</th>
				<td><input name="name" class="input length_5 name"  value="<?php echo $_GET['name'];?>" type="text"></td>
                <td><button class=" btn tj" type="submit" name="tj">查询</button>&nbsp;&nbsp;<button class=" btn cz" type="submit" name="cz">重置</button></td>
			</tr>
</table>
</form>


<form name="myform" id="myform" action="" method="post" >
<?php if ($now_flag) {?>
<table>
<tr>
<td style="width:746px;"></td>
<td><input type="hidden"  name="act" value="yes" /><button class="yesbtn" type="submit"  id="yes" >初审通过</button></td>
<td width="10"></td>
<td><button class="nobtn" type="button"  id="no">初审拒绝</button></td>
</tr>
<tr><td colspan="2"  height="1"></td></tr>
</table>
<?php }?>
<div class="refuse_fa">
	<div class="refuse_so rejectDiv">
    	<div class="refuse_ch">
        	<table class="refuse_tab2">
            	<tr>
                	<td width="100" align="right"><font color="#ff0000">*</font> 初审拒绝原因：</td>
                    <td align="left" >
                    	<textarea  style="width:300px;" name="refusedreason" class="refusedreason"></textarea>
                    </td>
                </tr>
                <tr>
                	<td width="100" align="right"><font color="#ff0000">*</font> 初审拒绝备注：</td>
                    <td align="left"><textarea  style="width:300px;" name="refusedremark" class="refusedremark"></textarea></td>
                </tr>
                <tr>
                	<td></td>
                    <td align="left"><input type="button" class="btn doSumup" name="doSumup" value="确定" />&nbsp;&nbsp;<input type="button" class="btn doSumupCancel" name="doSumupCancel" value="关闭" /></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<table class="list-table table" cellspacing="1" cellpadding="2">
			<tr>
            <th width="50" class="listcenter"><input type="checkbox" value="" id="check_box"  onclick="selectall('aid[]');"></th>
            <th width="100" class="listcenter">姓名</th>
            <th width="100" class="listcenter">性别</th>
            <th width="200" class="listcenter">出生日期</th>
            <th  class="listcenter">邮箱</th>
            <th width="140" class="listcenter">申请日期</th>
            <th width="50" class="listcenter">状态</th>
            </tr>
            <?php foreach($list as $v){
				$spm=array();
				$spm['id']=$v['recordid'];
				$spm['fromurl']="volunteer";
				$url='volunteer.php?act=detail&spm='.set_url($spm);
				if($v['status']=='1000') $stu="申请";
				else if($v['status']=='001') $stu="初审通过";
				else if($v['status']=='011') $stu="初审被拒";
				?>
			<tr>
            <td class="listcenter"><?php if($v['status']=='1000') {?><input type="checkbox" name="aid[]"   value="<?php echo $v['recordid'];?>"><?php }?></td>
            <td><a href="<?php echo $url;?>" class="tda" title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a></td>
            <td><span class="tda"><?php echo $v['sex']==1?'男':'女';?></span></td>
            <td><span class="tda" title="<?php echo $v['nickname'];?>"><?php echo date('Y-m-d',$v['birthday']);?></span></td>
            <td><?php echo $v['emails'];?></td>
            <td class="listcenter"><?php echo date("Y-m-d H:i",$v['applytime']);?></td>
            <td class="listcenter"><?php echo $stu;?></td>
            </tr>
            <?php }?> 
            <?php if(count($list)==0){ ?>
            <tr><td colspan="5">还没有新的人员申请</td></tr>
            <?php }?>    
		</table>
         
       <table width="750"><tr><td  height="5"></td></tr></table>
         <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
</form>




<script type="text/javascript">


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

function getselectnums(name) {
    var nums=new Array();
    $("input[name='"+name+"']").each(function() {
        if(this.checked==true) nums.push($(this).val());
    });
    return nums;
}

function hideselectnums(name) {
    $("input[name='"+name+"']").each(function() {
        if(this.checked==true) {
        	$(this).parent().parent().hide();
        }
    });
}



$(function(){


	$('#yes').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
				if(this.checked==true)falg=false;
		    });	
			if(falg){
				ui.error('请选择至少一个志愿者！');
				return false;
			}
			
	});	   
		   
	$('#no').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
				if(this.checked==true){
					falg=false;
				}
		    });	
			if(falg){
				ui.error('请选择至少一个志愿者！');
				return false;
			}else{
				$(".rejectDiv").show();
				return false;
			}			 
							 
	});	
	$(".doSumupCancel").click(function(){
		$(".rejectDiv").hide();
	});   
	$(".doSumup").click(function(){
		if($(".refusedreason").val()=='') {
			//ui.error("初审被拒原因不能为空格");
			alert("初审被拒原因不能为空格");
			$(".refusedreason").focus();
		}else if($(".refusedremark").val()=='') {
			//ui.error("初审被拒备注不能为空格");
			alert("初审被拒备注不能为空格");
			$(".refusedremark").focus();
		}else {
			$(".rejectDiv").hide();
			var nums=getselectnums("aid[]");
			$.post("volunteer.php", 
					{ act:"no",
					  refusedreason: $(".refusedreason").val(), 
					  refusedremark: $(".refusedremark").val(),
					  aid:nums
					 },function(){
					 	ui.success("批量拒绝成功！");
					 	hideselectnums("aid[]");
					 });
		}
	});


	$(".cz").click(function(){
		$(".name").val("");
		$(".tj").click();
	});
});

	

</script>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>

