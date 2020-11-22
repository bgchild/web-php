<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/adminvolunteerManage.css"/>
    <script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <script type="text/javascript" src="../templates/js/jsdate/WdatePicker.js"></script>
    <style type="text/css">
        .listright {
            text-align: right;
        }

        .listleft {
            text-align: left;
        }

        .listcenter {
            text-align: center;
        }

        .table {
            table-layout: fixed;
        }

        .tda {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .font-bold {
            font-weight: bold
        }
    </style>
</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'admin_left.tpl.php'; ?>

        <div class="admin_right">
            <?php include 'admin_top.tpl.php'; ?>

            <div class="explain-col">
                <div class="col_con">申请时间:</div>
                <div class="col_con"><a href="?t=7day" class="cl <?php if ($arr[vol_font] == '7') echo 'font-bold'; ?>">最近一周</a>
                </div>
                <div class="col_con"><a href="?t=30day"
                                        class="cl <?php if ($arr[vol_font] == '30') echo 'font-bold'; ?>">最近一个月</a>
                </div>
                <div class="col_con"><a href="?t=90day"
                                        class="cl <?php if ($arr[vol_font] == '90') echo 'font-bold'; ?>">最近三个月</a>
                </div>
                <div class="col_con"><a href="?t=180day"
                                        class="cl <?php if ($arr[vol_font] == '180') echo 'font-bold'; ?>">最近半年</a>
                </div>
                <div class="col_con"><a href="?t=0"
                                        class="cl <?php if ($arr[vol_font] == '0') echo 'font-bold'; ?>">全部</a></div>
            </div>
            <table width="750">
                <tr>
                    <td height="5"></td>
                </tr>
            </table>
            <form name="sform" action="" method="get" id="mydata">
                <table class="base_table" style="padding:0px;">
                    <tbody>
                    <tr>
                        <th>姓名:</th>
                        <td><input name="name" class="input name length_3" value="<?php echo $_GET['name']; ?>"
                                   type="text"></td>
                        <th>申请期起：</th>
                        <td><input type="text" name="time_start" class="input" onclick="WdatePicker()"
                                   readonly="readonly" value="<?php echo $_GET['time_start']; ?>" id="time_start"/></td>
                        <th>申请期止：</th>
                        <td><input type="text" name="time_stop" class="input" onclick="WdatePicker()"
                                   readonly="readonly" value="<?php echo $_GET['time_stop']; ?>" id="time_stop"/></td>
                        <th>审核状态:</th>
                        <td>
                            <select name="status" class="status">
                                <option value="0">全部</option>
                                <option value="1000" <?php if ($statused == "1000") echo 'selected="selected"'; ?> >
                                    申请
                                </option>
                                <option value="001" <?php if ($statused == "001") echo 'selected="selected"'; ?> >初审通过
                                </option>
                                <option value="011" <?php if ($statused == "011") echo 'selected="selected"'; ?> >初审被拒
                                </option>
                                <option value="010" <?php if ($statused == "010") echo 'selected="selected"'; ?> >通过终审
                                </option>
                                <option value="100" <?php if ($statused == "100") echo 'selected="selected"'; ?> >注销
                                </option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <th width="80">组织机构：</th>
                        <td width="140" colspan='2'>
                            <select id="secity" name="secity">
                                <?php foreach($level as $k=>$v){?>
                                    <option value="<?php echo $v['sign'].'"'; if($secity==$v['sign']){echo "selected=selected";}?>"><?php echo $v['name'];?></option >
                                <?php }?>
                            </select>
                            <?php if($isClub) {?>
                                <script>
                                    $(function() {
                                        var secity = document.getElementById("secity");
                                        secity.onfocus = function( ) {
                                            this.defaultIndex = this.selectedIndex;
                                        }

                                        secity.onchange = function() {
                                            this.selectedIndex = this.defaultIndex;
                                        }
                                    });
                                </script>
                            <?php }  ?>
                        </td>
                        <td colspan="2">
                            <input type="checkbox" checked="checked" disabled="disabled"/>本级&nbsp;&nbsp;
                            <?php if(count($level)!=1){?>
                                <input type="checkbox" name="lower" value="1" <?php if($lower==1){echo 'checked="checked"';}?>/>下级<?php }?>
                        </td>
                        <td align="right" colspan='3'>
                            <button class="btn tj" type="submit" name="tj">查询</button>
                            &nbsp;&nbsp;
                            <button class="btn cz" type="submit" name="cz">重置</button>
                        </td>
                    </tr>
                </table>
            </form>


            <form name="myform" id="myform" action="" method="post">
                <?php if ($now_flag) { ?>
                    <table>
                        <tbody>
                        <tr>
                            <td style="width:700px;"></td>
                            <td>
                                <button class="yesbtn" type="button" id="batch_exp">批量导出志愿者</button>
                            </td>
                            <td><a href="patch.php" class="yesbtn">批量导入志愿者</a></td>
                            <td><a href="../applyvolunteer.php?agree=<?php echo set_url('agreed') ?>" class="yesbtn">添加志愿者</a>
                            </td>
                            <td><input type="hidden" name="act" value="yes"/>
                                <button class="yesbtn" type="submit" id="yes">通过终审</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" height="1"></td>
                        </tr>
                    </table>
                <?php } ?>
                <table class="list-table table" cellspacing="1" cellpadding="2">
                    <tr>
                        <th width="50" align="center"><input type="checkbox" value="" id="check_box"
                                                             onclick="selectall('aid[]');"></th>
                        <th width="100" align="center">姓名</th>
                        <th width="120" width="80" align="center">用户名</th>
                        <th align="center">昵称</th>
                        <th width="40" align="center">性别</th>
                        <th width="90" align="center">出生日期</th>
                        <th width="70" align="center">服务总时间</th>
                        <?php if ($now_flag) { ?>
                            <th width="80" align="center">工时调整</th><?php } ?>
                        <th width="90" align="center">到期时间</th>
                        <th width="100" align="center">状态</th>
                    </tr>
                    <?php foreach ($list as $v) {
                        $spm = array();
                        $spm['id'] = $v['recordid'];
                        $url = 'volunteerManage.php?act=detail&spm=' . set_url($spm);
                        if ($v['status'] == '1000') $stu = "申请";
                        else if ($v['status'] == '001') $stu = "初审通过";
                        else if ($v['status'] == '011') $stu = "初审被拒";
                        else if ($v['status'] == '010') $stu = "通过终审";
                        else if ($v['status'] == '100') $stu = "注销";
                        ?>
                        <tr>
                            <td align="center"><?php if ($v['status'] == '001') { ?><input type="checkbox" name="aid[]"
                                                                                           value="<?php echo $v['recordid']; ?>"><?php } ?>
                            </td>
                            <td class="listleft"><a href="<?php echo $url; ?>" class="tda"
                                                    title="<?php echo $v['name']; ?>"><?php echo $v['name']; ?></a></td>
                            <td class="listleft"><span class="tda"
                                                       title="<?php echo $v['nickname']; ?>"><?php echo $v['username']; ?></span>
                            </td>
                            <td class="listleft"><span class="tda"
                                                       title="<?php echo $v['nickname']; ?>"><?php echo $v['nickname']; ?>
                                    <span></td>
                            <td align="center"><?php echo $v['sex'] == 1 ? '男' : '女'; ?></td>
                            <td align="center"><?php echo date("Y-m-d", $v['birthday']); ?></td>
                            <td align="center"><?php echo $v['allservertime']; ?></td>
                            <?php if ($now_flag) { ?>
                                <td align="center">
                                <?php if ($v['status'] == '1000' || $v['status'] == '011' || $v['status'] == '100') { ?>
                                    <a style="cursor: pointer;">不可调整</a><?php } else { ?><a href="###"
                                                                                            class="a_red sumupRid"
                                                                                            rid="<?php echo $v[recordid]; ?>">
                                        调整</a><?php } ?></td><?php } ?>
										
                            <td align="center"><?php echo date("Y-m-d", intval($v['applytime'])+20*365*24*60*60); ?></td>
                            <td><?php echo $stu;
                                if ($now_flag) { ?>
                                    <?php if ($v['status'] == '011' || $v['status'] == '100') { ?>
                                        <a href="javascript:void(0)" class="dlid" style="color:#ff0000"
                                           dlidvalue="<?php echo $v[recordid]; ?>">删除</a>
                                    <?php } ?>
                                    <?php if ($v['status'] == '100') { ?>
                                        <a href="javascript:void(0)" class="reactive" style="color:#ff0000"
                                           idvalue="<?php echo $v[recordid]; ?>">激活</a>
                                    <?php } ?>
                                    <?php if ($v['status'] == '001' || $v['status'] == '010') { ?> <a
                                            href="javascript:void(0)" class="ltid" style="color:#ff0000"
                                            ltidvalue="<?php echo $v[recordid]; ?>">注销</a>
                                    <?php }
                                } ?>

                            </td>
                        </tr>
                    <?php }
                    if (count($list) == 0) { ?>
                        <tr>
                            <td colspan="9">查无数据</td>
                        </tr>
                    <?php } ?>
                </table>

                <table width="750">
                    <tr>
                        <td height="5"></td>
                    </tr>
                </table>
                <?php include '../templates/page.php' ?>
                <table width="750">
                    <tr>
                        <td height="5"></td>
                    </tr>
                </table>
            </form>


        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
<div class="hiddenDiv hiddenDivSave">
    <table class="TimeTable">
        <tr>
            <td align="right" width="100px"><span style="color: red;">*&nbsp;</span><select name="types" id="types">
                    <option value="1">增加工时</option>
                    <option value="2">减少工时</option>
                </select>：
            </td>
            <td><input type="text" name="working_hours" class="working_hours input" id="working_hours"/> 小时</td>
        </tr>
        <tr>
            <td align="right" width="100px"><span style="color: red;">*&nbsp;</span>原因：</td>
            <td><textarea name="sumup" class="sumup" id="sumup" style="width:164px;height:120px;"></textarea></td>
        </tr>
        <tr>
            <td><input type="hidden" name="rid" class="doSumup_rid" value=""/></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="doSumup" class="btn doSumuph"
                                                                       value="确定"/>&nbsp;&nbsp;<input type="button"
                                                                                                      name="doSumupCancel"
                                                                                                      class="btn doSumupCancel"
                                                                                                      value="取消"/></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    var _rid;
    $(".sumupRid").click(function () {
        $('.hiddenDiv').each(function () {
            $(this).hide()
        });
        $('.hiddenDivSave').show();
        $("#working_hours").removeAttr("value");
        $("#sumup").removeAttr("value");
        _rid = $(this).attr("rid");
    });
    $(".doSumupCancel").click(function () {
        $('.hiddenDivSave').hide();
    });

    function getLength(s) {
        var len = 0;
        var a = s.split("");
        for (var i = 0; i < a.length; i++) {
            if (a[i].charCodeAt(0) < 299) {
                len++;
            } else {
                len += 2;
            }
        }
        return len;
    }

    $(".doSumuph").click(function () {
        var value = $(".working_hours").val();
        var len = getLength($(".sumup").val());
        var sumup = $(".sumup").val();
        if ($.trim(value) == '') {
            ui.error("工时请不为空");
            $(".working_hours").focus();
        } else if (!(/^(\+|-)?\d+$/.test(value)) || value <= 0) {
            ui.error("工时请填正数");
            $(".working_hours").focus();
        } else if ($.trim(sumup) == '') {
            ui.error("请填写原因！！！");
            $(".sumup").focus();
        } else if (len > 300) {
            ui.error("原因内容过长！！！");
            $(".sumup").focus();
        } else {
            $.post("volunteerManage.php",
                {
                    doSumuph: "true",
                    types: $("#types").val(),
                    sumup: $(".sumup").val(),
                    working_hours: $(".working_hours").val(),
                    rid: _rid
                }, function (data) {
                    if (data.result == "yes") {
                        ui.success("添加成功");
                        window.top.location.reload();
                        $(".hiddenDivSave").hide();
                    }
                    else ui.error("添加失败，请稍后再次尝试");
                }, "json");
        }
    });


    function selectall(name) {
        if ($("#check_box").is(':checked') == false) {
            $("input[name='" + name + "']").each(function () {
                this.checked = false;
            });
        } else {
            $("input[name='" + name + "']").each(function () {
                this.checked = true;
            });
        }
    }

    //批量导出
    $("#batch_exp").click(function () {
        var lhref = location.href;
        if ( lhref.indexOf('?') != -1 ) {
            location.href = lhref + '&a=1&act=batch_exp';
        } else {
            location.href = lhref + '?a=1&act=batch_exp';
        }
    });

    $(function () {
        $('#yes').click(function () {
            var falg = true;
            $("input[name='aid[]']").each(function () {
                if (this.checked == true) falg = false;
            });
            if (falg) {
                ui.error('请选择至少一个志愿者！');
                return false;
            }
        });
        $('#no').click(function () {
            var falg = true;
            $("input[name='aid[]']").each(function () {
                if (this.checked == true) falg = false;
            });
            if (falg) {
                ui.error('请选择至少一个志愿者！');
                return false;
            }
        });
        $(".reactive").click(function () {
            if (confirm("确定要激活么？"))
                location.href = "volunteerManage.php?act=reactive&reactiveid=" + $(this).attr("idvalue");
        });
        $(".ltid").click(function () {
            if (confirm("确定要注销么？"))
                location.href = "volunteerManage.php?act=ltid&ltidid=" + $(this).attr("ltidvalue");
        });
        $(".dlid").click(function () {
            if (confirm("该操作将彻底删除志愿者信息，确定删除志愿者？"))
                location.href = "volunteerManage.php?act=dlid&dlidid=" + $(this).attr("dlidvalue");
        });
        $(".cz").click(function () {
            $(".name").val("");
            $("#time_start").val("");
            $("#time_stop").val("");
            $(".status").val("0");
            $(".tj").click();
        });
        $("#time_stop").blur(function () {
            var start_time = $("#time_start").val();
            var stop_time = $("#time_stop").val();
            if (compareDate(start_time, stop_time)) {
                ui.error("开始时间不能大于结束时间！");
                $("#time_stop").val('');
                return false;
            }
        })
        $("#time_start").blur(function () {
            var start_time = $("#time_start").val();
            var stop_time = $("#time_stop").val();
            if (compareDate(start_time, stop_time)) {
                ui.error("开始时间不能大于结束时间！");
                $("#time_stop").val('');
                return false;
            }
        })
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
</script>

</body>
</html>