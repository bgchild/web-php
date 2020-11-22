<?php
include_once('adminBase.php');

/**
 *
 * 灾害-求助模块
 */
class adminSubscribeLists extends adminbase
{
    public function __construct()
    {
        parent::__construct();
    }

    //初始化求助列表
    public function init($query, $limit)
    {
        $q1 = " 1=1";
        if ( ($query && !$query['secity']) || !$query ) {
            $q1 .= " and sign='$_SESSION[sign]'";
        }

        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'name') {
                $q1 .= " and name like '%$val%' ";
                continue;
            }

            if ($key == 'mobile') {
                $q1 .= " and mobile like '%$val%' ";
                continue;
            }

            if ($key == 'secity') {
                $q1 .= " and sign = '$val' ";
            }

        }

        $this->count = $this->db->get_count('form__bjzh_subscribe', $q1);
        return $this->db->getall('form__bjzh_subscribe', $q1, array('limit' => $limit), "*", " order by recordid DESC ");
    }

    //获取求助详情
    public function getInfo($rid)
    {
        $where = " recordid = $rid";
        return $this->db->get_one('form__bjzh_subscribe', $where);
    }

    //获取求助详情
    public function setFlag($rid, $flag)
    {
        $where = " recordid = $rid";
        return $this->db->edit('form__bjzh_subscribe', array('flag' => $flag), $where);
    }

    //删除求助信息
    public function delete($rid)
    {
        return $this->db->drop('form__bjzh_subscribe', array('recordid' => $rid), 'recordid');
    }

    public function getCount()
    {
        return $this->count;
    }

    /**
     * 创建格式化数组
     */
    public function formatData($list) {
        $array = [];
        foreach($list as $k => $v) {
            $array[$k]['name'] = $v['name'];
            if ( $v['sex'] == 1 ) {
                $array[$k]['sex'] = "男";
            } else if( $v['sex'] == 2 )  {
                $array[$k]['sex'] = "女";
            } else {
                $array[$k]['sex'] = "不详";
            }
            $array[$k]['mobile'] = $v['mobile'];
            $array[$k]['add_date'] = $v['add_date'];
            if ( $v['flag'] == 0 ) {
                $array[$k]['flag'] = "否";
            } else if ( $v['flag'] == 1 ) {
                $array[$k]['flag'] = "是";
            } else {
                $array[$k]['flag'] = "不详";
            }
        }

        return $array;
    }

    /**
     * excel头部标题
     */
    function h_array() {
        $h_array = array(
            '姓名', '性别', '手机', '关注时间', '是否责任人	'
        );
        return $h_array;
    }

    /**
     * 导出
     */
    function batch_exp($exp_cfg, $expdata) {
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
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$v);

                        $span++;
                    }
                } else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$k,$value);
                }
                $span++;
            }
            $k++;
        }


        $title = "关注人员管理";
        $name = $title . '.xls';
        if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
            $name = rawurlencode($name);
        }
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle($title);

        // Redirect output to a client’s web browser (Excel5)
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean(); // 输出xls文档之前清理下缓存,以防部分机器上出现乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}

?>