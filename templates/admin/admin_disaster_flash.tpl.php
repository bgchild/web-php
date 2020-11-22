<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../templates/css/admin_flash.css"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/imgupload.css"/>
    <script type="text/javascript" src="../include/keditor/kindeditor-min.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <style>

    </style>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'admin_left.tpl.php'; ?>
        <div class="admin_right">
            <?php include 'admin_top.tpl.php'; ?>
            <div class="adminflash">
                <a href="admindisasteraddflash.php" <?php if (!$now_flag) { ?> style="visibility:hidden"<?php } ?>
                   class="addbtn btn_alone" role="button"><span class="add"></span>添加flash</a>
                <form action="admindisasterflash.php" method="post" id="orderlist">
                    <table class="list-table" cellspacing="1" cellpadding="2">
                        <tr>
                            <th>排序</th>
                            <th>名称</th>
                            <th>url</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach ($Info as $key => $val) { ?>
                            <tr>
                                <td>
                                    <input type="text" name="order[]" class="input length_0" value="<?php echo $val['orderlist'] ?>"/>
                                </td>
                                <td><?php echo $val['name'] ?></td>
                                <td><?php echo $val['url'] ?></td>
                                <td>
                                    <a href="admindisasteraddflash.php?rid=<?php echo set_url($val['id']); ?>">
                                        <img src="../templates/images/manage/icon_edit.gif"/>
                                    </a>
                                    <?php if ($now_flag) { ?>
                                    <a href="javascript:if(confirm('确定删除么?')) location.href='admindisasterflash.php?recordid=<?php echo set_url($val['id']); ?>' " class="del" >
                                        <img src="../templates/images/manage/icon_drop.gif"/>
                                    </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <input type="hidden" name="pid[]" value="<?php echo $val['id'] ?>"/>
                        <?php } ?>
                    </table>
                    <div class="order">
                        <?php if ($now_flag) { ?>
                            <input type="submit" name="or_btn" class="btn" value="排序"/>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("#orderlist").submit(function () {
        var ord = '0';
        $('td input').each(function () {
            var order = $(this).val().replace(/[ ]/g, "");
            if (!order) {
                ord = '1';
                return false;
            }
            reg = /^[1-9]\d?$/;
            if (!reg.test(order)) {
                ord = '2';
            }
        });

        if (ord == '1') {
            ui.error('排序号必填!');
            return false;
        }

        if (ord == '2') {
            ui.error('最多为2位数的正整数！');
            return false;
        }
    });

</script>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>