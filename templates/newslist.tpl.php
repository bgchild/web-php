<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/news.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'left.tpl.php'; ?>

<div class="content_right">
	<h3><?php echo $title;?></h3>
	<div class="content_right_top">
    	<ul>
    		<?php foreach ($list2 as $k=>$v) { 
				$url = 'newsDetail.php?spm='.set_url($v['recordid']);
			?>
        	<li><span><?php echo $v['ctime'];?></span><a href="<?php echo $url;?>"><?php echo $v['title'];?></a></li>
        	<?php } ?>
        </ul>
    </div>
    <div class="content_right_middle"><?php include 'templates/page.php'?></div>
</div>


</div>
</div>
<script type="text/javascript">

</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>