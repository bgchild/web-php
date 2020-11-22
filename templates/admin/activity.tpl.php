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
<style type='text/css'>
/*隐藏原因*/
.refuse_fa{position:relative;}
.refuse_so{position:absolute;width:450px;background:#fff;border:solid 2px #DFDFDF; display:none;left:150px;_left:-580px;z-index: 999}
.refuse_ch{float:left;padding:20px;}
.refuse_tab2{float:left;}
.refuse_big{color:red;font-size:18px;}
.refuse_tab2 tr{ height:35px; line-height:35px;}

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
<div class="col_con"><a href="?t=7day" class="cl <?php if($arr[vol_font]=='7') echo 'font-bold';?>" >最近一周</a></div>
<div class="col_con"><a href="?t=30day" class="cl <?php if($arr[vol_font]=='30') echo 'font-bold';?>">最近一个月</a></div>
<div class="col_con"><a href="?t=90day" class="cl <?php if($arr[vol_font]=='90') echo 'font-bold';?>">最近三个月</a></div>
<div class="col_con"><a href="?t=180day" class="cl <?php if($arr[vol_font]=='180') echo 'font-bold';?>">最近半年</a></div>
<div class="col_con"><a href="?t=0" class="cl <?php if($arr[vol_font]=='0') echo 'font-bold';?>">全部</a></div>
</div>
<table width="750"><tr><td  height="5"></td></tr></table>
<form name="sform" action="" method="get">
<table class="base_table" style="padding:0px;">
<tbody><tr>
				<th>活动名称:</th>
				<td><input name="keyword" class="input length_5 keyword"  value="<?php echo $keyword;?>" type="text"></td>
                <th>审核状态:</th>
				<td>
                <select name="status" class="status">
                <option value="0">全部状态</option>
                <option value="2" <?php if($activityStatus==2) echo 'selected="selected"';?> > 未审核</option>
                <option value="3" <?php if($activityStatus==3) echo 'selected="selected"';?> > 审核通过</option>
                <option value="4" <?php if($activityStatus==4) echo 'selected="selected"';?> > 已结束</option>
                <option value="5" <?php if($activityStatus==5) echo 'selected="selected"';?> > 已取消</option>
                <option value="6" <?php if($activityStatus==6) echo 'selected="selected"';?> >审核拒绝</option>
                </select>
                </td>
                <td><button class="btn tj" type="submit" name="tj" >查询</button>&nbsp;&nbsp;<button class="btn cz" type="reset" name="cz" >重置</button></td>
                
			</tr>
</table>
</form>


<form name="myform" id="myform" action="" method="post" >
<?php if ($now_flag) {?>
        <table >
        <tbody><tr>
        <td style="width:750px;"></td>
        <td><button class="yesbtn" type="submit"  name="act" value="yes" id="yes" >批量通过</button></td>
        <td width="10"></td>
         <td><button class="nobtn" type="submit" name="act" value="no" id="no">批量拒绝</button></td>
        </tr>
        <tr><td colspan="4"  height="1"></td></tr>
        </table>
<?php }?>

<div class="refuse_fa">
	<div class="refuse_so rejectDiv1">
    	<div class="refuse_ch">
        	<table class="refuse_tab2">
            	<tr>
                	<td width="120" align="right"><font color="#ff0000">*</font> <font  >批量通过原因:</font></td>
                    <td align="left" >
                    	<select name="statusreason" class="statusreason1"  >111<?php foreach($agree as $k=>$v) { echo "<option value='$v[id]'>$v[name]</option>"; } ?></select>
                    </td>
                </tr>
                <tr>
                	<td width="120" align="right"><font color="#ff0000">*</font> <font  >批量通过备注:</font></td>
                    <td align="left" >
                    	<textarea  style="width:300px;" name="statusremark" class="statusremark1"></textarea>
                    </td>
                </tr>
                <tr>
                	<td></td>
                    <td align="left"><input type="button" class="btn doSumup" name="doSumup" value="确定" />&nbsp;&nbsp;<input type="button" class="btn doSumupCancel1" name="doSumupCancel1" value="关闭" /></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="refuse_fa">
	<div class="refuse_so rejectDiv2">
    	<div class="refuse_ch">
        	<table class="refuse_tab2">
            	<tr>
                	<td width="120" align="right"><font color="#ff0000">*</font> <font>批量拒绝原因:</font></td>
                    <td align="left" >
                    	<select name="statusreason" class="statusreason2"  ><?php foreach($refuse as $k=>$v) { echo "<option value='$v[id]'>$v[name]</option>"; } ?></select>
                    </td>
                </tr>
                <tr>
                	<td width="120" align="right"><font color="#ff0000">*</font> <font  >批量拒绝备注:</font></td>
                    <td align="left" >
                    	<textarea  style="width:300px;" name="statusremark" class="statusremark2"></textarea>
                    </td>
                </tr>
                <tr>
                	<td></td>
                    <td align="left"><input type="button" class="btn doSumup" name="doSumup" value="确定" />&nbsp;&nbsp;<input type="button" class="btn doSumupCancel2" name="doSumupCancel2" value="关闭" /></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<table class="list-table table" cellspacing="1" cellpadding="2" >
			<tr>
            <th width="50" class='listcenter' ><input type="checkbox" value="" id="check_box"  onclick="selectall('aid[]');"></th>
            <th class='listcenter'>活动名称</th>
            <th width="240" class='listcenter'>活动日期</th>
            <th width="140" class='listcenter'>审核状态</th>
            <th width="60" class='listcenter'>基础工时</th>
            </tr>
            <?php foreach($list as $v){
				$spm=array();
				$spm['id']=$v['recordid'];
				$url='activity.php?act=detail&spm='.set_url($spm);
				if($v['status']==2) $stu="<span style='color:#AD6E22'>未审核</span>";
				if($v['status']==3) $stu="<span style='color:#9AAA25'>审核通过</span>";
				if($v['status']==4) $stu="活动已结束";
				if($v['status']==5) $stu="活动已取消";
				if($v['status']==6) $stu="<span style='color:#F92659'>审核拒绝</span>";
				if($v['delTag']=='1') $stu.="&nbsp;-&nbsp;<span style='color:#B74F08'>活动已删除</span>";
				?>
			<tr>
            <td class='listcenter'><?php if($v['status']==2 && $v['delTag']=='0') {?><input type="checkbox" name="aid[]"   value="<?php echo $v['recordid'];?>"><?php }?></td>
            <td align="center"><a href="<?php echo $url;?>" class="tda" title="<?php echo $v['activityName'];?>"><?php echo $v['activityName'];?></a></td>
            <td class='listcenter'><?php echo date('Y-m-d H:i',$v['activityStartDate']);?>--<?php echo date('Y-m-d H:i',$v['activityEndDate']);?></td>
            <td><?php echo $stu;?></td>
            <td class='listcenter'><?php echo $v['activitytime'];?></td>
          
            </tr>
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
	var yesorno="yes";
	var atype=1;
	$('#yes').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
			if(this.checked==true)falg=false;
		   });	
			if(falg){
				ui.error('请选择活动项目！');
				return false;
			}else{
				yesorno="yes";
				atype=1;
				$(".rejectDiv2").hide();
				$(".rejectDiv1").show();
				return false;
			}	
			
	});	   
		   
	$('#no').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
			if(this.checked==true)falg=false;
		   });	
			if(falg){
				ui.error('请选择活动项目！');
				return false;
			}else{
				yesorno="no";
				atype=2;
				$(".rejectDiv1").hide();
				$(".rejectDiv2").show();
				return false;
			}				 			 
	});	   

	$(".doSumupCancel1").click(function(){
		$(".rejectDiv1").hide();
	});   
	$(".doSumupCancel2").click(function(){
		$(".rejectDiv2").hide();
	}); 
	$(".doSumup").click(function(){
		if($(".statusremark"+atype).val()=='') {
			//ui.error("初审被拒原因不能为空格");
			alert("备注不能为空格");
			$(".statusremark"+atype).focus();
		}else {
			$(".rejectDiv1").hide();
			$(".rejectDiv2").hide();
			var nums=getselectnums("aid[]");
			$.post("activity.php", 
					{ act:yesorno,
					  statusreason: $(".statusreason"+atype).val(), 
					  statusremark: $(".statusremark"+atype).val(),
					  aid:nums
					 },function(){
					 	ui.success("批量操作成功！");
					 	hideselectnums("aid[]");
					 	setTimeout("location.href='activity.php'",3000);
					 });
		}
	});

	$(".cz").click(function(){
		$(".keyword").val("");
		$(".status").val("0");
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