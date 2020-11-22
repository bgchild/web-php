<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/demo2.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/user_center.css"/>
    <link type="text/css" rel="stylesheet" href="templates/css/adminAppraisingManage.css"/>

    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>

    <script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
    <script type="text/javascript" src="templates/js/common.js"></script>
    <script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>

    <style>
        .btn_alone {
            margin-left: 830px;
            margin-bottom: 10px;
        }

        .service_top tr {
            line-height: 40px;
            height: 40px;
        }

        .btn-group {
            margin-left: 200px;
            margin-top: 30px;
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

                <div class="choose_fa">
                    <div class="choose_so">
                        <div class="choose_ch">
                            <div class="choose_top">
                                <table class="choose_tab">
                                    <tr>
                                        <td align="right">姓名：</td>
                                        <td><input type="text" name="name" class="input" id="name" value="" /></td>
                                        <td align="right">身份证号：</td>
                                        <td><input type="text" name="guarderidnumb" class="input" id="guarderidnumb" value="" /></td>
                                        <td><input type="button" name="doSearch" class="btn" value="查询" id="doSearch" />&nbsp;&nbsp;
                                            <input type="button" value="重置" class="btn" id="doreset" /></td>

                                    </tr>

                                </table>
                            </div>
                            <div class="choose_middle">

                                <table class="list-table menTable" cellspacing="1" cellpadding="2" style="width:95%; margin:0 auto;">
                                    <tr>
                                        <th align="center"><input type="checkbox" name="selectall" class="selectall" /></th>
                                        <th align="center">姓名</th>
                                        <th align="center">年龄</th>
                                        <th align="center">性别</th>
                                        <th align="center">身份证号</th>
                                    </tr>
                                </table>
                                <div id="Pagination" class="pagination"></div>
                                <div class="choose_btn">
                                    <input type="button" value="确定" class="btn" id="ok" />&nbsp;&nbsp;<input type="button" value="返回" class="btn" id="close" />
                                    <input type="hidden" name="men_total" class="men_total" value="<?php echo $men_total;?>" />
                                    <input type="hidden" name="men_per" class="men_per" value="<?php echo $men_per;?>" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="service_top" style="margin-top: 30px;">
                    <form action="" method="post" name="myform" id="myform">
                        <table class="server_tab">
                            <tr>
                                <td width="90" align="right"><span style="color: red;">*&nbsp;</span>培训队员：</td>
                                <td colspan="2">
                                    <textarea style="width:300px;height:80px;" readonly="readonly" id="trainer" name="trainer" class="textarea" ><?php if($train){echo $train['trainer'];}else{foreach($showname as $k=>$v){echo $v.";  ";$c = ($k+1)%4; if($c==0) echo "\n";}}?></textarea>
                                    <?php if(!$train['trainer']){?>
                                        <input type="button" value="选择" class="btn" id="open" />
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <td width="90" align="right"><span style="color: red;">*&nbsp;</span>开始日期：</td>
                                <td width="150" colspan="2">
                                    <input type="text" style="width:120px;" name="startdate" id="startdate" class="input" onclick="WdatePicker()" readonly="readonly" value="<?php echo $train['startdate'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td width="90" align="right"><span style="color: red;">*&nbsp;</span>结束日期：</td>
                                <td width="150" colspan="2">
                                    <input type="text" style="width:120px;" name="enddate" id="enddate" class="input" onclick="WdatePicker()" readonly="readonly" value="<?php echo $train['enddate'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td width="90" align="right"><span style="color: red;">*&nbsp;</span>培训地点：</td>
                                <td width="150" colspan="2">
                                    <input type="text" style="width:300px;" name="trainaddress" id="trainaddress" maxlength="120" class="input"  value="<?php echo $train['trainaddress'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td width="90" align="right"><span style="color: red;">*&nbsp;</span>培训内容：</td>
                                <td width="150" colspan="2">
                                    <textarea style="width:600px;height:150px;"  name="traincontent" id="traincontent"  class="textarea"><?php echo $train['traincontent'];?></textarea>
                                </td>
                            </tr>
                        </table>

                        <div class="btn-group">
                            <?php if(!$train){		?>
                                <input type="hidden"  name="rids"  id="rids" />
                                <input type="submit" value="保存" name="dosubmit1" id="dosubmit1" class="btn dosave" />&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button"  name="dosubmit" class="btn doreset" >重置</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="userTrainManage.php" class="btn doreset" >返回</a>
                            <?php }else{?>
                                <input type="hidden" name="rid" value="<?php echo $train['recordID'];?>"/>
                                <input type="submit" value="保存" name="dosubmit2" id="dosubmit1" class="btn dosave" />&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="userTrainManage.php" class="btn doreset" >返回</a>
                            <?php }?>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    $(function(){
        $(".doreset").click(function(){
            $("#trainer").removeAttr("value");
            $("#startdate").removeAttr("value");
            $("#enddate").removeAttr("value");
            $("#trainaddress").removeAttr("value");
            $("#traincontent").removeAttr("value");
        });
        //选择弹框
        $("#open").click(function(){
            $(".choose_so").show();
        });
        $("#close").click(function(){
            $(".choose_so").hide();
        });
        //
        $("#doreset").click(function(){
            $("#name").removeAttr("value");
            $("#guarderidnumb").removeAttr("value");
            $("#doSearch").click();
        });

        //
        var men_total=$(".men_total").val();
        var _per_page=$(".men_per").val();
        function getFeatures(){
            var _features="";
            $(".features:checked").each(function(){_features+=$(this).val()+",";});
            return _features;
        }
        var selectids=new Array();
        $(".selecteach").live("click",function(){
            if(this.checked){
                selectids.push($(this).val());
            }else{
                for(var i = 0,len = selectids.length;i < len;i++){
                    if($(this).val()==selectids[i])selectids.splice(i,1);
                }
            }
        });
        function pageselectCallback(page_index, jq){
            var _features=getFeatures();
            $.post("userTrainSaveAdd.php",
                { doAPage:"true",
                    page_index:page_index,
                    name:$("#name").val(),
                    guarderidnumb:$("#guarderidnumb").val()
                },function(data){
                    var _th=$(".menTable tr:eq(0)");
                    $(".menTable").empty().append(_th);
                    for (var x in data){
                        var checkedstr="";
                        for(var j=0;j<selectids.length;j++) {
                            if(data[x].recordid==selectids[j]) {checkedstr=" checked='checked' ";break; }
                        }
                        var _html="<tr><td align='center' width='50px'><input type='checkbox' name='selecteach[]' class='selecteach' value='"+data[x].recordid+"' "+checkedstr+"/></td><td align='left' width='220px'>"+data[x].name+"</td><td align='center' width='120px'>"+data[x].birthday+"</td><td align='center' width='120px'>"+data[x].sex+"</td><td align='center'>"+data[x].idnumber+"</td>";
                        _html+="</tr>";
                        $(".menTable").append(_html);
                    }
                },"json");
            return false;
        }
        //
        $(".selectall").live("click",function(){
            if($(".selectall").attr("checked")=="checked")
                $(".selecteach").each(function(){
                    if(this.checked==false)
                        selectids.push($(this).val());
                    $(this).attr("checked","checked");

                });
            else $(".selecteach").each(function(){
                $(this).removeAttr("checked");
                for(var i = 0,len = selectids.length;i < len;i++){
                    if($(this).val()==selectids[i])selectids.splice(i,1);
                }
            });
        });
        //
        $("#Pagination").pagination(men_total, {
            num_edge_entries: 2,
            num_display_entries: 10,
            callback: pageselectCallback,
            items_per_page:_per_page,
            prev_text: "前一页",
            next_text: "后一页"
        });
//
        $("#ok").click(function(){
            var _recd=selectids.join(",");
            //alert(_recd);
            if(selectids.length==0) {
                ui.error("请选择至少一个志愿者！");
                return false;
            }
            $.post("userAppraisingSaveAdd.php",
                {   doRecd:"true",
                    recd:_recd
                },function(data){
                    if(data.result=="yes") {
                        // ui.success("保存成功");

                        $("#trainer").attr("value",data.name);
                        $("#rids").attr("value",data.rids);
                        //alert(data.name);
                        $(".choose_so").hide();
                    }
                    else ui.error("保存失败，请稍后再次尝试");
                },"json");

        });
        //
        $("#doSearch").click(function(){
            $.post("userTrainSaveAdd.php",
                { doSearch:"true",
                    name:$("#name").val(),
                    guarderidnumb:$("#guarderidnumb").val()
                },function(data){
                    men_total=data.men_total;
                    $("#Pagination").pagination(men_total, {
                        num_edge_entries: 2,
                        num_display_entries: 10,
                        callback: pageselectCallback,
                        items_per_page:_per_page,
                        prev_text: "前一页",
                        next_text: "后一页"
                    });
                },"json");
        });
        //
    });


    $(function(){
        $('#dosubmit1').click(function(){
            var trainer= $('#trainer').val();
            var startdate= $('#startdate').val();
            var enddate = $('#enddate').val();
            var trainaddress= $('#trainaddress').val();
            var traincontent= $('#traincontent').val();
            if(!$.trim(trainer)){
                ui.error('请选择培训队员！');
                return false;
            }
            if(!$.trim(startdate)){
                ui.error('开始时间不能为空！');
                return false;
            }
            if(!$.trim(enddate)){
                ui.error('结束时间不能为空！');
                return false;
            }
            if ($.trim(startdate)>$.trim(enddate)) {
                ui.error('结束时间不能早于开始时间！');
                return false;
            }
            if(!$.trim(trainaddress)){
                ui.error('培训地点不能为空！');
                return false;
            }
            if(getLength(trainaddress)>=80){
                ui.error('培训地点不能超过80个字！');
                return false;
            }
            if(!$.trim(traincontent)){
                ui.error('培训内容不能为空！');
                return false;
            }
        });
    });




</script>
<?php include 'footer.tpl.php'; ?>



</body>
</html>