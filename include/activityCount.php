<?php
include_once('adminBase.php');
/**
 * 
 * 志愿服务活动项目统计
 */
class activityCount extends adminbase {
	public $a;
	public function __construct() {
		parent::__construct ();
		$this->a="form__bjhh_activityexamine_activityinfo";
	}

	/**
	 * @language zh_CN
	 * 总会专用
	 */
	public function initClub($query) {
		$where = "1=1 ";

		//判断是有查询条件
		if( $query ) {

			foreach ( $query as $key => $val ) {
				if(!$val) continue;
				$val = trim ( $val );
				if ($key == 'time_start') {
					$val=strtotime($val.'00:00:00');
					$where.=" and creattime >=$val ";
				}
				if ($key == 'time_stop') {
					$val=strtotime($val.'23:59:59');
					$where.=" and creattime <=$val ";
				}
			}
		}


		$level = $this->getorganization(1);
		array_shift($level);

		$c=array();
		$all=array();
		//获取服务类别
		if($query[ctype]==2) {
			$activitytype = $this->db->getall ("form__bjhh_dictbl", "tcode='008' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		}

		foreach ($level as $k => $v) {
			$signs = [];
			$this->getOrganizationSigns($signs, $v['areaid']);
			$signs = array_unique($signs);
			$string = join("','", $signs);

			if( empty($query['ctype']) || ($query['ctype']==1)){
				$city=$this->db->getall($this->a, $where. " and (status='3' or status='4')  and sign IN ('$string')",array(limit=>'0,9999999'),'activitytime');
				$all[$v['sign']] = $city;
				$c=$this->formattime($v['sign'],$v['name'],$c);
			}
			if($query[ctype]==2){
				$city=$this->db->getall($this->a, $where. " and (status='3' or status='4')  and sign IN ('$string')",array(limit=>'0,9999999'),'activityType');
				if($city){
					$all[$v[sign]]=$city;
					$c=$this->formatdata($v['sign'],$v['name'], $activitytype,$c);
				}
			}
		}

		if(empty($query['ctype']) || $query[ctype]==1) $counts=$this->activitytime($all,$c);
		if($query[ctype]==2) $counts=$this->activitytype($all,$c);
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
						$where.=" and creattime >=$val ";
				}
				if ($key == 'time_stop') {
					$val=strtotime($val.'23:59:59');
						$where.=" and creattime <=$val ";
				}
			}
		}else{
			$city=$this->getCityInfo();
			$sign=$city[sign];
		}
		$area=$this->db->get_one("form__bjhh_area","sign='{$sign}'",'sign,areaid,name');
		$c=array();
		$all=array();
		//获取服务类别
		if($query[ctype]==2) {
		$activitytype = $this->db->getall ("form__bjhh_dictbl", "tcode='008' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		}
		
		//如果查询下一级
		if(isset($query['lower'])){
			$level=$this->getorganization($area['areaid']);
			foreach ($level as $k=>$v) {
				if($query['ctype']==1) {
	   				$city = $this->db->getall($this->a, $where. "and (status='3' or status='4')  and sign='{$v[sign]}'",array(limit=>'0,9999999'),'activitytime');

					$c = $this->formattime($v['sign'],$v['name'],$c);
					if($city){
					   $all[$v['sign']] = $city;

				   }
				}

				if($query[ctype]==2) {
	   				$city = $this->db->getall($this->a, $where. "and (status='3' or status='4')  and sign='{$v[sign]}'",array(limit=>'0,9999999'),'activityType');
					$c = $this->formatdata($v['sign'],$v['name'],$activitytype,$c);
					if($city) {
						$all[$v[sign]]=$city;
					}
				}
			}
			
		}else{
		    if( empty($query['ctype']) || ($query['ctype']==1)){
		    $city=$this->db->getall($this->a, $where. "and (status='3' or status='4')  and sign='{$area[sign]}'",array(limit=>'0,9999999'),'activitytime');
	    	$all[$area['sign']]=$city;
	 	    $c=$this->formattime($area['sign'],$area['name'],$c);	
			  }
			if($query[ctype]==2){
			  $city=$this->db->getall($this->a, $where. "and (status='3' or status='4')  and sign='{$area[sign]}'",array(limit=>'0,9999999'),'activityType');
				if($city){
					$all[$area[sign]]=$city;
					$c=$this->formatdata($area['sign'],$area['name'], $activitytype,$c);
				}
			}
		}
		if(empty($query['ctype']) || $query[ctype]==1) $counts=$this->activitytime($all,$c);
		if($query[ctype]==2) $counts=$this->activitytype($all,$c);
		return $counts;
	}
	
	/**
	 * 创建格式化数组
	 */
	public function formatdata($sign,$name,$severtype,$array){
		if(!($sign && $name)) return false;
		/*foreach ($severtype as $t){
			$array[$sign.$t[id]]['organ']=$name;
			$array[$sign.$t[id]]['name']=$t[name];
			$array[$sign.$t[id]]['num']=0;
		}*/



		$array[$sign]['name'] = $name;
		$array[$sign]['serverItems'] = array();
		foreach($severtype as $k => $t) {
			$array[$sign]['serverItems'][$t["id"]]['num'] = 0;
			$array[$sign]['serverItems'][$t["id"]]['name'] = $t['name'];
		}
		return $array;
	}
	/**
	 * 创建时间统计 数组
	 */
	public function formattime($sign,$name,$array){
		if(!($sign && $name)) return false;
		$array[$sign]['organ']=$name;
		$array[$sign]['num']['nm']=0;
		$array[$sign]['num']['sm']=0;
		$array[$sign]['num']['nhy']=0;
		$array[$sign]['num']['shy']=0;
		$array[$sign]['num']['ny']=0;
		$array[$sign]['num']['sy']=0;
		return $array;
	}
	/**
	 * 时间段长度统计
	 */
	public function activitytime($all,$array){
  	if(!($all&&$array)) return false;
  	//print_r($all); die();
	//一个月、半年、一年时长 单位小时
	$month=24*30;
	$hyear=24*183;
	$year=24*365;
	foreach ($all as $ak=>$av){
		foreach($av as $v){
			//一年以上
			if($v['activitytime']-$year>=0) $array["$ak"]['num']['sy']++;
			//半年以上
			if($v['activitytime']-$hyear>=0) $array["$ak"]['num']['shy']++;
			//一个月以上
            if($v['activitytime']-$month>=0) $array["$ak"]['num']['sm']++;
            //一年以内
            if($v['activitytime']-$year<0) $array["$ak"]['num']['ny']++;
            //半年以内
            if($v['activitytime']-$hyear<0) $array["$ak"]['num']['nhy']++;
            //一月以内
            if($v['activitytime']-$month<0) $array["$ak"]['num']['nm']++;
		}	
	}  
	return $array;
	}
	/**
	 * 活动服务项目统计
	 */
 public function activitytype($all,$array){
 	/*if(!($all&&$array)) return false;
	foreach ($all as $ak=>$av){
	foreach($av as $v){
		if(array_key_exists('num',$array[$ak."{$v['activityType']}"])){
			$array[$ak."{$v['activityType']}"][num]++;
		}
	}
		} 
		return $array;*/


	 if(!( $all && $array ) ) return false;
	 foreach ($all as $ak=>$av) {
		 foreach ($av as $v){
			 //var_dump($v);
			 if(array_key_exists('num',$array[$ak]["serverItems"][$v['activityType']])){
				 //$array[$ak."{$v['activityType']}"][num]++;
				 $array[$ak]["serverItems"][$v['activityType']]['num']++;
			 }
		 }
	 }
	 //var_dump($array);
	 return $array;
	}
	
	/**
	 * excel头部标题
	 */
	function h_array($ctype, $activitytype){
	   if($ctype==2){
        //$h_array= array ('组织机构','服务类别','数量');
		   $h_array = array('组织机构');
		   foreach($activitytype as $key=>$val) {
			   array_push($h_array, $val['name']);
		   }
	   }else{
	    $h_array= array ('组织机构','一月以内','一月以上','半年以内','半年以上','一年以内','一年以上');
	   }
	   return $h_array;
	}	
	/**
	 * 导出
	 */
	function batch_exp($exp_cfg,$expdata, $ctype){
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
	//设置表头
     $key = ord("A");
     foreach($exp_cfg as $v){
	   $colum = chr($key);
       $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
       $objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth(20);
	   $key += 1;
     }
	 $k=2;
	 foreach($expdata as $row)
		{
		$span = ord("A");
	 foreach ($row as $keyName=>$value){
		$j = chr($span);
		if(is_array($value)){
	    foreach ($value as $v){
	    	$j = chr($span);
			if ( $ctype != 2 ) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v);
			} else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v['num']);
			}
			$span++;
			}
		}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$value);}
		$span++;
			}
		$k++;
	}
		$name="志愿服务活动项目统计";
		$name=$name . '.xls';
		if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
			$name = rawurlencode($name);
		}
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('志愿服务活动项目统计');
	
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