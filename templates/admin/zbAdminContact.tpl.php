<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/adminContact.css"/>
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

            <div class="adm_con">
                <form action="zbAdminContact.php" method="post" class="contactForm">
                    <table class="contact_table" cellspacing="1" cellpadding="2">
                        <tr>
                            <td class="list-right">标题：</td>
                            <td><input type="text" style="width:250px" id='title' class="input" name="title"
                                       value="<?php echo $one['title'] ?>"/><font color="#ff0000">*</font></td>
                        </tr>
                        <tr>
                            <td class="list-right">邮政编码：</td>
                            <td><input type="text" id='mailcode' class="input" name="mailcode"
                                       value="<?php echo $one['mailcode'] ?>"/><font color="#ff0000">*</font></td>
                        </tr>
                        <tr>
                            <td class="list-right">电话：</td>
                            <td><input type="text" id='tel' class="input" name="tel" value="<?php echo $one['tel'] ?>"/><font
                                        color="#ff0000">*</font></td>
                        </tr>
                        <tr>
                            <td class="list-right">传真：</td>
                            <td><input type="text" id="fax" class="input" name="fax" value="<?php echo $one['fax'] ?>"/><font
                                        color="#ff0000">*</font>国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位),其中电话号码必填
                            </td>
                        </tr>
                        <tr>
                            <td class="list-right">电子邮箱：</td>
                            <td><input type="text" id="email" class="input" name="email"
                                       value="<?php echo $one['email'] ?>"/><font color="#ff0000">*</font></td>
                        </tr>
                        <tr>
                            <td class="list-right">网址：</td>
                            <td><input type="text" id="weburl" class="input" name="weburl"
                                       value="<?php echo $one['weburl'] ?>" style="width:400px;"/><font color="#ff0000">*</font>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-right">地址：</td>
                            <td><input type="text" id="addr" class="input" name="addr"
                                       value="<?php echo $one['addr'] ?>" style="width:400px;"/><font
                                        color="#ff0000">*</font>中文占2个字节，其余占1个字节
                            </td>
                        </tr>
                        <tr>
                            <td class="list-right">救援队号码：</td><td><input type="text" id="htels" class="input" name="htels" value="<?php echo $one['htels']?>" style="width:400px;"/><font color="#ff0000">*</font>救援队号码，多个请用","隔开</td>
                        </tr>
                        <tr>
                            <td></td>
                            <?php if ($now_flag) { ?>
                                <td>
                                    <input type="submit" name="submit" id="submit" class="btn" value="保存为草稿"/>
                                    <?php if (preg_match("/^zbadmin(.*)/", $now_admin)) { ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="submit" name="send" id="send" class="btn" value="保存并发布"/>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </table>
                </form>
            </div>


            <script type="text/javascript">
                $(document).ready(function () {

                    function getLength(s) {
                        var len = 0;
                        var a = s.split("");
                        for (var i = 0; i < a.length; i++) {
                            if (a[i].charCodeAt(0) < 299) {
                                len++;
                            } else {
                                len += 2;
                            }
                        }
                        return len;
                    }

                    function isEmail(strEmail) {
                        if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
                            return true;
                        else return false;
                    }


                    function isURL(str_url) {
                        var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
                            + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
                            + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
                            + "|" // 允许IP和DOMAIN（域名）
                            + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
                            + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
                            + "[a-z]{2,6})" // first level domain- .com or .museum
                            + "(:[0-9]{1,4})?" // 端口- :80
                            + "((/?)|" // a slash isn't required if there is no file name
                            + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
                        var re = new RegExp(strRegex);
                        if (re.test(str_url)) {
                            return true;
                        } else {
                            return false;
                        }
                    }

                    function isPostalCode(s) {
                        var pattern = /^[0-9]{6}$/;
                        if (!pattern.exec(s)) return false;
                        else return true;
                    }

                    function isTelephone(obj) {
                        var pattern = /(^(([0-9]{3,4}\-)|(\([0-9]{3,4}\)))?[0-9]{3,8}$)|(^[0-9]{11}$)/;
                        if (pattern.test(obj)) {
                            return true;
                        } else {
                            return false;
                        }
                    }

                    function isFax(obj) {
                        //国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位)"
                        var pattern = /^(([0+]?[0-9]{2,3}-)?(0?[0-9]{2,3})-)?[0-9]{7,8}(-[0-9]{3,})?$/;
                        if (!pattern.test(obj)) return false;
                        return true;
                    }


                    $(".contactForm").submit(function () {
                        if (getLength($('#title').val()) == 0) {
                            ui.error("请填写标题！");
                            $('#title').focus();
                            return false;
                        }
                        if (isPostalCode($('#mailcode').val()) == false) {
                            ui.error("邮编填写错误！");
                            $('#mailcode').focus();
                            return false;
                        }
                        if (isTelephone($('#tel').val()) == false) {
                            ui.error("电话填写错误！");
                            $('#tel').focus();
                            return false;
                        }
                        if (isFax($('#fax').val()) == false) {
                            ui.error("传真填写错误！");
                            $('#fax').focus();
                            return false;
                        }
                        if (isEmail($('#email').val()) == false) {
                            ui.error("电子邮件填写错误！");
                            $('#email').focus();
                            return false;
                        }
                        if (isURL($('#weburl').val()) == false) {
                            ui.error("网址填写错误！");
                            $('#weburl').focus();
                            return false;
                        }
                        if (getLength($('#addr').val()) == 0) {
                            ui.error("请填写地址！");
                            $('#addr').focus();
                            return false;
                        }
                        if (getLength($('#addr').val()) >= 80) {
                            ui.error("地址字节数量不能超过80！");
                            $('#addr').focus();
                            return false;
                        }
                        return true;
                    });
                });
            </script>


        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>