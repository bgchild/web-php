<?php
include_once("Xxtea.php");
include_once(INCLUDE_PATH . "search.php");

/**
 *
 * 服务队页面serveteam.php
 */
class Serveteam
{
    public $db;
    public $xxtea;
    private $count = 0;
    private $search;

    public function __construct()
    {
        global $db;
        $this->db = $db;
        $this->xxtea = new Xxtea();
        $this->search = new Search();
    }

    /**
     *
     * 加入服务队
     */
    public function addTeam($data)
    {
        foreach ($data as $key => $val) {
            $data[$key] = $val;
        }
        $datas['serviceteamid'] = $data['rid'];
        $serviceteamcaptainid = $this->getUser('0');
        $datas['serviceteamcaptainid'] = $serviceteamcaptainid;
        $datas['joinserviceteamdate'] = time();
        $table = "form__bjhh_serviceteammanage_addserviceteamperson";
        $volunteer = $this->getUser('0');
        $where = "serviceteamcaptainid='$volunteer' and serviceteamid='$data[rid]' ";
        $ist = $this->db->get_one($table, $where);
        if ($ist) {
            $datas['sp_status'] = '1';
            $affected = $this->db->edit($table, $datas, $where);
        } else {
            $affected = $this->db->add($table, $datas);
        }
        return $affected;
    }

