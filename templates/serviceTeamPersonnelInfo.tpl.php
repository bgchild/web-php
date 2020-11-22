<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/serviceTeamPersonnelInfo.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>


<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>

<div class="content_right">
		<?php include 'user_top.tpl.php'; ?>
	
	
	<div class="con_right_bottom">
    	<div class="basic_red"><div class="basic_title"><h1>基本资料</h1></div></div>
		<div id="basicInfo">
            <div class="basic_tab">
            	<table class="base_table">
                	<tr>
                    	<td  width="100" align="right">姓名：</td>
                        <td width="200"><?php echo $detail['name']?></td>
                        <td colspan="2" rowspan="4" align="center">
                        	<img src="<?php echo $detail['head'];?>" title="志愿者头像" alt="" />
                        </td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">年龄：</td>
                        <td width="200"><?php echo $detail['age'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">性别：</td>
                        <td width="200"><?php echo $detail['sex'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">民族：</td>
                        <td width="200"><?php echo $detail['race'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">国籍：</td>
                        <td width="200"><?php echo $detail['nationality'];?></td>
                        <td width="70" align="right">居住地：</td>
                        <td width="200"><?php echo $detail['province'];?><?php if ($detail['city'] !== '市辖区' || $detail['city'] !== '县') { echo $detail['city']; }?><?php echo $detail['area'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">出生年月：</td>
                        <td width="200"><?php echo $detail['birthday'];?></td>
                        <td width="70" align="right">证件号码：</td>
                        <td width="200"><?php echo $detail['idnumber'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">证件类型：</td>
                        <td width="200"><?php echo $detail['idtype'];?></td>
                        <td width="70" align="right">政治面貌：</td>
                        <td width="200"><?php echo $detail['politicalstatus'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">固定电话：</td>
                        <td width="200"><?php echo $detail['telephone'];?></td>
                        <td width="70" align="right">手机：</td>
                        <td width="200"><?php echo $detail['cellphone'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">详细通信地址：</td>
                        <td width="200"><?php echo $detail['detailplace'];?></td>
                        <td width="70" align="right">QQ：</td>
                        <td width="200"><?php echo $detail['qq'];?></td>
                    </tr>
                    <tr>
                    	<td width="100" align="right">工作单位：</td>
                        <td width="200"><?php echo $detail['work'];?></td>
                        <td width="70" align="right">邮编：</td>
                        <td width="200"><?php echo $detail['postcode'];?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="basic_red"><div class="basic_title"><h1>教育情况</h1></div></div>
        <div id="eduInfo">
            <div class="eduInfo_tab">
            	<table class="base_table">
                	<tr>
                    	<td align="right" width="100">是否在校大学生：</td>
                        <td width="200"><?php echo $detail['isstudent '];?></td>
                    </tr>
                    <tr>
                    	<td align="right" width="100">最高学历：</td>
                        <td width="200"><?php echo $detail['lasteducation'];?></td>
                    </tr>
                    <tr>
                    	<td align="right" width="100">毕业院校：</td>
                        <td width="200"><?php echo $detail['graduatecollege'];?></td>
                    </tr>
                    <tr>
                    	<td align="right" width="100">所学专业：</td>
                        <td width="200"><?php echo $detail['major'];?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="basic_red"><div class="basic_title"><h1>技能特长</h1></div></div>
        <div id="skill">
            <div class="skill_tab">
            	<table class="base_table">
                	<tr>
                    	<td align="right" width="100">技能特长：</td>
                        <td width="400"><?php echo $detail['features'];?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="basic_red"><div class="basic_title"><h1>支援者服务项目</h1></div></div>
        <div id="voservice">
            <div class="voservice_tab">
            	<table class="base_table">
                	<tr>
                    	<td align="right" width="100">支援者服务项目：</td>
                        <td width="400"><?php echo $detail['serveitem'];?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="basic_red"><div class="basic_title"><h1>服务时间</h1></div></div>
        <div id="serviceTime">
            <div class="serviceTime_tab">
            	<table class="table5" cellpadding="1" cellspacing="1">
                    <tr>
                        <td></td>
                        <td>周一</td>
                        <td>周二</td>
                        <td>周三</td>
                        <td>周四</td>
                        <td>周五</td>
                        <td>周六</td>
                        <td>周日</td>
                        <td>节假日</td>
                    </tr>
                    <tr>
                        <td>上午A.m</td>
                        <?php for ($i=1;$i<9;$i++){?>
                        <td id="stime_<?php echo $i?>"  <?php foreach ($detail['am'] as $val){if($i==$val){echo "class=chose";}}?>><input type="checkbox" id="che_<?php echo $i ?>" name="am[]" value="<?php echo $i?>" <?php foreach ($am as $val){if($i==$val){echo "checked";}}?>/></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td>下午P.m</td>
                        <?php for ($i=1;$i<9;$i++){?>
                        <td id="stime_2<?php echo $i?>"  <?php foreach ($detail['pm'] as $val){if($i==$val){echo "class=chose";}}?>><input type="checkbox" name="pm[]" value="<?php echo $i?>" <?php foreach ($pm as $val){if($i==$val){echo "checked";}}?>/></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td>晚上Night</td>
                        <?php for ($i=1;$i<9;$i++){?>
                        <td id="stime_3<?php echo $i?>" <?php foreach ($detail['night'] as $val){if($i==$val){echo "class=chose";}}?>><input type="checkbox" name="night[]" value="<?php echo $i?>" <?php foreach ($night as $val){if($i==$val){echo "checked";}}?>/></td>
                        <?php }?>
                    </tr>
		</table>
            </div>
        </div>
        
        <div id="goback"> <a href="<?php echo $backurl;?>" class="btn">返回</a></div>
        
        
        
        
        
        
	</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function(){ 
	 //服务时间
		$("td[id^='stime']").click(function(){
			if($(this).hasClass("chose")){
				 $(this).removeClass("chose");
				 $(this).find("input").attr("checked", false);   
			}else{
				 $(this).addClass("chose");
				 $(this).find("input").attr("checked", true); 
			}
		}); 		
});

</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>