<div class="admin_left">
    <?php
    function php_self()
    {
        $php_self = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1);
        return $php_self;
    }

    $cur = php_self();

    $userinfo = $admin_op->xxtea->parseLoginIdentify($_SESSION['admin_identify']);

    ?>
    <input type="hidden" value="<?php echo $cur ?>" id="cur"/>
    <div class="manage_sys">管理平台</div>
    <div class="left_menu" style=" padding-bottom:20px;">
        <?php if (strpos($userinfo[1], 'zbadmin') === 0) { ?>
            <div class="s_list_t">灾害管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="indexDisasterManage.php">首页模块管理</a></li>
                <li><a href="adminDisasterflash.php">首页flash管理</a></li>

                <li><a href="adminDisasterList.php">灾害列表</a></li>
                <li><a href="adminHelpList.php">求助列表</a></li>

                <li><a href="adminSubscribeList.php">关注人员管理</a></li>
            </ul>

            <div class="s_list_t">页面管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="zbAdminContact.php">联系方式管理</a></li>
                <li><a href="zbAdminAbout.php">关于我们管理</a></li>
            </ul>

            <div class="s_list_t">系统管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="zbAdminUserList.php">管理员管理</a></li>
            </ul>
        <?php } else { ?>
            <div class="s_list_t">志愿者管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="volunteer.php">志愿者初审</a></li>
                <li><a href="volunteerManage.php">志愿者管理</a></li>
                <li><a href="joinManage.php">志愿者转入转出管理</a></li>
            </ul>
            <div class="s_list_t">志愿服务队管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="captain.php">队长管理</a></li>
                <li><a href="activity.php">活动审核</a></li>
                <li><a href="serviceTeamAudit.php">服务队审核</a></li>
                <li><a href="serviceTeamMessage.php">服务队管理</a></li>
            </ul>
            <div class="s_list_t">志愿服务统计<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="volunteerCount.php">志愿者数统计</a></li>
                <li><a href="serviceteamCount.php">志愿服务队数统计</a></li>
                <li><a href="servicetimeCount.php">志愿服务工时统计</a></li>
                <li><a href="serviceobjCount.php">服务受益对象统计</a></li>
                <li><a href="activityCount.php">志愿服务活动项目统计</a></li>
              <!--   <?php
                $name = $admin_op->getUserName();
                if (($name === 'admin') && ($_SESSION['sign'] === 'www')) { ?>
                    <li><a href="serviceTimeObjCount.php">志愿服务工时+受益对象统计</a></li>
                <?php } ?> -->
            </ul>
            <div class="s_list_t"><a href="appraisingManage.php">评优管理</a><span>&gt;</span></div>
            <div class="s_list_t">页面管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="indexManage.php">首页模块管理</a></li>
                <li><a href="adminflash.php">首页flash管理</a></li>
                <li><a href="adminlink.php">相关连接</a></li>
                <li><a href="adminContact.php">联系方式管理</a></li>
                <li><a href="adminAbout.php">关于我们管理</a></li>
                <?php

                if (($name === 'admin') && ($_SESSION['sign'] === 'www')) {
                    ?>
                    <li><a href="fastChannel.php">首页快捷通道管理</a></li>
                <?php } ?>
                <li><a href="volunteerService.php">志愿者帮助栏目管理</a></li>
            </ul>

            <div class="s_list_t">系统管理<span>&gt;</span></div>
            <ul class="clearfix" style="display:none">
                <li><a href="adminuserlist.php">管理员管理</a></li>
                <?php
                if (($name === 'admin') && ($_SESSION['sign'] === 'www')) {
                    ?>
                    <li><a href="adminLogs.php">后台操作日志</a></li>
                    <li><a href="adminDownload.php">文件上传</a></li>
                    <li><a href="dic.php">数字字典</a></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

</div>
<style>
    .s_list_t a {
        color: #FFF
    }

    .s_list_t {
        cursor: pointer;
        width: 100%;
        float: left;
        height: 40px;
        line-height: 40px;
        color: #FFF;
        border-radius: 2px;
        margin-bottom: 2px;
        font-size: 16px;
        background: #E9423C;
        text-indent: 50px;
    }

    .s_list_t span {
        float: right;
        padding-right: 20px;
    }
</style>
<script>

    $(function () {
        var cur = $("#cur").val();
        $(".left_menu a").each(function () {
            if (cur == $(this).attr("href")) {
                $(this).addClass("active");
            }
        })
        if ($(".active").length > 0) {
            var o = $(".active").parents('ul');
            o.show();
        }

        $(".s_list_t").click(function () {
            var show = $(this).next().css('display');
            if (show == 'none') {
                $(this).next("ul").slideDown();
            } else {
                $(this).next("ul").slideUp();
            }
        });
    })
</script>