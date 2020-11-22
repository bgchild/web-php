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
<div class="upflash">
    <form action="" method="post"  id="addfast">
        <table>
         <tr>
                <td><p><span class="must">*</span>&nbsp;&nbsp;排序号：</p></td>
                <td><input type="text" name="fast_order" value="<?php echo $fastOne['fast_order'];?>" id="fast_order" class="input length_1" />　请输入正整数</td>
        </tr>
       <!-- <tr>
            <td><p><span class="must">*</span>&nbsp;&nbsp;样　式：</p></td>
            <td>
            	<select name="fast_style" class="select length_2" id="fast_style">
                	<option value="">请选择</option>
            		<?php foreach ($li_style as $k=>$v) { ?>
                	<option value="<?php echo $v;?>" <?php if ($fastOne['fast_style'] == $v) {echo 'selected';}?> ><?php echo $v;?></option>
                	<?php } ?>
                </select>
                　请选择样式
            </td>
        </tr>-->
        <tr>
            <td><p><span class="must">*</span>&nbsp;&nbsp;名　称：</p></td>
            <td><input type="text" name="fast_name" value="<?php echo $fastOne['fast_name'];?>" class="input length_3" id="fast_name" />　名称不要超过6~13字符</td>
        </tr>
         
        <tr>
            <td><p><span class="must">*</span>&nbsp;&nbsp;超链接：</p></td>
            <td><input type="text" name="fast_url" value="<?php echo $fastOne['fast_url'];?>"class="input length_3" id="fast_url" />　例如：http://www.honghui.com</td>
        </tr>
        </table>
        <div class="save">
        	<input type="hidden" name="recordid" value="<?php echo $fastOne['fast_id'];?>" />
            <input type="submit" class="addbtn" name="dosubmit" value="保存"/>
            <a href="<?php echo $backurl;?>">
                <div class="addbtn returnbtn">返回</div>
            </a>
        </div>
    </form>

</div>
</div>



</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
<script type="text/javascript">
$(function(){ 

	$("#addfast").submit(function(){
		//排序
		var fast_order = $("#fast_order").val();
		//样式
		var fast_style = $("#fast_style").val();
		//名称
		var fast_name = $("#fast_name").val();
		//超链接
		var fast_url = $("#fast_url").val();
		//正则
		var reg = '';
		
		if (!fast_order) {
			ui.error('排序不能为空！');
			return false;
		} else {
			reg=/^[1-9]\d*$/;
				if (!reg.test(fast_order)) {
					ui.error("排序,请输入正整数!");
					return false;
				}
		}
		if (!fast_name) {
			ui.error('名称不能为空！');
			return false;
		} else {
			if (fast_name.length<6 || fast_name.length>13 ) {
				ui.error('名称不满足规矩字符数！');
				return false;
			}	
		}
		if (!fast_url) {
			ui.error('超链接不能为空！');
			return false;
		} else {
			if (!IsURL(fast_url)) {
				ui.error('链接格式不正确！');
				return false;
			}
		}
		
	});

});
function IsURL(str_url){
	var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
	+ "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
	+ "(([0-9]{1,3}.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
	+ "|" // 允许IP和DOMAIN（域名）
	+ "([0-9a-z_!~*'()-]+.)*" // 域名- www.
	+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]." // 二级域名
	+ "[a-z]{2,6})" // first level domain- .com or .museum
	+ "(:[0-9]{1,4})?" // 端口- :80
	+ "((/?)|" // a slash isn't required if there is no file name
	+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
	var re=new RegExp(strRegex);
	//re.test()
	if (re.test(str_url)){
		return (true);
	}else{
		return (false);
	}
}

</script>
</body>
</html>