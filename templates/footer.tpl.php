<?php 
			$where="sign='$_SESSION[sign]'";
		    $contactInfo= $db-> get_one('form__bjhh_contact',$where);

    // 获取相关连接
    $links = $db->getall('form__bjhh_link',$where,array(limit => 4), $fields = '*',' order by orderlist ASC');
?>
<div id="footer">
<div class="footer_top">
	<div class="footer_top_con">
    <dl class="footer_top_left">
        <dd>地址：<?php echo $contactInfo['addr'];?></dd>
        <dd>电话：<?php echo $contactInfo['tel'];?></dd>
        <dd>邮政编码：<?php echo $contactInfo['mailcode'];?></dd>
        <dd>电子邮件：<?php echo $contactInfo['email'];?></dd>
        <dd>传真Fax：<?php echo $contactInfo['fax'];?></dd>
        <dd>中国红十字会维护与管理</dd>
    </dl>	
    <div class="footer_top_right"><span>相关链接/LINK</span>
    <ul class="footer_top_link">
       <!--  <a target="_blank" href="javascript:;">
            <li><img src="/templates/images/link_1.png"/></li>
        </a>
        <a target="_blank" href="javascript:;">
            <li><img src="/templates/images/link_1.png"/></li>
        </a>
        <a target="_blank" href="javascript:;">
            <li><img src="/templates/images/link_1.png"/></li>
        </a>
        <a target="_blank" href="javascrpt:;">
            <li><img src="/templates/images/link_1.png"/></li>
        </a> -->


        <?php foreach($links as $val) { ?>
        <a target="_blank" href="<?php echo $val['url']; ?>" title="<?php echo $val['name']; ?>">
            <li><img src="/<?php echo $val['img']; ?>"/></li>
        </a>
        <?php } ?>
    </ul>
    </div>
    </div>
    </div>
<div class="footer_bottom">
<div class="footer_bottom_con">
<div class="footer_bottom_left">版权所有：Copyright©2014.中国红十字会.All rights reserved.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备12048533号&nbsp;&nbsp;|&nbsp;&nbsp;<!--<a target="_blank" href="/admin/adminlogin.php" style="color:#FFF" title="点击登录">管理员登录</a>--></div>
<div class="footer_bottom_right">
<div class="jiathis_style_32x32">
<a class="jiathis_button_tsina"></a>
<a class="jiathis_button_tqq"></a>
<a class="jiathis_button_weixin"></a>
<a class="jiathis_button_cqq"></a>
</div>
<!-- JiaThis Button END -->
</div>
</div></div>
</div>
<script "text/javascript"> 
var jiathis_config = { 
	url: location.href, 
	title: location.href, 
} 
</script> 
<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
<style>
.jiathis_style_32x32 .jtico {background:none;}
.jiathis_style_32x32 .jtico_tsina {
	background:url(/templates/images/fx_xl.png) no-repeat;
}
.jiathis_style_32x32 .jtico_tqq {
	background:url(/templates/images/fx_tx.png) no-repeat;
}
.jiathis_style_32x32 .jtico_weixin {
	background:url(/templates/images/fx_wx.png) no-repeat;
}
.jiathis_style_32x32 .jtico_cqq{
	background:url(/templates/images/fx_qq.png) no-repeat;
}
</style>