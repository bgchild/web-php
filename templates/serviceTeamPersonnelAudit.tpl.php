<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<link type="text/css" rel="stylesheet" href="templates/css/serviceTeamPersonnelAudit.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
      <form name="sform" action="" method="post" class="searchFrom">
        <table style="padding:0px;">
            <tr>
                <th>姓名：</th>
                <td><input name="uname" class="input length_5" type="text" value="<?php echo $uname;?>" /></td>
                <td><input class="btn" type="submit" name="doSearch" value="查询" /></td>
            </tr>
        </table>
	</form>
    
<form name="myform" id="myform" action="" method="post" >
 <table>
        <tr>
       		<td><input type="hidden" name="server_id" value="<?php echo get_url($_GET['serviceid']);?>" /></td>
        	<td width="730" align="right"><input class="yesbtn" type="submit"  name="act" value="批量通过" id="yes" />&nbsp;&nbsp;<input class="nobtn" type="submit" name="act" value="批量拒绝" id="no" /></td>
        </tr>
        <tr><td colspan="4"  height="10"></td></tr>
</table>

<div class="tab_item">
<table class="list-table" cellspacing="1" cellpadding="2">
			<tr>
                <th width="50" align="center"><input type="checkbox" value="" id="check_box"  onclick="selectall('aid[]');"></th>
                <th align="center"  width="134">姓名</th>
                <th align="center" width="134">申请时间</th>
                <th align="center" width="134">年龄</th>
                <th align="center" width="134">性别</th>
                <th align="center" width="134">已有志愿者服务时间</th>
            </tr>
             <?php foreach($list as $v){
				$spm=array();
				$spm['id']=$v['recordid'];
				$url='serviceTeamPersonnelAudit.php?act='.set_url('detail').'&spm='.set_url($spm);
				if ($v['sex'] == 1) 
					$sex =  '男';
				else
					$sex = '女';
				$age = date('Y',time()) - date('Y',$v['birthday']);
			?>
			<tr>
                <td align="center"  width="50"><input type="checkbox" name="aid[]"   value="<?php echo $v['srecordid'];?>"></td>
                <td align="left" width="134" class="omit"><a href="<?php echo $url;?>" style="color:red; text-decoration:none;" title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a></td>
                <td align="center" width="134"><?php echo date('Y-m-d',$v['joinserviceteamdate'])?></td>
                <td align="center" width="134"><?php echo $age;?></td>
                <td align="center" width="134"><?php echo $sex;?></td>
                <td align="center" width="134"><?php echo $v['allservertime'];?></td>
            </tr>
            <?php }?>
		</table>
        </div>
     <table width="750"><tr><td  height="5"></td></tr></table>
    <?php include 'page.php'?>
  	<table width="750"><tr><td  height="5"></td></tr></table>
    <div class="sub">
       		<div class="team_url"><a href="serviceTeamManage.php?info=<?php if($info){echo $info;}if($_GET['page']){echo '&page'.$_GET['page'];}?>" class="btn" >返回</a></div>
       </div> 
</form>
	</div>

</div>
</div>
</div>
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


$(function(){
	$('#yes').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
			if(this.checked==true)falg=false;
		   });	
			if(falg){
				ui.error('请选择志愿者！');
				return false;
				}
			
			});	   
		   
	$('#no').click(function(){
			var falg=true;				 
			$("input[name='aid[]']").each(function() {							   
			if(this.checked==true)falg=false;
		   });	
			if(falg){
				ui.error('请选择志愿者！');
				return false;
				}				 
							 
			});	   

	
		   });




</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>