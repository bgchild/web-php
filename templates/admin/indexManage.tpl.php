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
<div style="height:30px;line-height:30px;flaot:left">
<span style="color:#2D8DD3; "><b>新闻栏目列表</b></span>
</div>


	<table id="column_table" class="list-table" cellspacing="1" cellpadding="2">
			<tr><th align="center">栏目名称</th><th align="center">管理操作</th></tr>
			<?php 	foreach ($list as $v){ ?>
			
			<tr>
			<td align="center" id="line2"><?php echo $v['name'];?></td>
			<td align="center" width="220px">
            <?php if (($now_admin === 'admin') && ($sign === 'www') ) {?>
				<a href="indexManage.php?rid=<?php echo set_url($v['recordid']);?>&act=edit "  style="text-decoration:none;">修改</a><?php }?>
				<a href="indexManageList.php?rid=<?php echo set_url($v['recordid']);?>"  style="text-decoration:none;">文章列表</a>
                <?php if ($now_flag) {?>
				<a href="indexManage.php?rid=<?php echo set_url($v['recordid']);?>&act=add"  style="text-decoration:none;">添加文章</a><?php }?>
			</td>
			</tr>
			
     <?php }?>
		</table>

</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>