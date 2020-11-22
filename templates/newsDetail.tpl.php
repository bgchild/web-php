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
	<h3>详细页</h3>
	<div class="detail_title">
        <h1><?php echo $one['title'];?></h1>
        <div class="zixun_title_mes">
        	<ul>
              <li>发布时间：<?php echo $one['createTime'];?></li>&nbsp;&nbsp;|
              <li>来源：中国红十字会</li>&nbsp;&nbsp;|
              <li>作者：<?php echo $one['creator']?></li>&nbsp;&nbsp;
            </ul>
        </div>
    </div>
    <div class="news_con"><?php echo $one['content'];?></div>
    <div class="news_back">
    	<div class="news_back2">
        	<a href="<?php echo $backurl;?>" class="btn">返回</a>
        </div>
    </div>
</div>


</div>
</div>
<script type="text/javascript">

</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>