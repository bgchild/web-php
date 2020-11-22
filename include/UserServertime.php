<?php

include_once("user.php");

/**
 *
 * 志愿服务时间
 */
class UserServertime extends user
{
    public function __construct($ajax = false)
    {
        parent::__construct();
        if (!$ajax) {
            $_user = $this->checkCaptain();
            if (!$_user)
                $this->db->get_show_msg($this->getBackUrl("userIndex.php"), "不是队长不能访问！");
        }
    }

    public function getRecords($query, $limit)
    {
        $id = $this->getUser(0);
        $q1 = "deltag=0 and cid='$id' and status=4 and basePredictHour is not null and basePredictHour<>''";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'activityName') {
                $q1 .= " and $key like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'activityStartDate') {
                $val = strtotime($val);
                $q1 .= " and $key >=$val   ";
                continue;
            }
            if ($key == 'activityEndDate') {
                $val = strtotime($val);
                $q1 .= " and $key <=$val   ";
                continue;
            }
            if ($key == 'name') {
                $q2 = " $key like '%" . $val . "%'  ";
            }

        }
        //$this->count = $this->db->get_count ( 'form__bjhh_activityexamine_activityinfo', $q1 );
        $record = $this->db->getall('form__bjhh_activityexamine_activityinfo', $q1, array(limit => '0,9999999'), '*', " order by recordid DESC ");
        $ids = array();
        foreach ($record as $k => $v) {
            if (!$this->getTwoRecord($v[recordid], $q2)) {
                //$this->count--;
                if ($v[recordid])
                    $ids[] = $v[recordid];
                //过滤活动
                //$q1.=" and recordid <> $v[recordid]";


            }
        }
        $idss = implode(',', $ids);
        if ($idss)
            $q1 .= " and recordid not in ($idss)";
        $this->count = $this->db->get_count('form__bjhh_activityexamine_activityinfo', $q1);
        $server = $this->db->getall('form__bjhh_activityexamine_activityinfo', $q1, array('limit' => $limit), '*', " order by a_date DESC ");

        foreach ($server as $k => $v) {
            $servertime[$k]['recordid'] = $v['recordid'];
            $servertime[$k]['activityName'] = $v['activityName'];
            $servertime[$k]['basePredictHour'] = $v['basePredictHour'];
            $servertime[$k]['predictHour'] = $v['predictHour'];
            //此活动所有人的工时总和代表活动总志愿服务时间
            $perss = $this->db->getall('form__bjhh_activity_personadd', "uid=$v[recordid] and delstatus=0 and status=4");
            $time = 0;
            foreach ($perss as $key => $val) {
                (int)$time += (int)$val[time];
            }
            $servertime[$k]['activitytime'] = $time;
            $servertime[$k]['activityStartDate'] = date("Y-m-d", $v['activityStartDate']);
            $servertime[$k]['activityEndDate'] = date("Y-m-d", $v['activityEndDate']);
        }

        return $servertime;
    }


    public function getCount()
    {
        return $this->count;
    }


    public function getTwoRecord($id, $q2)
    {
        $conditions = "";
        if ($q2) {
            $conditions .= "delstatus=0 and status=4 and uid=$id and " . $q2;
            $one = $this->db->get_one('form__bjhh_activityexamine_activityinfo', "recordid = $id");
            if ($one['status'] == 4 && isset($one['basePredictHour'])) {
                //没找到此活动就过滤掉
                return $this->db->get_one('form__bjhh_activity_personadd', $conditions);
            } else {
                return false;
            }
        } else {
            return true;
        }


    }

}

?>