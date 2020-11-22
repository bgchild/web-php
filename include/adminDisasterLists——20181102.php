<?php
include_once('adminBase.php');

/**
 *
 * 灾害-灾情模块
 */
class adminDisasterLists extends adminbase
{
    public function __construct()
    {
        parent::__construct();
    }

    //初始化灾情列表
    public function init($query, $limit)
    {
        $q1 = "a.volunteerid=b.recordid";

        if (($query && !$query['secity']) || !$query) {
            $q1 .= " and a.sign='$_SESSION[sign]'";
        }

        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'dname') {
                $q1 .= " and a.name like '%$val%' ";
                continue;
            }

            if ($key == 'cname' && $val != 0) {
                $q1 .= " and a.cate = $val ";
                continue;
            }

            if ($key == 'address' && $val) {
                $q1 .= " and a.address like '%$val%' ";
                continue;
            }

            if ($key == 'place' && $val) {
                $q1 .= " and a.place like '%$val%' ";
                continue;
            }

            if ($key == 'svictims_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.victims_num >= $val";
                continue;
            }

            if ($key == 'evictims_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.victims_num <= $val";
                continue;
            }

            if ($key == 'sinjured_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.injured_num >= $val";
                continue;
            }

            if ($key == 'einjured_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.injured_num <= $val";
                continue;
            }

            if ($key == 'smissing_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.missing_num >= $val";
                continue;
            }

            if ($key == 'emissing_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.missing_num <= $val";
                continue;
            }

            if ($key == 'sdie_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.die_num >= $val";
                continue;
            }

            if ($key == 'edie_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.die_num <= $val";
                continue;
            }

            if ($key == 'stransfer_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.transfer_num >= $val";
                continue;
            }

            if ($key == 'etransfer_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.transfer_num <= $val";
                continue;
            }

            if ($key == 'sfood_help_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.food_help_num >= $val";
                continue;
            }

            if ($key == 'efood_help_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.food_help_num <= $val";
                continue;
            }

            if ($key == 'sdamage_land' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_land >= $val";
                continue;
            }

            if ($key == 'edamage_land' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_land <= $val";
                continue;
            }

            if ($key == 'sdamage_crops' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_crops >= $val";
                continue;
            }

            if ($key == 'edamage_crops' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_crops <= $val";
                continue;
            }

            if ($key == 'description' && $val) {
                $q1 .= " and a.description like '%$val%' ";
                continue;
            }

            if ($key == 'damage_building' && $val) {
                $q1 .= " and a.damage_building like '%$val%' ";
                continue;
            }

            if ($key == 'sdate' && $val) {
                $val = strtotime($val);
                $q1 .= " and a.addtime >=$val ";
                continue;
            }

            if ($key == 'edate' && $val) {
                $val = strtotime($val);
                $q1 .= " and a.addtime <=$val ";
                continue;
            }

            if ($key == 'status') {
                $q1 .= " and a.status = $val ";
                continue;
            }

            if ($key == 'secity' && $val != 'all') {
                $q1 .= " and a.sign = '$val' ";
            }

