<?php

include_once('../global.php');
include_once(INCLUDE_PATH.'adminIndexManage.php');

$act=trim($_POST['act']);
if(!$act) exit();
switch ($act) {
	case 'add_column' : $process = '0';$category=1;break;
	case 'add_columnV' : $process = '0';$category=2;break;	
}
if($process=='0'){
	$datas['name'] = trim($_POST['name']);
	$datas['category'] = $category;
	$returnid=$db->add('form__bjhh_column', $datas);
	$ret[id] = set_url($returnid);
	$ret[rid] = $returnid;
	if($returnid) {echo json_encode ( $ret );}	
	 else {echo 0;}

}
exit();

?>