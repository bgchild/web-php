<?php

class action extends mysql {
	
	public function get_show_msg($url, $show, $back = '0') {
		
		$msg = '

<style type="text/css">

body{margin-top: 100px;}
.all{height: 200px;width: 400px;background-image: url(templates/images/message_bg.gif);background-repeat: no-repeat;}
.shang{height: 30px;width: 400px;line-height: 30px;font-size: 14px;color: #666666;font-weight: bold;text-decoration: none;float: left;}
.xia1{height: 30px;width: 360px;float: right;font-size: 13px;line-height: 30px;color: #333;text-decoration: none;text-align: left;}
.xia{height: 30px;width: 360px;float: right;font-size: 13px;line-height: 30px;color: #666666;text-decoration: none;text-align: left;}
.xia a{ color: #336600;text-decoration:none}
.message_h3{float: left;height:80px; width:400px;}

</style>



<body>
<table width="400" border="0" align="center">
  <tr>
    <td colspan="3">
	<div class="all">
	<div class="shang message_h3"></div>
	<div class="xia1">状态：' . $show . '</div>
	<div class="xia">页面<span id ="spanSeconds" >3</span>秒后自动跳转，如果浏览器不跳转，<a href="' . $url . '">点此跳转</a></div>
	</div>
	</td>
  </tr>
</table>

<script language="JavaScript">

var seconds = 3;
var defaultUrl = \'' . $url . '\';

onload = function()
{
  if (defaultUrl == \'javascript:history.go(-1)\' && window.history.length == \'0\')
  {
    return;
  }
  timeid=window.setInterval(redirection, 1000);
}
		
function redirection()
{
  if (seconds <= 0)
  {
    window.clearInterval(timeid);
    return;
  }

  seconds --;
  document.getElementById(\'spanSeconds\').innerHTML = seconds;

  if (seconds == 0)
  {
    window.clearInterval(timeid);
    location.href = defaultUrl;
  }
}
</script>
</body>
</html>';
		
		echo $msg;
		
		exit ();
	
	}

}

?>