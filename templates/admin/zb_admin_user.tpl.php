<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/adminUser.css"/>
    <script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <script type="text/javascript">
        $(function () {
            $("input[name='u_name']").blur(function () {
                username = $(this).val();
                username = $.trim(username);
                rid = $("#rid").val();

                if (username && !/^zbadmin(.*)$/.test(username)) {
                    ui.error('用户名必须以zbadmin开头!');
                    return;
                }


                $.ajax({
                    type: 'POST',
                    url: 'zbAdminUser.php',
                    data: {username: username, rid: rid, act: 'username'},
                    success: function (msg) {
                        if (msg == 'no') ui.error('用户名已存在');
                        return false;
                    }
                })
            });

            $('#adminuser').submit(function () {
                //用户名
                var username = $("input[name='u_name']").val();
                username = $.trim(username);
                if (!username) {
                    ui.error('用户名不能为空');
                    return false;
                }
                else if (username.length < 5 || username.length > 15) {
                    ui.error('用户名长度为5~15个字符');
                    return false;
                }
                else if (!/^[a-zA-Z]\w*$/.test(username)) {
                    ui.error('用户名由数字、下划线组成，首字符必须是英文字母');
                    return false;
                }
                else if (!/^zbadmin(.*)$/.test(username)) {
                    ui.error('用户名必须以zbadmin开头!');
                    return false;
                }

                //密码
                var password = $("input[name='u_pwd']").val();
                var rpassword = $("input[name='con_pwd']").val();
                if (!password) {
                    ui.error('密码不能为空');
                    return false;
                }
                else if (password.length < 6 || password.length > 20) {
                    ui.error('密码长度为6~20个字符');
                    return false;
                }
                else if (password != rpassword) {
                    ui.error('密码输入不一致');
                    return false;
                }
            });
        });


    </script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'admin_left.tpl.php'; ?>

        <div class="admin_right">
            <?php include 'admin_top.tpl.php'; ?>
            <div class="adm_user">

                <form name="myform" method="post" action="" id="adminuser">
                    <table class="contact_table">
                        <tr>
                            <td class="list-right">用户名：</td>
                            <?php if (!$spm) { ?>
                                <td>
                                    <input name="u_name" class="input length_3" type="text" value=""/></td>
                            <?php } else { ?>
                                <td><?php echo $adminuserOne['u_name']; ?><input name="u_name" type="hidden"
                                                                                 value="<?php echo $adminuserOne['u_name']; ?>"/>
                                </td>
                            <?php } ?>
                            <td class="liststart"><span style="color:red">*</span></td>
                            <td>用户名长度为5-15个字符，可用英文字母、数字、下划线组成，首字符必须是英文字母。</td>
                        </tr>
                        <tr>
                            <td class="list-right">密码：</td>
                            <td><input name="u_pwd" class="input length_3" type="password" value=""/></td>
                            <td class="liststart"><span style="color:red">*</span></td>
                            <td>密码长度为6-20个字符，可用英文字母、数字、特殊字符组合</td>
                        </tr>
                        <tr>
                            <td class="list-right">确认密码：</td>
                            <td><input name="con_pwd" class="input length_3" type="password" value=""/></td>
                            <td class="liststart"><span style="color:red">*</span></td>
                            <td>重复上面的密码</td>
                        </tr>

                        <tr>
                            <td><input type="hidden" name="rid" id="rid"
                                       value="<?php echo $adminuserOne['recordid']; ?>"/></td>
                            <td class="listcenter"><?php if (!$spm) { ?><input type="submit" name="dosubmit" class="btn"
                                                                               value="提交"/><?php } else { ?><input
                                        type="submit" name="doedit" class="btn" value="提交"/><?php } ?>&nbsp;&nbsp;&nbsp;<input
                                        type="reset" name="doreset" class="btn" value="重置"/>&nbsp;<a
                                        href="zbAdminUserList.php" style="text-decoration: none;"
                                        class="addbtn btn_alone">返回</a></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </table>
                </form>
            </div>

        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>

</body>
</html>