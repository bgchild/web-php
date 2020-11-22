<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/contactus.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
<div class="con ">
<div class="contactauto">
<div class="contactDiv">
<div class="contactTitle">当前位置：联系我们 </div>
<div class="conttactMainTitle"><?php echo  $contactInfo['title']; ?></div>
<div class="conttactCon">
<img class="contactImg" src="templates/images/contactus.png" />
<div class="contactInfo">
<div class="CII">
<p >地址：<?php echo $contactInfo['addr'];?></p>
<p >邮政编码：<?php echo $contactInfo['mailcode'];?></p>
<p >电话Tel：<?php echo $contactInfo['tel'];?></p>
<p >传真Fax：<?php echo $contactInfo['fax'];?></p>
<p >网址：<?php echo $contactInfo['weburl'];?></p>
<p >邮箱：<?php echo $contactInfo['email'];?></p>
</div>
</div>
</div>
</div>
</div>




</div>
</div>

<?php include 'footer.tpl.php'; ?>



</body>
</html>