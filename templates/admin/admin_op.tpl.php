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
<table class="base_table">
			
            
			<tbody><tr>
				<th>关键字</th>
				<td><input name="keyword" class="input length_3" placeholder="可使用通配符*" value="" type="text"></td>
				<th>所属版块</th>
				<td><select name="fid" class="select_3"><option value="0">所有版块</option><option value="1">&gt;&gt; 新分类</option><option value="2"> &nbsp;|- 新版块</option></select></td>
			</tr>
			<tr>
				<th>作者</th>
				<td><input name="author" class="input length_3" value="" type="text"></td>
				<th>发帖时间</th>
				<td><input class="input length_3 mr10 J_date date" name="created_time_start" value="" type="text"><span class="mr10">至</span><input class="input length_3 J_date date" name="created_time_end" value="" type="text"></td>
			</tr>
			<tr>
				<th>删除人</th>
				<td><input name="operator" class="input length_3" value="" type="text"></td>
				<th>删除时间</th>
				<td><input name="operate_time_start" class="input length_3 mr10 J_date date" value="" type="text"><span class="mr10">至</span><input name="operate_time_end" class="input length_3 J_date date" value="" type="text"></td>
			</tr>
		</tbody>
</table>

<button class="btn" type="submit">搜索</button>
<a href="#" class="addbtn" role="button"><span class="add"></span>添加后台用户</a>

<br />
<br />
<div class="tab">
<ul>
<li class="tabact">常规选项</li>
<li >高级选项</li>
<li >栏目内容</li>
</ul>
</div>








</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>