<?php
include_once('adminBase.php');

/**
 *
 * 评优管理
 */
class adminAppraisingManage extends adminbase
{
    public function __construct()
    {
        parent::__construct();
    }


    public function init($query, $limit)
    {
        $q1 = " 1=1 and sign='$_SESSION[sign]'";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'receivedate1') {
                $val = strtotime($val);
                $q1 .= " and receivedate >=$val ";
                continue;
            }
            if ($key == 'receivedate2') {
                $val = strtotime($val);
                $q1 .= " and receivedate <=$val ";
                continue;
            }
            if ($key == 'prizewinner') {
                $q1 .= " and $key like '%" . $val . "%' ";
            }
            //$q1 .= " and $key = '$val' ";
        }

        $this->count = $this->db->get_count('form__bjhh_superiormanage_addwinner', $q1);
        return $this->db->getall('form__bjhh_superiormanage_addwinner', $q1, array('limit' => $limit), '*', " order by recordID DESC ");


    }


    public function getCount()
    {
        return $this->count;
    }

}

?>