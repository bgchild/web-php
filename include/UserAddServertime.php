<?php

include_once("user.php");


class UserAddServertime extends user
{
    public function __construct($ajax = false)
    {
        parent::__construct($ajax);

        if (!$ajax) {
            $_user = $this->checkCaptain();
            if (!$_user)
                $this->db->get_show_msg($this->getBackUrl("userIndex.php"), "不是队长不能访问！");
        }
    }

    public function getActivityTypes($typename = '活动类型')
    {
        return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='" . $typename . "' and  a.typeCode=b.tCode  and b.state='1' ", $limit = array(limit => '0,9999999'), ' order by b.listorder desc');
    }

    public function getRecords($query, $limit)
    {
        // 这里只获取普通活动 或 大型活动中的小型活动(因为大型活动本身不进行服务时间计算)
        $id = $this->getUser(0);
        $q = " deltag='0' and cid='$id' and status=4 and large=0 and (basePredictHour is null or basePredictHour='')";
        //$q=" deltag='0' and cid='$id' and status=4  and (basePredictHour is null or basePredictHour='')";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($key == 'activityName' || $key == 'activityAddr') {
                $q .= " and $key like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'activityStartDate') {
                $val = strtotime($val);
                $q .= " and $key >=$val   ";
                continue;
            }
            if ($key == 'activityEndDate') {
                $val = strtotime($val);
                $q .= " and $key <=$val   ";
                continue;
            }
            $q .= " and $key='$val' ";
        }
        $this->count = $this->db->get_count('form__bjhh_activityexamine_activityinfo', $q);
        $records = $this->db->getall('form__bjhh_activityexamine_activityinfo', $q, array(limit => $limit), $fields = '*', ' order by recordid DESC');
        $types = $this->getActivityTypes();
        foreach ($records as $k => $v) {
            $rid = $v['recordid'];
            //$v['totalnums']=$this->db->get_count('form__bjhh_activity_personadd', " uid=$rid ");
            //$v['passnums']=$this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='1' ");
            foreach ($types as $type) {
                if ($type['id'] == $v['activityType']) {
                    $v['typename'] = $type['name'];
                    break;
                }
            }
            $records[$k] = $v;
        }
        return $records;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getOneRecord($recordid)
    {
        return $this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=" . $recordid);
    }

    /*public function editRecord($post){
                foreach($post as $key=>$val) $post[$key]=trim($val);
                $datas=array();
                $datas['basePredictHour']=$post['basePredictHour'];
                $time['time']=$post['basePredictHour'];
                $datas['a_date']=$post['addtime'];
            if($post['recordid']) {
                    $activityID = $post['recordid'];
                    $stime=$post['basePredictHour'];
                    $activity = $this->db->get_one('form__bjhh_activityexamine_activityinfo'," recordid=".$post['recordid']);
                    if($post['basePredictHour']>$activity['predictHour']){$this->db->get_show_msg('UserAddServerTime.php', '保存失败，基础工时应小于志愿服务时间'.$activity['predictHour'].'小时');}
                    //给参与这一活动的人员分配基础工时
                    $conditions = "uid=$activityID and status=4 and delstatus=0";
                    $this->db->edit ( 'form__bjhh_activity_personadd',$time, $conditions);
                    $persons = $this->db->getAll ( 'form__bjhh_activity_personadd', $conditions);

                    foreach($persons as $k=>$v){
                        $one = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=".$v[pid]);
                        $newtime = (int)$one['allservertime']+(int)$stime;
                        $this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo',"allservertime=".$newtime, "recordid=".$v[pid]);
                    }


                    $affected=$this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, " recordid=".$post['recordid']) ;

                    if($affected) return $affected;
                    else return false;
            }else {
                 return false;
        }
    }*/

    public function editRecordAjax($post)
    {

        foreach ($post as $key => $val) {
            $post[$key] = trim($val);
        }

        $datas = array();
        $datas['basePredictHour'] = $post['basePredictHour'];
        $time['time'] = $post['basePredictHour'];
        $datas['a_date'] = $post['addtime'];
        if ($post['recordid']) {
            $activityID = $post['recordid'];
            // 检测活动是否为大型活动,因为大型活动不参与计时
            $record = $this->getOneRecord($activityID);
            if ($record && $record['large']) {
                return -2;
            } else {
                $stime = $post['basePredictHour'];
                $activity = $this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=" . $post['recordid']);
                if ($post['basePredictHour'] > $activity['predictHour']) {
                    return -3;
                }

                //给参与这一活动的人员分配基础工时
                $conditions = "uid=$activityID and status=4 and delstatus=0";
                $this->db->edit('form__bjhh_activity_personadd', $time, $conditions);
                $persons = $this->db->getAll('form__bjhh_activity_personadd', $conditions);

                foreach ($persons as $k => $v) {
                    $one = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=" . $v[pid]);
                    $newtime = (int)$one['allservertime'] + (int)$stime;
                    $this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', "allservertime=" . $newtime, "recordid=" . $v[pid]);
                }

                $affected = $this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, " recordid=" . $post['recordid']);

                if ($affected) return $affected;

                else return false;
            }
        } else {
            return false;
        }
    }

    public function editRecord($post)
    {
        foreach ($post as $key => $val) {
            $post[$key] = trim($val);
        }

        $datas = array();
        $datas['basePredictHour'] = $post['basePredictHour'];
        $time['time'] = $post['basePredictHour'];
        $datas['a_date'] = $post['addtime'];
        if ($post['recordid']) {
            $activityID = $post['recordid'];
            // 检测活动是否为大型活动,因为大型活动不参与计时
            $record = $this->getOneRecord($activityID);
            if ($record && $record['large']) {
                $this->db->get_show_msg('UserAddServerTime.php', '保存失败，大型活动不参加计时');
                return false;
            } else {
                $stime = $post['basePredictHour'];
                $activity = $this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=" . $post['recordid']);
                if ($post['basePredictHour'] > $activity['predictHour']) {
                    $this->db->get_show_msg('UserAddServerTime.php', '保存失败，基础工时应小于志愿服务时间' . $activity['predictHour'] . '小时');
                }

                //给参与这一活动的人员分配基础工时
                $conditions = "uid=$activityID and status=4 and delstatus=0";
                $this->db->edit('form__bjhh_activity_personadd', $time, $conditions);
                $persons = $this->db->getAll('form__bjhh_activity_personadd', $conditions);

                foreach ($persons as $k => $v) {
                    $one = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=" . $v[pid]);
                    $newtime = (int)$one['allservertime'] + (int)$stime;
                    $this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', "allservertime=" . $newtime, "recordid=" . $v[pid]);
                }

                $affected = $this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, " recordid=" . $post['recordid']);

                if ($affected) return $affected;
                else return false;
            }
        } else {
            return false;
        }
    }

}

?>