<?php 
include_once (INCLUDE_PATH . "user.php");
$userindex=new user();
$_user=$userindex->checkCaptain();
?>

<!-- 原菜单栏暂先隐藏 -->
<div class="user_left" style="display: none;">
<ul>
<li class="li_first"><a href="userIndex.php">个人中心</a></li>
<li class="li_item"><a href="userIndex.php">欢迎页面</a></li>
<li class="li_item"><a href="userBasicInfo.php">我的基本信息</a></li>
<li class="li_item"><a href="userActivationRecord.php">我的活动记录</a></li>
<li class="li_item"><a href="userBelongServiceTeam.php">我所属的志愿服务队</a></li>
<li class="li_item"><a href="UserMyServertime.php">我的志愿服务时间</a></li>
<li class="li_item"><a href="UserMyAward.php">我的获奖信息</a></li>
<?php if($_user) {?>
<li class="li_item"><a href="serviceTeamManage.php">志愿服务队管理</a></li>
<li class="li_item"><a href="userActivityManage.php">活动与项目管理</a></li>
<li class="li_item"><a href="UserServertime.php">志愿服务时间管理</a></li>
<?php }?>
<li class="li_item"><a href="UserJion.php">志愿者转出</a></li>
<li class="li_item"><a href="userMsg.php">我的消息</a></li>
<!--
<li class="li_item"><a href="userPhoto.php">修改照片</a></li>
<li class="li_item"><a href="userChangePassword.php">修改密码</a></li>
<li class="li_item"><a href="userWithdraw.php">志愿者注销</a></li>
-->
</ul>
</div>

<!-- 用户中心菜单栏 -->
<div class="user-menu">
    <?php
    function php_self()
    {
        $php_self = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1);
        return $php_self;
    }

    $cur = php_self();
    ?>
    <input type="hidden" value="<?php echo $cur ?>" id="cur"/>
    <div class="user-menu-header"><a class="user-menu-title" href="userIndex.php">用户中心</a></div>
    <div class="user-menu-list" style="padding-bottom: 20px;">
        <!-- 个人中心 -->
        <div class="user-menu-item">个人中心<span>&gt;</span></div>
        <ul class="clearfix" style="display: none;">
            <li><a href="userIndex.php">欢迎页面</a></li>
            <li><a href="userBasicInfo.php">修改资料</a></li>
            <li><a href="userChangePassword.php">修改密码</a></li>
            <li><a href="userMsg.php">站内消息</a></li>
        </ul>
        <!-- 培训与表彰 -->
        <div class="user-menu-item">培训与表彰<span>&gt;</span></div>
        <ul class="clearfix" style="display: none;">
            <li><a href="userMyTrain.php">我的培训</a></li>
            <li><a href="UserMyAward.php">我的表彰</a></li>
            <li><a href="UserMyServertime.php">我的志愿服务时间</a></li>
        </ul>
        <!-- 组织与项目 -->
        <div class="user-menu-item">组织与活动<span>&gt;</span></div>
        <ul class="clearfix" style="display: none;">
            <li><a href="userBelongServiceTeam.php">我的组织</a></li>
            <li><a href="userActivationRecord.php">我的活动</a></li>
        </ul>
        <!-- 记录转移 -->
        <div class="user-menu-item">
            <a href="UserJion.php">记录转移</a>
        </div>
        <!-- 我管理的服务队 -->
        <?php if($_user) { ?>
        <div class="user-menu-item">我管理的服务队<span>&gt;</span></div>
        <ul class="clearfix" style="display: none;">
            <li><a href="serviceTeamManage.php">基础信息管理</a></li>
            <li><a href="userVolunteerManage.php">志愿者管理</a></li>
            <li><a href="userActivityManage.php">志愿服务活动管理</a></li>
            <li><a href="UserServertime.php">志愿服务时间管理</a></li>
            <li><a href="userAppraisingManage.php">表彰奖励管理</a></li>
            <li><a href="userTrainManage.php">培训管理</a></li>
        </ul>
        <?php } ?>
    </div>
</div>

<script>
$(function () {
    var cur = $("#cur").val();
    $(".user-menu-list a").each(function () {
        if (cur == $(this).attr("href")) {
            $(this).addClass("active");
        }
    })
    if ($(".active").length > 0) {
        var o = $(".active").parents('ul');
        o.show();
    }

    $(".user-menu-item").click(function () {
        var show = $(this).next().css('display');
        if (show == 'none') {
            $(this).next("ul").slideDown();
        } else {
            $(this).next("ul").slideUp();
        }
    });
});
</script>