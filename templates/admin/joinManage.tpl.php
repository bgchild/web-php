<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>
    <link type="text/css" rel="stylesheet" href="../templates/css/admin_base.css"/>
    <script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="../templates/js/msgbox.js"></script>
    <style type='text/css'>
        /*隐藏原因*/
        .refuse_fa {
            position: relative;
        }

        .refuse_so {
            position: absolute;
            width: 450px;
            background: #fff;
            border: solid 2px #DFDFDF;
            display: none;
            left: 150px;
            _left: -580px;
            z-index: 999
        }

        .refuse_ch {
            float: left;
            padding: 20px;
        }

        .refuse_tab2 {
            float: left;
        }

        .refuse_big {
            color: red;
            font-size: 18px;
        }

        .refuse_tab2 tr {
            height: 35px;
            line-height: 35px;
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
            <form name="sform" action="" method="get">
                <table class="base_table" style="padding:0px;">
                    <tbody>
                    <tr>
                        <th>用户名:</th>
                        <td><input name="keyword" class="input length_5 keyword" value="<?php echo $keyword; ?>"
                                   type="text"></td>
                        <td>
                            <button class="btn tj" type="submit" name="tj">查询</button>
                            &nbsp;&nbsp;
                            <button class="btn cz" type="reset" name="cz">重置</button>
                        </td>

                    </tr>
                </table>
            </form>


            <form name="myform" id="myform" action="" method="post">
                <?php if ($now_flag) { ?>
                    <table>
                        <tbody>
                        <tr>
                            <td style="width:750px;"></td>
                            <td>
                                <button class="yesbtn" type="submit" name="act" value="yes" id="yes">批量通过</button>
                            </td>
                            <td width="10"></td>
                            <td>
                                <button class="nobtn" type="submit" name="act" value="no" id="no">批量拒绝</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" height="1"></td>
                        </tr>
                    </table>
                <?php } ?>

                <div class="refuse_fa">
                    <div class="refuse_so rejectDiv">
                        <div class="refuse_ch">
                            <table class="refuse_tab2">
                                <tr>
                                    <td width="120" align="right"><font color="#ff0000">*</font> <font>批量备注:</font></td>
                                    <td align="left">
                                        <textarea style="width:300px;" name="statusremark"
                                                  class="statusremark"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="left"><input type="button" class="btn doSumup" name="doSumup"
                                                            value="确定"/>&nbsp;&nbsp;<input type="button"
                                                                                           class="btn doSumupCancel"
                                                                                           name="doSumupCancel"
                                                                                           value="关闭"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


                <table class="list-table table" cellspacing="1" cellpadding="2">
                    <tr>
                        <th width="50" class='listcenter'>
                            <input type="checkbox" name="all" value="1" id="check_box" onclick="selectall('aid[]');">
                        </th>
                        <th class='listcenter'>用户名</th>
                        <th width="60" class='listcenter'>原城市</th>
                        <th width="60" class='listcenter'>转至城市</th>
                        <th width="50" class='listcenter'>状态</th>
                        <th width="150" class='listcenter'>用户备注</th>
                        <th width="150" class='listcenter'>申请时间</th>
                        <th width="150" class='listcenter'>审核状态</th>

                    </tr>
                    <?php foreach ($list as $v) {
                        $spm = array();
                        $spm['id'] = $v['uid'];
                        $url = 'joinManage.php?act=detail&spm=' . set_url($spm);
                        if ($v['status'] == 1) $stu = "<span style='color:#AD6E22'>等待" . $v[oname] . "审核</span>";
                        if ($v['status'] == 2) $stu = "<span style='color:#9AAA25'>" . $v[oname] . "拒绝</span>";
                        if ($v['status'] == 3) $stu = $v[oname] . "同意，等待" . $v[nname] . "审核";
                        if ($v['status'] == 4) $stu = $v[oname] . "同意，" . $v[nname] . "拒绝";
                        if ($v['status'] == 5) $stu = "<span style='color:#F92659'>" . $v[oname] . "同意 , " . $v[nname] . "同意，完成</span>";
                        ?>
                        <tr>
                            <td class='listcenter'>
                                <?php if (($v['jstatus'] == 1 and $v['status'] == 1) or ($v['jstatus'] == 2 and $v['status'] == 3)) { ?>
                                    <input type="checkbox" name="aid[]" value="<?php echo $v['id']; ?>">
                                <?php } ?>
                                <input type="hidden" name="old[]" value="<?php echo $v['jstatus']; ?>"/>
                            </td>
                            <td><a href="<?php echo $url ?>" class="tda"
                                   title="<?php echo $v['uname']; ?>"><?php echo $v['uname']; ?></a></td>
                            <td><?php echo $v['oname']; ?></td>
                            <td><?php echo $v['nname']; ?></td>
                            <td><?php if ($v[jstatus] == 1) {
                                    echo "<span style='color:red'>转出</span>";
                                } else {
                                    echo "<span style='color:blue'>转入</span>";
                                } ?>
                            </td>
                            <td><a style=" cursor:pointer" class="tda"
                                   title="<?php echo $v['ureason']; ?>"><?php echo $v['ureason']; ?></a></td>
                            <td class='listcenter'><?php echo date('Y-m-d H:i', $v['addtime']); ?></td>
                            <td><?php echo $stu; ?></td>
                        </tr>
                    <?php }
                    if (!$list) { ?>
                        <tr>
                            <td colspan='8'>查无数据</td>
                        </tr><?php } ?>
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


            <script type="text/javascript">


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

                function getselectnums(name) {
                    var nums = new Array();
                    $("input[name='" + name + "']").each(function () {
                        if (this.checked == true) nums.push($(this).val());
                    });
                    return nums;
                }

                function getnoselectnums(name) {
                    var nums = new Array();
                    $("input[name='" + name + "']").each(function () {
                        if (this.checked != true) {
                            nums.push($(this).val());
                        }
                    });
                    return nums;
                }

                function getold(name) {
                    var nums = new Array();
                    $("input[name='" + name + "']").each(function () {
                        if (this.checked == true) nums.push($(this).next().val());
                    });
                    return nums;
                }

                function getall() {
                    if ($('#check_box')[0].checked) {
                        return 1;
                    } else {
                        return 0;
                    }
                }

                function hideselectnums(name) {
                    $("input[name='" + name + "']").each(function () {
                        if (this.checked == true) {
                            $(this).parent().parent().remove();
                        }
                    });
                }


                $(function () {
                    var yesorno = "yes";
                    $('#yes').click(function () {
                        var falg = true;
                        $("input[name='aid[]']").each(function () {
                            if (this.checked == true) falg = false;
                        });
                        if (falg) {
                            ui.error('您还没有选择！');
                            return false;
                        } else {
                            yesorno = "yes";
                            $(".rejectDiv").show();
                            return false;
                        }

                    });

                    $('#no').click(function () {
                        var falg = true;
                        $("input[name='aid[]']").each(function () {
                            if (this.checked == true) falg = false;
                        });
                        if (falg) {
                            ui.error('您还没有选择！');
                            return false;
                        } else {
                            yesorno = "no";
                            $(".rejectDiv").show();
                            return false;
                        }
                    });

                    $(".doSumupCancel").click(function () {
                        $(".rejectDiv").hide();
                    });


                    $(".doSumup").click(function () {
                        if ($(".statusremark").val() == '') {
                            alert("备注不能为空格");
                            $(".statusremark").focus();
                        } else {
                            $(".rejectDiv").hide();
                            var nums = getselectnums("aid[]");
                            var old = getold("aid[]");
                            var all = getall();
                            var naids = getnoselectnums("aid[]");

                            $.post("joinManage.php",
                                {
                                    act: yesorno,
                                    statusremark: $(".statusremark").val(),
                                    aid: nums,
                                    old: old,
                                    all: all,
                                    naids: naids,
                                }, function () {
                                    ui.success("批量操作成功！");
                                    hideselectnums("aid[]");
                                    //setTimeout("location.href='joinManage.php'",2000);
                                });
                        }
                    });

                    $(".cz").click(function () {
                        $(".keyword").val("");
                        $(".status").val("0");
                        $(".tj").click();
                    });
                });


            </script>

        </div>
    </div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
</body>
</html>