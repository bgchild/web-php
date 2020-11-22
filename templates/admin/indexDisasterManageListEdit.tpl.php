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
                <span style="color:#2D8DD3; "><b><?php if ($isshow == 1) echo "添加"; else echo "修改"; ?>内容</b></span>
            </div>
            <div style="margin-left:20px;">
                <form action='indexDisasterManageList.php' method='post' class="searchFrom">
                    <table class="base_table">
                        <tbody>
                        <tr>
                            <th><span style="color: red;">*&nbsp;</span>栏目：</th>
                            <td colspan="4"><input readonly="readonly" type="text" style="height:30px;" name="name"
                                                   value="<?php echo $column['name']; ?>" class="input length_5"/></td>
                        </tr>
                        <tr>
                            <th><span style="color: red;">*&nbsp;</span>标题：</th>
                            <td colspan="4"><input type="text" name="title" style="height:30px;" id="title"
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
                            <td><input type="button" id="uploadButton" value="上传图片"/></td>
                        </tr>
                        <tr>
                            <th><span style="color: red;">*&nbsp;</span>内容：</th>
                            <td colspan="4"><textarea name="content" id="cont" class="cont"
                                                      style="width:650px; height:400px;"><?php echo $detail['content']; ?></textarea>
                            </td>
                        </tr>

                        <?php if ($column['recordid'] == 169) { ?>
                        <tr>
                            <th><span style="color: red;">*&nbsp;</span>灾情预警：</th>
                            <td colspan="4">
                                <input type="checkbox" name="flag" value="1" <?php if($detail['flag']==1) echo 'checked'?>>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <input type="hidden" id="thumb_url" name="thumb_url" value="<?php if ($detail['pictures']) {
                                echo $detail['pictures'];
                            } ?>"/>
                            <?php if ($isshow == 1) { ?>
                                <td></td>
                                <td><input type="hidden" name="rid" class="btn" value="<?php echo $rid; ?>"/></td>
                                <td><input type="hidden" name="act" class="btn" value="add" id="act"/></td>
                                <td>
                                    <input type="submit" name="save" class="btn" id="save" value="保存为草稿"/>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php if (preg_match("/^zbadmin(.*)/", $now_admin)) { ?>
                                        <input type="submit" name="send" class="btn" id="send" value="保存并发布"/>
                                        &nbsp;&nbsp;&nbsp;
                                    <?php } ?>
                                    <a href="indexDisasterManage.php" class="btn">返回</a>
                                </td>
                            <?php } else { ?>
                                <td></td>
                                <td><input type="hidden" name="rid" class="btn"
                                           value="<?php echo $detail['recordid']; ?>"/></td>
                                <td><input type="hidden" name="act" class="btn" value="save" id="act"/></td>
                                <td>
                                    <input type="submit" name="save" id="save" class="btn" value="保存为草稿"/>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php if (preg_match("/^zbadmin(.*)/", $now_admin)) { ?>
                                        <input type="submit" name="send" class="btn" id="send" value="保存并发布"/>
                                        &nbsp;&nbsp;&nbsp;
                                    <?php } ?>
                                    <a href="<?php echo $backurl; ?>" class="btn">返回</a>
                                </td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#save').click(function () {
            if (!$('#title').val()) {
                ui.error('标题不能为空！');
                return false;
            }
            return true;
        });
    });

    KindEditor.ready(function (K) {
        var uploadbutton = K.uploadbutton({
            button: K('#uploadButton')[0],
            fieldName: 'imgFile',
            url: '../image_thumb.php?&time=' + new Date().getTime(),
            afterUpload: function (data) {
                if (data.error === 0) {
                    var url = '../' + K.formatUrl(data.url);
                    K('#thumb_url').val(url);
                    K('.thumb').html('<img src=' + url + ' />');
                } else {

                    alert(data.message);
                }
            },
            afterError: function (str) {
                alert('自定义错误信息: ' + str);
            }
        });
        uploadbutton.fileBox.change(function (e) {
            uploadbutton.submit();
        });
    });


    var editor;
    KindEditor.ready(function (K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager: false,
            resizeType: 1,
            items: [
                'source', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'table']
        });
    });
</script>

<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>