<?php
include_once('adminBase.php');
/**
 * 
 * 数据字典管理
 */
class adminDic extends adminbase {
	public function __construct() {
		parent::__construct ();
	
	}


public function pwquestion($act){

$arr=array();	
$conditions = " tcode=$act ";
$list = $this->db->getAll('form__bjhh_dictbl',$conditions,array(limit=>'0,9999999'),'*'," order by listorder ");
$arr['list']=$list;
return $arr;
}	


public function serviceitem(){
$arr=array();
$arrcombine=array();	
$conditions = " tcode='007' and fid='0' ";
$list = $this->db->getAll('form__bjhh_dictbl',$conditions,array(limit=>'0,9999999'),'*'," order by listorder ");
$arr['list']=$list;

$conditions2 = " tcode='007' and fid <>'0' ";
$childlist = $this->db->getAll('form__bjhh_dictbl',$conditions2,array(limit=>'0,9999999'),'*'," order by listorder ");
$arr['childlist']=$childlist;

$i=0;
foreach($list as $v){
	$arrcombine[$i]=$v;
	$i++;
	foreach($childlist as $h){
		if($h[fid]==$v[id]){
			$h[name]='└─'.$h[name];
			$arrcombine[$i]=$h;
			$i++;
		}
	}
}

return $arrcombine;
}








}

?>