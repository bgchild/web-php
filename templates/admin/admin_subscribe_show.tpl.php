<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/admin_indexNews.css"/>
    <script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../templates/css/imgupload.css"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/imgareaselect-animated.css"/>
    <script type="text/javascript" src="../templates/js/jquery.imgareaselect.min.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <script type="text/javascript" src="../templates/js/jquery.pagination.js"></script>
    <link rel="stylesheet" href="../admin/keditor/themes/default/default.css"/>
    <link rel="stylesheet" href="../admin/keditor/plugins/code/prettify.css"/>
    <script charset="utf-8" src="../admin/keditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="../admin/keditor/lang/zh_CN.js"></script>
    <script charset="utf-8" src="../admin/keditor/plugins/code/prettify.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'admin_left.tpl.php'; ?>
        <div class="admin_right">
            <?php include 'admin_top.tpl.php'; ?>
            <table width="750">
                <tr>
                    <td height="5"></td>
                </tr>
            </table>
            <div style="height:30px;line-height:30px;">
                <span style="color:#2D8DD3; "><b><?php echo $title;?></b></span>
            </div>
            <div style="margin-left:20px;">
                <form action='adminSubscribeList.php' method="post" class="postFrom">
                    <table class="base_table">
                        <tbody>
                        <tr>
                            <th width="65">姓名：</th>
                            <td colspan="4"><?php echo $info['name']; ?></td>
                        </tr>
                        
                        <tr>
                            <th width="65">性别：</th>
                            <td colspan="4">
                                <?php if($info[sex] == 1){?>
                                    男
                                <?php }elseif($info[sex] == 2){?>
                                    女
                                <?php }else{?>
                                    不详
                                <?php }?>
                            </td>
                        </tr>

                        <tr>
                            <th width="65">身份证号：</th>
                            <td colspan="4"><?php echo $info['cardno']; ?></td>
                        </tr>

                        <tr>
                            <th width="65">手机：</th>
                            <td colspan="4"><?php echo $info['mobile']; ?></td>
                        </tr>

                        <tr>
                            <th width="65">邮件：</th>
                            <td colspan="4"><?php echo $info['email']; ?></td>
                        </tr>

                        <tr>
                            <th width="65">地址：</th>
                            <td colspan="4"><?php echo $info['address']; ?></td>
                        </tr>

                        <tr>
                            <th width="65">关注时间：</th>
                            <td colspan="4"><?php echo $info['addDate'];?></td>
                        </tr>

                        <tr>
                            <th width="65">设置为责任人：</th>
                            <td colspan="4">
                                <select name="flag">
                                    <option value="0" <?php if($info['flag'] == 0) echo "selected"?>>否</option>
                                    <option value="1" <?php if($info['flag'] == 1) echo "selected"?>>是</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td><input type="submit" name="save" id="save" class="btn" value="保存"/></td>
                            <td><a href="<?php echo $backurl;?>" class="btn">返回</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="act" value="edit"/>
                    <input type="hidden" name="rid" value="<?php echo set_url($info['recordid']);?>"/>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>