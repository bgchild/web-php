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
<div style="height:30px;line-height:30px;">
<span style="color:#2D8DD3; "><b>内容列表</b></span>
</div>
	<table class="list-table" cellspacing="1" cellpadding="2">
			<tr><th align="center">标题</th><th align="center">栏目名称</th><th align="center">发布人</th><th align="center">更新时间</th><?php if ($now_flag) { ?><th align="center">管理操作</th><?php } ?></tr>
			<?php foreach ($list as $v){ ?>
			
			<tr><td align="left" width="320px"><?php echo $v['title'];?></td>
			<td align="center"><?php echo $column['name'];?></td>
			<td align="center"><?php echo $v['creator'];?></td>
			<td align="center" width="150px">
		           <?php echo $v['editTime'];?>
			</td>
            <?php if ($now_flag) { ?>
			<td align="center" width="60px">
            
				<a href="indexManageList.php?rid=<?php echo set_url($v['recordid']);?>&act=edit"  style="text-decoration:none;">修改</a>
				<a href="javascript:if(confirm('确定删除吗？')) location.href='indexManageList.php?rid=<?php echo set_url($v['recordid']);?>&act=delete'"  style="text-decoration:none;" id="delete">删除</a>
			</td>
            <?php } ?>
			</tr>
			
     <?php }
     if(!$list){
     ?>
     				<tr><td colspan='5'>查无数据</td></tr><?php }?>
		</table>

<?php include '../templates/page.php'?>

		<div style="margin-top:40px;margin-left:10px;">		
    				<a href="indexManage.php" class="yesbtn">返回</a>
   		</div>
</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>

</body>
</html>