<div class="content_left">
<?php include 'login.tpl.php';?>
<h3 style="width:275px; float:left">志愿者帮助</h3>
<div class="volunteerhelp">
<?php foreach ($list as $k=>$v) { 
$url = 'newslist.php?spm='.set_url($v['recordid']);
?>
<dl>
<dt><a href="<?php echo $url;?>" title="<?php echo $v['name'];?>" style="float:left; width:180px;overflow:hidden; white-space:nowrap;text-overflow:ellipsis; text-align:left;"><?php echo $v['name'];?></a></dt>
</dl>
<?php } ?>
</div>
</div>
