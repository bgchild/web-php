<?php
include_once ( "Xxtea.php");
class Search  { 
	public $xxtea;
	public  $db;

	public function __construct() {
		global $db;
		$this->db=$db;
		$this->xxtea=new Xxtea();
	}
	
	public function init($keyword=''){
		$conditions="sign = '$_SESSION[sign]'";
		if($keyword) $conditions.=" and title like '%".$keyword."%' ";
		$page   =  _get_page(10);   
		$list = $this->db->getAll('form__bjhh_search',$conditions,array('limit'=>$page['limit']),'*'," order by ctime DESC ");
		$list2=$list;
		foreach($list as $k=>$li) {
			$li['title']=$this->bat_highlight($li['title'],$keyword);
			if($li['type']=='1') {
				//活动
				$one=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid='".$li['fno']."' ");
				if($one['status']==1 || $one['status']==5 || $one['status']==6 || $one['deltag']==1) {
					$none=array_slice( $list , $k , 1 );
					$list2=array_diff($list2,$none);
					continue;
				}
			}else if($li['type']=='2') {
				//服务队
				$one=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteam', " recordid='".$li['fno']."' ");
				if($one['agree']==1 || $one['agree']==3  || $one['deltag']==1) {
					$none=array_slice( $list , $k , 1 );
					$list2=array_diff($list2,$none);
					continue;
				}
			}else if($li['type']=='3') {
				//新闻
			}
			$list2[$k]=$li;
		}
		$page['item_count'] = count($list2); 
		$page = _format_page($page);
		$arr['list']=$list2;
		$arr['page']=$page;
		return $arr;
	}

	public function addInfo($type,$fno) {
		$datas['type']=$type;
		$datas['fno']=$fno;
		$datas['sign']=$this->getCityInfo(sign);
		if(count($this->db->get_one('form__bjhh_search', " fno='$fno' and type='$type'  "))>0) return false;
 		if('1'==$type) {//活动
			$one=$this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=$fno and deltag='0' and status in('3','4') ") ;
			if(count($one)==0) return false;
			$datas['title']="活动：".$one['activityName'];
			$datas['ctime']=$one['creattime'];
			$datas['mark']=$one['activityProfile'];
		}else if('2'==$type) {//服务队
			$one=$this->db->get_one('form__bjhh_serviceteammanage_addserviceteam', " recordid=$fno and deltag='0' and agree='2' ") ;
			if(count($one)==0) return false;
			$datas['title']="服务队：".$one['serviceteamname'];
			$datas['ctime']=$one['foundingtime'];
			$datas['mark']=$one['teamintroduction'];
		}else if('3'==$type) {//新闻
			$one=$this->db->get_one('form__bjhh_news', " recordid=$fno ") ;
			if(count($one)==0) return false;
			$datas['title']="新闻：".$one['title'];
			$datas['ctime']=$one['createTime'];
			$datas['mark']=$one['content'];
		}
		return  $this->db->add('form__bjhh_search',$datas);
	}
	
	public function delInfo($type,$fno) {
		return $this->db->drop('form__bjhh_search', " type=$type and fno=$fno" ) ;
	}
	
	public function updateInfo($type,$fno) {
		$this->delInfo($type,$fno) ;
		$this->addInfo($type,$fno);
	}
	
	private function bat_highlight($message,$words,$color = '#ff0000'){
		if(!empty($words)){
			$highlightarray = explode('+',$words);
			$sppos = strrpos($message,chr(0).chr(0).chr(0));
			if($sppos!==FALSE){
				$specialextra = substr($message,$sppos+3);
				$message = substr($message,0,$sppos);
			}
			$message = preg_replace(array("/(^|>)([^<]+)(?=<|$)/sUe","/<highlight>(.*)<\/highlight>/siU"),array("\$this->highlight('\\2', \$highlightarray, '\\1')","<strong><font color=\"$color\">\\1</font></strong>"),$message);
			if($sppos!==FALSE){
				$message = $message.chr(0).chr(0).chr(0).$specialextra;
			}
		}
		return $message;
	}
	
	private function highlight($text, $words, $prepend) {
		$text = str_replace('\"', '"', $text);
		foreach($words AS $key => $replaceword) {
			$text = str_replace($replaceword, '<highlight>'.$replaceword.'</highlight>', $text);
		}
		return "$prepend$text";
	}
	
	
	/**
	 * 获取当前登录用户 总会/省/市 信息
	 * @return array $arr 例:Array([sign]=>www,[parentid]=>0,[areaid]=>1)
	 */
	public function getCityInfo($i) {
		$useInfo = array ();
		$adminInfo = array ();
		$arr = array ();
		$useInfo = $this->xxtea->parseLoginIdentify ( $_SESSION ['admin_identify'] );
		$adminInfo = $this->db->get_one ( 'form__bjhh_admin', "u_name='{$useInfo[1]}'" );
		$arr ['sign'] = $adminInfo ['sign'];
		return $arr[$i];
	}
	
}
 
?>