            if ($key == 'secity' && $val == 'all') {
                $q1 .= " and a.sign IN ('$query[signs]') ";
            }

        }

        //查询字段，vname上报志愿者名称
        $fields = "a.*,b.name as vname,b.mobile as mobile";

        $this->count = $this->db->get_relations_count('form__bjzh_disaster', 'form__bjzh_subscribe', $q1);

        $list = $this->db->get_relations_info('form__bjzh_disaster', 'form__bjzh_subscribe', $q1, array('limit' => $limit), " order by a.recordid DESC ", $fields);
        return $list;

    }

    //获取灾情种类列表
    public function getAllLists($query)
    {
        $q1 = "a.volunteerid=b.recordid";

        if (($query && !$query['secity']) || !$query) {
            $q1 .= " and a.sign='$_SESSION[sign]'";
        }

        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'dname') {
                $q1 .= " and a.name like '%$val%' ";
                continue;
            }

            if ($key == 'cname' && $val != 0) {
                $q1 .= " and a.cate = $val ";
                continue;
            }

            if ($key == 'address' && $val) {
                $q1 .= " and a.address like '%$val%' ";
                continue;
            }

            if ($key == 'place' && $val) {
                $q1 .= " and a.place like '%$val%' ";
                continue;
            }

            if ($key == 'svictims_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.victims_num >= $val";
                continue;
            }

            if ($key == 'evictims_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.victims_num <= $val";
                continue;
            }

            if ($key == 'sinjured_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.injured_num >= $val";
                continue;
            }

            if ($key == 'einjured_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.injured_num <= $val";
                continue;
            }

            if ($key == 'smissing_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.missing_num >= $val";
                continue;
            }

            if ($key == 'emissing_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.missing_num <= $val";
                continue;
            }

            if ($key == 'sdie_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.die_num >= $val";
                continue;
            }

            if ($key == 'edie_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.die_num <= $val";
                continue;
            }

            if ($key == 'stransfer_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.transfer_num >= $val";
                continue;
            }

            if ($key == 'etransfer_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.transfer_num <= $val";
                continue;
            }

            if ($key == 'sfood_help_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.food_help_num >= $val";
                continue;
            }

            if ($key == 'efood_help_num' && $val) {
                $val = intval($val);
                $q1 .= " and a.food_help_num <= $val";
                continue;
            }

            if ($key == 'sdamage_land' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_land >= $val";
                continue;
            }

            if ($key == 'edamage_land' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_land <= $val";
                continue;
            }

            if ($key == 'sdamage_crops' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_crops >= $val";
                continue;
            }

            if ($key == 'edamage_crops' && $val) {
                $val = intval($val);
                $q1 .= " and a.damage_crops <= $val";
                continue;
            }

            if ($key == 'description' && $val) {
                $q1 .= " and a.description like '%$val%' ";
                continue;
            }

            if ($key == 'damage_building' && $val) {
                $q1 .= " and a.damage_building like '%$val%' ";
                continue;
            }

            if ($key == 'sdate' && $val) {
                $val = strtotime($val);
                $q1 .= " and a.addtime >=$val ";
                continue;
            }

            if ($key == 'edate' && $val) {
                $val = strtotime($val);
                $q1 .= " and a.addtime <=$val ";
                continue;
            }

            if ($key == 'status') {
                $q1 .= " and a.status = $val ";
                continue;
            }

            if ($key == 'secity' && $val != 'all') {
                $q1 .= " and a.sign = '$val' ";
            }

            if ($key == 'secity' && $val == 'all') {
                $q1 .= " and a.sign IN ('$query[signs]') ";
            }

        }

        //查询字段，vname上报志愿者名称
        $fields = "a.*,b.name as vname,b.mobile as mobile";
        $list = $this->db->get_relations_info('form__bjzh_disaster', 'form__bjzh_subscribe', $q1, array(limit => '0,9999999'), " order by a.recordid DESC ", $fields);

        return $list;
    }

    //获取灾情种类列表
    public function getCateLists()
    {
        return $this->db->getall('form__bjzh_disaster_cate');
    }

    //获取灾情详情
    public function getInfo($rid)
    {
        $where = " a.volunteerid=b.recordid and a.recordid = $rid";
        $fields = "a.*,b.name as vname,b.mobile";
        return $this->db->get_relations_one('form__bjzh_disaster', 'form__bjzh_subscribe', $where, $fields);
    }

    //更新灾情详情
    public function update($data, $rid)
    {
        return $this->db->edit('form__bjzh_disaster', $data, array('recordid' => $rid), 'recordid');
    }

    //删除灾情详情
    public function delete($rid)
    {
        return $this->db->drop('form__bjzh_disaster', array('recordid' => $rid), 'recordid');
    }

    public function getCount()
    {
        return $this->count;
    }

    /**
     * 创建格式化数组
     */
    public function formatData($list)
    {
        $array = [];
        foreach ($list as $k => $v) {
            $array[$k]['name'] = $v['name'] ? $v['name'] : '不详';
            $array[$k]['address'] = $v['address'] ? $v['address'] : '不详';
            $array[$k]['cate_name'] = $v['cate_name'] ? $v['cate_name'] : '不详';
            $array[$k]['place'] = $v['place'] ? $v['place'] : '不详';
            $array[$k]['description'] = $v['description'] ? $v['description'] : '不详';
            $array[$k]['victims_num'] = $v['victims_num'] ? $v['victims_num'] : '不详';
            $array[$k]['injured_num'] = $v['injured_num'] ? $v['injured_num'] : '不详';
            $array[$k]['missing_num'] = $v['missing_num'] ? $v['missing_num'] : '不详';
            $array[$k]['die_num'] = $v['die_num'] ? $v['die_num'] : '不详';
            $array[$k]['transfer_num'] = $v['transfer_num'] ? $v['transfer_num'] : '不详';
            $array[$k]['food_help_num'] = $v['food_help_num'] ? $v['food_help_num'] : '不详';
            $array[$k]['damage_land'] = $v['damage_land'] ? $v['damage_land'] : '不详';
            $array[$k]['damage_crops'] = $v['damage_crops'] ? $v['damage_crops'] : '不详';
            $array[$k]['damage_building'] = $v['damage_building'] ? $v['damage_building'] : '不详';
            $array[$k]['vname'] = $v['vname'];
            $array[$k]['mobile'] = $v['mobile'];
            $array[$k]['add_date'] = $v['addtime'] ? date("Y-m-d", $v['addtime']) : '不详';
        }

        return $array;
    }


    /**
     * excel头部标题
     */
    function h_array()
    {
        $h_array = array(
            '灾害名称',
            '灾害地点',
            '灾害种类',
            '事发地点',
            '灾情描述',
            '受灾人数（人）',
            '受伤人数（人）',
            '失踪人数（人）',
            '死亡人数（人）',
            '需紧急转移安置人口（人）',
            '需口粮救济人口（人）',
            '损坏耕地面积（公顷）',
            '农作物/草场受灾面积（公顷）',
            '建筑物损毁情况',
            '上报人',
            '联系方式',
            '上报时间'
        );
        return $h_array;
    }

    /**
     * 导出
     */
    function batch_exp($exp_cfg, $expdata)
    {
        require_once('PHPExcel.php');
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
        foreach ($exp_cfg as $v) {
            $column = chr($key);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . '1', $v);
            $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(20);
            $key += 1;
        }

        $k = 2;
        foreach ($expdata as $row) {
            $span = ord("A");
            foreach ($row as $keyName => $value) {
                $j = chr($span);
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $j = chr($span);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($j . $k, $v);

                        $span++;
                    }
                } else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($j . $k, $value);
                }
                $span++;
            }
            $k++;
        }


        $title = "灾害列表";
        $name = $title . '.xls';
        if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
            $name = rawurlencode($name);
        }
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle($title);

        // Redirect output to a client’s web browser (Excel5)
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean(); // 输出xls文档之前清理下缓存,以防部分机器上出现乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}

?>