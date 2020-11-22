<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $siteconfig['title'];?></title>
    <meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
    <meta name="Description" content="<?php echo $siteconfig['description'];?>" />
    <link type="text/css" rel="stylesheet" href="templates/css/activity.css"/>
    <link rel="stylesheet" type="text/css" href="templates/css/jquery.bxslider.css">
    <script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="templates/js/msgbox.js"></script>
    <script type="text/javascript" src="templates/js/jquery.bxslider.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <?php include 'left.tpl.php';?>
        <div class="content_right">
            <h3>人物经历</h3>
            <!--<div class="detail_con">
                <div class="item">志愿团体：<?php /*echo $one['serviceteamname'];*/?></div>
                <div class="item">所属地区：<?php /*echo $one['areas'];*/?></div>
                <div class="item">招收人数：<?php /*echo $one['planmembernumber'];*/?>人</div>
                <div class="item">成员人数：<?php /*echo $one['member'];*/?>人</div>
                <div class="item">成立日期：<?php /*echo $one['foundingtime'];*/?></div>
                <div class="item">负责人：<?php /*echo $one['responsibleperson'];*/?></div>
                <div class="item">联系人：<?php /*echo $one['relationperson'];*/?></div>
                <div class="item">联系电话：<?php /*echo $one['mobile_telephone']."&nbsp;&nbsp;"; echo $one['telephones'];*/?></div>
                <div class="item">电子邮箱：<?php /*echo $one['emails']*/?></div>
                <div class="item">详细通讯地址：<?php /*echo $one['detailed_address']*/?></div>
                <div class="item">邮编：<?php /*echo $one['postcodes']*/?></div>
                <div class="item">传真：<?php /*echo$one['fax']*/?></div>
                <div class="item">服务类型：<?php /*echo $one['serveitem']*/?></div>
                <div class="item">所需技能：<?php /*echo $one['skillitem']*/?></div>
                <div class="item">目前或计划开展服务：<?php /*echo $one['others']*/?></div>
                <div class="item">简要服务经历：<?php /*echo $one['teamintroduction']*/?></div>
            </div>-->

            <div class="team_activity">评优经历：
                <table class="list-table" cellspacing="1" cellpadding="2">
                    <tr><th>获奖地点</th><th>获奖内容</th><th style="text-align:center">获奖日期</th></tr>
                    <?php if(!$prizeList){?><tr><td colspan='5'>查无数据</td></tr><?php }?>
                    <?php foreach($prizeList as $val){?>
                        <tr>
                            <td class="onetd"><?php echo $val['winaddress']; ?></td>
                            <td><?php echo $val['wincontent'];?></td>
                            <td style="text-align:center"><?php echo date("Y-m-d", $val['receivedate']); ?></td>
                        </tr>
                    <?php }?>
                </table><?php include 'page.php';?></div>


        </div>
    </div>
</div>

<?php include 'footer.tpl.php'; ?>
</body>
</html>