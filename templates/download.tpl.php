<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/download.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/activity.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <div class="con_left">
        <!--<ul>
            <li class="li_first">文件类型</li>
            <?php /*foreach($types as $type) {*/?>
            <li class="li_item"><a href="?id=<?php /*echo set_url($type['id']);*/?>"><?php /*echo $type['name'];*/?></a></li>
            <?php /*}*/?>
        </ul>-->
        <?php include 'left.tpl.php';?>
        </div>
        <div class="con_right">
            <div class="con_right_con">
                <div class="con_right_title"><?php echo $typename?>列表</div>
                <div class="con_right_bot">
                    <ul class="con_right_ul">
                        <?php  foreach($fileList as $k=>$v) {?>
                        <li ><a href="?down=<?php echo set_url($v['recordid']);?>" style="color:#CE0404" >下载</a><?php echo $v['filename'];?></li>
                        <?php }?>
                        <?php if(count($fileList)==0) echo "暂无资料下载,我们依然感谢您的关注！";?>
                    </ul>
                </div>
            </div>

<?php include 'templates/page.php'?>

</div>


</div>
</div>
<?php include 'footer.tpl.php'; ?>




</body>
</html>