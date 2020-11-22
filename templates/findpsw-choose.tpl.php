<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/findpsw.css"/>
    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <div class="findpsw">
            <div class="fpsw_head">
                <span style="font-size: 16px;color: #313131;">重设密码：</span>
            </div>
            <div class="fpsw_con" style="text-align: center;">
                <div class="choose">
                    <div class="choose-header">
                        <p class="subtitle">选择您想要重置密码的方式:</p>
                        <p class="description">
                            请在下面的选项中进行选择，以重设 <label class="medium"><?php echo $_SESSION['findpsw.username'] ?></label>的密码
                        </p>
                    </div>
                    <div class="choose-body">
                        <form action="findpsw.php" method="post" class="choose-form">
                            <div class="choose-main-row">
                                <div class="choose-main-column">
                                    <input type="radio" class="option-radio" name="type" value="sms" checked />
                                </div>
                                <div class="choose-main-column multiple-options">
                                    <label class="option-label">获取短信动态码</label>
                                    <div class="subtext">
                                        我们会将动态码发送值您
                                        <label class="semi-bold"><?php echo preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2', $cellphone); ?></label>
                                        的手机号。
                                    </div>
                                </div>
                            </div>
                            <div class="choose-main-row">
                                <div class="choose-main-column">
                                    <input type="radio" class="option-radio" name="type" value="question" />
                                </div>
                                <div class="choose-main-column multiple-options">
                                    <label class="option-label">回答安全提示问题</label>
                                    <div class="subtext">
                                        回答您创建账号时选择的问题。
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="act" value="doChoose"/>
                            <div class="btn-group">
                                <button type="button" class="findpsw-cancel-btn">取消</button>
                                <!--<input type="image" class="doChoose-btn btn " src="templates/images/end.png" />-->
                                <button class="doChoose-btn findpsw-btn">确定</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include 'footer.tpl.php'; ?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".findpsw-cancel-btn").click(function() {
            if (confirm("确认取消?")) {
                location.href = "findpsw.php";
            }
        });

        $(".doChoose-btn").click(function(){
            $(".choose-form").submit();
        });
    });
</script>


</body>
</html>