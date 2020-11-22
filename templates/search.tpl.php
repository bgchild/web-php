<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/search.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<style type="text/css">
.con-none{height:400px;font-size:14px;}
</style>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con">

<?php foreach($list as $k=>$v) {?>
<div class="SsearchItem">
<?php 
if($v['type']=='1') $aurl="detailactivity.php?rid=$v[fno]";
if($v['type']=='2') $aurl="detailteam.php?rid=$v[fno]";
if($v['type']=='3') $aurl="newsDetail.php?spm=".set_url($v[fno]);
?>
<a href="<?php echo $aurl;?>" class="sa"><?php echo $v['title'];?></a>
<?php if($v['mark']) {?>
<div class="scontent"><?php echo $v['mark'];?></div>
<?php }?>
</div>
<?php }

if(count($list)==0) {
?>
<div class="con-none">
抱歉，你查找的暂无数据，可以尝试搜索其他关键字。
</div>

<?php }?>


<?php include 'templates/page.php'?>
</div>
</div>



<?php include 'footer.tpl.php'; ?>
</body>
</html>