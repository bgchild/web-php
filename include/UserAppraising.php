<?php
include_once ("user.php");
/**
 * 队长维护的表彰奖项记录
 */
class UserAppraising extends user {

    public function __construct() {
        parent::__construct ();

    }

    /**
     * 获取奖励列表
     */
    public function getList($query,$limit) {
        $q1 = " 1=1 and sign='$_SESSION[sign]'";
        foreach ( $query as $key => $val ) {
            $val = trim ( $val );
            if ($key == 'receivedate1') {
                $val=strtotime($val);
                $q1.=" and receivedate >=$val ";continue;
            }
            if ($key == 'receivedate2') {
                $val=strtotime($val);
                $q1.=" and receivedate <=$val ";continue;
            }
            if($key == 'prizewinner'){
                $q1 .= " and $key like '%".$val."%' ";
            }
            //$q1 .= " and $key = '$val' ";
        }

        $this->count = $this->db->get_count ( 'form__bjhh_captainmanage_addwinner', $q1 );
        return $this->db->getall('form__bjhh_captainmanage_addwinner',$q1,array ('limit' => $limit ),'*'," order by recordID DESC ");
    }

    public function getCount(){
        return $this->count;
    }

    //隐藏选择人
    public function selectInit($name = '',$guarderidnumb='',$limit = array(limit=>'0,9999999')) {
        $a = 'form__bjhh_serviceteammanage_addserviceteamperson';
        $b = 'form__bjhh_volunteermanage_volunteerbasicinfo';

        $serviceteamcaptainid = $this->getUser(0);
        $sign = $_SESSION['sign'];

        $teamIds = array();
        $list = $this->db->getall( $a, " serviceteamcaptainid='$serviceteamcaptainid' and sp_status=2 ");
        foreach ($list as $val) {
            array_push($teamIds, $val['serviceteamid']);
        }
        $teamIds = array_unique($teamIds);
        if ( $teamIds && count($teamIds) ) {
            $where = "a.serviceteamcaptainid = b.recordid and b.status in ('001','010') and b.sign='{$sign}' and a.serviceteamid IN (". join($teamIds, ",") .") ";
            if ($name) {
                $where .= " and b.name like '%" . $name . "%' ";
            }
            if($guarderidnumb) {
                $where .= " and b.idnumber like '%" . $guarderidnumb . "%' ";
            }

            $where.=" group by a.serviceteamcaptainid ";


            $count = $this->db->get_relations_count($a, $b, $where);
            $list = $this->db->get_relations_info($a, $b, $where, $limit, $orders = 'order by a.joinserviceteamdate DESC', $fields = '*');
            foreach ( $list as $k => $v ) {
                if ($v ['sex'] == '1') {
                    $v ['sex'] = '男';
                } else {
                    $v ['sex'] = '女';
                }
                $v ['birthday'] = date ( 'Y', time () ) - date ( 'Y', $v ['birthday'] );
                //$v ['features'] = $this->strHandle ( $v ['features'] );
                $list [$k] = $v;
            }
        }

        return $list;
    }

    public function init($id){
        $q1 = "";
        if($id) $q1.="recordID=$id";
        return $this->db->get_one('form__bjhh_captainmanage_addwinner',$q1);
    }

    public function editRecord($post){
        foreach($post as $key=>$val) {
            $post[$key]=trim($val);
        }

        $datas=array();
        $datas[prizewinner]=$post[prizewinner];
        $datas[receivedate]=strtotime($post[receivedate]);
        $datas[winaddress]=$post[winaddress];
        $datas[wincontent]=$post[wincontent];

        if($post['rid']) {
            $affected = $this->db->edit('form__bjhh_captainmanage_addwinner', $datas, " recordid=".$post['rid']) ;
            return true;
        } else {
            return false;
        }
    }

    public function addRecord($post,$ids){
        foreach($ids as $k=>$v){
            $datas[$k][receivedate] = strtotime($post[receivedate]);
            $datas[$k][winaddress] = $post[winaddress];
            $datas[$k][wincontent] = $post[wincontent];
            $person = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$v") ;
            $datas[$k][prizewinner] = $person[name];
            $datas[$k][winnerid] = $v;
            $datas[$k][sign] = $_SESSION[sign];
        }

        foreach($datas as $k=>$v){
            $affected=$this->db->add('form__bjhh_captainmanage_addwinner', $v) ;

        }

        return true;
    }

    public function showName($id){
        foreach($id as $k=>$v){
            $person[$k] = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$v");
            $name[$k] = $person[$k][name];
        }
        if($name)return $name;
        else return false;
    }
}