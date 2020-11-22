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
                <span style="color:#2D8DD3; "><b><?php echo $title; ?></b></span>
            </div>
            <div style="margin-left:20px;">
                <form action='adminHelpList.php' method='post' class="searchFrom">
                    <table class="base_table">
                        <tbody>
                        <tr>
                            <th width="95">求助需求：</th>
                            <td colspan="4"><?php echo $info['name']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">求助地点：</th>
                            <td colspan="4"><?php echo $info['address']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">事发地点：</th>
                            <td colspan="4"><?php echo $info['place'] ? $info['place'] : '不详'; ?></td>
                        </tr>

                        <tr>
                            <th width="95">求助描述：</th>
                            <td colspan="4"><?php echo $info['description']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">求助附件：</th>
                            <td colspan="4">
                                <?php if ($info['pictures']) { ?>
                                    <?php echo $info['attachment']; ?>
                                <?php } else {
                                    echo "未上传附件";
                                } ?>
                            </td>
                        </tr>

                        <tr>
                            <th width="95">求助图片：</th>
                            <td colspan="4">
                                <div class="thumb"><?php if ($info['pictures']) { ?> <img
                                            src="<?php echo $info['pictures'] ?>"> <?php } else {
                                        echo "未上传图片";
                                    } ?></div>
                            </td>
                        </tr>

                        <tr>
                            <th width="95">求助人：</th>
                            <td colspan="4"><?php echo $info['vname']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">求助人身份：</th>
                            <td colspan="4"><?php echo $info['type_desc']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">手机：</th>
                            <td colspan="4"><?php echo $info['mobile']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">上报时间：</th>
                            <td colspan="4"><?php echo $info['addDate']; ?></td>
                        </tr>

                        <tr>
                            <th width="95">备注：</th>
                            <td colspan="4">
                                <textarea name="remark" id="remark" class="cont" style="width:800px; height:400px;">
                                    <?php echo $info['remark']; ?>
                                </textarea>
                            </td>
                        </tr>

                        <tr>
                            <th width="95">处理状态：</th>
                            <td colspan="4">
                                <select name="status" id="status">
                                    <option value="0" <?php if ($info['status'] == 0) {
                                        echo "selected";
                                    } ?>>未处理
                                    </option>
                                    <option value="1" <?php if ($info['status'] == 1) {
                                        echo "selected";
                                    } ?>>处理中
                                    </option>
                                    <option value="2" <?php if ($info['status'] == 2) {
                                        echo "selected";
                                    } ?>>已处理
                                    </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="hidden" name="recordid" class="btn"
                                       value="<?php echo $info['recordid']; ?>"/></td>
                            <td><input type="hidden" name="act" class="btn" value="save" id="act"/></td>
                            <td><input type="submit" name="save" id="save" class="btn" value="保存"/>&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo $backurl; ?>" class="btn">返回</a></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
<script type="text/javascript">
    var editor;
    KindEditor.ready(function (K) {
        editor = K.create('textarea[name="remark"]', {
            allowFileManager: false,
            resizeType: 1,
            items: [
                'source', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'table']

        });
    });
</script>
</body>
</html>