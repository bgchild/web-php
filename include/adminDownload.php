<?php
include_once('adminBase.php');
/**
 * 
 * 活动上传
 */
class adminDownload extends adminbase {
	public function __construct() {
		parent::__construct ();
	
	}
	
	public function getActivityTypes($typename='文件类型') {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder desc');
	}

	public function init($cond){
		$conditions=" 1=1 and delTag=0";
		if(count($cond)>0) {
			foreach($cond as $key=>$val) $conditions.=" and $key='$val' ";
		}
		$page   =  _get_page(10);   
		$list = $this->db->getAll('form__bjhh_fileupload_addfile',$conditions,array('limit'=>$page['limit']),'*'," order by recordid DESC ");
		$page['item_count'] = $this->db->get_count('form__bjhh_fileupload_addfile',$conditions); 
		$page = _format_page($page);
		$types=$this->getActivityTypes();
		foreach($list as $key=>$val) {
			foreach($types as $k=>$v) {
				if($v['id']==$val['moduleid']) {
					$val['modulename']=$v['name'];
					break;
				}
			}
			$list[$key]=$val;
		}
		$arr['list']=$list;
		$arr['page']=$page;
		return $arr;
	}	
	
	public function insertFileInfo($file){
		return $this->db->add("form__bjhh_fileupload_addfile", $file);
	}


	public function editRecord($datas){
		foreach($datas as $key=>$val) $datas[$key]=trim($val);
		$affected=$this->db->edit('form__bjhh_fileupload_addfile', $datas, " recordid=".$datas['recordid']) ;
		if($affected) return $affected;
		else return false;
	}
	
	
}

?>