<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/demo2.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/adminServiceTeam.css"/>

    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

    <script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
    <script  type="text/javascript"   src="templates/js/common_table.js"></script>
    <script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>

    <style>
    .btn_alone {
        margin-left: 830px;
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
    <div class="con">
        <?php include 'user_left.tpl.php'; ?>

        <div class="content_right">
            <?php include 'user_top.tpl.php'; ?>


            <div class="con_right_bottom">

                <div class="service_top">
                    <form action='userAppraisingManage.php' method="post" class="searchFrom" id="myform">
                        <fieldset class="searchFieldSet">
                            <legend>查询条件</legend>
                            <table class="base_table">
                                <tbody>
                                <tr>
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;获奖人：</th>
                                    <td><input type="text" name="prizewinner"  value="<?php echo $info['prizewinner'];?>" class="input length_2"/></td>
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;获奖日期：</th>
                                    <td><input name="receivedate1" id="receivedate1" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_2 mr10 J_date date" value="<?php echo $info['receivedate1'];?>" /></td>
                                    <th>至</th>
                                    <td><input name="receivedate2" id="receivedate2" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_2 mr10 J_date date" value="<?php echo $info['receivedate2'];?>" />&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;<a href="userAppraisingManage.php" class="btn" role="button"><span class="add"></span>重置</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </form>
                </div>

                <a href="userAppraisingSaveAdd.php" class="addbtn btn_alone" role="button"><span class="add"></span>新建</a>
                <div class="service_middle">
                    <div class="tabContent">
                        <table class="list-table" cellspacing="1" cellpadding="2">
                            <tr>
                                <th align="center">获奖人</th>
                                <th align="center">获奖日期</th>
                                <th align="center">获奖地点</th>
                                <th align="center">获奖内容</th>
                                <th align="center">操作</th>
                            </tr>
                            <?php 	foreach ($myaward as $k=>$v){ ?>
                                <tr>
                                    <td align="left" width="74px" class="tdprizewinner"><a style="cursor: pointer;" title="<?php echo $v[prizewinner];?>"><?php echo $v[prizewinner];?></a></td>
                                    <td align="center" width="100px"><?php echo $v['receivedate'];?></td>
                                    <td align="left" width="150px" class="tdwinaddress"><a style="cursor: pointer;" title="<?php echo $v[winaddress];?>"><?php echo $v[winaddress];?></a></td>
                                    <td align="left" class="tdwincontent"><a style="cursor: pointer;" title="<?php echo $v[wincontent];?>"><?php echo $v[wincontent];?></a></td>
                                    <td align="center" width="45px"><a href="userAppraisingSaveAdd.php?recordid=<?php echo set_url($v['recordID']);?>"><img src="../templates/images/manage/icon_edit.gif" alt="修改"/></a></td>
                                </tr>
                            <?php } if(!$myaward){ ?>
                                <tr><td colspan='4'>查无数据</td></tr>
                            <?php }?>
                        </table>
                        <table><tr style="height:5px"></tr></table>
                        <?php include './templates/page.php'?>
                        <table><tr style="height:30px"></tr></table>
                    </div>
                </div>




            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){

        $("#search_btn").click(function(){
            $("#hid_abs").show();
        });
        $("#hid_btn").click(function(){
            $("#hid_abs").hide();
        });

        $("#myform").submit(function(){
            var start_time = $("#foundingtime_start").val();
            var stop_time = $("#foundingtime_stop").val();

            if (compareDate(start_time,stop_time)) {
                ui.error("通过日期起不能大于通过时间止！");
                return false;
            }

        });

    });
    function compareDate(DateOne,DateTwo)
    {
        if ( !DateOne || !DateTwo ) {
            return false;
        }
        var OneMonth = DateOne.substring(5,DateOne.lastIndexOf ("-"));
        var OneDay = DateOne.substring(DateOne.length,DateOne.lastIndexOf ("-")+1);
        var OneYear = DateOne.substring(0,DateOne.indexOf ("-"));
        var TwoMonth = DateTwo.substring(5,DateTwo.lastIndexOf ("-"));
        var TwoDay = DateTwo.substring(DateTwo.length,DateTwo.lastIndexOf ("-")+1);
        var TwoYear = DateTwo.substring(0,DateTwo.indexOf ("-"));

        if (Date.parse(OneMonth+"/"+OneDay+"/"+OneYear) >Date.parse(TwoMonth+"/"+TwoDay+"/"+TwoYear)) {
            return true;
        } else {
            return false;
        }

    }
</script>
<?php include 'footer.tpl.php'; ?>



</body>
</html>