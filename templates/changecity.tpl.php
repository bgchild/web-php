<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/volunteer.css"/>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
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
<body>
<?php include 'header.tpl.php'; ?>
<div id="content">
    <div class="con">
        <!--<dl id="clist">
        <?php /*foreach($pro as $k=>$v){*/?>
            <dt>
                <a href="http://<?php /*echo $v['sign'];*/?><?php /*echo $website; */?>/<?php /*if ($sta) {echo $sta;}*/?>"><?php /*echo $k */?></a>
            </dt>
            <dd>
                <?php /*foreach($city[$k] as $c){*/?>
                <a href="http://<?php /*echo $c['sign']*/?><?php /*echo $website; */?>/<?php /*if ($sta) {echo $sta;}*/?>"><?php /*echo $c['name'] */?></a>
                <?php /*}*/?>
            </dd>
        <?php /*}*/?>
        </dl>-->

        <dl id="clist">
        <?php foreach($province as $k => $v) {?>
            <dt>
                <a href="http://<?php echo $v['sign'];?><?php echo $website; ?>/<?php if ($sta) {echo $sta;}?>"><?php echo $v['name']; ?></a>
            </dt>
            <dd>
                <?php $city = $v['children']; ?>
                <?php foreach($city as $k1 => $v1) {?>
                    <span class="city-item">
                        <a class="city-item-link" href="http://<?php echo $v1['sign'];?><?php echo $website; ?>/<?php if ($sta) {echo $sta;}?>"><?php echo $v1['name']; ?></a>
                        <?php $area = $v1['children']; ?>
                        <?php if($area && count($area)) { ?>
                        <div class="city-area">
                            <div class="city-area-label">
                                <a href="http://<?php echo $v1['sign'];?><?php echo $website; ?>/<?php if ($sta) {echo $sta;}?>"><?php echo $v1['name']; ?></a>
                            </div>
                            <div class="city-area-menu">
                            <ul class="clearfix">
                                <?php foreach($area as $k2 => $v2) {?>
                                <li>
                                    <a href="http://<?php echo $v2['sign'];?><?php echo $website; ?>/<?php if ($sta) {echo $sta;}?>" title="<?php echo $v2['name']; ?>"><?php echo $v2['name']; ?></a>
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
</div>
</div>
<script>
$(function() {
    $(".city-item").hover(function() {
        if ($(this).find(".city-area").get(0)) {
            $(this).addClass("hover");
        }
    }, function() {
        $(this).removeClass("hover");
    });
});
</script>

<?php include 'footer.tpl.php'; ?>




</body>
</html>