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
            <div class="searchFrom" style="margin-left:20px;">
                <table class="base_table">
                    <tbody>
                    <tr>
                        <th width="125">灾情名称：</th>
                        <td colspan="4"><?php echo $info['name'] ? $info['name'] : '不详'; ?></td>
                    </tr>
                    <tr>
                        <th width="125">灾情种类：</th>
                        <td colspan="4"><?php echo $info['cate_name'] ? $info['cate_name'] : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">灾情地点：</th>
                        <td colspan="4"><?php echo $info['address'] ? $info['address'] : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">事发地点：</th>
                        <td colspan="4"><?php echo $info['place'] ? $info['place'] : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">灾情描述：</th>
                        <td colspan="4"><?php echo $info['description'] ? $info['description'] : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">受灾人数：</th>
                        <td colspan="4"><?php echo $info['victims_num'] ? $info['victims_num'] . "人" : '不详' ?></td>
                    </tr>

                    <tr>
                        <th width="125">受伤人数：</th>
                        <td colspan="4"><?php echo $info['injured_num'] ? $info['injured_num'] . "人" : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">失踪人数：</th>
                        <td colspan="4"><?php echo $info['missing_num'] ? $info['missing_num'] . "人" : '不详'; ?></td>
                    </tr>


                    <tr>
                        <th width="125">死亡人数：</th>
                        <td colspan="4"><?php echo $info['die_num'] ? $info['die_num'] . "人" : '不详'; ?></td>
                    </tr>


                    <tr>
                        <th width="125">受紧急转移安置人口：</th>
                        <td colspan="4"><?php echo $info['transfer_num'] ? $info['transfer_num'] . "人" : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">需口粮救济人口：</th>
                        <td colspan="4"><?php echo $info['food_help_num'] ? $info['food_help_num'] . "人" : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">损坏耕地面积：</th>
                        <td colspan="4"><?php echo $info['damage_land'] ? $info['damage_land'] . "公顷" : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">农作物/草场受灾面积：</th>
                        <td colspan="4"><?php echo $info['damage_crops'] ? $info['damage_crops'] . "公顷" : '不详'; ?></td>
                    </tr>

                    <tr>
                        <th width="125">建筑物损毁情况：</th>
                        <td colspan="4"><?php echo $info['damage_building'] ? $info['damage_building'] : '不详'; ?></td>
                    </tr>


                    <tr>
                        <th width="125">灾情附件：</th>
                        <td colspan="4">
                            <?php if ($info['attachment']) { ?>
                                <?php echo $info['attachment']; ?>
                            <?php } else {
                                echo "未上传附件";
                            } ?>
                        </td>
                    </tr>

                    <tr>
                        <th width="125">灾情图片：</th>
                        <td colspan="4">
                            <div class="thumb" style="border: 1px solid #ccc"><?php if ($info['image']) { ?>
                                    <?php foreach ($info['image'] as $ik => $iv) { ?>
                                        <img style="float:left" src="<?php echo $iv ?>">
                                    <?php } ?>
                                <?php } else {
                                    echo "未上传图片";
                                } ?></div>
                        </td>
                    </tr>

                    <tr>
                        <th width="125">上报人：</th>
                        <td colspan="4"><?php echo $info['vname']; ?></td>
                    </tr>

                    <tr>
                        <th width="125">上报人身份：</th>
                        <td colspan="4"><?php echo $info['type_desc']; ?></td>
                    </tr>

                    <tr>
                        <th width="125">手机：</th>
                        <td colspan="4"><?php echo $info['mobile']; ?></td>
                    </tr>

                    <tr>
                        <th width="125">上报时间：</th>
                        <td colspan="4"><?php echo $info['addDate']; ?></td>
                    </tr>

                    <tr>
                        <th width="125">处理状态：</th>
                        <td colspan="4">
                            <?php if ($info['status'] == 0) { ?>
                                <span style="color: red"><?php echo $info['status_desc']; ?></span>
                            <?php } elseif ($info['status'] == 1) { ?>
                                <span style="color: blue"><?php echo $info['status_desc']; ?></span>
                            <?php } elseif ($info['status'] == 2) { ?>
                                <span style="color: green"><?php echo $info['status_desc']; ?></span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td colspan="4"><a href="<?php echo $backurl; ?>" class="btn">返回</a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>