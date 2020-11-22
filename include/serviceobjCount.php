<?php
include_once('adminBase.php');
/**
 * 
 * 服务受益对象统计
 */
class serviceobjCount extends adminbase {
	public $a,$b;
	public function __construct() {
		parent::__construct ();
		$this->a="form__bjhh_serviceteammanage_addserviceteam";
	    $this->b="form__bjhh_activityexamine_activityinfo";
	}
	/*public function init($query){
		//判断是有查询条件
		$where="a.agree='2' and a.deltag='0' and (b.status='3' or b.status='4') and a.recordid=b.serviceid";
		if($query){
			$sign=$query['secity'];
			foreach ( $query as $key => $val ) {
				if(!$val) continue;
				$val = trim ( $val );
				if ($key == 'time_start') {
					$val=strtotime($val.'00:00:00');
					$where.=" and a.foundingtime >=$val ";
				}
				if ($key == 'time_stop') {
					$val=strtotime($val.'23:59:59');
					$where.=" and a.foundingtime <=$val ";
				}
				if ($key == 'ctype') {
					$where.=" and  ((a.serviceclassification_checkbox='{$val}') or (a.serviceclassification_checkbox like '{$val},%') or  (serviceclassification_checkbox like '%,{$val}') or (serviceclassification_checkbox like '%,{$val},%'))";
				}
				if ($key == 'team') {
					$where.=" and a.serviceteamname like '%{$val}%' ";
				}
				if($key == 'actcityname'){
					$where.=" and b.activityName like '%{$val}%' ";
				}
			}
	
		}else{
			$city=$this->getCityInfo();
			$sign=$city[sign];
		}
		$area=$this->db->get_one("form__bjhh_area","sign='{$sign}'",'sign,areaid,name');
		$c=array();
		//如果查询下一级
		if(isset($query[lower])){
			$level=$this->getorganization($area[areaid]);
			foreach ($level as $k=>$v){
				$city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$v['sign']}'",array(limit=>'0,9999999'),"order by a.recordid asc",'a.serviceteamname,b.activityName,b.actysobjnum');
				if ($city) $c=$this->formatdata($v['sign'], $v['name'], $city, $c);
				unset($city);
			}
		}else{
			   $city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$area['sign']}' ",array(limit=>'0,9999999'),"order by a.recordid asc",'a.serviceteamname,b.activityName,b.actysobjnum');
			   if ($city) $c=$this->formatdata($area['sign'], $area['name'], $city, $c);
		}

		$counts=$c;
		return $counts;
	}*/


	/**
	 * @language zh_CN
	 * 总会专用
	 */
	public function initClub($query) {
		//判断是有查询条件
		if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
			$where="a.agree='2' and a.deltag='0' and (b.status='3' or b.status='4') and a.recordid=b.serviceid";
		}

		if ( $query['ctype'] == 2 ) {
			$where = "status=4 and deltag=0 and large=0 ";
		}

		//判断是有查询条件
		if( $query ) {

			if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
				foreach ( $query as $key => $val ) {
					if(!$val) continue;
					$val = trim ($val);

					if ($key == 'time_start') {
						$val = strtotime($val.'00:00:00');
						$where .= " and a.foundingtime >=$val ";
					}

					if ($key == 'time_stop') {
						$val = strtotime($val.'23:59:59');
						$where .= " and a.foundingtime <=$val ";
					}
				}
			}

