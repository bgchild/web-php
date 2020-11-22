<?php
include_once('adminBase.php');
/**
 * 
 * 志愿者数统计
 */
class volunteerCount extends adminbase {
	public $a,$b;
	public function __construct() {
		parent::__construct ();
		$this->a="form__bjhh_volunteermanage_volunteerbasicinfo";
		$this->b="form__bjhh_volunteermanage_volunteerextendinfo";
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
					if(($query[ctype]==3) or ($query[ctype]==4)){
						$where.=" and a.applytime >=$val ";
					}else{
						$where.=" and applytime >=$val ";
					}
				}
				if ($key == 'time_stop') {
					$val=strtotime($val.'23:59:59');
					if(($query[ctype]==3) or ($query[ctype]==4)){
						$where.=" and a.applytime <=$val ";
					}else{
						$where.=" and applytime <=$val ";
					}
				}
			}
		}

		$level = $this->getorganization(1);
		array_shift($level);

		$c=array();
		//获取服务类别
		if($query[ctype]==3)$severtype = $this->db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		//学历类型
		if($query[ctype]==4)$edutype = $this->db->getall ("form__bjhh_dictbl", "tcode='005' and state='1' ",array(limit=>'0,9999999'), 'id','order by listorder ASC' );
		foreach ($level as $k => $v) {
			$signs = [];
			$this->getOrganizationSigns($signs, $v['areaid']);
			$signs = array_unique($signs);
			$string = join("','", $signs);

			if( empty($query['ctype']) || $query[ctype]==1){
				$city = $this->db->getall($this->a,$where." and sign IN ('$string')", array(limit=>'0,9999999'),'sex');
				$c = $this->formatsex($v[sign], $v[name],$c);
				if($city){
					$all[$v[sign]]=	$city;
				}
			}

			if($query[ctype]==2){
				$city = $this->db->getall($this->a,$where." and sign IN ('$string')", array(limit=>'0,9999999'),'birthday');
				if($city){
					$all[$v[sign]]=	$city;
					$c=$this->formatage($v[sign], $v[name],$c);
				}
			}

			if($query[ctype]==3){
				$city = $this->db->get_relations_info($this->a, $this->b, $where." and a.sign IN ('$string') and a.recordid=b.rid", array(limit=>'0,9999999'),"",'b.serveitem');
				if($city){
					$all[$v['sign']]=$city;
					$c=$this->formatdata($v[sign], $v[name], $severtype,$c);
				}
			}

			if($query[ctype]==4){
				$city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign IN ('$string') and a.recordid=b.rid", array(limit=>'0,9999999'),"",'b.lasteducation');
				if($city){
					$all[$v[sign]]=$city;
					$c=$this->formatedu($v[sign],$v[name], $edutype,$c);
				}
			}

			if($query[ctype]==5){
				$city=$this->db->getall($this->a,$where." and sign IN ('$string')", array(limit=>'0,9999999'),'allservertime');
				if($city){
					$all[$v[sign]]=	$city;
					$c=$this->formatage($v[sign], $v[name],$c);
				}
			}

			if($query[ctype]==6){
				$city=$this->db->getall($this->a,$where." and sign IN ('$string')", array(limit=>'0,9999999'),'allservertime');
				if($city){
					$all[$v[sign]]=	$city;
					$c=$this->formatsex($v[sign], $v[name],$c);
				}
			}

		}


		if(empty($query['ctype']) || $query[ctype]==1) $counts=$this->sex($all,$c);
		if($query[ctype]==2) $counts=$this->age($all,$c);
		if($query[ctype]==3) $counts=$this->severitem($all,$c);
		if($query[ctype]==4) $counts=$this->education($all,$c);
		if($query[ctype]==5) $counts=$this->stars($all,$c);
		if($query[ctype]==6) $counts=$this->severtime($all,$c);
		return $counts;
	}