    /**
     * 获取审核通过的服务队
     */
    function getTeam($query, $limit)
    {
        $where = "agree='2' and deltag='0' and sign='$_SESSION[sign]'";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'serviceteamname' || $key == 'teamintroduction') {
                $where .= " and $key like '%" . $val . "%' ";
                continue;
            }
            $where .= " and $key='$val' ";
        }
        $a = "form__bjhh_serviceteammanage_addserviceteam";
        $this->count = $this->db->get_count($a, $where);
        $team = $this->db->getall($a, $where, $limit = array(limit => $limit), $fields = '*', $orders = 'order by foundingtime DESC');
        //格式化个人服务信息
        foreach ($team as $key => $val) {
            $val['people'] = $this->countPeople($val['recordid']);
            $val['areas'] = $this->getAreas($val['areas']);
            $val['serveritem'] = $this->getTypesName($val['serviceclassification_checkbox'], 2);
            $val['skillitem'] = $this->getTypesName($val['skills_checkbox'], 2);
            $team[$key] = $val;
        }
        return $team;
    }


    function getTeamAjax($query, $limit, $sign = "")
    {
        $where = "agree='2' and deltag='0' ";

        if (!$query['serviceteamname']) {
            if (!$this->checkUserLogin()) {
                $where .= " and sign='$sign' ";
            } else {
                $_sign = $this->getUser('sign');
                $where .= " and sign='$_sign' ";
            }
        } else {
            $signs = [$sign];
            if ($this->checkUserLogin()) {
                array_push($signs, $this->getUser('sign'));
            }
            $signs = array_unique(array_filter($signs));
            $where .= " and sign IN ('" . join(",", $signs) . "')";
        }


        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'serviceteamname' || $key == 'teamintroduction') {
                $where .= " and $key like '%" . $val . "%' ";
                continue;
            }
            $where .= " and $key='$val' ";
        }
        $a = "form__bjhh_serviceteammanage_addserviceteam";
        $this->count = $this->db->get_count($a, $where);
        $team = $this->db->getall($a, $where, $limit = array(limit => $limit), $fields = '*', $orders = 'order by foundingtime DESC');
        //格式化个人服务信息
        foreach ($team as $key => $val) {
            $val['people'] = $this->countPeople($val['recordid']);
            $val['areas'] = $this->getAreas($val['areas']);
            $val['serveritem'] = $this->getTypesName($val['serviceclassification_checkbox'], 2);
            $val['skillitem'] = $this->getTypesName($val['skills_checkbox'], 2);
            $team[$key] = $val;
        }
        return $team;
    }

    /**
     * 服务项目和服务技能字串处理
     */
    public function getTypesName($str, $num)
    {
        if (!$str) return false;
        if (!strpos($str, ',')) {
            $where = "id=$str and fid='0' ";
            $types = $this->db->get_one('form__bjhh_dictbl', $where);
            $res = $types['name'];
        } else {
            $types = explode(',', $str, $num);
            foreach ($types as $val) {
                $where = "fid='0' and id='$val' ";
                $types = $this->db->get_one('form__bjhh_dictbl', $where);
                if ($types['name']) $name .= $types['name'] . "、";
            }
            $res = substr($name, 0, -3);

        }
        return $res;
    }

    /**
     * 地区
     *
     */
    public function getAreas($str)
    {
        if (!$str) return false;
        $where = "areaId='$str'";
        $arr = $this->db->get_one('pubmodule_area_tbl', $where);
        return $arr['areaName'];
    }

    public function getTeamCount()
    {
        return $this->count;
    }

    /**
     * 统计服务队人数并判断有没满员
     */
    public function countPeople($recordid, $planNum)
    {
        $table = "form__bjhh_serviceteammanage_addserviceteamperson";
        $people = $this->db->get_count($table, "serviceteamid='$recordid' and sp_status='2'");
        if (!$planNum) {
            return $people;
        }
        if ($planNum) {
            if ($people >= $planNum) return $people;
            else return false;
        }
    }

    /**
     * 判断有没重复加入
     */
    public function isRepeat($recordid)
    {
        $table = "form__bjhh_serviceteammanage_addserviceteamperson";
        $volunteer = $this->getUser('0');
        $where = "serviceteamcaptainid='$volunteer' and serviceteamid='$recordid' and sp_status!='3'";
        $repeat = $this->db->get_one($table, $where);
        if ($repeat) return true;
        else return false;
    }

    /**
     *
     * 加入活动
     */
    public function addActivity($data)
    {
        foreach ($data as $key => $val) {
            $data[$key] = $val;
        }
        $datas['uid'] = $data['rid'];
        $name = $this->getUser('1');
        $datas['name'] = $name;
        $datas['addDate'] = mktime();
        $affected = $this->db->add('form__bjhh_activity_personadd', $datas);
        if ($affected) {
            $this->search->addInfo('1', $affected);
            return $affected;
        } else return false;
    }

    /**
     *
     * 检查登入否
     */
    public function checkUserLogin()
    {
        if (isset($_SESSION['code'])) {
            $arg = $this->xxtea->parseLoginIdentify($_SESSION['code']);
            if (isset($arg[0]) && isset($arg[1]) && isset($arg[2])) return true;
            else return false;
        } else return false;
    }

    /**
     * 是否属于会员注册地区
     */
    public function checkSign()
    {
        $sign = $this->getUser('sign');
        if ($sign == $_SESSION['sign']) return true;
        else return false;
    }

    /**
     * 是否属于会员注册地区
     */
    public function checkSignAjax($rid = 0)
    {
        $sign = $this->getUser('sign');
        $table = 'form__bjhh_serviceteammanage_addserviceteam';
        $where = "recordid='$rid' ";
        $info = $this->db->get_one($table, $where);
        if ($sign == $info['sign']) return true;
        else return false;
    }

    /**
     * 检查权限
     */
    public function checkPower()
    {
        $rid = $this->getUser('0');
        $table = "form__bjhh_volunteermanage_volunteerbasicinfo";
        $arr = $this->db->get_one($table, "recordid='$rid'");
        if ($arr['status'] != '001' && $arr['status'] != '010') return true;
        else return false;
    }

    /**
     * 获取登入信息
     */
    public function getUser($i)
    {
        $userArr = array();
        $arg = $this->xxtea->parseLoginIdentify($_SESSION['code']);
        $userArr = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$arg[0]");
        $arg['sign'] = $userArr['sign'];
        $arg['parentid'] = $userArr['parentid'];
        return $arg[$i];
    }

    /**
     * 判断数据库是否存在传过来的$rid
     */
    public function checkrid($rid)
    {
        $where = "recordid='$rid'";
        $result = $this->db->get_count('form__bjhh_serviceteammanage_addserviceteam', $where);
        if ($result) return true;
        else return false;
    }

    /**
     * 获取一条详细记录
     */
    public function getDetailServeteam($rid)
    {
        $a = 'form__bjhh_serviceteammanage_addserviceteam';
        $where = "recordid='$rid' ";
        $records = $this->db->get_one($a, $where);
        if (!$records) return $records;
        //格式化服务队信息
        $records['member'] = $this->countPeople($rid);
        $records['areas'] = $this->getAreas($records['areas']);
        $records['foundingtime'] = date("Y-m-d G:i:s", $records['foundingtime']);
        $records['serveitem'] = $this->getTypesName($records['serviceclassification_checkbox'], 30);
        $records['skillitem'] = $this->getTypesName($records['skills_checkbox'], 30);
        return $records;
    }

    /**
     * 获取服务队图片
     */
    public function getTeamPcitures($rid)
    {
        if (!$rid) return false;
        $a = 'form__bjhh_serviceteampicture';
        $where = "serverid=$rid";
        $orders = " order by img_order ASC";
        $res = $this->db->getall($a, $where, $limit = array(limit => '0,9999999'), $fields = '*', $orders);
        if ($res) return $res;
    }

    /**
     * 获取过往活动
     */
    public function getServeteamActivity($rid, $limit)
    {
        $table = 'form__bjhh_activityexamine_activityinfo';
        $where = "serviceid='$rid' and status='3' and deltag='0' ";
        $this->count = $this->db->get_count($table, $where);
        $records = $this->db->getall($table, $where, $limit = array(limit => $limit), $fields = '*', $orders = 'order by creattime DESC');
        $type = $this->getActivityTypes();
        //格式化活动信息
        foreach ($records as $key => $val) {
            foreach ($type as $k => $v) {
                if ($v['id'] == $val['activityType']) {
                    $val['typename'] = $v['name'];
                    break;
                }
            }
            //统计报名人数
            $applicant = $this->db->get_count("form__bjhh_activity_personadd", "uid=$val[recordid]");
            if ($val['signUpDeadline'] < time()) {
                $val['applystatus'] = "报名截止";
            } elseif ($applicant >= $val['planNum']) {
                $val['applystatus'] = "报名人数已满";
            } else {
                $val['applystatus'] = "招募中";
            };
            $val['activityStartDate'] = date("Y-m-d", $val['activityStartDate']);
            $val['activityEndDate'] = date("Y-m-d", $val['activityEndDate']);

            $records[$key] = $val;
        }
        return $records;
    }

    /**
     * 获取活动类型
     */
    public function getActivityTypes()
    {
        $a = 'form__bjhh_dictbl';
        $where = "tcode='008'";
        return $this->db->getall($a, $where);
    }

    /**
     * 判断报名有没截止
     */
    public function endTime($end)
    {
        if ($end > time()) return true;
        else return false;
    }

    /**
     * 统计报名人数并判断
     */
    public function countactivityPeople($recordid, $planNum)
    {
        $table = "form__bjhh_activity_personadd";
        $people = $this->db->get_count($table, "uid=$recordid");
        if (!$planNum) {
            return $people;
        }
        if ($planNum) {
            if ($people >= $planNum) return $people;
            else return false;
        }
    }
}


?>