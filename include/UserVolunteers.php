<?php
include_once ("user.php");
/**
 * 志愿者管理
 */
class UserVolunteers extends user {

    public function __construct() {
        parent::__construct ();

    }

    /**
     * 获取队长所管理的服务队
     */
    public function getTeams($limit = array(limit=>'0,9999999')) {
        $a = 'form__bjhh_serviceteammanage_addserviceteam';
        $serviceteamcaptainid = $this->getUser(0);

        $where = " serviceteamcaptainid='$serviceteamcaptainid' and agree=2 ";
        $list = $this->db->getall( $a, $where, $limit, $fields = '*', $orders = 'order by recordid DESC');
        return $list;
    }

    /**
     * 获取队长所管理的志愿者
     */
    public function getList($query, $limit) {
        $a = 'form__bjhh_serviceteammanage_addserviceteamperson';
        $b = 'form__bjhh_volunteermanage_volunteerbasicinfo';

        $serviceteamcaptainid = $this->getUser(0);
        $sign = $_SESSION['sign'];

        $where = "a.serviceteamcaptainid = b.recordid and b.status in ('001','010') and b.sign='{$sign}'  ";
        if ( $query ) {
            $serviceteamid = $query['serviceteamid'];
            $name = $query['name'];
        }

        if ( $serviceteamid ) {
            $where .= " and a.serviceteamid='$serviceteamid'";
        } else {
            $teamIds = array();
            $list = $this->db->getall( $a, " serviceteamcaptainid='$serviceteamcaptainid' and sp_status=2 ");
            foreach ($list as $val) {
                array_push($teamIds, $val['serviceteamid']);
            }
            $teamIds = array_unique($teamIds);
        }

        if ( $teamIds && count($teamIds) ) {
            //$where = "a.serviceteamcaptainid = b.recordid and b.status in ('001','010') and b.sign='{$sign['sign']}' and a.serviceteamid IN (". join($teamIds, ",") .") ";
            $where .= " and a.serviceteamid IN (". join($teamIds, ",") .") ";
        }

        if ($name) {
            $where .= " and b.name like '%" . $name . "%' ";
        }

        $where .=" group by a.serviceteamcaptainid ";
        $this->count = $this->db->get_relations_count($a, $b, $where);
        $list = $this->db->get_relations_info($a, $b, $where, array ('limit' => $limit ), $orders = 'order by a.joinserviceteamdate DESC', $fields = '*');
        foreach ( $list as $k => $v ) {
            if ($v ['sex'] == '1') {
                $v ['sex'] = '男';
            } else {
                $v ['sex'] = '女';
            }
            $list [$k] = $v;
        }

        return $list;
    }

    public function getCount(){
        return $this->count;
    }
}