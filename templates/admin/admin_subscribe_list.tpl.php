<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/adminAppraisingManage.css"/>
    <script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <script type="text/javascript" src="../templates/js/jsdate/WdatePicker.js"></script>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'admin_left.tpl.php'; ?>

        <div class="admin_right">
            <?php include 'admin_top.tpl.php'; ?>

            <div class="app_top">
                <form action='adminSubscribeList.php' class="searchFrom" id="myform" style="height: 105px;">
                    <fieldset class="searchFieldSet" style="height: 100px;">
                        <legend>查询条件</legend>
                        <table class="base_table" style="padding: 0px;">
                            <tbody>
                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;姓名：</th>
                                <td><input type="text" name="name" value="<?php echo $infos['name']; ?>"
                                           class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;手机：</th>
                                <td><input name="mobile" id="mobile" type="text" class="input length_2 mr10"
                                           value="<?php echo $infos['mobile']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="listright">&nbsp;&nbsp;组织机构：</td>
                                <td width="140" colspan='2'>
                                    <select id="secity" name="secity">
                                        <?php foreach($level as $k=>$v){?>
                                            <option value="<?php echo $v['sign'].'"'; if($infos[secity]==$v['sign']){echo "selected=selected";}?>"><?php echo $v['name'];?></option >
                                        <?php }?>
                                    </select>
                                </td>
                                <td colspan='6'></td>
                                <td align="right" colspan='2'>
                                    <input type="submit" name="doSearch" class="btn" value="查询"/>&nbsp;&nbsp;<a
                                        href="adminSubscribeList.php" class="btn" role="button"><span
                                            class="add"></span>重置</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </form>
            </div>

            <?php if ($now_flag) {?>
                <table>
                    <tbody><tr>
                        <td style="width:835px;"></td>
                        <td><button class="yesbtn" type="button" id="batch_exp" >导出</button></td>
                </table>
            <?php }?>

            <div class="uma" style="margin-top: 10px; margin-bottom: 10px;">
                <table class="list-table" cellspacing="1" cellpadding="2">
                    <tr>
                        <th align="center">ID</th>
                        <th align="center">姓名</th>
                        <th align="center">性别</th>
                        <th align="center">手机</th>
                        <th align="center">关注时间</th>
                        <th align="center">是否责任人</th>
                        <?php if ($now_flag) { ?>
                            <th align="center">操作</th>
                        <?php } ?>
                    </tr>
                    <?php foreach ($lists as $k => $v) { ?>
                        <tr>
                            <td align="center" width="100px">
                                <a style="cursor: pointer;" title="<?php echo $v[recordid]; ?>"><?php echo $v[recordid]; ?></a>
                            </td>
                            <td align="center" width="100px">
                                <a style="cursor: pointer;" title="<?php echo $v[name]; ?>"><?php echo $v[name]; ?></a>
                            </td>
                            <td align="center" width="100px">
                                <?php if($v[sex] == 1){?>
                                    <a style="cursor: pointer;"title="男">男</a>
                                <?php }elseif($v[sex] == 2){?>
                                    <a style="cursor: pointer;"title="女">女</a>
                                <?php }else{?>
                                    <a style="cursor: pointer;"title="不详">不详</a>
                                <?php }?>
                            </td>
                            <td align="center" width="80px"><?php echo $v['mobile']; ?></td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[add_date]; ?>"><?php echo $v[add_date]; ?></a>
                            </td>
                            <td align="center" width="100px">
                                <?php if($v[flag] == 0){?>
                                    <a style="cursor: pointer;color: red"title="否">否</a>
                                <?php }elseif($v[flag] == 1){?>
                                    <a style="cursor: pointer;color: green"title="是">是</a>
                                <?php }else{?>
                                    <a style="cursor: pointer;"title="不详">不详</a>
                                <?php }?>
                            </td>

                            <?php if ($now_flag) { ?>
                                <td align="center" width="60px">
                                    <a href="adminSubscribeList.php?act=show&recordid=<?php echo set_url($v['recordid']); ?>">
                                        <img src="../templates/images/manage/icon_view.gif" alt="查看" title="查看"/>
                                    </a>

                                    <a href="javascript:if(confirm('确定删除吗？')) location.href='adminSubscribeList.php?act=del&recordid=<?php echo set_url($v['recordid']);?>'"  style="text-decoration:none;" id="delete"><img src="../templates/images/manage/icon_drop.gif" alt="删除" title="删除"></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }
                    if (!$lists) {
                        ?>
                        <tr>
                            <td colspan='8' style="text-align: center">查无数据</td>
                        </tr><?php } ?>
                </table>
                <table>
                    <tr style="height:5px"></tr>
                </table>
                <?php include '../templates/page.php' ?>
                <table>
                    <tr style="height:30px"></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    //导出
    $("#batch_exp").click(function(){
        location.href = location.href +"&type=batch_exp";
    });
</script>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>