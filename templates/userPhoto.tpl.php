<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/css/userPhoto.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/imgupload.css"/>
<link type="text/css" rel="stylesheet" href="templates/css/imgareaselect-animated.css"/>
<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="templates/js/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="include/keditor/kindeditor-min.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
</head>
<body>
<?php include 'header.tpl.php'; ?>

<div id="content">
<div class="con">
<?php include 'user_left.tpl.php'; ?>
<div class="content_right">
<?php include 'user_top.tpl.php'; ?>
<div class="con_right_bottom">
<div class="set-hd"><h3><?php if($up) {echo "上传";}else{echo "修改";}?>照片</h3></div>
<div class="up_btn">
请选择个人正面大照片作为头像，照片不能小于300px*300px(支持JPG,JPGE,PNG格式，大小限制5M以内)
</div>
 <div class="up_btn">
    <input   type="hidden" id="thumb_url2" name="thumb_url2" value=""  />
    <a href="<?php echo $url;?>" class="btn">返回</a>  
    <input type="button"  id="uploadButton2" value="上传照片"  />
 </div> 
 <div class="photo" id="user_head_small">
 <?php if ($Info['head']){?>
 <img id='user_head_small_img' src="<?php echo $Info['head']?>">
 <?php }else {?><img id='user_head_small_img' src="templates/images/face.jpg"><?php }?>
 </div>
   <div style="width:700px; display:none; float:left; margin-top:10px;" id="user_head_big">
   <div  class="frame" >
   <img src="" id="photo">
    </div>
    <div style="float: left; width: 50%;">
    <div style="margin: 0 1em; width: 200px; height: 200px;" class="frame">
    <div style="width: 200px; height: 200px; overflow: hidden;" id="preview">
    <img style="width: 200px; height: 200px;" src="" id="small_img">
    </div>
  
    </div>

    </div>
                <input type="hidden" name="username" value="<?php echo $Info['username']?>" id="username"/>
                <input type="hidden" name="up" value="<?php echo $up?>" id="up"/>
                <input type="hidden" name="x1" value="0" id="x1" />
				<input type="hidden" name="y1" value="0" id="y1" />
				<input type="hidden" name="x2" value="200" id="x2" />
				<input type="hidden" name="y2" value="200" id="y2" />
				<input type="hidden" name="w" value="200" id="w" />
				<input type="hidden" name="h" value="200" id="h" />

 <div class="opp">  
 <div class="btn"  id="save_btn">保存</div></div>
 </div>
 
 <?php if($up) {?>
 <div class="jump" id="nextstation"><a href="userIndex.php"><div class="addbtn">跳过</div></a></div><?php }?>
</div>
</div>
    
</div>
</div>
<script type="text/javascript">
			KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton2')[0],
					fieldName : 'imgFile',
					url : 'user_thumb.php?&time='+new Date().getTime(),
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = data.url;
							$("#nextstation").hide();
							$("#user_head_small").hide();
							K("#user_head_big").show();
							K('#thumb_url2').val(url);
							K('#photo').attr('src',url);
							K('#small_img').attr('src',url);
							 $('#photo').imgAreaSelect({  x1: 10, y1: 10, x2: 200, y2: 200 ,aspectRatio: '1:1', handles: true, fadeSpeed: 200, onSelectChange: preview });
						} else {
							
							alert(data.message);
						}
					},
					afterError : function(str) {
						alert('自定义错误信息: ' + str);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					uploadbutton.submit();
				});
			});
		</script>
             <script type="text/javascript">
function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;
    
    var scaleX = 200 / selection.width;
    var scaleY = 200 / selection.height;

    $('#preview img').css({
        width: Math.round(scaleX * 300),
        height: Math.round(scaleY * 300),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });

    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);    
}



        
       


$(function () {
   
	$("#save_btn").click(function(){
	var x1=	$('#x1').val();
	var y1=	$('#y1').val();
	var x2=	$('#x2').val();
	var y2=	$('#y2').val();
	var username=$('#username').val();
	var up=$('#up').val();
	var w=	$('#w').val();
	var h=	$('#h').val();
	var bigimg=	$('#thumb_url2').val();	
	if(!bigimg || !w || !h){
		return false;
		}
	$.ajax({
		type:'POST',
		url:'ajax_head.php',
		dataType:'json',
		data:{act:'dosubmit',x1:x1,x2:x2,y1:y1,y2:y2,w:w,h:h,bigimg:bigimg,username:username},
		success:function(data){
			if(data.error==0){
				$("#user_head_big").hide();
				$('.u_head_img').hide();
				$("#user_head_small").show();
				$("#user_head_small_img").attr('src',data.url);	
				ui.success("上传头像成功");
				if(up) setTimeout("location.href = 'userIndex.php' ", 2000);
				}
			
			}
		});	
		
		
		});
	
});

</script>

<?php include 'footer.tpl.php'; ?>
</body>
</html>