			if ( $query['ctype'] == 2 ) {
				foreach ( $query as $key => $val ) {
					if(!$val) continue;
					$val = trim ($val);

					if ($key == 'time_start') {
						$val = strtotime($val.'00:00:00');
						$where .= " and activitystartdate >=$val ";
					}

					if ($key == 'time_stop') {
						$val = strtotime($val.'23:59:59');
						$where .= " and activityenddate <=$val ";
					}
				}
			}
		}

		$level = $this->getorganization(1);
		array_shift($level);

		$c=array();
		// 获取服务类别
		if ( $query['ctype'] == 2 ) {
			$activitytype = $this->db->getall ("form__bjhh_dictbl", "tcode='008' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		}

		foreach ($level as $k => $v) {
			$signs = [];
			$this->getOrganizationSigns($signs, $v['areaid']);
			$signs = array_unique($signs);
			$string = join("','", $signs);

			if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
				/*$city = $this->db->get_relations_info(
					$this->a,
					$this->b,
					$where." and a.sign IN ('$string')",
					array(limit=>'0,9999999'),"group by b.serviceid order by a.recordid asc",'a.serviceteamname,b.activityName,b.actysobjnum,a.sign,sum(b.actysobjnum) as allactysobjnum'
				);*/

				$city = $this->db->get_relations_info(
					$this->a,
					$this->b,
					$where." and a.sign IN ('$string')",
					array(limit=>'0,9999999'), "order by a.recordid asc",'b.actysobjnum,a.sign,count(DISTINCT a.recordid) as num_team,sum(b.actysobjnum) as allactysobjnum'
				);

				if ( $city ) {
					$c = $this->formatdata($v['sign'], $v['name'], $city, $c);
				}
			}

			if ( $query['ctype'] == 2 ) {
				$sql = "select activitytype,sign,sum(actysobjnum) as allactysobjnum from ".$this->b." where ".$where." and sign IN ('$string') group by activitytype";
				$city = $this->db->query($sql);
				if ( $city ) {
					$c = $this->formatData2($v['sign'], $v['name'], $activitytype, $city, $c);
				}
			}
		}


		if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
			$counts = $c;
		}

		if ( $query['ctype'] == 2 ) {
			$counts = $c;
		}

		return $counts;
	}

	public function init($query) {
		//判断是有查询条件
		if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
			$where="a.agree='2' and a.deltag='0' and (b.status='3' or b.status='4') and a.recordid=b.serviceid";
		}

		if ( $query['ctype'] == 2 ) {
			$where = "status=4 and deltag=0 and large=0 ";
		}

		if ($query) {
			/*$sign = $query['secity'];*/
			if ( $query['secity'] ) {
				if ( $query['secity'] == 'all' ) {
					$sign = $_SESSION['sign'];
				} else {
					$sign = $query['secity'];
				}
			}

			if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
				foreach ( $query as $key => $val ) {
					if(!$val) continue;
					$val = trim ($val);

					if ($key == 'time_start') {
						$val = strtotime($val.'00:00:00');
						$where .= " and a.foundingtime >=$val ";
					}

					if ($key == 'time_stop') {
						$val = strtotime($val.'23:59:59');
						$where .= " and a.foundingtime <=$val ";
					}
				}
			}

			if ( $query['ctype'] == 2 ) {
				foreach ( $query as $key => $val ) {
					if(!$val) continue;
					$val = trim ($val);

					if ($key == 'time_start') {
						$val = strtotime($val.'00:00:00');
						$where .= " and activitystartdate >=$val ";
					}

					if ($key == 'time_stop') {
						$val = strtotime($val.'23:59:59');
						$where .= " and activityenddate <=$val ";
					}
				}
			}


		} else {
			$city=$this->getCityInfo();
			$sign=$city[sign];
		}

		$area = $this->db->get_one("form__bjhh_area","sign='{$sign}'",'sign,areaid,name');
		$c = array();
		$all=array();
		// 获取服务类别
		if ( $query['ctype'] == 2 ) {
			$activitytype = $this->db->getall ("form__bjhh_dictbl", "tcode='008' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		}

		// 如果查询下一级
		if ( isset($query['lower']) ) {
			$level = $this->getorganization($area['areaid']);
			foreach ($level as $k=>$v){
				$this->_init($query, $where, $v, $activitytype, $c, true);
			}
		} else {
			$this->_init($query, $where, $area, $activitytype, $c);
		}


		if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
			$counts = $c;
		}

		if ( $query['ctype'] == 2 ) {
			$counts = $c;
		}

		return $counts;
	}

	private function _init($query, $where, $area, $activitytype, &$c, $lower = false) {
		if ( empty($query['ctype']) || $query['ctype'] == 1 ) {
			//$city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$area['sign']}' ",array(limit=>'0,9999999'),"order by a.recordid asc",'a.serviceteamname,b.activityName,b.actysobjnum');
			/*$city = $this->db->get_relations_info(
				$this->a,
				$this->b,
				$where." and a.sign='{$area['sign']}' ",
				array(limit=>'0,9999999'),"group by b.serviceid order by a.recordid asc",'a.serviceteamname,b.activityName,b.actysobjnum,a.sign,sum(b.actysobjnum) as allactysobjnum'
			);*/
			$city = $this->db->get_relations_info(
				$this->a,
				$this->b,
				$where." and a.sign='{$area['sign']}' ",
				array(limit=>'0,9999999'),"order by a.recordid asc",'b.actysobjnum,a.sign,count(DISTINCT a.recordid) as num_team,sum(b.actysobjnum) as allactysobjnum'
			);

			//$sql = "select serviceteamname,sign,sum(actysobjnum) as allactysobjnum from ".$this->b." where ".$where." and sign='".$area['sign']."' group by serviceid";
			//$city = $this->db->query($sql);
			//var_dump($city);
			if ( $lower || $city ) {
				$c = $this->formatdata($area['sign'], $area['name'], $city, $c);
			}
		}

		if ( $query['ctype'] == 2 ) {
			$sql = "select activitytype,sign,sum(actysobjnum) as allactysobjnum from ".$this->b." where ".$where." and sign='".$area['sign']."' group by activitytype";
			$city = $this->db->query($sql);
			if ( $lower || $city ) {
				$c = $this->formatData2($area['sign'], $area['name'], $activitytype, $city, $c);
			}
		}
	}
	
	/**
	 * 创建格式化数组
	 */
	public function formatdata($sign, $name, $city, $array) {
		/*foreach ( $city as $k => $t ) {
			$array [$sign . $k] ['organ'] = $name;
			$array [$sign . $k] ['team'] = $t ['serviceteamname'];
			$array [$sign . $k] ['num'] = $t ['allactysobjnum'];
		}*/
		foreach ( $city as $k => $t ) {
			$array[$sign]['organ'] = $name;
			if ( $t['num_team'] ) {
				$array[$sign]['num_team'] = $t['num_team'];
			} else {
				$array[$sign]['num_team'] = 0;
			}

			if ( $t['allactysobjnum'] ) {
				$array[$sign] ['num'] = $t['allactysobjnum'];
			} else {
				$array[$sign] ['num'] = 0;
			}

		}
		return $array;
	}

	public function formatData2($sign, $name, $activitytype, $city, $array) {
		if(!($sign && $name)) return false;
		/*foreach ($activitytype as $k => $t){
			$array [$sign . $k] ['organ'] = $name;
			$array [$sign . $k] ['name'] = $t['name'];
			$array [$sign . $k] ['num'] = 0;
		}

		foreach($city as $k => $t) {
			$array [$sign . $k] ['num'] = $t['allactysobjnum'];
		}

		return $array;*/


		$array[$sign]['name'] = $name;
		$array[$sign]['serverItems'] = array();
		foreach($activitytype as $k => $t) {
			$array[$sign]['serverItems'][$k]['num'] = 0;
			$array[$sign]['serverItems'][$k]['name'] = $t['name'];
		}

		foreach($city as $k => $t) {
			$array [$sign]['serverItems'][$k]['num'] = $t['allactysobjnum'];
		}


		//var_dump($city);
		///var_dump($array);
		return $array;
	}

	/**
	 * excel头部标题
	 */
	public function h_array($ctype, $activitytype) {
		if ( $ctype == 2 ) {
			// $h_array = array('组织机构', '服务类别', '受益人次');
			$h_array = array('组织机构');
			foreach($activitytype as $key=>$val) {
				//$h_array[$key] = $val['name'];
				array_push($h_array, $val['name']);
			}
		} else {
			$h_array = array(
				'组织机构',
				//'志愿者服务项目',
				'服务队',
				'受益人次');
		}

		return $h_array;
	}

	/**
	 * 导出
	 */
	/*function batch_exp($expdata){
		$exp_cfg = array (
				'organ' => '组织机构',
				'name' => '志愿者服务项目',
				'team' => '服务队',
				'num'=>'受益人次'
		);
		$firstys = 'organ';
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
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($WordC.$k,$row[$ckey]);
			}
			$k++;
		}
		$name="服务受益对象统计";
		$name=$name . '.xls';
		if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
			$name = rawurlencode($name);
		}
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('服务受益对象统计');
	
		// Redirect output to a client’s web browser (Excel5)
		$objPHPExcel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$name.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}*/

	function batch_exp($exp_cfg, $expdata, $ctype){

		//var_dump($exp_cfg);
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

		//设置表头
		$key = ord("A");
		foreach($exp_cfg as $v) {
			$column = chr($key);
			$objPHPExcel->setActiveSheetIndex(0) ->setCellValue($column.'1', $v);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(20);
			$key += 1;
		}

		$k = 2;
		foreach($expdata as $row) {
			$span = ord("A");
			foreach($row as $keyName => $value) {
				$j = chr($span);
				if ( is_array($value) ) {
					foreach($value as $v) {
						$j = chr($span);
						if ( $ctype != 2 ) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v);
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v['num']);
						}
						$span++;
					}
				} else {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$value);
				}
				$span++;
			}
			$k++;
		}

		$title = "服务受益对象统计";
		$name = $title . '.xls';
		if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
			$name = rawurlencode($name);
		}
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle($title);

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