<?php 
//自定义模块
$arr=$db->getall('form__bjhh_column',"category='1'",array(limit=>"0,3"));
$notice=$db->get_one( 'form__bjhh_news',"sign='{$_SESSION['sign']}'",'*','order by createTime desc');

$admin="";
$status = false; //后台切换地区标识
if(strpos($_SERVER['PHP_SELF'], "admin")) {
	$admin="../";
	$status = true;
}
?>
<div id="header">
<div class="header_top"><div class="header_top_nav">
<div class="header_notice"><font color="#B9615F">通知公告：</font><a target="_blank" href="/newsDetail.php?spm=<?php echo set_url($notice['recordid'])?>" title="<?php echo $notice['title'];?>"><?php echo $notice['title'];?></a></div>
<ul>
<li class="one"><a onClick="SetHome('http://<?php echo $_SERVER[SERVER_NAME]; ?>');" href="javascript:void(0);">设为首页</a>|</li>
 <span></span></li>
       <li class="two"><a href="javascript:void(0);" onclick="AddFavorite('<?php echo $_SERVER[SERVER_NAME]; ?>','中国红十字志愿者系统');" >加入收藏</a>|</li>
       <!--<li class="three"><a href="javascript:void(0);" onclick="share('tx')">腾讯微博</a>|</li>
       <li class="three"><a href="javascript:void(0)" onclick="share('xl')">新浪微博</a></li>-->
		<li class="three"><a target="_blank" href="/admin/adminlogin.php">管理员登录</a></li>
</ul></div></div>
<div class="header_center">
<div class="h_logo">
<div class="city" style="float:left; padding-top:43px; overflow:hidden; padding-left:50%"><span style=" font-size:14px;"><?php echo $_SESSION['cityname'] ?></span><a style="color:#DA6868; margin-left:5px; display:inline" href="/changecity.php<?php if ($status) {echo '?status=admin';}?>">[切换城市]</a></div>
<div class="h_search"/>
<form class="hsearch_form" action="<?php echo $admin;?>search.php" method="POST">
<p>
<input type="text" class="text" id="h_seach" name="keyword" value="<?php if(!$_SESSION['keyword']) echo '站内搜索';else echo $_SESSION['keyword'];?>" onfocus="if (value =='站内搜索'){value =''}"onblur="if (value ==''){value='站内搜索'}"    />
</p>
<p><input type="submit" class="search_submit"  value=""  /></p>
</form></div></div>
</div>
<div class="header_nav">
<div class="h_nav">

<ul>

	<!-- 未登录 by itshajia -->
	<?php if(!$_SESSION['code'] && !$_SESSION['admin_identify']) { ?>
		<li><a href="/">首页</a></li>
		<li><a href="/service.php">志愿服务</a></li>
		<?php foreach ($arr as $v){?>
			<li><a href="/newslist.php?spm=<?php echo set_url($v[recordid]);?>"><?php echo $v[name];?></a></li>
		<?php }?>
		<li><a href="/aboutus.php">关于我们</a></li>
		<li><a href="/contactus.php">联系我们</a></li>
		<?php if($_SESSION['code']){?><li><a href="<?php echo $admin;?>download.php">下载</a></li><?php } ?>
	<?php  } else { ?>
		<!-- 登录状态 by itshajia -->
		<li><a href="/">首页</a></li>
		<li class="nav">
			<a href="javascript:;">志愿快讯</a>
			<div class="nav-menu">
				<div class="nav-menu-inner">
					<?php foreach ($arr as $v){?>
					<?php if($v['name'] == "通知公告" || $v['name'] == "新闻动态") { ?>
						<a class="nav-sub-item" href="/newslist.php?spm=<?php echo set_url($v['recordid']);?>"><?php echo $v['name'];?></a></a>
					<?php } ?>
					<?php }?>
				</div>
			</div>
		</li>
		<li><a href="/activity.php">志愿活动</a></li>
		<li><a href="/serveteam.php">志愿团体</a></li>
		<li><a href="/prizewinner.php">志愿人物</a></li>
		<?php
			$downFileTypes = $db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='文件类型' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder asc');
		?>
		<li class="nav">
			<a href="javascript:;">培训研究</a>
			<div class="nav-menu">
				<div class="nav-menu-inner">
					<?php foreach($downFileTypes as $type) {?>
					<a class="nav-sub-item" href="/download.php?id=<?php echo set_url($type['id']);?>"><?php echo $type['name'];?></a></a>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php  } ?>

</ul>
</div>
</div>
</div>
<script>
/**
 * by itshajia
 * */
$('.nav').hover(function() {
	$(this).addClass('hover');
}, function() {
	$(this).removeClass('hover');
});


</script>
<script type="text/javascript">  
function AddFavorite(sURL, sTitle) {
	sURL = encodeURI(sURL);
	try{
		window.external.addFavorite(sURL, sTitle);
	}catch(e) {
		try{
			window.sidebar.addPanel(sTitle, sURL, "");
		}catch (e) {
			alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.");
		}
	}
}
//设为首页
function SetHome(url){
	if (document.all) {
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
	}else{
		alert("您好,您的浏览器不支持自动设置页面为首页功能,请您手动在浏览器里设置该页面为首页!");
	}
}
function share(type) { 
    title =location.href;  
   // pic = $(".p-img img").attr("src");  
    rLink =location.href;  
	if(type=='xl'){
		//新浪微博
		turl="http://service.weibo.com/share/share.php";
		tname="分享至新浪微博"
		}
    if(type=='tx'){
		//腾讯微博
		turl="http://v.t.qq.com/share/share.php";
		tname="分享至腾讯微博"
		}
    window.open(turl+"?&title=" +
    encodeURIComponent(title.replace(/&nbsp;/g, " ").replace(/<br \/>/g, " "))+ "&url=" + encodeURIComponent(rLink),tname);      
} 
 

</script>