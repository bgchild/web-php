<?php
include_once ("user.php");
/**
 * 我管理的服务团队
 */
class UserServiceTeam extends user {

    //默认省、市、区 parentid和地区表
    public $de_province_pid = '000001';
    public $de_city_pid = '000100010001';
    public $de_area_pid = '0001000100010001';
    public $cityTable = 'pubmodule_area_tbl';

    public function __construct() {
        parent::__construct ();

    }

    public function getMyTeams($gets) {
        $arr = array ();
        $serviceteamcaptainid = $this->getUser(0);
        $conditions = " delTag='0' and agree='2' and sign='$_SESSION[sign]' and serviceteamcaptainid='$serviceteamcaptainid' ";
        foreach ( $gets as $k => $v ) {
            if ($k == 'serviceteamname') {
                if ($v) {
                    $conditions .= " and $k like '%" . $v . "%' ";
                }
                continue;
            }
            if ($k == 'foundingtime_start') {
                if ($v) {
                    $v2 = strtotime ( $v . '00:00:00' );
                    $conditions .= ' and foundingtime>=' . $v2;
                }
                continue;
            }
            if ($k == 'foundingtime_stop') {
                if ($v) {
                    $v2 = strtotime ( $v . '23:59:59' );
                    $conditions .= ' and foundingtime<=' . $v2;
                }
                continue;
            }
            if ($k == 'stype') {
                foreach ( $v as $key => $val ) {
                    $conditions .= " and serviceclassification_checkbox like '%" . $val . "%'";
                }
                continue;
            }
        }
        $page = _get_page ( 10 ); //获取分页信息
        $orders = ' order by foundingtime DESC ';

        $page ['item_count'] = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteam', $conditions );
        $list = $this->db->getAll ( 'form__bjhh_serviceteammanage_addserviceteam', $conditions, array ('limit' => $page ['limit'] ), '*', $orders );
        foreach ( $list as $k => $v ) {
            $q = 'sp_status=2 and serviceteamid=' . $v ['recordid'];
            $passNum = $this->db->get_count ( 'form__bjhh_serviceteammanage_addserviceteamperson', $q );
            $q2 = " recordid='{$v['serviceteamcaptainid']}'";
            $arr2 = $this->db->get_one ( 'form__bjhh_volunteermanage_volunteerbasicinfo', $q2 );
            $list [$k] ['captainName'] = $arr2 ['name'];
            $list [$k] ['audittime'] = date ( 'Y-m-d', $v ['foundingtime'] );
            $list [$k] ['auditpasstime'] = date ( 'Y-m-d', $v ['auditpasstime'] );
            $list [$k] ['skill'] = $this->strHandle ( $v ['serviceclassification_checkbox'] );
            $list [$k] ['passNum'] = $passNum;
            unset($passNum);
            unset($arr2);
        }
        $page = _format_page ( $page );
        $arr ['list'] = $list;
        $arr ['page'] = $page;
        return $arr;
    }

    public function getServictTeamType($table, $tcode) {
        $checkbox = $this->db->getall ( $table, "fid=0 and tcode=$tcode" );
        return $checkbox;
    }

    public function defaultCityArray($cityName) {
        $arr = $this->db->getall ( $this->cityTable, 'parentid=' . $this->{de_ . $cityName . _pid} );
        return $arr;
    }

    public function checkboxArray($tableName, $tcode) {
        $checkbox = $this->db->getall ( $tableName, "fid=0 and tcode=$tcode" );

        foreach ( $checkbox as $k => $v ) {
            $cid = $v ['id'];
            $checkbox_list = $this->db->getall ( $tableName, "fid=$cid" );
            $checkbox [$k] ['child'] = $checkbox_list;
        }

        return $checkbox;

    }

    public function detail($id) {
        $where = "recordid='$id'";
        $info = $this->db->get_one ( "form__bjhh_serviceteammanage_addserviceteam", $where );
        $info ['foundingtime'] = date ( 'Y-m-d H:i:s', $info ['foundingtime'] );
        $info ['serviceclassification_checkbox'] = explode ( ',', $info ['serviceclassification_checkbox'] );
        $info ['skills_checkbox'] = explode ( ',', $info ['skills_checkbox'] );
        $info ['service_thumb'] = $info ['service_thumb'];
        return $info;
    }

    public function OneCityArray($cid) {
        $arr = $this->db->getall ( 'pubmodule_area_tbl', "parentId=$cid" );
        return $arr;
    }

