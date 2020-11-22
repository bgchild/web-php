<?php
include_once('adminBase.php');
/**
 * 
 * 志愿服务队数统计
 */
class serviceteamCount extends adminbase {
	public function __construct() {
		parent::__construct ();
	}

	/**
	 * @language zh_CN
	 * 总会专用
	 */
	public function initClub($query) {
		$where = "1=1";

		//判断是有查询条件
		if( $query ) {

			foreach ( $query as $key => $val ) {
				if(!$val) continue;
				$val = trim ( $val );
				if ($key == 'time_start') {
					$val=strtotime($val.'00:00:00');
					$where.=" and foundingtime >=$val ";
				}
				if ($key == 'time_stop') {
					$val=strtotime($val.'23:59:59');
					$where.=" and foundingtime <=$val ";
				}
			}
		}


		$level = $this->getorganization(1);
		array_shift($level);

		$c=array();
		$team=array();
		$severtype = $this->db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		foreach ($level as $k => $v) {
			$signs = [];
			$this->getOrganizationSigns($signs, $v['areaid']);
			$signs = array_unique($signs);
			$string = join("','", $signs);

			$city=$this->db->getall("form__bjhh_serviceteammanage_addserviceteam", $where." and agree='2' and deltag='0' and sign IN ('$string') ");
			if($city){
				$team[$v[sign]]=$city;
				$c = $this->formatdata($v[sign], $v[name], $severtype,$c);
			}
		}

		$counts=$this->severitem($team,$c);
		return $counts;
	}

public function init($query){
	$where = "1=1 ";
	//判断是有查询条件
       if($query){
       	/*$sign=$query['secity'];*/
	   if ( $query['secity'] ) {
		   if ( $query['secity'] == 'all' ) {
			   $sign = $_SESSION['sign'];
		   } else {
			   $sign = $query['secity'];
		   }
	   }
       	foreach ( $query as $key => $val ) {
       		if(!$val) continue;
       		$val = trim ( $val );
       		if ($key == 'time_start') {
       			$val=strtotime($val.'00:00:00');
       			$where.=" and foundingtime >=$val ";
       		}
       		if ($key == 'time_stop') {
       			$val=strtotime($val.'23:59:59');
       			$where.=" and foundingtime <=$val ";
       		}
       	}

       }else{
       	$city=$this->getCityInfo();
       	$sign=$city[sign];
       }
       $area=$this->db->get_one("form__bjhh_area","sign='{$sign}'",'sign,areaid,name');
	   $c=array();
	   $team=array();
	   //获取服务类别
	   $severtype = $this->db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		//如果查询下一级
		if(isset($query[lower])){
	 		$level=$this->getorganization($area[areaid]);
     		foreach ($level as $v){
				$city=$this->db->getall("form__bjhh_serviceteammanage_addserviceteam", $where. "and agree='2' and deltag='0' and sign='{$v[sign]}'",array(limit=>'0,9999999'),'serviceclassification_checkbox');
		 		$c = $this->formatdata($v[sign], $v[name], $severtype,$c);
		 		if( $city ){
     				$team[$v[sign]] = $city;
				}
			}

			//var_dump($team);
		} else {
	   		$city=$this->db->getall("form__bjhh_serviceteammanage_addserviceteam", $where." and agree='2' and deltag='0' and sign='"."{$area[sign]}'");
			//var_dump($city);
	   		if($city){
		 		$team[$area[sign]]=$city;
	 	 		$c = $this->formatdata($area[sign], $area[name], $severtype,$c);
		   		//var_dump($c);
			}
		}
	    $counts=$this->severitem($team,$c);
		//var_dump($c);
	    return $counts;
	}

	/**
	 * 服务类别统计
	 */
	/*public function severitem($team,$array){
		$this->severitem2($team, $array);
		if(!($team&&$array)) return false;
		foreach ($team as $ck=>$te){
			foreach ($te as $v){
				$tz=explode(',',$v[serviceclassification_checkbox]);
				foreach ($tz as $t){
					if(array_key_exists("num",$array[$ck.$t])){
						$array[$ck.$t][num]++;
					}
				}
			}
		}
	  return $array;
	}*/

	public function severitem($team,$array) {
		if(!( $team && $array )) return false;
		foreach ($team as $ck=>$te) {
			foreach ($te as $v){
				if ( isset($v['serviceclassification_checkbox']) ) {
					$tz = explode(',',$v['serviceclassification_checkbox']);
					foreach ($tz as $t){
						if(array_key_exists("num",$array[$ck]["serverItems"][$t]) && !empty($t)){
							$array[$ck]["serverItems"][$t]["num"]++;
						}
					}
				}

			}
		}

		return $array;
	}

/**
 * 创建格式化数组
 */
public function formatdata($sign,$name,$severtype,$array){
		/*var_dump($sign);
	var_dump($name);
	var_dump($array);*/


		/*foreach ($severtype as $t){
			$array[$sign.$t[id]]['num']=0;
			$array[$sign.$t[id]]['name']=$t[name];
			$array[$sign.$t[id]]['organ']=$name;
		}*/



	$array[$sign]['name'] = $name;
	$array[$sign]['serverItems'] = array();
	foreach($severtype as $t) {
		$array[$sign]['serverItems'][$t['id']]['num'] = 0;
		$array[$sign]['serverItems'][$t['id']]['name'] = $t['name'];
	}


	    return $array;
}
/**
 * 导出
 */
function batch_exp($expdata, $severtype){
	//var_dump($expdata);
	$exp_cfg = array (
			'organ' => '组织机构'
	);

	foreach($severtype as $key=>$val) {
		$exp_cfg[$val['id']] = $val['name'];
	}

	$firstys = 'organ';
	//exit();
	require_once ('PHPExcel.php');
	$objPHPExcel = new PHPExcel();
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");
	// Add some data
	$Word = 'A';
	foreach ($exp_cfg as $key=>$v){
		if($key != $firstys ){
			$Word = ++$Word;
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($Word.'1',$v);
		$objPHPExcel->getActiveSheet()->getColumnDimension($Word)->setWidth(20);
	}
	$k=2;
 	foreach($expdata as $row)
	{
		$WordC = 'A';
		foreach ($exp_cfg as $ckey=>$cv){
			if($ckey != $firstys ){
				$WordC = ++$WordC;
			}
			if ( $ckey == $firstys ) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($WordC.$k,$row['name']);
			} else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($WordC.$k,$row["serverItems"][$ckey]['num']);
			}

		}
		$k++;
	} 
	$name="志愿服务队数统计导出";
	$name=$name . '.xls';
	if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
		$name = rawurlencode($name);
	}
	// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle('志愿服务队数统计');
		
	// Redirect output to a client’s web browser (Excel5)
	$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$name.'"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}      
}

?>