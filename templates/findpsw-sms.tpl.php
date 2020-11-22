<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/findpsw.css"/>
    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="templates/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <div class="findpsw">
            <div class="fpsw_head">
                <span style="font-size: 16px;color: #313131;">短信验证：</span>
            </div>
            <div class="fpsw_con">
                <form action="findpsw.php" method="post"  class="sms-form" autocomplete="off">
                    <table>
                        <tr>
                            <td align="right">手机号码：</td>
                            <td><?php echo preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2', $cellphone); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right">
                                <span style="color: red;margin-right:4px;">*</span>验证码：
                            </td>
                            <td>
                                <input type="text" class="textyzm" id="smscode" name="smscode" onblur="javascript:on_blur1();" />
                            </td>
                            <td style="vertical-align: bottom;">
                                <span class="sms-send-btn">发送</span>
                                <span id="alert_sms" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;请输入验证码</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <span style="color: red;margin-right:4px;">*</span>新密码：
                            </td>
                            <td>
                                <input type="password" class="textyzm" id="password" name="password" onblur="javascript:on_blur2();" />
                            </td>
                            <td>
                                <span id="alert_password" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;请输入密码</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <span style="color: red;margin-right:4px;">*</span>确认密码：
                            </td>
                            <td>
                                <input type="password" class="textyzm" id="confirm_password" name="confirm_password" onblur="javascript:on_blur3();" />
                            </td>
                            <td>
                                <span id="alert_confirm_password" style="margin-left:8px;color: red;display:none;"><img src="templates/images/errorl.png" />&nbsp;密码不一致</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2 class="l_btn">
                                <div class="btn-group" style="margin-left: 60px; margin-top: 10px;">
                                    <button type="button" class="doSms-btn findpsw-btn">确定</button>
                                </div>
                                <input type="hidden" name="act" value="changePwdBySmsCode"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.tpl.php'; ?>

<script type="text/javascript">

    function on_blur1() {
        if ( !$('#smscode').val() ) {
            $('#alert_sms').attr('style','margin-left:8px;color: red;');
        } else {
            $('#alert_sms').attr('style','margin-left:8px;color: red;display:none');
        }

    }

    function on_blur2() {
        if ( !$('#password').val() ) {
            $('#alert_password').attr('style','margin-left:8px;color: red;');
        } else {
            $('#alert_password').attr('style','margin-left:8px;color: red;display:none');
        }

        validatePasswordEqual();
    }

    function on_blur3() {
        validatePasswordEqual();
    }


    function validatePasswordEqual() {
        if ( $('#password').val() != $('#confirm_password').val() ) {
            $('#alert_confirm_password').attr('style','margin-left:8px;color: red;');
        } else {
            $('#alert_confirm_password').attr('style','margin-left:8px;color: red;display:none');
        }
    }


    $(document).ready(function(){
        $(".doSms-btn").click(function(){
            var password =  $('#password').val();
            var confirm_password = $('#confirm_password').val();
            if ( password != confirm_password ) {
                validatePasswordEqual();
            } else {
                $(".sms-form").submit();
            }
        });


        // cookie存在倒计时
        if ( $.cookie("s") != undefined && $.cookie("s")!='NaN' && $.cookie("s")!='null' ) {
            timerKeeping($(".sms-send-btn"));
        }

        $(".sms-send-btn").click(function() {
            var self = this;
            if ($(self).attr("disabled")) return;
            $(self).attr("disabled", true);

            $.ajax({
                type:'POST',
                url:'findpsw.php',
                data:{act: 'sendSmsCode'},
                dataType: "json",
                success: function(res){
                    if ( !res ) return;

                    if ( res.errcode ) {
                        ui.error(res.errmsg);
                    } else {
                        ui.success("发送短信验证码成功，请注意查看您的手机");
                    }
                },
                error: function(msg) {
                    if (msg) ui.error(msg);
                },
                complete: function() {
                    $(self).attr("disabled", false);

                    $.cookie("s", 60);
                    //$.cookie("s", 10);
                    timerKeeping(self);

                }
            });






        });

        var ing = false, s, timer;
        function timerKeeping(self) {
            if (ing) {
                return;
            }

            clearInterval(timer);
            ing = true;
            s = 30;
            s = $.cookie("s");
            $(self).addClass('disabled').text(s--);
            timer = setInterval(function() {
                $(self).text(s--);

                if ( s < 1 ) {
                    clearInterval(timer);
                    $.cookie("s", s, {expires: -1});

                    $(self).text("发送").removeClass('disabled');
                    ing = false;
                } else {
                    $.cookie("s", s);
                }
            }, 1000);
        }
    });
</script>


</body>
</html>