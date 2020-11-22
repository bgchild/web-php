<?php

include_once('../global.php');
include_once(INCLUDE_PATH.'adminDic.php');

$act=trim($_POST['act']);
if(!$act) exit();
switch ($act) {
	case 'delete'     : $process = '1';break;
	case 'newchild'   : $tcode = '007'; $process = '2';break;
	case 'edit'	      : $process= '3'; break;
	case 'pwquestion' : $tcode = $_POST['tcode']; $fid = '0'; $process = '0';break;	
	case 'serviceitem': $tcode = '007'; $fid = '0'; $process = '0';break;
}

if($process=='0'){
	$datas['name'] = trim($_POST['name']);
	$datas['state'] = $_POST['status'];
	$datas['tcode'] = $tcode;
	$datas['fid'] = $fid;
	$datas['listorder'] = trim($_POST['listorder']);
	
	//$conditions = 'name = '.$_POST['name'];
	
	$returnid=$db->add('form__bjhh_dictbl', $datas);
	if($returnid) {echo $returnid;}	
	 else {echo 0;}

}elseif ($process=='1'){
	$deleteid = $_POST['deleteid'];
	$conditions = 'id ='.$deleteid;
	$rresult = $db->drop('form__bjhh_dictbl',$conditions);
	if($rresult){echo 'dsucess';}
	  else {echo 0;}
	//set_url($data);
}elseif ($process=='2'){
	
	$data['fid'] = $_POST['addid'];
	$data['tcode'] = $tcode;
	$data['state'] = $_POST['status'];
	$data['name'] = trim($_POST['name']);
	$data['listorder'] = trim($_POST['listorder']);
	
	$returnid=$db->add('form__bjhh_dictbl', $data);
     if($returnid) {echo $returnid;}	
	 else {echo 0;}
}elseif ($process=='3'){
	$editid = $_POST['editid'];
	$data['state'] = $_POST['status'];
	$data['name'] = trim($_POST['name']);
	$data['listorder'] = trim($_POST['listorder']);	
	$conditions = 'id ='.$editid;
	
	if($db->edit('form__bjhh_dictbl', $data ,$conditions)){echo '修改成功';} else echo '0';
}



exit();

?>