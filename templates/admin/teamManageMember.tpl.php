<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="../templates/css/serviceTeamAudit.css"/>
<script type="text/javascript" src="../templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../templates/js/msgbox.js"></script>

</head>
<body>
<?php include '../templates/header.tpl.php'; ?>
<div id="content">
<div class="con">
<?php include 'admin_left.tpl.php'; ?>

<div class="admin_right">
<?php include 'admin_top.tpl.php'; ?>
<div class="admin_mamage_right adm_con">

  <div class="tab"  style="margin-top:10px;">
       	<ul>
				<li><a href="teanManageDetail.php?act=edit&spm=<?php echo $_GET['spm'];?>">基本信息</a></li>
				<li class="tabact"><a href="teanManageDetail.php?act=member&spm=<?php echo $_GET['spm'];?>">服务队人员</a></li>
				<li><a href="teanManageDetail.php?act=activity&spm=<?php echo $_GET['spm'];?>">开展活动</a></li>
			</ul>	
  </div>

  <div class="manage_content">
      <div class="manage_content_list tab_item">
         <table class="list-table table_2 " cellspacing="1" cellpadding="2">
			<tr>
            <th align="center" width="154">姓名</th>
            <th align="center" width="98">加入时间</th>
            <th align="center" width="42">年龄</th>
            <th align="center" width="35">性别</th>
            <th align="center" width="100" >邮箱</th>
            <th align="center" width="107">手机号码</th>
            <?php if ($now_flag) {?><th align="center" width="184">操作</th><?php  }?>
            </tr >        
            <?php 
			     foreach($list as $v){  	
			     $sex = $v['sex']==1?'男':'女';
				 $age = date('Y',time()) - date('Y',$v['birthday']);
				 $age = floor($age);
				 if($v['captain']=='1') {$posi = "<img src='../templates/images/p1.png' alt='' title=''  />";}
				 if($v['captain']=='2') {$posi = "<img src='../templates/images/p2.png' alt='' title='' />";}
				 if($v['captain']=='3'){$posi = "<img src='../templates/images/p3.png' alt='' title='' />";}
?>
			<tr>
            <td align="left" width="154" class="omit3"><a title="<?php  echo $v['name'];?>"><?php echo $posi,$v['name'];?></a></td>
            <td align="center" width="98"><?php echo date('Y-m-d',$v['joinserviceteamdate']); ?></td>
            <td align="center" width="42"><?php echo $age;?></td>
            <td align="center" width="35"><?php echo $sex ; ?></td>
            <td align="left" width="100" class="omit4"><a title="<?php echo $v['emails'];?>"><?php echo $v['emails'];?></a></td>
            <td align="center" width="107"><?php echo $v['cellphone'];?></td>
            <?php if ($now_flag) {?>
            <?php   if($v['captainable']=='0')  {  ?>
            <td align="center" width="184">没有队长权限</td>
            <?php   }  elseif($v['captain']==1){ ?>
            <td align="center" width="184"><a class="addbtn btn_alone" onclick="captainchange(this,4,'<?php echo $v['serviceteamid'];?>','<?php echo $v['precordid'];?>')">取消队长<input type="hidden" value="<?php echo $v['recordid'];?>"/></a></td>
            <?php   }  elseif($v['captain']==2){ ?>    
            <td align="center" width="184"><a class="addbtn btn_alone" onclick="captainchange(this,5,'<?php echo $v['serviceteamid'];?>','<?php echo $v['precordid'];?>')">取消副队长<input type="hidden" value="<?php echo $v['recordid'];?>"/></a></td>     
            <?php  }  else{ ?>
            <td align="center" width="184"><a class="addbtn btn_alone" role="button" onclick="captainchange(this,2,'<?php echo $v['serviceteamid'];?>','<?php echo $v['precordid'];?>')">设为队长<input type="hidden" value="<?php echo $v['recordid'];?>"/></a>&nbsp;<a class="addbtn btn_alone" onclick="captainchange(this,3,'<?php echo $v['serviceteamid'];?>','<?php echo $v['precordid'];?>')">设为副队长<input type="hidden" value="<?php echo $v['recordid'];?>"/></a></td> 
            <?php } ?>
            <?php } else { ?>
            
            <?php } ?> 
            </tr>
            <?php } ?>   
            
            
              
		</table>
         
       <table width="750"><tr><td  height="5"></td></tr></table>
     <?php include '../templates/page.php'?>
     <table width="750"><tr><td  height="5"></td></tr></table>
      
      </div>
      <div class="manage_content_back"><a href="serviceTeamMessage.php" class="btn" >返回</a></div>
  </div>




</div>  



</div>
</div>
</div>
<?php include '../templates/footer.tpl.php'; ?>
<script type="text/javascript">

function captainchange(row,type,servid,uid) {
 if(confirm("确定要修改队长设置？")){
	  var editid = $(row).find('input').val();
	  var act=type;
	  	  $.ajax({type      :'post',
			         url         :'ajax_captain.php',
			         data      :{editid:editid,act:act,servid:servid,uid:uid},
			         success  :function(msg){
						                 if(msg!='0'){
                                                 location.reload();
											 } else { alert('设置失败！');}
								}
			   });
	 }
}


</script>

</body>
</html>