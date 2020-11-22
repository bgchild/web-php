<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $siteconfig['title']; ?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords']; ?>"/>
    <meta name="Description" content="<?php echo $siteconfig['description']; ?>"/>

    <style>
        .clear {
            clear: both; display: block; overflow: hidden; visibility: hidden; width: 0; height: 0;
        }

        .clearfix:after {
            clear: both; content: ' '; display: block; font-size: 0; line-height: 0; visibility: hidden; width: 0; height: 0;
        }

        .clearfix {
            display: inline-block;
        }

        * html .clearfix {
            height: 1%;
        }

        .clearfix {
            display: block;
        }



        #clist {
            width: 100%;
            float:left;
            overflow: hidden;
            padding: 0px 0px 20px;
        }
        #clist dt {
            color: #545454;
            float: left;
            width: 50px;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 12px;
            clear: both;
            font-weight: bold;
            margin: 0px;
            padding: 5px 0px 5px 5px;
        }
        #clist dd {
            float: left;
            width: 900px;
            margin-left: 0px;
            padding: 5px 0px;
        }
        #clist dd a {
            font-size: 12px;
            margin-right: 6px; margin-left: 6px;
            white-space: nowrap;
            text-decoration: none;
            color: #333;
        }

        #clist dd a:hover {
            color: #E40000;
        }


        .city-item {
            position: relative;
            line-height: 18px;
            display: inline-block;
        }

        .city-item .city-area{
            display: none;
            position: absolute;
            z-index: 1;
            /*border: 1px solid #E9423C;*/
            top: 0; left: 0;
            width: 100%;
        }

        .city-item.hover {
            background-color: #f9e3e2;
        }

        .city-item.hover .city-item-link{
            visibility: hidden;
        }

        .city-item.hover .city-area {
            display: block;
        }

        .city-area-label {
            width: 100%;
        }
        .city-area-menu {
            background-color: #f9e3e2;
            width: 280px;
            position: absolute;
            left: 0;
        }
        .city-area-menu ul {
            padding: 3px 0;
        }
        .city-area-menu ul li {
            float: left;
            width: 33.33%;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .city-area-menu ul li a {

        }
    </style>
    <link type="text/css" rel="stylesheet" href="templates/css/userjoin.css"/>
    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'user_left.tpl.php'; ?>

        <div class="content_right">
            <div class="jinfo">

                <?php if ($nearone) echo "<font style=color:red>" . $nearone['oname'] . "转至" . $nearone['nname'] . "</font><br/>";
                echo $rmark ?>
            </div>
            <?php if ($nearone[status] != 1 and $nearone[status] != 3) { ?>
                <div class="userjion">
                    <a id="chosecity">点击选择要转至的城市</a>
                    <dl id="clist">
                        <?php foreach($province as $k => $v) {?>
                            <dt>
                                <a href="javascript:;"><?php echo $v['name']; ?></a>
                            </dt>
                            <dd>
                                <?php $city = $v['children']; ?>
                                <?php foreach($city as $k1 => $v1) {?>
                                    <span class="city-item">
                        <a class="city-item-link" href="javascript:;" data="<?php echo $v1['sign']; ?>"><?php echo $v1['name']; ?></a>
                                        <?php $area = $v1['children']; ?>
                                        <?php if($area && count($area)) { ?>
                                            <div class="city-area">
                                                <div class="city-area-label">
                                                    <a href="javascript:;" data="<?php echo $v1['sign'] ?>"><?php echo $v1['name']; ?></a>
                                                </div>
                                                <div class="city-area-menu">
                                                    <ul class="clearfix">
                                                        <?php foreach($area as $k2 => $v2) {?>
                                                            <li>
                                                                <a href="javascript:;" title="<?php echo $v2['name']; ?>" data="<?php echo $v2['sign']; ?>"><?php echo $v2['name']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
                    </span>

                                <?php } ?>
                            </dd>
                        <?php } ?>
                    </dl>
                    <form method="post">
                        <table class="tinfo">
                            <tr>
                                <td>所属城市：</td>
                                <td class="oname"><?php echo $binfo[oname]; ?></td>
                            </tr>
                            <tr>
                                <td>转至城市：</td>
                                <td><input class="input length_2" name="nname" value="" type="text" readonly="true">
                                </td>
                            </tr>
                            <tr>
                                <td>备注：</td>
                                <td><textarea id="ureason" name="ureason" style=" width:200px;"></textarea></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" class="btn" name="dosubmit" value="提交申请"/></td>
                            </tr>
                        </table>
                        <input type="hidden" name="ncity" value=""/>
                    </form>
                </div>
            <?php } ?>
        </div>


    </div>
</div>
<?php include 'footer.tpl.php'; ?>
</body>
<script type="text/javascript">
    $(function () {
        $('#chosecity').click(function () {
            $('#clist').show();
        })
        $('.city-item a').click(function () {
            var name = $(this).html();
            var sign = $(this).attr('data');

            if (name == $('.oname').html()) {
                ui.error("您已属于当前城市！");
                return false;
            }
            $("input[name='nname']").val(name);
            $("input[name='ncity']").val(sign);
            $('#clist').hide();
        })

        $("form").submit(function () {
            if (!$("input[name='nname']").val()) {
                ui.error("请选择要转至的城市!");
                return false;
            }
            if ($('#ureason').val().length > 100) {
                ui.error("备注过长，不能超过100个字符。");
                return false;
            }
        });



        var content = $(".content_right").eq(0);
        $(".city-item").hover(function() {

            var left;
            var width;
            var max = content.offset().left + content.width();
            var area = $(this).find(".city-area-menu");
            if (area.get(0)) {
                $(this).addClass("hover");

                left = area.offset().left;
                width = area.width();
                if ( left + width > max ) {
                    area.css({left: (max - (left + width)+"px")})
                }
            }
        }, function() {
            $(this).removeClass("hover");
        });

    })

</script>
</html>