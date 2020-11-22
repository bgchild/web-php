<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <style>
        .list-table {
            border: none;
        }

        .list-table tr > th, td {
            display: table-cell;
            white-space: nowrap;
            padding: 0 10px;
            background: none;
            border: none;
        }

        .page {
            padding-bottom: 20px;
        }
    </style>
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
                <form action='adminDisasterList.php' class="searchFrom" id="myform" style="height:380px">
                    <fieldset class="searchFieldSet" style="height:380px">
                        <legend>查询条件</legend>
                        <table class="list-table" style="padding: 0px;border: none">
                            <tbody>
                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;灾情名称：</th>
                                <td><input type="text" name="dname" value="<?php echo $infos['dname']; ?>"
                                           class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上报日期：</th>
                                <td colspan="2"><input name="sdate" id="sdate" onclick="WdatePicker()"
                                                       readonly="readonly" type="text"
                                                       class="input length_2 mr10 J_date date"
                                                       value="<?php echo $infos['sdate']; ?>"/>&nbsp;至&nbsp;<input
                                            name="edate" id="edate" onclick="WdatePicker()"
                                            readonly="readonly" type="text" class="input length_2 mr10 J_date date"
                                            value="<?php echo $infos['edate']; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;灾情种类：</th>
                                <td><select id="cname" name="cname">
                                        <option value="0">全部</option>
                                        <?php foreach ($cates as $ck => $cv) { ?>
                                        <option value="<?php echo $cv['recordid'] . '"';
                                        if ($infos[cname] == $cv['recordid']) {
                                            echo "selected=selected";
                                        } ?>><?php echo $cv['name'] ?></option>
                                        <?php } ?>
                                    </select></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;灾情地点：</th>
                                <td><input type=" text
                                        " name="address" value="<?php echo $infos['address']; ?>"
                                        class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;事发地点：</th>
                                <td><input type="text" name="place" value="<?php echo $infos['place']; ?>"
                                           class="input length_2"/></td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;受灾人数：</th>
                                <td colspan="2"><input type="text" name="svictims_num"
                                                       value="<?php echo $infos['svictims_num']; ?>"
                                                       class="input length_2"/>-<input type="text" name="evictims_num"
                                                                                       value="<?php echo $infos['evictims_num']; ?>"
                                                                                       class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;受伤人数：</th>
                                <td colspan="2"><input type="text" name="sinjured_num"
                                                       value="<?php echo $infos['sinjured_num']; ?>"
                                                       class="input length_2"/>-<input type="text" name="einjured_num"
                                                                                       value="<?php echo $infos['einjured_num']; ?>"
                                                                                       class="input length_2"/></td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;失踪人数：</th>
                                <td colspan="2"><input type="text" name="smissing_num"
                                                       value="<?php echo $infos['smissing_num']; ?>"
                                                       class="input length_2"/>-<input type="text" name="emissing_num"
                                                                                       value="<?php echo $infos['emissing_num']; ?>"
                                                                                       class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;死亡人数：</th>
                                <td colspan="2"><input type="text" name="sdie_num"
                                                       value="<?php echo $infos['sdie_num']; ?>"
                                                       class="input length_2"/>-<input type="text" name="edie_num"
                                                                                       value="<?php echo $infos['edie_num']; ?>"
                                                                                       class="input length_2"/></td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;需紧急转移安置人口：</th>
                                <td colspan="2"><input type="text" name="stransfer_num"
                                                       value="<?php echo $infos['stransfer_num']; ?>"
                                                       class="input length_2"/>-<input type="text" name="etransfer_num"
                                                                                       value="<?php echo $infos['etransfer_num']; ?>"
                                                                                       class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;需口粮救济人口：</th>
                                <td colspan="2"><input type="text" name="sfood_help_num"
                                                       value="<?php echo $infos['sfood_help_num']; ?>"
                                                       class="input length_2"/>-<input type="text" name="efood_help_num"
                                                                                       value="<?php echo $infos['efood_help_num']; ?>"
                                                                                       class="input length_2"/></td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;损坏耕地面积：</th>
                                <td colspan="2"><input type="text" name="sdamage_land"
                                                       value="<?php echo $infos['sdamage_land']; ?>"
                                                       class="input length_2"/>-<input type="text" name="esdamage_land"
                                                                                       value="<?php echo $infos['esdamage_land']; ?>"
                                                                                       class="input length_2"/></td>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;农作物/草场受灾面积：</th>
                                <td colspan="2"><input type="text" name="sdamage_crops"
                                                       value="<?php echo $infos['sdamage_crops']; ?>"
                                                       class="input length_2"/>-<input type="text" name="edamage_crops"
                                                                                       value="<?php echo $infos['edamage_crops']; ?>"
                                                                                       class="input length_2"/></td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;建筑物损毁情况：</th>
                                <td colspan="4"><input type="text" name="damage_building"
                                                       value="<?php echo $infos['damage_building']; ?>"
                                                       class="input length_2" style="width: 100%"/></td>
                            </tr>

                            <tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;灾情描述：</th>
                                <td colspan="4">
                                    <input type="text" name="description" value="<?php echo $infos['description']; ?>"
                                           class="input length_2" style="width: 100%"/>
                                </td>
                            </tr>

                            <tr>
                                <th class="listright">&nbsp;&nbsp;&nbsp;&nbsp;组织机构：</th>
                                <td colspan="2">
                                    <!--<ul>
                                        <li style="float: left;margin-left: 10px">
                                            <select name="province" id="province">
                                                <?php /*foreach ($province as $pro) { */ ?>
                                                    <option value="<?php /*echo $pro['sign']; */ ?>">
                                                        <?php /*echo $pro['name']; */ ?>
                                                    </option>
                                                <?php /*} */ ?>
                                            </select>
                                        </li>
                                        <li id="citydiv" style="float: left;margin-left: 10px">
                                            <select name="city" style="display:none" id="city">
                                                <?php /*foreach ($city as $cit) { */ ?>
                                                    <option value="<?php /*echo $cit['sign']; */ ?>">
                                                        <?php /*echo $cit['name']; */ ?>
                                                    </option>
                                                <?php /*} */ ?>
                                            </select>
                                        </li>
                                        <li id="areadiv" style="float: left;margin-left: 10px">
                                            <select name="area" style="display:none" id="area">
                                                <?php /*foreach ($area as $val) { */ ?>
                                                <option value="<?php /*echo $val['sign']; */ ?>">
                                                    <?php /*echo $val['name']; */ ?></option>
                                                <?php /*} */ ?>
                                            </select>
                                        </li>
                                    </ul>-->

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
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;当前状态：</th>
                                <td><select name="status" id="status">
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

                            </tr>

                            <tr>
                                <td align="right" colspan="4">
                                    <input type="submit" name="doSearch" class="btn" value="查询"/>&nbsp;&nbsp;<a
                                            href="adminDisasterList.php" class="btn" role="button"><span
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
                        <td style="width:835px;"></td>
                        <td>
                            <button class="yesbtn" type="button" id="batch_exp">导出</button>
                        </td>
                </table>
            <?php } ?>

            <div class="uma" style="margin-top: 10px; margin-bottom: 10px;overflow-x: scroll;width: 865px;">
                <table class="list-table" cellspacing="1" cellpadding="2">
                    <tr>
                        <th align="center" style="width: 95px">灾情名称</th>
                        <th align="center" style="width: 95px">灾情地点</th>
                        <th align="center" style="width: 95px">灾情种类</th>
                        <th align="center" style="width: 95px">事发地点</th>
                        <th align="center" style="width: 95px">灾情描述</th>
                        <th align="center" style="width: 95px">受灾人数</th>
                        <th align="center" style="width: 95px">受伤人数</th>
                        <th align="center" style="width: 95px">失踪人数</th>
                        <th align="center" style="width: 95px">死亡人数</th>
                        <th align="center" style="width: 195px">需紧急转移安置人口</th>
                        <th align="center" style="width: 165px">需口粮救济人口</th>
                        <th align="center" style="width: 165px">损坏耕地面积</th>
                        <th align="center" style="width: 195px">农作物/草场受灾面积</th>
                        <th align="center" style="width: 165px">建筑物损毁情况</th>
                        <th align="center" style="width: 95px">上报人</th>
                        <th align="center" style="width: 95px">上报人身份</th>
                        <th align="center" style="width: 95px">联系方式</th>
                        <th align="center" style="width: 95px">上报时间</th>
                        <th align="center" style="width: 95px">当前状态</th>
                        <?php if ($now_flag) { ?>
                            <th align="center">操作</th>
                        <?php } ?>
                    </tr>
                    <?php foreach ($lists as $k => $v) { ?>
                        <tr>
                            <td align="center">
                                <a style="cursor: pointer;"><?php echo $v[name] ? $v[name] : '不详'; ?></a>
                            </td>
                            <td align="center">
                                <a style="cursor: pointer;"><?php echo $v[address] ? $v[address] : '不详'; ?></a>
                            </td>
                            <td align="center"><?php echo $v['cate_name'] ? $v['cate_name'] : '不详'; ?></td>
                            <td align="center"><?php echo $v[place] ? $v[place] : '不详'; ?></td>
                            <td align="center"><?php echo $v[description] ? $v[description] : '不详'; ?></td>
                            <td align="center"><?php echo $v[victims_num] ? $v[victims_num] : '不详'; ?></td>
                            <td align="center"><?php echo $v[injured_num] ? $v[injured_num] : '不详'; ?></td>
                            <td align="center"><?php echo $v[missing_num] ? $v[missing_num] : '不详'; ?></td>
                            <td align="center"><?php echo $v[die_num] ? $v[die_num] : '不详'; ?></td>
                            <td align="center"><?php echo $v[transfer_num] ? $v[transfer_num] : '不详'; ?></td>
                            <td align="center"><?php echo $v[food_help_num] ? $v[food_help_num] : '不详'; ?></td>
                            <td align="center"><?php echo $v[damage_land] ? $v[damage_land] : '不详'; ?></td>
                            <td align="center"><?php echo $v[damage_crops] ? $v[damage_crops] : '不详'; ?></td>
                            <td align="center"><?php echo $v[damage_building] ? $v[damage_building] : '不详'; ?></td>
                            <td align="center">
                                <a style="cursor: pointer;"><?php echo $v[vname] ? $v[vname] : '不详'; ?></a>
                            </td>
                            <td align="center"><?php echo $v[type_desc] ? $v[type_desc] : '不详'; ?></td>
                            <td align="center"><?php echo $v[mobile] ? $v[mobile] : '不详'; ?></td>
                            <td align="center">
                                <a style="cursor: pointer;"
                                   title="<?php echo $v[add_date]; ?>"><?php echo $v[add_date]; ?></a>
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
                                    <a href="adminDisasterList.php?act=show&recordid=<?php echo set_url($v['recordid']); ?>">
                                        <img src="../templates/images/manage/icon_view.gif" alt="查看" title="查看"/>
                                    </a>

                                    <a href="adminDisasterList.php?act=edit&recordid=<?php echo set_url($v['recordid']); ?>">
                                        <img src="../templates/images/manage/icon_edit.gif" alt="修改" title="修改"/>
                                    </a>

                                    <a href="javascript:if(confirm('确定删除吗？')) location.href='adminDisasterList.php?act=del&recordid=<?php echo set_url($v['recordid']); ?>'"
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

        $('#province').change(function () {
            var provinceid = $('#province').val();
            $('#citydiv').html('');
            $('#areadiv').html('');

            if (provinceid == 1)
                return;

            $.ajax({
                type: 'get',
                url: './adminDisasterList.php',
                dataType: 'json',
                cache: false,
                data: {psign: provinceid, act: 'province'},
                success: function (msg) {
                    var m = msg.mes.split("|");
                    $('#citydiv').html(m[0]);
                    $('#areadiv').html(m[1]);
                    if (msg.status) $('#area').remove();
                }
            });
        });
//
        $('#city').live('change', city);
        function city() {
            var cityid = $('#city').val();
            $('#areadiv').html('');
            $.ajax({
                type: 'get',
                url: './adminDisasterList.php',
                dataType: 'json',
                cache: false,
                data: {psign: cityid, act: 'city'},
                success: function (msg) {
                    $('#areadiv').html(msg.mes);
                }
            });
        }

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