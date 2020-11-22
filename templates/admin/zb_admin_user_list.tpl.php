<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_flash.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>
<div class="admin_right">
 <?php include 'admin_top.tpl.php'; ?> 
<div class="adminflash">
	<?php if($now_flag) {?><a href="zbAdminUser.php" class="addbtn btn_alone" role="button"><span class="add"></span>添加管理员</a><?php }?>
    <form action="" method="post" id="orderlist">
    	<table class="list-table" cellspacing="1" cellpadding="2">
    		<tr>
                <th align="center">名称</th>
                
                <th align="center">更新时间</th>
                <th align="center">最近登录IP</th>
                <?php if($now_flag) {?><th align="center">操作</th><?php }?>
            </tr>	
            <?php foreach ($list as $k=>$v) {?>
            <tr>
                <td align="center"><?php echo $v['u_name'];?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$v['last_time']);?></td>
                <td align="center"><?php echo $v['last_ip'];?></td>
                <?php if($now_flag) {?><td align="center"><a href="zbAdminUser.php?spm=<?php echo set_url($v['recordid']);?>"><img src="../templates/images/manage/icon_edit.gif"/></a>
                <?php if ($v['def']!='1'){?><a href="javascript:if(confirm('确定删除么?')) location.href='zbAdminUserList.php?deleteid=<?php echo set_url($v['recordid']);?>' " class="del" ><img src="../templates/images/manage/icon_drop.gif"/></a><?php }?></td><?php }?>
            </tr> 
            <?php } ?>
        </table>
    </form>
</div>
</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>

</body>
</html>