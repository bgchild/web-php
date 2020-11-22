<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_flash.css"/>
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
<div class="adminflash">
	<a href="addFastChannel.php" class="addbtn btn_alone" role="button"><span class="add"></span>添加快捷通道</a>
    <form action="" method="post" id="orderlist">
    	<table class="list-table" cellspacing="1" cellpadding="2">
    		<tr>
            	<th align="center">排序号</th>
                <th align="center">名称</th>
                <th align="center">url</th>
                <!--<th align="center">样式</th>-->
                <th align="center">操作</th>
            </tr>	
            <?php foreach ($list as $k=>$v) {?>
            <tr>
            	<td align="center"><input type="text" name="order[]" class="input length_0" value="<?php echo $v['fast_order']?>" maxlength="2"/></td>
                <td align="center"><?php echo $v['fast_name'];?></td>
                <td align="center"><?php echo $v['fast_url'];?></td>
                <!-- <td align="center"><?php echo $v['fast_style'];?></td>-->
                <td align="center"><a href="addFastChannel.php?spm=<?php echo set_url($v['fast_id']);?>"><img src="../templates/images/manage/icon_edit.gif"/></a><a href="javascript:if(confirm('确定删除么?')) location.href='fastChannel.php?deleteid=<?php echo set_url($v['fast_id']);?>' " class="del" ><img src="../templates/images/manage/icon_drop.gif"/></a></td>
            </tr>
            <input type="hidden" name="pid[]" value="<?php echo $v['fast_id']?>"/> 
            <?php } ?>
        </table>
    	<div class="order"><input type="submit" name="or_btn"  class="btn" value="排序"/></div>
    </form>
</div>
</div>

</div>
</div>
<script type="text/javascript">
$("#orderlist").submit(function(){
var ord='0';
$('td input').each(function(){
	var order=$(this).val().replace(/[ ]/g,"");
	if(!order) {ord='1';  return false; }
	reg=/^[1-9]\d?$/;
	if(!reg.test(order)){
		ord= '2';
		}
});	
if (ord=='1') {
	ui.error('排序号必填!');
	return false;
}
if (ord=='2') {
	ui.error('最多为2位数的正整数！');
	return false;
}

});	

</script>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>