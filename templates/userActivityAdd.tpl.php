<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteconfig['title'];?></title>
<meta name="Keywords" content="<?php echo $siteconfig['keywords'];?>" />
<meta name="Description" content="<?php echo $siteconfig['description'];?>" />

<link type="text/css" rel="stylesheet" href="templates/css/userActivityAdd.css"/>

<script type="text/javascript" src="templates/js/jquery-1.3.1.min.js"></script>
<script  type="text/javascript"   src="templates/js/jsdate/WdatePicker.js"></script>
<script type="text/javascript" src="templates/js/msgbox.js"></script>
<script  type="text/javascript"   src="templates/js/jquery.pagination.js"></script>

<link rel="stylesheet" href="include/keditor/themes/default/default.css" />
<link rel="stylesheet" href="include/keditor/plugins/code/prettify.css" />
<script charset="utf-8" src="include/keditor/kindeditor-min.js"></script>
<script charset="utf-8" src="include/keditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="include/keditor/plugins/code/prettify.js"></script>

<link type="text/css" rel="stylesheet" href="templates/css/imgupload.css"/>

<script  type="text/javascript"   src="templates/js/common_table.js"></script>
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=A739765f9a84bee561d30fa0b537ccb9"></script>

<style>
.large-select.hidden,.large-check.hidden,.large-input.hidden {
	visibility: hidden;
}
#activityPoint.disable {
	cursor: not-allowed;
	background: #ddd;
	box-shadow: none;
}
table tr td ul li {
	margin-right: 2px;
	display: inline;
}
.allmap-container {
	position: fixed; left: 0; top: 0; right: 0; bottom: 0;
	background-color: rgba(0,0,0,0.75);
	z-index: 10;
	display: none;
}
.allmap-box {
	position: absolute; left: 0; top: 0; right: 0; bottom: 0;
	margin: auto; width: 800px; height: 500px;
}
.allmap-close-btn {
	position: absolute; top: -10px; right: -10px;
	width: 20px; height: 20px; line-height: 20px;
	background-color: #E9423C; color: #fff;
	font-size: 14px;
	text-align: center;
	border-radius: 50%;
	cursor: pointer;
}

