<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
  <table width="750"><tr><td  height="8"></td></tr></table>
<div class="explain-col" style="width:170px; margin-top:5px;">
<ul>
<?php foreach($tlist as $v){?>
<li  style="width:170px; float:left; margin-bottom:3px; text-align:center"><a href="#" class="btn" style="width:100px;"><?php echo $v['dicTypeName']?></a></li>
<?php }?>
</ul>
</div>  
<div style="float:right;width:570px;">  
<form name="myform" id="myform" action="" method="post" >
<table class="list-table" cellspacing="1" cellpadding="2" style=" width:570px;">
			<tr>
            <th>排序</th>
            <th width="220">名称</th>
            <th width="80">是否启用</th>
            <th >操作</th>
            </tr>
            <?php foreach($list as z$v){
				$spm=array();
				$spm['id']=$v['recordid'];
				$url='activity.php?act=detail&spm='.set_url($spm);
				?>
			<tr>
            <td align="center"><input type="checkbox" name="aid[]"   value="<?php echo $v['recordid'];?>"></td>
            <td><a href="<?php echo $url;?>"><?php echo $v['activityName'];?></a></td>
            <td><?php echo $v['serviceid'];?></td>
            <td><?php echo $v['activitytime'];?></td>
          
            </tr>
            <?php }?>     
		</table>
         
       <table width="750"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
</form>

</div>




</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>