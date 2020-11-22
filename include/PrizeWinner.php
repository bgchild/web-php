<?php
include_once ( "Xxtea.php");
include (INCLUDE_PATH . "search.php");
include (INCLUDE_PATH . "Volunteers.php");

class PrizeWinner {
    public  $db;
    public $volunteers;
    private $count = 0;

    public function __construct() {
        global $db;
        $this->db=$db;
        $this->volunteers = new Volunteers();
    }

    /**
     * 获取评优志愿者
     */
    public function getUsers($query,$limit) {
        $where="a.winnerid = b.recordid and a.sign='$_SESSION[sign]' and b.status='010' ";
        foreach ($query as $key =>$val){
            $val = trim($val);
            if($key=='prizewinner') {
                $where.=" and a.$key like '%".$val."%' ";
                continue;
            } else {
                $where.=" and a.$key='$val' ";
            }
        }

        $where.=" group by a.winnerid ";
        $a="form__bjhh_superiormanage_addwinner";
        $b = "form__bjhh_volunteermanage_volunteerbasicinfo";
        $this->count=$this->db->get_relations_count($a, $b, $where);
        $list = $this->db->get_relations_info($a, $b, $where, array ('limit' => $limit ), $orders = 'order by a.receivedate DESC', $fields = '*');

        $ids = array();
        foreach ($list as $key=>$val) {
            array_push($ids, $val['winnerid']);
        }
        array_unique($ids);

        // 根据用户ids获取用户信息
        if ( count($ids) ) {
            return $this->volunteers->getVolunteersByIds($ids);
        }
    }

    public function getCount(){
        return $this->count;
    }

    /**
     * 检测rid的用户是否存在有效记录
     */
    public function checkrid($rid) {
        $where="recordid='$rid'";
        $result=$this->db->get_count('form__bjhh_volunteermanage_volunteerbasicinfo', $where);
        if ( $result ) {
            $where2 = "winnerid='$rid'";
            $result2 = $this->db->get_count('form__bjhh_superiormanage_addwinner', $where2);
            if ( $result2 ) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取获奖经历
     */
    public function getPrizeList($rid, $limit) {
        $table = 'form__bjhh_superiormanage_addwinner';
        $where = "winnerid='$rid' ";
        $this->count=$this->db->get_count($table,$where);
        $records = $this->db->getall($table,$where,$limit = array(limit=>$limit), $fields = '*', $orders = 'order by receivedate DESC');
        return $records;
    }

}