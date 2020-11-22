<?php
include_once ("user.php");
class Download  extends user{ 
	public  $db;

public function __construct() {
		parent::__construct ();
		global $db;
		$this->db=$db;
	}
	public function getActivityTypes($typename='文件类型') {
		return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='".$typename."' and  a.typeCode=b.tCode  and b.state='1' ",  array(limit=>'0,9999999'),' order by b.listorder asc');
	}
	
	public function init($moduleid){
		$conditions=" delTag='0'  ";
		if($moduleid) $conditions.=" and moduleid=$moduleid ";
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
	
	public function getOne($recordid) {
		return $this->db->get_one("form__bjhh_fileupload_addfile"," recordid=$recordid ");
	}
}
 
?>