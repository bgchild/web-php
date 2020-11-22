<?php
include_once('adminBase.php');

/**
 *
 * 联系我们
 */
class zbAdminContact extends adminbase
{

    private $_recordid;

    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        $where = "sign='$_SESSION[sign]'";
        $arr = $this->db->get_one('form__bjhh_zb_contact', $where);
        if (count($arr) > 0) $this->_recordid = $arr['recordid'];
        return $arr;
    }

    public function update($datas, $status = 0)
    {
        $arr = $this->getCityInfo();
        $datas['sign'] = $arr['sign'];
        $datas['status'] = $status;
        foreach ($datas as $k => $v) {
            $datas[$k] = trim($v);
        }
        if ($this->_recordid) $this->db->drop('form__bjhh_zb_contact', " recordid='" . $this->_recordid . "'");
        if ($this->db->add("form__bjhh_zb_contact", $datas)) return true;
        else return false;
    }

    public function aboutinfo()
    {
        $arr = $this->getCityInfo();
        $info = $this->db->get_one("form__bjhh_zb_about", "sign='{$arr['sign']}'", '*');
        if ($info) return $info;
        else return false;
    }

    public function aboutus($con, $status = 0)
    {
        $arr = $this->getCityInfo();
        $datas['con'] = jsformat($con);
        $datas['sign'] = $arr['sign'];
        $datas['status'] = $status;
        $iscz = $this->db->get_one("form__bjhh_zb_about", "sign='{$arr['sign']}'", 'recordid');
        if ($iscz) {
            $affect = $this->db->edit("form__bjhh_zb_about", $datas, "recordid=$iscz[recordid]");
        } else {
            $affect = $this->db->add("form__bjhh_zb_about", $datas);
        }
        if ($affect) return true;
        else return false;
    }

}

?>