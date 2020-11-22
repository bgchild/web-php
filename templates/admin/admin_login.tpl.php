<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/login.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>

<div class="main">
<form name="myform" method="post" action="" >
<input name="u_name" type="text" value=""  class="input_name"/>
<input name="u_pwd"  type="password" value=""   class="input_pwd" />
<input type="submit" name="dosubmit" value="" class="input_sub" />
</form>
</div>

</body>
</html>