.allmap-close-btn:hover {
	background-color: #c72f29;
	color: #fff;
}
#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
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
	
		<input type="hidden" id="isShow" value="<?php echo $isShow?>" />
		<input type="button" name="doAddActivity" value="从以往活动中筛选" class="btn butLeft" />
		
		<div class="hiddenChooseDiv">
			<form action='userActivityAdd.php' method='post' class="searchFrom" >
  			<fieldset class="searchFieldSet">
    			<legend>查询条件</legend>
    			<table class="searchTable" cellpadding="0" cellspacing="0">
    				<tr><td class="listright "  width="80">活动名称：</td>
    					<td width="130"><input type="text" name="activityName"   class="input length_201 activityName" value="<?php echo $info['activityName'];?>"/></td>
    					<td class="listright" width="80">活动类型：</td>
    					<td width="130"><select name='activityType' class='select_201 activityType_search'  ><option value='0' class="activityType_search_option ">请选择</option><?php foreach($types as $key=>$val) {?><option class="activityType_search_option" value='<?php echo $val['id']?>' <?php if($info[activityType]==$val['id']) echo "selected='selected'";?>><?php echo $val[name]?></option><?php }?></select></td>
    					<td class="listright" width="80">活动地点：</td>
    					<td width="130"><input type="text" name="activityAddr" class="input length_201 activityAddr" value="<?php echo $info['activityAddr'];?>"/></td>
    				</tr>
    				<tr><td class="listright">活动时间起：</td>
    					<td><input type="text" name="activityStartDate" class="input length_201 activityStartDate" onclick="WdatePicker()"   readonly="readonly" value="<?php echo $info['activityStartDate'];?>"/></td>
    					<td class="listright">活动时间止：</td>
    					<td><input type="text" name="activityEndDate" class="input length_201 activityEndDate" onclick="WdatePicker()"   readonly="readonly"  value="<?php echo $info['activityEndDate'];?>"/></td>
    					<td colspan='2' class="listright"><input type="submit" name="doSearch" class="btn" value="查询" />&nbsp;<input type="button"   class="btn btn_rest" value="重置" />&nbsp;<input type="button"   class="btn btn_close" value="关闭" /></td>
    				</tr>
    			</table>
  			</fieldset>
			</form>
			<table class="list-table  table-95" cellspacing="1" cellpadding="2">
			<tr><th width="10px"></th><th>活动名称</th><th width="180px">活动日期</th><th>活动类型</th><th>活动地点</th></tr>
				<?php foreach($sta as $k=>$val ){?>
						<tr><td><input type="radio" class="chooseRecord" value="<?php echo $val['recordid']?>" /></td><td><?php echo $val[activityName];?></td><td><?php echo $val[activityStartDate];?>~<?php echo $val[activityEndDate];?></td><td><?php echo $val[typename];?></td><td><?php echo $val[activityAddr];?></td></tr>
				<?php } if(!$sta){?>	<tr><td colspan='8'>查无数据</td></tr><?php }?>
			</table>
			 <?php include 'page.php'?>
			 <input type="button" class="btn btn_choose" value="确定" />
		</div>
		
		<div class="activityAddDiv">
			<form action="userActivityAdd.php" method="post"  id="addUserActivity" enctype="multipart/form-data" >
			<table class="activityAddTable">
				<tr style="display:none;height:0px;">
					<td width="135px" ><input type="hidden" name="recordid" value="<?php echo $one[recordid];?>" /></td>
					<td width="235px" ></td><td width="115px" ></td><td width="235px" ></td>
				</tr>
				<tr>
					<td class="listright" >活动名称：</td>
					<td ><input type="text" name="activityName"  id="activityName" class="input length_20 " value="<?php echo $one[activityName];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
					<td class="listright">活动类型：</td>
					<td><select name="activityType" id="activityType"class="select_20 "><option value="0">请选择</option><?php foreach($types as $k=>$v) {?><option value="<?php echo $v[id];?>"  class="typenos typeno_<?php echo $v[id];?>" <?php if( $one['activityType']==$v[id]) echo "selected=selected";?>><?php echo $v[name];?></option><?php }?></select><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
				</tr>
				<tr id="pca-tr">
					<td class="listright">活动地址：</td>
					<td colspan="3">
						<ul>
							<li>
								<select name="activityProvince" id="province">
									<option value="">请选择</option>
									<?php foreach($province as $val) {?>
										<option value="<?php echo $val['areaId']; ?>"><?php echo $val['areaName']; ?></option>
									<?php } ?>
								</select>
							</li>
							<li id="citydiv">
								<select name="activityCity" id="city" style="display: none;">
									<?php foreach($city as $val) {?>
										<option value="<?php echo $val['areaId']; ?>"><?php echo $val['areaName']; ?></option>
									<?php } ?>
								</select>
							</li>
							<li id="areadiv">
								<select name="activityArea" id="area" style="display: none;">
									<?php foreach($area as $val) {?>
										<option value="<?php echo $val['areaId']; ?>"><?php echo $val['areaName']; ?></option>
									<?php } ?>
								</select>
							</li>
							<font color="#ff0000" style="font-weight:bold;">&nbsp;*</font>
						</ul>
					</td>

				</tr>
				<tr>
					<td class="listright">活动详情地点：</td>
					<td colspan="3"><input type="text" name="activityAddr" id="activityAddr"class="input length_20" style="width: 526px;" value="<?php echo $one['activityAddr'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
				</tr>
				<tr>
					<td class="listright">活动坐标点：</td>
					<td><input type="text" readonly name="activityPoint" id="activityPoint" class="input length_20" style="width: 275px;" value="<?php if ($one['lng'] && $one['lat'])  echo $one['lng'].','.$one['lat'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
					<td class="listright">计划人数：</td>
					<td><input type="text" name="planNum"  id="planNum"class="input length_20 " value="<?php echo $one['planNum'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
				</tr>
				<tr>
					<td class="listright" >预计志愿服务时间：</td>
					<td><input type="text" name="predictHour"  id="predictHour" class="input length_20 " value="<?php echo $one['predictHour'];?>"/>&nbsp;小时<font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
					<td class="listright">创建时间：</td>
					<td><input type="text" name="creattime"  id="creattime" readonly="readonly"class="input length_20 " value="<?php  echo trim($one['creattime'])?$one['creattime']:"";?>"/></td>
				</tr>
				<tr>
					<td class="listright" >活动时间：</td>
					<td><input type="text" name="activityStartDate"  id="activityStartDate"onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"   readonly="readonly" class="input  "  style="width:120px"  value="<?php echo $one['activityStartDate'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font>至
							<input type="text" name="activityEndDate" id="activityEndDate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"   readonly="readonly"  class="input  "  style="width:120px" value="<?php echo $one['activityEndDate'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
					<td class="listright">活动时长：</td>
					<td><input type="text" name="activitytime"  id="activitytime" readonly="readonly" class="input length_20 " value="<?php echo $one['activitytime'];?>"/>&nbsp;小时</td>
				</tr>
				<tr>
					<td class="listright" >报名截止时间：</td>
					<td><input type="text" name="signUpDeadline"  id="signUpDeadline" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="readonly" class="input length_20 " value="<?php echo $one['signUpDeadline'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
					<td>服务队名称:</td>
					<td><input type="text"  id="servicename" value="<?php echo $one['servicename']?>" class="input length_20 " readonly="readonly"/><input type="hidden" name="serviceid"  id="serviceid" value="<?php echo $one['serviceid']?>" /><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
				</tr>
				<tr>
					<td class="listright" >预算经费：</td>
					<td><input type="text" name="actysmoney"  id="actysmoney"  class="input length_20 " value="<?php echo $one['actysmoney'];?>"/>&nbsp;&nbsp;元</td>
					<td class="listright">受益人次：</td>
					<td><input type="text" name="actysobjnum"  id="actysobjnum"  class="input length_20 " value="<?php echo $one['actysobjnum'];?>"/><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
				</tr>
				<tr>
					<td class="listright large-check <?php if($largeRecord) {?> hidden <?php } ?>">大型活动：</td>
					<td class="large-check <?php if($largeRecord) {?> hidden <?php } ?>">
						<?php if(!$largeRecord) {?>
						<input type="checkbox" name="large" id="large" <?php if ( $one && $one['large'] == 1 ) {?> checked <?php } ?> />
						<?php } ?>
					</td>
					<td class="listright large-select <?php if ( !$largeRecord && $one && $one['large'] == 1 ) {?> hidden <?php } ?>">父级活动：</td>
					<td class="large-select <?php if ( $one && $one['large'] == 1 ) {?> hidden <?php } ?>">
						<?php if($largeRecord) {?>
						<input type="hidden" name="largeid" id="largeid" data-startdate="<?php echo date("Y-m-d H:i:s",$largeRecord['activityStartDate']); ?>" data-enddate="<?php echo date("Y-m-d H:i:s",$largeRecord['activityEndDate']); ?>" value="<?php echo $largeRecord['recordid']; ?>" />
						<a href="javascript:;" title="<?php echo date("Y-m-d H:i:s",$largeRecord['activityStartDate']); ?> - <?php echo date("Y-m-d H:i:s",$largeRecord['activityEndDate']); ?>"><?php echo $largeRecord['activityName']; ?></a>
						<?php } else {?>
						<select name="largeid" id="largeid" class="select_20 ">
							<option value="">请选择</option>
							<?php foreach($largeActivityList as $val) {?>
								<option data-startdate="<?php echo date("Y-m-d H:i:s",$val['activityStartDate']); ?>" data-enddate="<?php echo date("Y-m-d H:i:s",$val['activityEndDate']); ?>" value="<?php echo $val['recordid']; ?>"><?php echo $val['activityName']; ?></option>
							<?php } ?>
						</select>
						<?php } ?>
					</td>
				</tr>

				<tr>
					<td class="listright" >参加活动要求：</td>
					<td colspan='3' ><textarea name="remarks" id="remarks"  style="width:521px; height:50px;" ><?php echo $one['remarks'];?></textarea><font color="#ff0000" style="font-weight:bold;">&nbsp;*</font></td>
				</tr>
				<tr>
					<td class="listright" >活动简介：</td>
					<td colspan='3'><textarea name="activityProfile" id="activityProfile" style="width:531px; height:300px;"  ><?php echo $one['activityProfile'];?></textarea></td>
				</tr>
				<tr>
					<td class="listright">上传附件：</td>
					<td colspan="3"><input type="file" name="filename"  class="filename"/><?php echo $one['filename'];?><br />格式要求：pdf，xlsx，xls，doc，docx，ppt，gif，jpg，png，txt(不要超过2M)</td>
				</tr>
				<tr>
					<td class="listright">活动宣传图片：</td>
					<td colspan="3">
							<div class="thumb">
								<img src="<?php echo $one['imgpath'];?>" style="width:250px;height:150px;" class="imgthumb"/>
							</div>
							<input type="hidden" id="imgpath" name="imgpath" value=""  />
							<input type="button" id="uploadButton2" value="上传活动照片"  />
							<br>格式要求：gif，jpg，png，jpeg(不要超过2M),(250px*150px)
					</td>
				</tr>
				<tr>
					<td></td><td colspan='3'><input type="hidden" name="isSubmit" value="true" />
					<input type="hidden" name="status" class="status" value="1" /><input type="submit" name="doSave" class="btn doSave" value="保存为草稿" />&nbsp;&nbsp;
					<input type="button" name="doSaveAndCommit" class="btn doSaveAndCommit" value="保存并提交" />&nbsp;&nbsp;
					<input type="button" name="doCancel" class="btn doCancel" value="取消" />&nbsp;&nbsp;
					<a href="<?php echo $manage->getBackurl();?>" class="btn" >返回</a>
					</td>
				</tr>
			</table>
			</form>
		</div>
		
		<div class="chooseTeam" >
		<div class="title_close"><img src="templates/images/action_delete.png" class="img_close" /></div>
		<div class="chooseTeamContent">
			<fieldset class="searchTeamSet"  style="width: 95%;">
	    			<legend>查询条件</legend>
					<table class="searchTeamTable">
					<tr><td width="30px" class="listright">名称:</td>
						<td width="80px"><input type="text" name="serviceteamname" class="input length_202 serviceteamname" value="" /></td>
						<td width="80px" class="listright">成立日期:</td>
						<td width="100px"><input type="text" name="foundingtime" class="input length_202 foundingtime" value=""  onclick="WdatePicker()"   readonly="readonly" /></td>
					    <td width="60px" class="listright"></td>
					    <td ></td>
					    <td width="120px"><input type="button" name="doInviteSearch" class="btn doInviteSearch" value="查询"/>&nbsp;&nbsp;<input type="reset"  class="btn chooseTeamRest" value="重置" /></td>
					</tr>
				</table>
			</fieldset>
			<input type="hidden" name="team_total" class="team_total" value="<?php echo $team_total;?>" />
			<input type="hidden" name="team_per" class="team_per" value="<?php echo $team_per;?>" />
			<!--<input type="button" name="doChooseTeam" class="btn doChooseTeam" value="选择" style="margin-top:5px;margin-bottom:10px;" /> -->
			<table class="list-table teamTable table" style="width:95%"  cellspacing="1" cellpadding="2">
			<tr><th width="30px">&nbsp;&nbsp;</th><th class="listcenter" width="80px">名称</th><th width="150px" class="listcenter">成立日期</th><th class="listcenter" width="150px">技能特长</th><th class="listcenter">服务项目</th></tr>
			</table>
			<div id="Pagination" class="pagination"></div>
	    </div>
		</div>

		<!-- 百度地图容器 -->
		<div class="allmap-container" id="allmap-container">
			<div class="allmap-box">
				<div id="allmap"></div>
				<a class="allmap-close-btn" id="allmap-close-btn">X</a>
			</div>
		</div>

		<script>
		function trimValue(objUserName){
			var reg = /^\s*(.*)\s*$/;
			if(reg.test(objUserName)){
				//如果用户输入的内容,开头或结尾带有空格,则将空格去掉
				return  RegExp.$1;
			}else{
				return "";
			}
		}
		</script>
		<script type="text/javascript">

			// 百度地图API功能
			var map = new BMap.Map("allmap");    // 创建Map实例
			map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);  // 初始化地图,设置中心点坐标和地图级别
			//添加地图类型控件
			map.addControl(new BMap.MapTypeControl({
				mapTypes:[
					BMAP_NORMAL_MAP,
					BMAP_HYBRID_MAP
				]}));
			map.setCurrentCity("北京");          // 设置地图显示的城市 此项是必须设置的
			map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
			map.addControl(new BMap.NavigationControl());
			//单击获取点击的经纬度
			map.addEventListener("click", function(e) {
				setPoint(e.point.lng, e.point.lat);
			});

			var icon = new BMap.Icon('http://wx.58haha.cn/1.png', new BMap.Size(20, 32), {
				anchor: new BMap.Size(10, 30)
			});

			// 创建标注
			var pointMarker;
			function setPoint(lng, lat) {
				if ( !pointMarker ) {
					pointMarker = new BMap.Marker(new BMap.Point(lng,lat));
					pointMarker.enableDragging();  //设置可拖拽
					pointMarker.addEventListener("dragend", function(e) {
						setPointValue(e.point.lng, e.point.lat);
					});
					map.addOverlay(pointMarker);
					//跳动的动画
					pointMarker.setAnimation(BMAP_ANIMATION_BOUNCE);
				} else {
					pointMarker.setPosition(new BMap.Point(lng,lat));
				}

				setPointValue(lng, lat);
			}

			function setPointValue(lng, lat) {
				$("#activityPoint").val(lng+","+lat);
			}

			var local = new BMap.LocalSearch(map, {
				renderOptions:{map: map}
			});

			$("#allmap-close-btn").click(function() {
				$("#allmap-container").hide();
			});

			// 打开百度地图

			$("#activityPoint").click(function() {
				if ( $('#large').is(":checked") ) {
					return;
				}
				var cityName = "";
				if ( $("#province").val() ) {
					cityName += trimValue($("#province").children('option:selected').text());
				}
				if ( $("#city").val() ) {
					cityName += trimValue($("#city").children('option:selected').text());
				}
				if ( $('#area').val() ) {
					cityName += trimValue($("#area").children('option:selected').text());
				}

				var address = trimValue($('#activityAddr').val());
				if ( address ) {
					cityName += address;
					local.search(cityName);
					map.setZoom(15);  // 街道缩放级别15
				} else {
					local.clearResults();
					map.setZoom(11); // 城市缩放级别11
					map.setCenter(cityName || "北京");
				}

				$("#allmap-container").show();
			});
		</script>
		<script>
		$(function() {

			$("#province").change(function() {
				var provinceid = $(this).val();

				$.ajax({
					type:'get',
					url:'ajax.php',
					dataType:'json',
					cache: false,
					data:{provinceid:provinceid,act:'provinceid'},
					success:function(msg){
						var re = new RegExp("name=\"city\" id=\"city\"","g");
						var msn = msg.mes.replace(re,"name=activityCity id=city");
						var m = msn.split("|");
						$('#citydiv').html(m[0]);
						$('#areadiv').html(m[1]);
						if ( msg.status ) {
							$('#area').remove();
						}
					}
				});
			});

			$("#city").live('change', city);
			function city() {
				var cityid = $('#city').val();
				$.ajax({
					type:'get',
					url:'ajax.php',
					dataType:'json',
					cache: false,
					data:{cityid:cityid,act:'cityid'},
					success:function(msg) {
						var re = new RegExp("name=\"area\" id=\"area\"","g");
						var msn = msg.mes.replace(re,"name=activityArea id=area");
						$('#areadiv').html(msn);
					}
				});
			}
		});
		</script>
		<script type="text/javascript">

			$("#large").click(function() {
				if ($(this).is(":checked")) {
					$(".large-select").addClass("hidden");
					$("#largeid").val("");

				} else {
					$(".large-select").removeClass("hidden");
				}
			});

			$("#large").change(function() {
				if ($(this).is(":checked")) {
					$("#pca-tr").hide();
					$("#activityPoint").addClass("disable").next("font").hide();
				} else {
					$("#pca-tr").show();
					$("#activityPoint").removeClass("disable").next("font").show();
				}
			});

			$("#largeid").change(function() {
				if ( $(this).children('option:selected').val() ) {
					$(".large-check").addClass("hidden");
					$("#large").removeAttr("checked");
					disableLarge();
				} else {
					$(".large-check").removeClass("hidden");
				}
			});


		  $(document).ready(function(){			  
			  var editor;
			  KindEditor.ready(function(K) {
				  editor = K.create('textarea[name="activityProfile"]', {
					  allowFileManager : false,
					  resizeType:1,
					  items : [
							'source','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
							'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
							'insertunorderedlist', '|', 'emoticons', 'image','link','table'],
					  afterCreate : function(){ 
					              this.sync();   
					       },
					  afterChange: function(){ 
					              this.sync();   
					       },
					   afterBlur : function(){ 
					           this.sync(); 
					       }  						
				  });
				  var uploadbutton = K.uploadbutton({
						button : K('#uploadButton2')[0],
						fieldName : 'imgFile',
						url : 'image_thumb.php?&time='+new Date().getTime(),
						afterUpload : function(data) {
							if (data.error === 0) {
								var url = K.formatUrl(data.url, 'absolute');
								K('#imgpath').val(url);
							    K('.thumb').html('<img src='+url+' style=\"width:250px;height:150px;\"/>&nbsp;&nbsp;(250px*150px)');
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
			  
			  	var d=new Date();
				var ctime=d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds(); 
				if($("#creattime").val()=='') $("#creattime").val(ctime);
				if($("#isShow").val()=='1') $('.hiddenChooseDiv').show();
				$(".butLeft").click(function(){if($('.hiddenChooseDiv').css('display')=='none') $('.hiddenChooseDiv').show();else $('.hiddenChooseDiv').hide();});
				$(".btn_close").click(function(){$('.hiddenChooseDiv').hide();});
				$(".btn_rest").click(function(){
					$(".activityName").removeAttr("value");
					$(".activityAddr").removeAttr("value");
					$(".activityStartDate").removeAttr("value");
					$(".activityEndDate").removeAttr("value");
					$(".activityType_search_option").each(function(){$(this).removeAttr("selected");});
				});
				$(".chooseTeamRest").click(function(){
					$(".serviceteamname").removeAttr("value");
					$(".foundingtime").removeAttr("value");
				});
				$("#servicename").click(function(){$(".chooseTeam").show();});
				$(".img_close").click(function(){$(".chooseTeam").hide();});
				$(".chooseRecord").click(function(){
					$(".chooseRecord").each(function(){$(this).removeAttr("checked");});
					$(this).attr("checked","checked");
				});
				$(".doSaveAndCommit").click(function(){$(".status").val("2");$("#addUserActivity").submit();});
				$(".btn_choose").click(function(){
					var recd=$(".chooseRecord:checked").val();
					$.getJSON("userActivityAdd.php?recd="+recd, function(data){
						 $("#activityName").val(data.activityName);
						 $(".typenos").each(function(){$(this).removeAttr("selected");});
						 $(".typeno_"+data.activityType).attr("selected","selected");
						 $("#activityType").val(data.activityType);
						 $("#activityAddr").val(data.activityAddr);
						 $("#planNum").val(data.planNum);
						 $("#predictHour").val(data.predictHour);
						 $("#activitytime").val(data.activitytime);
						 $("#activityStartDate").val(data.activityStartDate);
						 $("#activityEndDate").val(data.activityEndDate);
						 $("#signUpDeadline").val(data.signUpDeadline);
						 $("#remarks").val(data.remarks);
						 $("#serviceid").val(data.serviceid);
						 $("#servicename").val(data.servicename);
						 $("#actysobjnum").val(data.actysobjnum);
						 $(document.getElementsByTagName('iframe')[0].contentWindow.document.body).html("").append(data.activityProfile);
						 $("#activityProfile").val(data.activityProfile);
						 //$("#activityProfile").html("").append(data.activityProfile);
						 $("#imgpath").val("imageuploads/"+data.imgpath);
						 $(".imgthumb").attr("src",data.imgpath);
							$("#activityPoint").val(data.activityPoint);
					});
					$('.hiddenChooseDiv').hide();
				});
				var team_total=$(".team_total").val();
				var _per_page=$(".team_per").val();
				function pageselectCallback(page_index, jq){
					$.post("userActivityAdd.php", 
							{ doAPage:"true",
						      page_index:page_index,
						      serviceteamname:$(".serviceteamname").val(),
						      foundingtime:$(".foundingtime").val()
						     },function(data){
						    	 var _th=$(".teamTable tr:eq(0)");
									$(".teamTable").empty().append(_th);
									  for(var i=0;i<data.length;i++) {
										  var _html="<tr><td class='listcenter'><input type='radio'  class='chooseTeamRio' value='"+data[i].recordid+"' n='"+data[i].serviceteamname+"'/></td><td class='tda' title='"+data[i].serviceteamname+"'>"+data[i].serviceteamname+"</td><td class='listcenter'>"+data[i].foundingtime+"</td><td class='tda' title='"+data[i].skillnames+"'>"+data[i].skillnames+"</td><td class='tda' title='"+data[i].servicenames+"'>"+data[i].servicenames+"</td></tr>";
										  $(".teamTable").append(_html);
									  }
					},"json");
					return false;
				}
				$("#Pagination").pagination(team_total, {
				    num_edge_entries: 2,
				    num_display_entries: 10,
				    callback: pageselectCallback,
				    items_per_page:_per_page,
				    prev_text: "前一页",
					next_text: "后一页"
				});
				$(".doInviteSearch").click(function(){
					$.post("userActivityAdd.php", 
							{  doInviteSearch:"true",
						       serviceteamname:$(".serviceteamname").val(),
						       foundingtime:$(".foundingtime").val()
						     },function(data){
						    	 team_total=data.team_total;
								 $("#Pagination").pagination(team_total, {
									    num_edge_entries: 2,
									    num_display_entries: 10,
									    callback: pageselectCallback,
									    items_per_page:_per_page,
									    prev_text: "前一页",
										next_text: "后一页"
									});
					},"json");
				});
				var _serviceid=0;
				$(".chooseTeamRio").live("click",function(){
					$(".chooseTeamRio").each(function(){$(this).removeAttr("checked");});
					$(this).attr("checked","checked");
					_serviceid=$(this).val();
					$("#serviceid").val(_serviceid);
					$("#servicename").val($(this).attr('n'));
					$(".chooseTeam").hide();
				});
				$(".doChooseTeam").click(function(){
					     if(_serviceid==0) {
						     alert("请选择一个服务队");
					     }else {
					    	 $("#serviceid").val(_serviceid);
							 $(".chooseTeam").hide();
						 }	
				});

				function DateCompare(d1,d2){
					var date1;   
				    var date2;
					if(d1=="now") date1=new Date();
					else date1=new Date(Date.parse(d1.replace(/-/g,"/")));
					if(d2=="now") date2=new Date();
					else date2=new Date(Date.parse(d2.replace(/-/g,"/"))); 
				    if(date1>date2)  return true;
				    else return false;
				}	
				function getDiffHours(d1,d2){
					var date1=new Date(Date.parse(d1.replace(/-/g,"/")));
					var date2=new Date(Date.parse(d2.replace(/-/g,"/")));
					var hours=Math.round((date2.getTime()-date1.getTime())/(1000*60*60));
					return hours;
				}
				function getLength(s) {
				    var len = 0;
				    var a = s.split("");
				    for (var i=0;i<a.length;i++) {
				        if (a[i].charCodeAt(0)<299) {
					    len++;
					} else {
					    len+=2;
					}
				    }
				    return len;
				}


				$("#activityEndDate").blur(function(){
					if($("#activityStartDate").val()!=0 && $("#activityEndDate").val()!=0) {
						$("#activitytime").val(getDiffHours($("#activityStartDate").val(),$("#activityEndDate").val()));
					}
				});
				$("#activityStartDate").blur(function(){
					if($("#activityStartDate").val()!=0 && $("#activityEndDate").val()!=0) {
						$("#activitytime").val(getDiffHours($("#activityStartDate").val(),$("#activityEndDate").val()));
					}
				});
				$("#addUserActivity").submit(function(){
					var activityName=trimValue($("#activityName").val());
					if( activityName==''  ) {
						ui.error("活动名称不能为空！");
						$("#activityName").focus();
						return false;
					}
					if(getLength($("#activityName").val())> 30) {
						ui.error("活动名称过长！");
						$("#activityName").focus();
						return false;
					}
					if(  $("#activityType").val()=='0') {
						ui.error("活动类型不能为空！");
						$("#activityType").focus();
						return false;
					}

					// 只有普通活动检查
					if ( !$('#large').is(":checked") ) {
						if (!$("#province").val() || !$("#city").val() || !$("#area").val()) {
							ui.error("活动地点不能为空！");
							return false;
						}
					}

					var activityAddr=trimValue($("#activityAddr").val());
					if( activityAddr=='' ) {
						ui.error("活动详情地点不能为空！");
						$("#activityAddr").focus();
						return false;
					}
					if(getLength($("#activityAddr").val())> 30) {
						ui.error("活动地点过长！");
						$("#activityAddr").focus();
						return false;
					}

					// 只有普通活动检查
					if ( !$('#large').is(":checked") ) {
						if (!$("#activityPoint").val()) {
							ui.error("活动地图标注点不能为空！");
							return false;
						}
					}


					if( $("#planNum").val()=='' ) {
						ui.error("计划人数不能为空！");
						$("#planNum").focus();
						return false;
					}
					if( $("#servicename").val()=='' ) {
						ui.error("服务队名称不能为空！");
						$("#servicename").focus();
						return false;
					} 
				   if( $("#actysobjnum").val()=='' ) {
						ui.error("受益人次不能为空！");
						$("#actysobjnum").focus();
						return false;
					} 
				    var pattern= /^\d+$/;		
					if(!pattern.test($("#planNum").val())) {
						ui.error("计划人数必须是整数！");
						$("#planNum").focus();
						return false;
					}
					if( $("#predictHour").val()=='' ) {
						ui.error("预计志愿服务时间不能为空！");
						$("#predictHour").focus();
						return false;
					}
					if(!pattern.test($("#predictHour").val())) {
						ui.error("预计志愿服务时间必须是整数！");
						$("#predictHour").focus();
						return false;
					}
					if(!pattern.test($("#actysobjnum").val())) {
						ui.error("受益人次必须是整数！");
						$("#actysobjnum").focus();
						return false;
					}
					if( $("#activityStartDate").val()=='') {
						ui.error("活动开始时间不能为空！");
						$("#activityStartDate").focus();
						return false;
					}
					if(DateCompare($("#activityStartDate").val(),"now")==false) {
						ui.error("活动开始时间不能小于当前时间！请重新选择");
				        $("#activityStartDate").focus(); 
				        return false;
					}
					if( $("#activityEndDate").val()=='') {
						ui.error("活动结束时间不能为空！");
						$("#activityEndDate").focus();
						return false;
					}
					if(DateCompare($("#activityEndDate").val(),$("#activityStartDate").val())==false) {
						ui.error("活动结束时间不能小于活动开始时间！请重新选择");
				        $("#activityEndDate").focus(); 
				        return false;
					}
					$("#activitytime").val(getDiffHours($("#activityStartDate").val(),$("#activityEndDate").val()));
					if( $("#signUpDeadline").val()=='') {
						ui.error("报名截止时间不能为空！");
						$("#signUpDeadline").focus();
						return false;
					}
					if(DateCompare($("#signUpDeadline").val(),"now")==false) {
						ui.error("报名截止时间时间必须大于当前时间！请重新选择");
				        $("#signUpDeadline").focus(); 
				        return false;
					}
					if(DateCompare($("#activityStartDate").val(),$("#signUpDeadline").val())==false) {
						ui.error("报名截止时间时间不能大于活动开始时间！请重新选择");
				        $("#signUpDeadline").focus(); 
				        return false;
					}

					// 如果存在父级活动,创建子集活动时需要检测活动日期,是否在父级活动日期范围内
					if ( $("#largeid").val() ) {
						// $(this).children('option:selected').val()
						var item, _activityStartDate, _activityEndDate;
						if ( $('#largeid').children().length ) {
							item = $('#largeid').children('option:selected');
						} else {
							item = $('#largeid');
						}

						_activityStartDate = $(item).attr("data-startdate");
						_activityEndDate = $(item).attr("data-enddate");
						if ( _activityStartDate && _activityEndDate ) {
							if ( DateCompare($("#activityStartDate").val(), _activityEndDate) || DateCompare($("#activityStartDate").val(), _activityStartDate) == false ) {
								ui.error("活动开始时间必须在父级活动范围内！请重新选择");
								$("#activityStartDate").focus();
								return false;
							}

							if ( DateCompare($("#activityEndDate").val(), _activityEndDate) || DateCompare($("#activityEndDate").val(), _activityStartDate) == false ) {
								ui.error("活动结束时间必须在父级活动范围内！请重新选择");
								$("#activityEndDate").focus();
								return false;
							}
						}
					}


					if( $("#serviceid").val()=='') {
						ui.error("服务队编号不能为空！");
						$("#serviceid").focus();
						return false;
					}
					var remarks=trimValue($("#remarks").val());
					/*if( remarks=='') {
						ui.error("参加活动要求不能为空！");
						$("#remarks").focus();
						return false;
					}*/
					if(getLength($("#remarks").val())> 300) {
						ui.error("参加活动要求过长！");
						$("#remarks").focus();
						return false;
					}
					if(getLength($("#activityProfile").val())> 5000) {
						ui.error("活动简介过长！");
						$("#activityProfile").focus();
						return false;
					}
					return true;
				});
					
				$(".doCancel").click(function(){
					$("#activityName").val("");
					$("#activityType").val("0");
					$("#activityAddr").val("");
					$("#planNum").val("");
					$("#predictHour").val("");
					$("#activityStartDate").val("");
					$("#activityEndDate").val("");
					$("#activitytime").val("");
					$("#signUpDeadline").val("");
					$("#serviceid").val("");
					$("#remarks").val("");
					//$("#activityProfile").val("");
					editor.html("");
					$(".thumb").children("img").attr("src","");
				});

			});
    </script>
		
		
	</div>

</div>
</div>
</div>


<?php include 'footer.tpl.php'; ?>
</body>
</html>