public function init($query){
	$where = "1=1";


	//判断是有查询条件
	if( $query ) {
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
       			if(($query[ctype]==3) or ($query[ctype]==4)){
       			$where.=" and a.applytime >=$val ";
       			}else{
       			$where.=" and applytime >=$val ";
       			}
       		}
       		if ($key == 'time_stop') {
       			$val=strtotime($val.'23:59:59');
       			if(($query[ctype]==3) or ($query[ctype]==4)){
       			$where.=" and a.applytime <=$val ";
       			}else{
       			$where.=" and applytime <=$val ";
       			}
       		}
       	}
    } else {
		$city=$this->getCityInfo();
		$sign=$city[sign];
    }

	if ( !empty($sign) ) {
		$area=$this->db->get_one("form__bjhh_area","sign='{$sign}'",'sign,areaid,name');
	}

		$c=array();
		$all=array();
		//获取服务类别
	    if($query[ctype]==3)$severtype = $this->db->getall ("form__bjhh_dictbl", "tcode='007' and state='1' and fid='0' ",array(limit=>'0,9999999'), 'id,name','order by listorder ASC' );
		//学历类型
		if($query[ctype]==4)$edutype = $this->db->getall ("form__bjhh_dictbl", "tcode='005' and state='1' ",array(limit=>'0,9999999'), 'id','order by listorder ASC' );
		//如果查询下一级
	    if(isset($query[lower])){
			$level=$this->getorganization($area[areaid]);

				foreach ($level as $k=>$v){
				    if( empty($query['ctype']) || $query[ctype]==1){
				    	$city=$this->db->getall($this->a,$where." and sign = '{$v[sign]}'", array(limit=>'0,9999999'),'sex');
						//var_dump($city);
						$c=$this->formatsex($v[sign], $v[name],$c);
				    	if($city){
				    		$all[$v[sign]]=	$city;
				    	}
				    }
			        if($query[ctype]==2){
			        	$city=$this->db->getall($this->a,$where." and sign = '{$v[sign]}'", array(limit=>'0,9999999'),'birthday');
						$c=$this->formatage($v[sign], $v[name],$c);
			        	if($city){
			        		$all[$v[sign]]=	$city;
			        	}	
			        }
			        if($query[ctype]==3){
			          $city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$v[sign]}' and a.recordid=b.rid", array(limit=>'0,9999999'),"",'b.serveitem');
						$c=$this->formatdata($v[sign], $v[name], $severtype,$c);
						if($city){
			          	$all[$v[sign]]=$city;
			          }
			 
			        }
			        if($query[ctype]==4){
			        	$city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$v[sign]}' and a.recordid=b.rid", array(limit=>'0,9999999'),"",'b.lasteducation');
						$c=$this->formatedu($v[sign],$v[name],$edutype,$c);
						$all[$v[sign]]=$city;
						/*if($city){

			        	}*/
			        }
			        if($query[ctype]==5){
			        	$city=$this->db->getall($this->a,$where." and sign = '{$v[sign]}'", array(limit=>'0,9999999'),'allservertime');
						$c=$this->formatage($v[sign], $v[name],$c);
				    	if($city){
				    		$all[$v[sign]]=	$city;
				    	}
			        }
			        if($query[ctype]==6){
			        	$city=$this->db->getall($this->a,$where." and sign = '{$v[sign]}'", array(limit=>'0,9999999'),'allservertime');
						$c=$this->formatsex($v[sign], $v[name],$c);
			        	if($city){
			        		$all[$v[sign]]=	$city;
			        	}
			        }
				}
			 }else{
			        if( empty($query['ctype']) || ($query['ctype']==1)){
			        	$city=$this->db->getall($this->a,$where." and sign = '{$area[sign]}'", array(limit=>'0,9999999'),'sex');
			        	if($city){
			        		$all[$area['sign']] = $city;
			        		$c=$this->formatsex($area['sign'], $area['name'],$c);
			        	}
			        }
			      if($query[ctype]==2){
			        	$city=$this->db->getall($this->a,$where." and sign = '{$area[sign]}'", array(limit=>'0,9999999'),'birthday');
			        	if($city){
			        		$all[$area[sign]]=	$city;
			        		$c=$this->formatage($area[sign], $area[name],$c);
			        	}	
			        }
			        if($query['ctype']==3){
			        	$city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$area[sign]}' and a.recordid=b.rid", array(limit=>'0,9999999'),"",'b.serveitem');
			        	if($city){
			        		$all[$area['sign']]=$city;
			        		$c=$this->formatdata($area[sign], $area[name], $severtype,$c);
			        	}
			        }
			        if($query[ctype]==4){
			        	$city=$this->db->get_relations_info($this->a, $this->b, $where." and a.sign='{$area[sign]}' and a.recordid=b.rid", array(limit=>'0,9999999'),"",'b.lasteducation');
			        	if($city){
			        		$all[$area[sign]]=$city;
			        		$c=$this->formatedu($area[sign],$area[name], $edutype,$c);
			        	}
			        }
			        if($query[ctype]==5){
			         $city=$this->db->getall($this->a,$where." and sign = '{$area[sign]}'", array(limit=>'0,9999999'),'allservertime');
			         if($city){
			         	$all[$area[sign]]=	$city;
			         	$c=$this->formatage($area[sign], $area[name],$c);
			         }
			        }
			        if($query[ctype]==6){
			        	$city=$this->db->getall($this->a,$where." and sign = '{$area[sign]}'", array(limit=>'0,9999999'),'allservertime');
			        	if($city){
			        		$all[$area[sign]]=	$city;
			        		$c=$this->formatsex($area[sign], $area[name],$c);
			        	}
			        }  
			}
			if(empty($query['ctype']) || $query[ctype]==1) $counts=$this->sex($all,$c);
			if($query[ctype]==2) $counts=$this->age($all,$c);
			if($query[ctype]==3) $counts=$this->severitem($all,$c);
			if($query[ctype]==4) $counts=$this->education($all,$c);	
			if($query[ctype]==5) $counts=$this->stars($all,$c);
			if($query[ctype]==6) $counts=$this->severtime($all,$c);
		    return $counts; 
	}


	
	/**
	 * 创建格式化数组
	 */
	public function formatdata($sign,$name,$severtype,$array){
		/*foreach ($severtype as $t){
			$array[$sign.$t[id]]['organ']=$name;
			$array[$sign.$t[id]]['name']=$t[name];
			$array[$sign.$t[id]]['num']=0;
		}
		return $array;*/

		$array[$sign]['name'] = $name;
		$array[$sign]['serverItems'] = array();
		foreach($severtype as $t) {
			$array[$sign]['serverItems'][$t['id']]['num'] = 0;
			$array[$sign]['serverItems'][$t['id']]['name'] = $t['name'];
		}


		return $array;
	}
	public  function formatedu($sign,$name,$edutype,$array){
		foreach ($edutype as $t){
			$array[$sign]['organ']=$name;
			$array[$sign][edu][$t[id]]=0;
			//$array[$sign]['edu']['all']=0;
		}
		return $array;
	}
	public  function formatsex($sign,$name,$array){
		$array[$sign]['organ']=$name;
		$array[$sign]['nan']=0;
		$array[$sign]['nv']=0;
		$array[$sign]['all']=0;
		return $array;
	}
	public  function formatage($sign,$name,$array){
		$array[$sign]['organ']=$name;
		$array[$sign]['one']=0;
		$array[$sign]['two']=0;
		$array[$sign]['three']=0;
		$array[$sign]['four']=0;
		$array[$sign]['five']=0;
		$array[$sign]['all']=0;
		return $array;
	}
	/**
	 * 性别统计
	 */
	public function sex($all,$array){
	 	if(!($all&&$array)) return false;
	 	foreach ($all as $ak=>$av){
            $cnum=0;
	 		foreach($av as $v){
	 			if($v[sex]=='1'){
	 			$array[$ak]['nan']++;
	 			}else{
	 			$array[$ak]['nv']++;
	 			}
                $array[$ak]['all']++;
	 		}
	 	}
        return $array;
	}
	/**
	 * 年龄统计
	 */
	public function age($all,$array){
	    if(!($all&&$array)) return false;
		$e=strtotime('-18 year');
		$sf=strtotime('-35 year');
		$sx=strtotime('-60 year');
		$sv=strtotime('-70 year');
		foreach ($all as $ak=>$av){
	 		foreach($av as $v){
	 			if($v['birthday']>$e) $array[$ak]['one']++;
	 			if(($v['birthday']<=$e)&&($v['birthday']>$sf)) $array[$ak]['two']++;
	 			if(($v['birthday']<=$sf)&&($v['birthday']>$sx)) $array[$ak]['three']++;
	 			if(($v['birthday']<=$sx)&&($v['birthday']>$sv)) $array[$ak]['four']++;
	 			if(($v['birthday']<=$sx)&&($v['birthday']<=$sv)) $array[$ak]['five']++;
	 		}
	 		$array[$ak]['all']=$array[$ak]['one']+$array[$ak]['two']+$array[$ak]['three']+$array[$ak]['four']+$array[$ak]['five'];
		}
		return $array;
	}
	
	/**
	 * 服务类别统计
	 */
 public function severitem($all,$array){
 	/*if(!($all&&$array)) return false;
		foreach ($all as $ck=>$te){
			foreach ($te as $v){
				$tz=explode(',',$v[serveitem]);
				foreach ($tz as $t){
					if(array_key_exists("num",$array[$ck.$t])){
						$array[$ck.$t][num]++;
					}
				}
			}
		}
		return $array;*/

	 if(!( $all && $array )) return false;
	 foreach ($all as $ck=>$te) {
		 foreach ($te as $v){
			 if ( isset($v['serveitem']) ) {
				 $tz = explode(',',$v['serveitem']);
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
	 * 学历统计
	 */
	public function education($all,$array){
		if(!($all && $array)) return false;
		//var_dump($all);
		foreach ($all as $ak=>$av){
        	$array[$ak]['edu']['all']=0;
			foreach($av as $v){
				if(array_key_exists("{$v['lasteducation']}",$array[$ak]['edu'])){
					$array[$ak]['edu']['all']++;
					$array[$ak]['edu'][$v['lasteducation']]++;
				}
			}
		} 
		return $array;
	}
	
	/**
	 * 星级统计
	 */
	public function stars($all,$array){
		if(!($all&&$array)) return false;
		foreach ($all as $ak=>$av){
			foreach($av as $v){
             	if(($v['allservertime']>=100) && ($v['allservertime']<300)) $array[$ak]['one']++;
             	if(($v['allservertime']>=300) && ($v['allservertime']<600)) $array[$ak]['two']++;
             	if(($v['allservertime']>=600) && ($v['allservertime']<1000)) $array[$ak]['three']++;
             	if(($v['allservertime']>=1000) && ($v['allservertime']<1500)) $array[$ak]['four']++;
             	if($v['allservertime']>=1500) $array[$ak]['five']++;
             }
		}
		return $array;
	}
	/**
	 * 服务时间统计
	 */
	public function severtime($all,$array){
		if(!($all&&$array)) return false;
		foreach ($all as $ak=>$av){
			foreach($av as $v){
				if($v[allservertime]<20){
					$array[$ak]['nan']++;
				}else{
					$array[$ak]['nv']++;
				}
			}
		}
		return $array;
	}
/**
  * excel头部标题
  */
function h_array($ctype, $severtype){
	 switch ($ctype){
	 	case 1:
	 		$h_array= array ('组织机构','男','女','合计');
	 		break;
	 	case 2:
	 		$h_array= array ( '组织机构', '一月以内','一月以上', '半年以内','半年以上', '一年以内', '一年以上');
	 		break;
	 	case 3:

	 		$h_array= array ('组织机构');
			foreach($severtype as $key=>$val) {
				$h_array[$val['id']] = $val['name'];
			}
	 		break;
	    case 4:
	    	$h_array= array ('组织机构','本科','职高','硕士','研究生','合计');
	    	break;
	    case 5:
	    	$h_array= array ('组织机构','一星','二星', '三星', '四星', '五星');
	    	break;
	    case 6:
	    	$h_array= array ('组织机构','<20小时','>=20小时');
	    	break;
	        default:$h_array= array ('组织机构','男','女','合计');
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
			//var_dump($row);
			foreach ($row as $keyName=>$value){
				$j = chr($span);
				//var_dump($j);
				//var_dump($value);
				if(is_array($value)){
					//var_dump($value);
					foreach ($value as $v){
						$j = chr($span);
						if ( $ctype != 3 ) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v);
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v['num']);
						}

						$span++;
					}
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$value);

				}
				$span++;
			}
			$k++;
		}

		//exit();
		$name="志愿者数统计";
		$name=$name . '.xls';
		if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
			$name = rawurlencode($name);
		}
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('志愿者数统计');
	
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