    /**
     * 服务队添加
     * @param array $post
     */
    public function serviceTeamEdit($post) {
        foreach ( $post as $k => $v ) {
            if (is_array ( $v )) {
                foreach ( $v as $child_k => $child_v ) {
                    $v [$child_k] = trim ( $child_v );
                }
                $post [$k] = $v;
            } else {
                $post [$k] = trim ( $v );
            }
        }
        $datas = array ();
        $datas ['serviceteamname'] = $post ['ser_tname'];
        $datas ['province'] = $post ['province'];
        $datas ['city'] = $post ['city'];
        $datas ['areas'] = $post ['area'];
        $datas ['foundingtime'] = strtotime ( $post ['foundingtime'] );
        $datas ['relationperson'] = $post ['linkman'];
        $datas ['responsibleperson'] = $post ['principal'];
        $datas ['emails'] = $post ['emails'];
        $datas ['detailed_address'] = $post ['detailed_address'];
        $datas ['postcodes'] = $post ['postcodes'];
        $datas ['planmembernumber'] = $post ['plan_num'];
        $datas ['telephones'] = $post ['telephones'];
        $datas ['sign'] =$_SESSION[sign];
        $datas ['parentid'] =$_SESSION[fid];
        if ($post ['thumb_url']) {
            $datas ['service_thumb'] = $post ['thumb_url'];
        } else {
            $datas ['service_thumb'] = '../templates/images/No_photo.jpg';
        }
        $datas ['serviceclassification_checkbox'] = implode ( ',', $post ['stype'] );
        $datas ['skills_checkbox'] = implode ( ',', $post ['skills'] );
        $datas ['others'] = $post ['others'];
        $datas ['teamintroduction'] = $post ['ser_intro'];
        $datas ['edittime'] = strtotime ( $post ['foundingtime'] );
        $datas ['fax'] = $post ['fax'];
        $datas ['mobile_telephone'] = $post ['mobile_telephone'];

        $rid = $post ['editid'];
        $where = " recordid='$rid' ";
        $datas ['edittime'] = time ();
        $affected = $this->db->edit ( 'form__bjhh_serviceteammanage_addserviceteam', $datas, $where );
        //写入操作日志
        $arr=array();
        $arr[module]='5';
        $arr[type]='53';
        $arr[name]=$datas[serviceteamname];
        $this->doLog($arr);
        return $affected;
    }


    public function serviceGetOne($rid) {
        $arr = $this->db->get_one ( 'form__bjhh_serviceteammanage_addserviceteam', "recordid=$rid" );
        $arr ['foundingtime'] = date ( 'Y-m-d H:i:s', $arr ['foundingtime'] );
        $arr ['serviceclassification_checkbox'] = explode ( ',', $arr ['serviceclassification_checkbox'] );
        $arr ['skills_checkbox'] = explode ( ',', $arr ['skills_checkbox'] );
        return $arr;
    }


    public function filterChars($datas) {
        foreach ( $datas as $k => $v ) {
            if (is_array ( $v )) {
                foreach ( $v as $child_k => $child_v ) {
                    $v [$child_k] = trim ( $child_v );
                }
                $datas [$k] = $v;
            } else {
                $datas [$k] = trim ( $v );
            }
        }
        return $datas;
    }

    /**
     *
     * 字符串处理
     */
    public function strHandle($str) {
        if ($str) {
            if (! strpos ( $str, ',' )) {
                $arr = $this->db->get_one ( 'form__bjhh_dictbl', "id=$str" );
                $res = $arr ['name'];
            } else {
                $arr = explode ( ',', $str );
                foreach ( $arr as $k => $v ) {
                    $arr = $this->db->get_one ( 'form__bjhh_dictbl', "id=$v" );
                    $val .= $arr ['name'] . ' ';
                }
                $res = rtrim ( $val, ' ' );
            }
            return $res;
        } else {
            return '';
        }
    }

    /**
     *
     * 获得返回地址
     * @param  $url 如果没有$_SERVER['HTTP_REFERER']就返回$url;
     */
    public function getBackUrl($url) {
        return $_SERVER ['HTTP_REFERER'] ? $_SERVER ['HTTP_REFERER'] : $url;
    }


    /**
     * 服务队展示图片入库
     * @param array $post  入库数据(图片名、路径)
     * @param string $sid 对应服务队主键
     * @return bool $res 返回布尔结果
     */
    public function serTeamPicAdd($post, $sid) {
        //变量初始化
        $data = array ();
        $res = null;

        //去除图片名有可能出现的空格
        $post ['img_name'] = trim ( $post ['img_name'] );

        $data ['img_name'] = $post ['img_name'];
        $data ['img_url'] = substr ( $post ['thumb_url'], 3 );
        $data ['serverid'] = $sid;

        //入库
        $res = $this->db->add ( 'form__bjhh_serviceteampicture', $data );
        return $res;
    }

    /**
     * 服务队图片表信息获取
     * @param  string $sid 服务队主键
     * @return boolean|array 返回布尔值或全部数组信息
     */
    public function getSTPInfo($sid) {
        //变量初始化
        $order = null;

        //判断是否传参
        if (! $sid) {
            return false;
        }

        //照排序字段排序
        $orders = ' order by img_order asc';
        return $this->db->getall ( 'form__bjhh_serviceteampicture', " serverid='$sid' ", array (limit => '0,9999999' ), '*', $orders );

    }

    /**
     * 图片删除
     * @param string $drop_id 图片表主键
     * @return boolean true|fales
     */
    public function deletePic($drop_id) {

        //验证传参
        if (! $drop_id) {
            return false;
        }

        return $this->db->drop ( 'form__bjhh_serviceteampicture', " recordid=$drop_id " );

    }

    /**
     * 图片排序
     * @param array $ord 排序字段数组
     * @param array $rid 主键数组
     * @return boolean true|false
     */
    public function serTpOrder($ord, $rid) {
        //变量初始化
        $status = false;
        $merge = array ();
        $datas = array ();
        $where = '';
        $affset = null;

        //验证参数
        if (! ($ord && $rid)) {
            return false;
        }

        //合并数组
        $merge = array_combine ( $rid, $ord );

        //数组遍历修改
        foreach ( $merge as $k => $v ) {
            $datas ['img_order'] = $v;
            $where = " recordid=$k ";
            $affset = $this->db->edit ( 'form__bjhh_serviceteampicture', $datas, $where );
            if ($affset)
                $status = true;
        }

        return $status;
    }
}