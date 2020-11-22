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
                <span style="color:#2D8DD3; "><b>查看内容</b></span>
            </div>
            <div style="margin-left:20px;">
                <form action='indexDisasterManageList.php' method='post' class="searchFrom">
                    <table class="base_table">
                        <tbody>
                        <tr>
                            <th><span style="color: red;"></span>栏目：</th>
                            <td colspan="4">
                                <input readonly="readonly" type="text" style="height:30px;" name="name"
                                                   value="<?php echo $column['name']; ?>" class="input length_5"/></td>
                        </tr>
                        <tr>
                            <th><span style="color: red;"></span>标题：</th>
                            <td colspan="4">
                                <input readonly="readonly" type="text" name="title" style="height:30px;" id="title"
                                                   maxlength="26" value="<?php echo $detail['title']; ?>"
                                                   class="input length_5"/></td>
                        </tr>
                        <tr>
                            <th>缩略图：</th>
                            <td colspan="3">
                                <div class="thumb"><?php if ($detail['pictures']) { ?> <img
                                            src="<?php echo $detail['pictures'] ?>"> <?php } else {
                                        echo "生成160px*120px缩略图";
                                    } ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th><span style="color: red;"></span>内容：</th>
                            <td colspan="4">
                                <div style="width:650px; height:400px;border: 1px solid #ccc;overflow: scroll;padding: 4px;"><?php echo $detail['content']; ?></div>
                            </td>
                        </tr>

                        <?php if ($column['recordid'] == 169) { ?>
                        <tr>
                            <th><span style="color: red;"></span>灾情预警：</th>
                            <td colspan="4">
                                <input disabled="disabled" type="checkbox" name="flag" value="1" <?php if($detail['flag']==1) echo 'checked'?>>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td></td>
                            <td></td>
                           <td><a href="<?php echo $backurl; ?>" class="btn">返回</a></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>