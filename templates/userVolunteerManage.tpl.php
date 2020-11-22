<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/demo2.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/serviceTeamManage.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/adminvolunteerManage.css"/>

    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

    <script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>

    <style type="text/css">
        .listright{text-align:right;}
        .listleft{text-align:left;}
        .listcenter{text-align:center;}
        .tda{display:block;overflow:hidden; white-space:nowrap;text-overflow:ellipsis;}
        table {
            table-layout: auto!important;
        }
        .font-bold{font-weight:bold}

        .uma {
            display: block;
            width: 95%;
            clear: both;
            margin-left: 20px;
            margin-bottom: 10px;
            margin-top: 10px;
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

                <form action='userVolunteerManage.php' method='post' class="searchFrom" id="mydata" style="margin-top: 15px;">
                    <fieldset class="searchFieldSet">
                        <legend>查询条件</legend>
                        <div class="searchDivInFieldset">
                            <table class="searchTable" cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td class="listright" width="80">姓名：</td>
                                    <td width="140"><input type="text" name="name" class="input" value="<?php echo $infos['name'];?>" id="name" /></td>
                                    <td width="50">服务队：</td>
                                    <td>
                                        <select name="serviceteamid" style="width: 150px;">
                                            <option value="">全部</option>
                                            <?php foreach($teams as $val) { ?>
                                            <option value="<?php echo $val['recordid']; ?>" <?php if($infos['serviceteamid'] == $val['recordid']) {?> selected <?php } ?> ><?php echo $val['serviceteamname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td colspan='1'>
                                        <input type="hidden" name="tag" value="<?php echo $tag;?>" />
                                        <input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;&nbsp;
                                        <a href="userVolunteerManage.php" class="btn">重置</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                </form>

                <div class="uma">
                    <form name="myform" id="myform" action="" method="post" >
                        <table class="list-table table" cellspacing="1" cellpadding="2">
                            <tr>
                                <th width="100" align="center">姓名</th>
                                <th width="120"width="80"  align="center">用户名</th>
                                <th align="center">昵称</th>
                                <th width="40" align="center">性别</th>
                                <th width="90" align="center">出生日期</th>
                                <th width="70" align="center">服务总时间</th>
                                <?php if ($now_flag) {?><th width="80" align="center">工时调整</th><?php }?>
                                <th width="100" align="center">状态</th>
                            </tr>
                            <?php foreach($list as $v){
                                $spm=array();
                                $spm['id']=$v['recordid'];
                                $url='volunteerManage.php?act=detail&spm='.set_url($spm);
                                if($v['status']=='1000') $stu="申请";
                                else if($v['status']=='001') $stu="初审通过";
                                else if($v['status']=='011') $stu="初审被拒";
                                else if($v['status']=='010') $stu="通过终审";
                                else if($v['status']=='100') $stu="注销";
                                ?>
                                <tr>
                                    <td class="listleft"><a href="<?php echo $url;?>" class="tda" title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a></td>
                                    <td class="listleft"><span class="tda" title="<?php echo $v['nickname'];?>"><?php echo $v['username'];?></span></td>
                                    <td class="listleft"><span class="tda" title="<?php echo $v['nickname'];?>"><?php echo $v['nickname'];?><span></td>
                                    <td align="center"><?php echo $v['sex']==1?'女':'男';?></td>
                                    <td align="center"><?php echo date("Y-m-d",$v['birthday']);?></td>
                                    <td align="center"><?php echo $v['allservertime'];?></td>
                                    <?php if ($now_flag) {?><td align="center">
                                        <?php if ($v['status']=='1000'||$v['status']=='011'||$v['status']=='100'){?><a style="cursor: pointer;">不可调整</a><?php }else{?><a href="###"  class="a_red sumupRid" rid="<?php echo $v[recordid];?>">调整</a><?php }?></td><?php }?>
                                    <td><?php echo $stu;if($now_flag) { ?>
                                            <?php if ($v['status']=='011'){ ?><a href="javascript:void(0)" class="dlid" style="color:#ff0000" dlidvalue="<?php echo $v[recordid];?>">删除</a><?php }?><?php if($v['status']=='100') {?> <a href="javascript:void(0)" class="reactive" style="color:#ff0000" idvalue="<?php echo $v[recordid];?>">激活</a> <?php }?>
                                            <?php if($v['status']=='001' || $v['status']=='010') {?> <a href="javascript:void(0)" class="ltid" style="color:#ff0000" ltidvalue="<?php echo $v[recordid];?>">注销</a>
                                            <?php } }?>

                                    </td>
                                </tr>
                            <?php } if(count($list)==0){?>
                                <tr><td colspan="9">查无数据</td></tr>
                            <?php }?>
                        </table>

                        <table width="750"><tr><td  height="5px"></td></tr></table>
                        <?php include './templates/page.php'?>
                        <table width="750"><tr><td  height="5px"></td></tr></table>
                    </form>
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