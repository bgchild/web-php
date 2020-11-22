<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
<link type="text/css" rel="stylesheet" href="../templates/css/admin_captain.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="../templates/js/jsdate/WdatePicker.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>
<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
<div style="width:auto; margin-top:5px; height:100px;">
    <div class="search_bar_inside">
    <form action='' method='get' class="searchFrom" id="myform">
    <span class="search_title">用户名：</span><input type="text"  name="username" class="input length_2" value="<?php echo $infos['username'];?>"/>&nbsp;&nbsp;
    <span class="search_title">IP：</span><input type="text"  name="ip" class="input length_2" value="<?php echo $infos['ip'];?>"/>&nbsp;&nbsp;
    <span class="search_title">时间：</span>
  <input type="text" name="start_time" id="time_start" class="input length_2" onclick="WdatePicker()" readonly="readonly" value="<?php echo $infos['start_time'];?>" id="time_start" />&nbsp;&nbsp;<span class="search_title">至&nbsp;&nbsp;</span><input type="text" name="end_time" id="time_stop" class="input length_2" onclick="WdatePicker()"  readonly="readonly" value="<?php echo $infos['end_time'];?>" id="time_stop" />&nbsp;&nbsp;
    <input  name="doSearch"value="查询" type="submit" class="btn"/>&nbsp;&nbsp;
    <a href="adminLogs.php" class="btn" role="button"><span class="add"></span>重置</a>
    &nbsp;&nbsp;
   <!--  <a href="javascript:if(confirm('确定删除么?')) location.href='adminLogs.php?del'" class="del" >删除一月前数据</a>-->
    </form>
    </div>
</div>  

 <div class="admin_mamage_right adm_con">
<table class="list-table" cellspacing="1" cellpadding="2">
    		<tr>
			    <th align="center" width="10%">ID</th>
                <th align="center" width="15%">用户名</th>
                <th align="center" width="35%">说明</th>
                <th align="center" width="15%">时间</th>
				<th align="center" width="10%">城市标志</th>
                <th align="center" width="15%">IP</th>
            </tr>	
            <?php if(!$list) {?><td colspan="6" align="left">暂无数据</td><?php }?>
            <?php foreach ($list as $k=>$v) {?>
            <tr>
			    <td align="center" width="10%"><?php echo $v['loginid'];?></td>
                <td align="center" width="15%"><?php echo $v['username'];?></td>
				<td align="left" width="35%"><?php echo $v['remark'];?></td>
                <td align="center" width="15%"><?php echo $v['logintime']?></td>
				<td align="center" width="10%"><?php echo $v['name'];?></td>
                <td align="center" width="15%"><?php echo $v['loginip'];?></td>
            </tr> 
            <?php } ?>

        </table>
		<table width="753"><tr><td  height="10"></td></tr></table>
<?php include '../templates/page.php'?>
<table width="753"><tr><td  height="10"></td></tr></table>
 </div>
</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>