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
                    <form action='userMyTrain.php' method="post" class="searchFrom" id="myform">
                        <fieldset class="searchFieldSet">
                            <legend>查询条件</legend>
                            <table class="base_table">
                                <tbody>
                                <tr>
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;培训日期：</th>
                                    <td><input name="startdate" id="startdate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_2 mr10 J_date date" value="<?php echo $info['startdate'];?>" /></td>
                                    <th>至</th>
                                    <td><input name="enddate" id="enddate" onclick="WdatePicker()" readonly="readonly" type="text" class="input length_2 mr10 J_date date" value="<?php echo $info['enddate'];?>" />&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;<a href="userMyTrain.php" class="btn" role="button"><span class="add"></span>重置</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </form>
                </div>

                <div class="service_middle">
                    <div class="tabContent">
                        <table class="list-table" cellspacing="1" cellpadding="2">
                            <tr>
                                <th align="center">培训日期</th>
                                <th align="center">培训地点</th>
                                <th align="center">培训内容</th>
                            </tr>
                            <?php 	foreach ($trains as $k=>$v){ ?>
                                <tr>
                                    <td align="center" width="200px"><?php echo $v['startdate'];?> - <?php echo $v['enddate']; ?></td>
                                    <td align="left" width="150px" class="tdwinaddress">
                                        <a style="cursor: pointer;" title="<?php echo $v['trainaddress'];?>"><?php echo $v['trainaddress'];?></a>
                                    </td>
                                    <td align="left" class="tdwincontent">
                                        <a style="cursor: pointer;" title="<?php echo $v['traincontent'];?>"><?php echo $v['traincontent'];?></a>
                                    </td>
                                </tr>
                            <?php } if(!$trains){ ?>
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