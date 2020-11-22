<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/activity.css"/>
    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>
    <style>
    .prize-winner-list {
        padding-top: 30px;
    }

    .prize-winner-item {
        float: left;
        width: 25%;
        height: 210px;
        color: #000;
        margin-bottom: 54px;
        text-align: center;
    }

    .prize-winner-item-inner {
        padding: 0 5px;
    }

    .prize-winner-item .avatar{
        width: 159px;
        height: 159px;
        border: 2px solid #ff8b86;
        border-radius: 50%;
        position: relative;
        overflow: hidden;
        margin: 0 auto;
    }

    .prize-winner-item:hover .avatar {
        border-color: #e9423b;
    }

    .prize-winner-item .avatar-box{
        width: 139px;
        height: 139px;
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        background-color: #fff;
        border-radius: 50%;
        overflow: hidden;
    }

    .prize-winner-item .avatar img {
        width: 100%;
        height: 100%;
    }

    .prize-winner-item h4 {
        font-size: 22px;
        padding-top: 25px;
        font-weight: 700;
    }
    </style>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'left.tpl.php';?>
        <div class="content_right">
            <h3>志愿人物</h3>
            <div class="con_border">
                <form  action="prizewinner.php" method="get">
                    <div class="serach_more">
                        <div class="first">人物名称： <input type="text"  class="input length_3" name="prizewinner" value="<?php echo $info['prizewinner'];?>"/>
                            <input class="btn s_btn" type="submit" name="doSearch" value="查询"/></div>
                    </div>
                </form>
                <div class="content">
                    <div class="prize-winner-list">
                        <?php if(!$users){?> <div style="text-align:center; line-height:130px; color:red">查无数据</div><?php }?>
                        <?php foreach($users as $val){?>
                            <a target="_blank" class="prize-winner-item" href="prizewinner-detail.php?rid=<?php echo $val['recordid']; ?>">
                                <div class="prize-winner-item-inner">
                                    <div class="avatar">
                                        <div class="avatar-box">
                                            <img src="<?php if($val['head']){ echo $val['head']; } else { echo "templates/images/face.jpg"; } ?>" />
                                        </div>
                                    </div>
                                    <h4><?php echo $val['name']; ?></h4>
                                </div>
                            </a>
                        <?php }?>
                    </div>
                </div>
                <?php include 'page.php';?>
            </div>
        </div>







    </div>
</div>

<?php include 'footer.tpl.php'; ?>



</body>
</html>