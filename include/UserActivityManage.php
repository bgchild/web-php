<?php

include_once("user.php");

include_once(INCLUDE_PATH . "search.php");

/**
 *
 * 用户活动管理类
 */
class UserActivityManage extends user
{

    private $count = 0;
    private $ActivityMemcount = 0;
    private $search;

    public function __construct($ajax = false)
    {
        parent::__construct($ajax);
        $this->search = new Search();
        if(!$ajax){
            $this->selfcheckCaptain();
        }
    }

    /**
     * 大型活动列表
     */
    public function getLargeActivityList()
    {
        $cid = $this->getUser(0);
        $where = "cid='$cid' and large=1 and status=3";
        return $this->db->getall('form__bjhh_activityexamine_activityinfo', $where);
    }

    public function selfcheckCaptain()
    {
        $_user = $this->checkCaptain();
        if (!$_user) $this->db->get_show_msg($this->getBackUrl("userIndex.php"), "不是队长和注销用户不能访问！");
    }

    public function addOneActivity($post)
    {
        foreach ($post as $key => $val) $post[$key] = trim($val);

        $datas = array();
        if ($post['activityName']) $datas['activityName'] = $post['activityName'];
        if ($post['activityType']) $datas['activityType'] = $post['activityType'];
        if ($post['activityAddr']) $datas['activityAddr'] = $post['activityAddr'];
        if ($post['planNum']) $datas['planNum'] = $post['planNum'];
        if ($post['predictHour']) $datas['predictHour'] = $post['predictHour'];
        if ($post['activitytime']) $datas['activitytime'] = $post['activitytime'];
        if ($post['activityStartDate']) $datas['activityStartDate'] = strtotime($post['activityStartDate']);
        if ($post['activityEndDate']) $datas['activityEndDate'] = strtotime($post['activityEndDate']);
        if ($post['creattime']) $datas['creattime'] = strtotime($post['creattime']);
        if ($post['signUpDeadline']) $datas['signUpDeadline'] = strtotime($post['signUpDeadline']);
        if ($post['remarks']) $datas['remarks'] = $post['remarks'];
        if ($post['activityProfile']) $datas['activityProfile'] = jsformat($post['activityProfile']);
        if ($post['filename']) $datas['filename'] = $post['filename'];
        if ($post['filepath']) $datas['filepath'] = $post['filepath'];
        if ($post['serviceid']) $datas['serviceid'] = $post['serviceid'];
        if ($post['actysmoney']) $datas['actysmoney'] = $post['actysmoney'];
        if ($post['actysobjnum']) $datas['actysobjnum'] = $post['actysobjnum'];
        if ($post['large']) $datas['large'] = 1;
        // 如果是普通活动,则记录 省市信息 和 坐标信息
        if (!$datas['large']) {
            if ($post['activityProvince']) $datas['activityProvince'] = $post['activityProvince'];
            if ($post['activityCity']) $datas['activityCity'] = $post['activityCity'];
            if ($post['activityArea']) $datas['activityArea'] = $post['activityArea'];
            if ($post['activityPoint']) {
                //$datas['activityPoint'] = $post['activityPoint'];
                $_points = explode(",", $post['activityPoint']);
                $datas['lng'] = $_points[0];
                $datas['lat'] = $_points[1];
            }
        }

        if ($post['largeid']) $datas['largeid'] = $post['largeid'];
        $datas['deltag'] = '0';
        $datas['cid'] = $this->getUser(0);
        if ($post['status']) $datas['status'] = $post['status'];
        if ($post['imgpath']) $datas['imgpath'] = $post['imgpath'];
        if ($post['recordid']) {
            $affected = $this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, " recordid=" . $post['recordid']);
            if ($affected) {
                return $affected;
            } else return false;
        } else {
            $datas['sign'] = $this->getUser('sign');
            $datas['parentid'] = $this->getUser('parentid');
            $insert_id = $this->db->add('form__bjhh_activityexamine_activityinfo', $datas);
            if ($insert_id) {
                $u['uid'] = $insert_id;
                $u['pid'] = $this->getUser(0);
                $per = $this->db->get_one("form__bjhh_volunteermanage_volunteerbasicinfo", "recordid='" . $this->getUser(0) . "'");
                $u['name'] = $per['name'];
                $u['addDate'] = time();
                $u['status'] = 2;
                $this->db->add('form__bjhh_activity_personadd', $u);
                return $insert_id;
            } else return false;
        }
    }

    public function editRecord($datas)
    {
        foreach ($datas as $key => $val) $datas[$key] = trim($val);
        if (isset($datas['activityProfile'])) $datas['activityProfile'] = jsformat($datas['activityProfile']);
        if (isset($datas['sumup'])) $datas['sumup'] = jsformat($datas['sumup']);
        $affected = $this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, " recordid=" . $datas['recordid']);
        if ($affected) {
            return $affected;
        } else return false;
    }

    public function stopActivity($rid)
    {
        $msg = "";
        $err = false;
        // 检测活动是否为大型活动,如果存在子集活动没有结束,则必须先结束所有子集活动
        $record = $this->getOneRecord($rid);
        if ($record && $record['large']) {
            // 如果存在子集活动处于 2:等待审核 3:活动进行中 的情况,则大型活动将不能立即结束,必须等这些子集活动全部结束后,方可执行.
            $childrenCount = $this->db->get_count("form__bjhh_activityexamine_activityinfo", "largeid=$rid and status IN (2,3)");
            if ($childrenCount) {
                $msg = "存在子集活动未结束!";
                $err = true;
            }
        }

        if (!$err) {
            $v['status'] = 4;
            $a1 = $this->db->edit("form__bjhh_activityexamine_activityinfo", $v, " recordid=" . $rid);
            $v2['status'] = 4;
            $a2 = $this->db->edit("form__bjhh_activity_personadd", $v2, " uid=" . $rid . " and status='2' ");
            if (!$a1 || !$a2) {
                $err = true;
            }
        }


        /*$v['status']=4;
        $a1=$this->db->edit("form__bjhh_activityexamine_activityinfo", $v, " recordid=".$rid);
        $v2['status']=4;
        $a2=$this->db->edit("form__bjhh_activity_personadd", $v2, " uid=".$rid." and status='2' ");
        if($a1 && $a2) return true;
        else {
            return false;
        }*/

        return array('err' => $err, 'msg' => $msg);
    }

    public function sendChangeTimeMsg2Mem($aid)
    {
        $act = $this->getOneRecord($aid);
        $data['fromid'] = $this->getUser(0);
        $data['fromname'] = $this->getUser(1);
        $data['status'] = '13';//13: 活动被改期
        $data['date'] = time();
        $data['fno'] = $aid;
        $data['content'] = "活动【$act[activityName]】 已经被改期，请注意！";
        $mems2 = $this->getActivityMem($aid, 2);//已通过
        foreach ($mems2 as $mem) {
            if ($mem['recordid'] == $this->getUser(0)) continue;
            $data['toid'] = $mem['recordid'];
            $data['toname'] = $mem['username'];
            $this->db->add('form__bjhh_message', $data);
        }
        return true;
    }

    public function sendCancelActivityMsg2Mem($aid)
    {
        $act = $this->getOneRecord($aid);
        $data['fromid'] = $this->getUser(0);
        $data['fromname'] = $this->getUser(1);
        $data['status'] = '12';//12: 活动被取消
        $data['date'] = time();
        $data['fno'] = $aid;
        $data['content'] = "活动【$act[activityName]】 已经被活动创始人【$data[fromname]】取消！！";
        $mems1 = $this->getActivityMem($aid, 1);//报名
        $mems2 = $this->getActivityMem($aid, 2);//已通过
        $mems = array_merge($mems1, $mems2);
        foreach ($mems as $mem) {
            $m['status'] = 5;
            $this->db->edit('form__bjhh_activity_personadd', $m, " recordID=" . $mem['recordID']);
            if ($mem['recordid'] == $this->getUser(0)) continue;
            $data['toid'] = $mem['recordid'];
            $data['toname'] = $mem['username'];
            $this->db->add('form__bjhh_message', $data);
        }
        return true;
    }

    public function editActivityMen($datas, $type = "pass")
    {
        foreach ($datas as $key => $val) $datas[$key] = trim($val);
        $actinfo = $this->db->get_relations_one("form__bjhh_activity_personadd", "form__bjhh_activityexamine_activityinfo", " a.recordID=" . $datas['recordID'] . " and a.uid=b.recordid ");
        $perinfo = $this->db->get_relations_one("form__bjhh_activity_personadd", "form__bjhh_volunteermanage_volunteerbasicinfo", " a.recordID=" . $datas['recordID'] . " and a.pid=b.recordid ");
        if ("pass" == $type) $content = " 您已经被批准加入活动【$actinfo[activityName]】";
        else $content = " 您已经被拒绝加入活动【$actinfo[activityName]】";
        //echo $actinfo[recordID],"---",$actinfo[name],"---",'14',"---",$actinfo['recordid'],"---",$content;die();
        $this->sendMsg($perinfo[recordid], $actinfo[name], '14', $actinfo['recordid'], $content);
        $affected = $this->db->edit('form__bjhh_activity_personadd', $datas, " recordID=" . $datas['recordID']);
        if ($affected) return $affected;
        else return false;
    }


    public function getActivityTypes($typename = '活动类型')
    {
        return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='" . $typename . "' and  a.typeCode=b.tCode  and b.state='1' ", array(limit => '0,9999999'), ' order by b.listorder desc');
    }

    private function _addExtInfo(&$arr, $tagname, $colname, $valname)
    {
        $types = $this->getActivityTypes($tagname);
        foreach ($arr as $k => $v) {
            $skills = split(",", $v[$colname]);
            $skillnames = "";
            foreach ($skills as $p) {
                foreach ($types as $type)
                    if ($p == $type['id'])
                        $skillnames .= $type['name'] . ",";
            }
            $v[$valname] = substr($skillnames, 0, -1) ? substr($skillnames, 0, -1) : "无";
            $arr[$k] = $v;
        }
    }

    public function getActivityMem($cid, $status = 1, $limit = '0,9999999')
    {
        //$q="  b.recordid=a.rid and b.recordid=c.pid  and c.uid='".$cid."' and c.status='".$status."' and c.delstatus='0' ";
        //$mem= $this->db-> get_relations_info("form__bjhh_volunteermanage_volunteerextendinfo","form__bjhh_volunteermanage_volunteerbasicinfo", "form__bjhh_activity_personadd", $q,  array(limit=>$limit), $orders = ' order by c.recordid desc ');
        $q = " a.recordid=b.pid  and b.uid='" . $cid . "' and b.status='" . $status . "' and b.delstatus='0' ";
        $mem = $this->db->get_relations_info("form__bjhh_volunteermanage_volunteerbasicinfo", "form__bjhh_activity_personadd", $q, array(limit => $limit), $orders = ' order by b.recordid desc ');
        foreach ($mem as $key => $value) {
            $each = $this->db->get_one("form__bjhh_volunteermanage_volunteerextendinfo", " rid='" . $value[pid] . "'");
            if (count($each) > 0) {
                $value['features'] = $each['features'];
            } else {
                $value['features'] = '';
            }
            $mem[$key] = $value;
        }
        $this->_addExtInfo($mem, "技能特长", 'features', "skillnames");
        $this->ActivityMemcount = $this->db->get_count('form__bjhh_activity_personadd', "uid='" . $cid . "' and status='" . $status . "'");
        return $mem;
    }

    public function getActivityMemCount()
    {
        return $this->ActivityMemcount;
    }

    public function getServiceTeams($query, $limit = array(limit => '0,9999999'))
    {
        $userid = $this->getUser(0);
        $userInfo = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$userid");
        $q = " b.agree='2'  and b.deltag='0' and sign='{$userInfo['sign']}'  and b.recordid=a.serviceteamid and a.serviceteamcaptainid=$userid and a.sp_status='2' ";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($val == "") continue;
            if ($key == 'serviceteamname') {
                $q .= " and b.$key like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'foundingtime') {
                $val2 = mktime(0, 0, 0, date("m", $val), date("d", $val) + 1, date("Y", $val));
                $q .= " and b.$key>=$val and b.$key<=$val2 ";
                continue;
            }
            $q .= " and b.$key='$val' ";
        }
        //$arr= $this->db->getall("form__bjhh_serviceteammanage_addserviceteam",$q, $limit, '*','  order by recordid DESC');
        $arr = $this->db->get_relations_info("form__bjhh_serviceteammanage_addserviceteamperson", "form__bjhh_serviceteammanage_addserviceteam", $q, $limit, ' order by b.recordid DESC');
        $this->_addExtInfo($arr, "技能特长", 'skills_checkbox', "skillnames");
        $this->_addExtInfo($arr, "服务项目", 'serviceclassification_checkbox', "servicenames");
        return $arr;
    }

    public function getServiceTeamsAjax($query, $limit = array(limit => '0,9999999')) {
        $userid = $this->getUser(0);
        $q = " b.agree='2'  and b.deltag='0' and b.recordid=a.serviceteamid and a.serviceteamcaptainid=$userid and a.sp_status='2' ";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($val == "") continue;
            if ($key == 'serviceteamname') {
                $q .= " and b.$key like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'foundingtime') {
                $val2 = mktime(0, 0, 0, date("m", $val), date("d", $val) + 1, date("Y", $val));
                $q .= " and b.$key>=$val and b.$key<=$val2 ";
                continue;
            }
            $q .= " and b.$key='$val' ";
        }
        $arr = $this->db->get_relations_info("form__bjhh_serviceteammanage_addserviceteamperson", "form__bjhh_serviceteammanage_addserviceteam", $q, $limit, ' order by b.recordid DESC');
        $this->_addExtInfo($arr, "技能特长", 'skills_checkbox', "skillnames");
        $this->_addExtInfo($arr, "服务项目", 'serviceclassification_checkbox', "servicenames");
        return $arr;
    }

    private function _getServiceMenDo($activityId, $query = array(), $features = "")
    {
        /*****获取当前登录用户的地区标识******/
        $userid = $this->getUser(0);
        $userInfo = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$userid");
        /**************/
        $q = " b.status in ('010','001')  ";
        $q2 = " b.status in ('010','001') ";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($val == "") continue;
            if ($key == 'nickname') {
                $q .= " and b.username like '%" . $val . "%' ";
                $q2 .= " and b.username like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'serviceteamid') {
                $q .= " and a.serviceteamid = '$val' ";
                continue;
            }
        }
        if ($features) {
            $features = split(",", $features);
            foreach ($features as $f) {
                $q .= " and concat(',',c.features,',')  like concat('%,','" . $f . "' ,',%') ";
                $q2 .= " and concat(',',c.features,',')  like concat('%,','" . $f . "' ,',%') ";
            }
        }
        if (!$query['serviceteamid']) {
            $sql = " select b.*,c.features from form__bjhh_volunteermanage_volunteerbasicinfo as b left join form__bjhh_volunteermanage_volunteerextendinfo as c on b.recordid=c.rid";
            $q2 .= "and b.sign='{$userInfo['sign']}' ";
            $sql .= " where  " . $q2;
            $sql .= " order by b.applytime desc";
            //$sql.=" limit ".$limit['limit'];
        } else {
            $sql = " select distinct a.serviceteamcaptainid,a.serviceteamid,a.joinserviceteamdate,a.captain,b.*,c.features from form__bjhh_serviceteammanage_addserviceteamperson as a right join form__bjhh_volunteermanage_volunteerbasicinfo as b on a.serviceteamcaptainid=b.recordid  left join form__bjhh_volunteermanage_volunteerextendinfo as c on b.recordid=c.rid";
            $sql .= " where  " . $q;
            $sql .= " group by a.serviceteamcaptainid order by a.serviceteamcaptainid ";
            //$sql.=" limit ".$limit['limit'];
        }
        $res = $this->db->db->query($sql);
        if ($res == false) return false;
        $arr = array();
        $arr2 = array();
        while ($row = mysql_fetch_assoc($res)) {
            $arr[$row['recordid']] = $row;
            $arr2[$row['recordid']] = $row;
        }
        $this->_addExtInfo($arr, "技能特长", 'features', "pnames");
        $this->_addExtInfo($arr2, "技能特长", 'features', "pnames");
        foreach ($arr as $k => $v) {
            if ($v["recordid"] == $this->getUser(0)) {
                $arr2 = $this->array_delete_item($arr2, $k);
                continue;
            }
            if ($this->db->get_one('form__bjhh_message', " fno='" . $activityId . "' and toid='" . $v['recordid'] . "' and isread='0' and status=4 ")) {
                $arr2 = $this->array_delete_item($arr2, $k);
                continue;
            }
            if ($this->db->get_one('form__bjhh_message', " fno='" . $activityId . "' and toid='" . $v['recordid'] . "' and isdone='1' and status=4 ")) {
                if ($this->db->get_one('form__bjhh_activity_personadd', "uid='" . $activityId . "' and pid='" . $v['recordid'] . "' and status in('2','4')")) {
                    $arr2 = $this->array_delete_item($arr2, $k);
                    continue;
                }
            }
        }
        return $arr2;
    }

    public function _getServiceMenDoAjax($activityId, $query = array(), $features = "") {
        /*****获取当前登录用户的地区标识******/
        //$userid = $this->getUser(0);
        //$userInfo = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$userid");
        $sign = $_SESSION['sign'];
        /**************/
        $q = " b.status in ('010','001')  ";
        $q2 = " b.status in ('010','001') ";
        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($val == "") continue;
            if ($key == 'nickname') {
                $q .= " and b.username like '%" . $val . "%' ";
                $q2 .= " and b.username like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'serviceteamid') {
                $q .= " and a.serviceteamid = '$val' ";
                continue;
            }
        }
        if ($features) {
            $features = split(",", $features);
            foreach ($features as $f) {
                $q .= " and concat(',',c.features,',')  like concat('%,','" . $f . "' ,',%') ";
                $q2 .= " and concat(',',c.features,',')  like concat('%,','" . $f . "' ,',%') ";
            }
        }
        if (!$query['serviceteamid']) {
            $sql = " select b.*,c.features from form__bjhh_volunteermanage_volunteerbasicinfo as b left join form__bjhh_volunteermanage_volunteerextendinfo as c on b.recordid=c.rid";
            $q2 .= "and b.sign='{$sign}' ";
            $sql .= " where  " . $q2;
            $sql .= " order by b.applytime desc";
            //$sql.=" limit ".$limit['limit'];
        } else {
            $sql = " select distinct a.serviceteamcaptainid,a.serviceteamid,a.joinserviceteamdate,a.captain,b.*,c.features from form__bjhh_serviceteammanage_addserviceteamperson as a right join form__bjhh_volunteermanage_volunteerbasicinfo as b on a.serviceteamcaptainid=b.recordid  left join form__bjhh_volunteermanage_volunteerextendinfo as c on b.recordid=c.rid";
            $sql .= " where  " . $q;
            $sql .= " group by a.serviceteamcaptainid order by a.serviceteamcaptainid ";
            //$sql.=" limit ".$limit['limit'];
        }
        $res = $this->db->db->query($sql);
        if ($res == false) return false;
        $arr = array();
        $arr2 = array();
        while ($row = mysql_fetch_assoc($res)) {
            $arr[$row['recordid']] = $row;
            $arr2[$row['recordid']] = $row;
        }
        $this->_addExtInfo($arr, "技能特长", 'features', "pnames");
        $this->_addExtInfo($arr2, "技能特长", 'features', "pnames");
        foreach ($arr as $k => $v) {
            if ($v["recordid"] == $this->getUser(0)) {
                $arr2 = $this->array_delete_item($arr2, $k);
                continue;
            }
            if ($this->db->get_one('form__bjhh_message', " fno='" . $activityId . "' and toid='" . $v['recordid'] . "' and isread='0' and status=4 ")) {
                $arr2 = $this->array_delete_item($arr2, $k);
                continue;
            }
            if ($this->db->get_one('form__bjhh_message', " fno='" . $activityId . "' and toid='" . $v['recordid'] . "' and isdone='1' and status=4 ")) {
                if ($this->db->get_one('form__bjhh_activity_personadd', "uid='" . $activityId . "' and pid='" . $v['recordid'] . "' and status in('2','4')")) {
                    $arr2 = $this->array_delete_item($arr2, $k);
                    continue;
                }
            }
        }
        return $arr2;
    }

    public function getServiceMen($activityId, $query = array(), $features = "", $limit = array(limit => '0,9999999'))
    {
        $arr = $this->_getServiceMenDo($activityId, $query, $features);
        foreach ($arr as $v) {
            $fa[] = $v;
        }
        $ls = split(",", $limit['limit']);
        return array_slice($fa, $ls[0], $ls[1]);
    }

    public function getServiceMenAjax($activityId, $query = array(), $features = "", $limit = array(limit => '0,9999999')) {
        $arr = $this->_getServiceMenDoAjax($activityId, $query, $features);
        foreach ($arr as $v) {
            $fa[] = $v;
        }
        $ls = split(",", $limit['limit']);
        return array_slice($fa, $ls[0], $ls[1]);
    }

    private function array_delete_item($arr, $k)
    {
        return array_diff_key($arr, array($k => $arr[$k]));
        /*$arr1=array_slice($arr,0,$k);
        $arr2=array_slice($arr,$k+1);
        return array_merge($arr1,$arr2);*/
    }


    public function getRecordsByStatus($status, $largeid, $query, $limit)
    {
        $userid = $this->getUser(0);
        $userInfo = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$userid");
        //var_dump($userInfo);

        $q2 = " deltag='0' and sign='{$userInfo['sign']}' and cid='" . $this->getUser(0) . "'";
        if ($status) {
            $q2 .= "  and status='" . $status . "' ";
        }

        foreach ($query as $key => $val) {
            $val = trim($val);
            if ($val == "") continue;
            if ($key == 'activityName' || $key == 'activityAddr') {
                $q2 .= " and $key like '%" . $val . "%' ";
                continue;
            }
            if ($key == 'activityStartDate') {
                $val = strtotime($val);
                $val2 = mktime(0, 0, 0, date("m", $val), date("d", $val) + 1, date("Y", $val));
                $q2 .= " and $key >=$val2    ";
                continue;
            }
            if ($key == 'activityEndDate') {
                $val = strtotime($val);
                $val2 = mktime(0, 0, 0, date("m", $val), date("d", $val) + 1, date("Y", $val));
                $q2 .= " and $key<=$val2 ";
                continue;
            }
            $q2 .= " and $key='$val' ";
        }

        if ($status) {
            if ($largeid) {
                $q2 .= " and largeid=$largeid";
            } else {
                $q2 .= " and largeid=0";
            }
        }

        $this->count = $this->db->get_count('form__bjhh_activityexamine_activityinfo', $q2);
        $records = $this->db->getall('form__bjhh_activityexamine_activityinfo', $q2, array(limit => $limit), $fields = '*', ' order by recordid DESC');
        foreach ($records as $k => $v) {
            $rid = $v['recordid'];
            /*if ($v['largeid']) {
                $largeRecord = $this->getOneRecord($v['largeid']);
                if ( $largeRecord ) {
                    $v['largeActivityName'] = $largeRecord['activityName'];
                }
            }*/
            // 如果是大型项目,则获取子项目数
            if ($v['large']) {
                $v['childrenCount'] = $this->db->get_count("form__bjhh_activityexamine_activityinfo", "largeid=$rid");
            }
            $v['totalnums'] = $this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='1' and delstatus='0' ");
            $v['passnums'] = $this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='2' and delstatus='0' ");
            $v['gonums'] = $this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='4' and delstatus='0' ");
            $records[$k] = $v;
        }
        $this->_addExtInfo($records, "活动类型", 'activityType', "typename");
        $this->_addExtInfo($records, "活动审核拒绝原因", 'statusreason', "statusreasontext");
        return $records;
    }

    /*public function getRecordsByStatus($status,$query,$limit){
        $userid=$this->getUser(0);
        $userInfo = array();
        $userInfo = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo',"recordid=$userid");

        $q2=" a.deltag='0' and a.sign='{$userInfo['sign']}' and a.cid='".$this->getUser(0)."' and a.largeid=b.recordid ";
        if($status) {
            $q2.="  and a.status='".$status."'";
        }
        foreach($query as $key=>$val){
            $val=trim($val);
            if($val=="") continue;
            if($key=='activityName' || $key=='activityAddr') {
                $q2.=" and a.$key like '%".$val."%' ";
                continue;
            }
            if($key=='activityStartDate' ) {
                $val=strtotime($val);
                $val2= mktime(0, 0, 0, date("m",$val)  , date("d",$val)+1, date("Y",$val));
                $q2.=" and a.$key >=$val    ";
                continue;
            }
            if($key=='activityEndDate') {
                $val=strtotime($val);
                $val2= mktime(0, 0, 0, date("m",$val)  , date("d",$val)+1, date("Y",$val));
                $q2.=" and a.$key<=$val2 ";
                continue;
            }
            $q2.=" and a.$key='$val' ";
        }

        $a = "form__bjhh_activityexamine_activityinfo";
        $b = "form__bjhh_activityexamine_activityinfo";

        //$this->count=$this->db->get_count('form__bjhh_activityexamine_activityinfo', $q2);
        $this->count = $this->db->get_relations_count($a, $b, $q2);
        //$records= $this->db->getall( 'form__bjhh_activityexamine_activityinfo', $q2, array(limit=>$limit), $fields = '*',' order by recordid DESC');
        $records = $this->db->get_relations_info($a, $b, $q2, array ('limit' => $limit ), $orders = 'order by a.recordid DESC', $fields = 'a.*, b.activityName as largeActivityName');
        foreach($records as $k=>$v) {
            $rid=$v['recordid'];
            $v['totalnums']=$this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='1' and delstatus='0' ");
            $v['passnums']=$this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='2' and delstatus='0' ");
            $v['gonums']=$this->db->get_count('form__bjhh_activity_personadd', " uid=$rid and status='4' and delstatus='0' ");
            $records[$k]=$v;
        }
        $this->_addExtInfo($records,"活动类型",'activityType',"typename");
        $this->_addExtInfo($records,"活动审核拒绝原因",'statusreason',"statusreasontext");
        return $records;
    }*/

    public function getRecordsByStatusCount()
    {
        return $this->count;
    }

    public function getActivityServicename($recordid)
    {
        $sql = "select a.*,b.serviceteamname from form__bjhh_activityexamine_activityinfo as a left join form__bjhh_serviceteammanage_addserviceteam as b on a.serviceid=b.recordid where a.recordid=$recordid limit 0,9999999";
        $res = $this->db->query($sql);
        //$arr=$this->db->get_relations_info("form__bjhh_activityexamine_activityinfo", "form__bjhh_serviceteammanage_addserviceteam", "a.serviceid=b.recordid and  a.recordid=".$recordid);
        $res = $res[0];
        //print_r($res);
        return $res;
    }


    public function getOneRecord($recordid)
    {
        return $this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid=" . $recordid);
    }

    public function deleteOneRecord($recordid)
    {
        $datas['deltag'] = '1';
        $this->search->delInfo('1', $recordid);
        return $this->db->edit('form__bjhh_activityexamine_activityinfo', $datas, "recordid=$recordid");
    }

    public function invite2Activity($rids, $aid)
    {
        $data['fromid'] = $this->getUser(0);
        $data['fromname'] = $this->getUser(1);
        $data['status'] = 4;
        $data['date'] = time();
        $data['fno'] = $aid;
        foreach ($rids as $rid) {
            $data['toid'] = $rid;
            $toperson = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', " recordid=" . $rid);
            $act = $this->db->get_one('form__bjhh_activityexamine_activityinfo', " recordid='" . $aid . "'");
            $data['toname'] = $toperson['username'];
            $data['content'] = "活动 【" . $act['activityName'] . "】 邀请您加入";
            if (!$this->db->get_one('form__bjhh_message', " fromid=" . $data['fromid'] . " and toid=" . $data['toid'] . " and status='4' and fno='" . $aid . "'")) {
                $this->db->add('form__bjhh_message', $data);
            } else {
                //如果拒绝加入则继续发送邀请消息
                $msgone = $this->db->get_one('form__bjhh_message', " fromid=" . $data['fromid'] . " and toid=" . $data['toid'] . " and status='4' and fno='" . $aid . "' and isdone='1' ");
                $precord = $this->db->get_one('form__bjhh_activity_personadd', "uid='" . $aid . "' and pid='" . $rid . "' and status in('2','4')");
                if ($msgone && !$precord) {
                    //$data['isread']='0';
                    //$data['isdone']='0';
                    //$data['isdel']='0';
                    //$this->db->edit('form__bjhh_message', $data, " fromid=".$data['fromid']." and toid=".$data['toid']." and status='4' and fno='".$aid."'");
                    $this->db->add('form__bjhh_message', $data);
                }
            }
        }
    }

    public function getBackUrl($url)
    {
        if (strpos($_SERVER['HTTP_REFERER'], 'userMsg.php') > 0) return 'userMsg.php';
        else return $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $url;
    }

}

?>