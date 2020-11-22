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
    <style>
        .list-table tr > th, td {
            display: table-cell;
            white-space: nowrap;
            padding: 0 10px;
        }

        .page {
            padding-bottom: 20px;
        }
    </style>
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

            <div class="app_top" style="height: 200px">
                <form action='adminHelpList.php' class="searchFrom" id="myform" style="height: 105px;">
                    <fieldset class="searchFieldSet" style="height: auto;">
                        <legend>查询条件</legend>
                        <table class="base_table" style="padding: 0px;">
                            <tbody>
                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;求助需求：</th>
                                <td><input type="text" name="dname" value="<?php echo $infos['dname']; ?>"
                                           class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上报日期：</th>
                                <td><input name="sdate" id="sdate" onclick="WdatePicker()"
                                           readonly="readonly" type="text" class="input length_2 mr10 J_date date"
                                           value="<?php echo $infos['sdate']; ?>"/>&nbsp;至&nbsp;
                                    <input name="edate" id="edate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_2 mr10 J_date date" value="<?php echo $infos['edate']; ?>"/>
                                </td>
                                <th></th>
                                <td></td>
                                <th></th>
                                <td></td>

                            </tr>
                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;求助地点：</th>
                                <td><input type="text" name="address" value="<?php echo $infos['address']; ?>"
                                           class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;事发地点：</th>
                                <td><input name="place" id="place" type="text" style="width: 100%" class="input"
                                           value="<?php echo $infos['sdate']; ?>"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;当前状态：</th>
                                <td colspan='2'><select name="status" id="status">
                                        <option value="" <?php if (!isset($infos['status'])) {
                                            echo "selected";
                                        } ?>>全部
                                        </option>
                                        <option value="0" <?php if ($infos['status'] === "0") {
                                            echo "selected";
                                        } ?>>未处理
                                        </option>
                                        <option value="1" <?php if ($infos['status'] === "1") {
                                            echo "selected";
                                        } ?>>处理中
                                        </option>
                                        <option value="2" <?php if ($infos['status'] === "2") {
                                            echo "selected";
                                        } ?>>已处理
                                        </option>
                                    </select>
                                </td>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;求助描述</th>
                                <td colspan='3'><input name="description" id="description" class="input" style="width: 340px" type="text"
                                           value="<?php echo $infos['description']; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <th></th>
                                <td></td>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="listright">&nbsp;&nbsp;组织机构：</td>
                                <td width="140" colspan='2'>
                                    <select id="secity" name="secity">
                                        <option value="all">全部</option>
                                        <?php foreach ($level as $k => $v) { ?>
                                            <option value="<?php echo $v['sign'] . '"';
                                            if ($infos[secity] == $v['sign']) {
                                                echo "selected=selected";
                                            } ?>"><?php echo $v['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td colspan='6'></td>
                                <td align="right" colspan='2'>
                                    <input type="submit" name="doSearch" class="btn" value="查询"/>&nbsp;&nbsp;<a
                                            href="adminHelpList.php" class="btn" role="button"><span
                                                class="add"></span>重置</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </form>
            </div>

            <?php if ($now_flag) { ?>
                <table>
                    <tbody>
                    <tr>
                        <td style="width:805px;"></td>
                        <td>
                            <button class="yesbtn" type="button" id="batch_exp">导出</button>
                        </td>
                </table>
            <?php } ?>

            <div class="uma" style="margin-top: 10px; margin-bottom: 10px;width: 865px;overflow: scroll">
                <table class="list-table" cellspacing="1" cellpadding="2">
                    <tr>
                        <th align="center">求助需求</th>
                        <th align="center">求助地点</th>
                        <th align="center">事发地点</th>
                        <th align="center">求助描述</th>
                        <th align="center">求助人</th>
                        <th align="center">求助人身份</th>
                        <th align="center">联系方式</th>
                        <th align="center">上报时间</th>
                        <th align="center">当前状态</th>
                        <?php if ($now_flag) { ?>
                            <th align="center">操作</th>
                        <?php } ?>
                    </tr>
                    <?php foreach ($lists as $k => $v) { ?>
                        <tr>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[name]; ?>"><?php echo $v[name] ? $v[name] : "不详"; ?></a>
                            </td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[address]; ?>"><?php echo $v[address] ? $v[address] : "不详"; ?></a>
                            </td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[place]; ?>"><?php echo $v[place] ? $v[place] : "不详"; ?></a>
                            </td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[description]; ?>"><?php echo $v[description] ? $v[description] : "不详"; ?></a>
                            </td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[vname]; ?>"><?php echo $v[vname] ? $v[vname] : '不详'; ?></a>
                            </td>
                            <td align="center"><?php echo $v[type_desc] ? $v[type_desc] : '不详'; ?></td>
                            <td align="center"><?php echo $v[mobile] ? $v[mobile] : '不详'; ?></td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[add_date]; ?>"><?php echo $v[add_date] ? $v[add_date] : '不详'; ?></a>
                            </td>
                            <td align="center">
                                <?php if ($v['status'] == 0) { ?>
                                    <a style="cursor: pointer;color: red"
                                       title="<?php echo $v[status_desc]; ?>"><?php echo $v[status_desc]; ?></a>
                                <?php } elseif ($v['status'] == 1) { ?>
                                    <a style="cursor: pointer;color: blue"
                                       title="<?php echo $v[status_desc]; ?>"><?php echo $v[status_desc]; ?></a>
                                <?php } elseif ($v['status'] == 2) { ?>
                                    <a style="cursor: pointer;color: green"
                                       title="<?php echo $v[status_desc]; ?>"><?php echo $v[status_desc]; ?></a>
                                <?php } ?>
                            </td>
                            <?php if ($now_flag) { ?>
                                <td align="center" width="60px">
                                    <a href="adminHelpList.php?act=show&recordid=<?php echo set_url($v['recordid']); ?>">
                                        <img src="../templates/images/manage/icon_view.gif" alt="查看" title="查看"/>
                                    </a>

                                    <a href="adminHelpList.php?act=edit&recordid=<?php echo set_url($v['recordid']); ?>">
                                        <img src="../templates/images/manage/icon_edit.gif" alt="修改" title="修改"/>
                                    </a>

                                    <a href="javascript:if(confirm('确定删除吗？')) location.href='adminHelpList.php?act=del&recordid=<?php echo set_url($v['recordid']); ?>'"
                                       style="text-decoration:none;" id="delete"><img
                                                src="../templates/images/manage/icon_drop.gif" alt="删除" title="删除"></a>
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
            </div>
            <?php include '../templates/page.php' ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        $("#myform").submit(function () {
            var join_start = $("#receivedate1").val();
            var join_stop = $("#receivedate2").val();

            if (compareDate(join_start, join_stop)) {
                ui.error("获奖日期起不能大于获奖日期止！");
                return false;
            }
        });


    });

    function compareDate(DateOne, DateTwo) {
        var OneMonth = DateOne.substring(5, DateOne.lastIndexOf("-"));
        var OneDay = DateOne.substring(DateOne.length, DateOne.lastIndexOf("-") + 1);
        var OneYear = DateOne.substring(0, DateOne.indexOf("-"));
        var TwoMonth = DateTwo.substring(5, DateTwo.lastIndexOf("-"));
        var TwoDay = DateTwo.substring(DateTwo.length, DateTwo.lastIndexOf("-") + 1);
        var TwoYear = DateTwo.substring(0, DateTwo.indexOf("-"));

        if (Date.parse(OneMonth + "/" + OneDay + "/" + OneYear) > Date.parse(TwoMonth + "/" + TwoDay + "/" + TwoYear)) {
            return true;
        } else {
            return false;
        }

    }

    //导出
    $("#batch_exp").click(function () {
        var cur_href = window.location.href;
        if (cur_href.indexOf('?') !== -1) {
            location.href = window.location.href + "&type=batch_exp";
        } else {
            location.href = window.location.href + "?type=batch_exp";
        }
    });
</script>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>