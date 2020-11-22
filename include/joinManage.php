<?php
include_once('adminBase.php');

/**
 *
 *转入转出审核
 */
class joinManage extends adminbase
{
    private $search;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * 活动列表
     */
    public function init($status, $keyword)
    {
        $sign = array();
        $sign = $this->getCityInfo();
        $arr = array();
        $conditions = "(ocity='{$_SESSION['sign']}' or (ncity='{$_SESSION['sign']}' and status>'2'))";
        if ($keyword) $conditions .= " and uname like '%$keyword%' ";
        $nowtime = time();
        $t = trim($_GET['t']);
        $vol_font = '0';
        if ($t == '7day') {
            $begintime = $nowtime - 7 * 24 * 60 * 60;
            $vol_font = '7';
        } elseif ($t == '30day') {
            $begintime = $nowtime - 30 * 24 * 60 * 60;
            $vol_font = '30';
        } elseif ($t == '90day') {
            $begintime = $nowtime - 90 * 24 * 60 * 60;
            $vol_font = '90';
        } elseif ($t == '180day') {
            $begintime = $nowtime - 180 * 24 * 60 * 60;
            $vol_font = '180';
        }
        if ($t) $conditions .= "  and addtime>$begintime";
        $page = _get_page(10);   //获取分页信息
        $list = $this->db->getAll('form__bjhh_joinrecord', $conditions, array('limit' => $page['limit']), '*', " order by addtime desc");
        foreach ($list as $k => $v) {
            $v[ocity] == $sign['sign'] ? $v[jstatus] = "1" : $v[jstatus] = "2";
            $list[$k] = $v;
        }
        $page['item_count'] = $this->db->get_count('form__bjhh_joinrecord', $conditions);
        //最多显示最近500条
        if ($page['item_count'] > 500) $page['item_count'] = 500;
        $page = _format_page($page);
        $arr['list'] = $list;
        $arr['page'] = $page;
        $arr['vol_font'] = $vol_font;
        return $arr;
    }

    /**
     *
     * 个人详情
     */
    public function detail()
    {
        $spm = get_url($_GET['spm']);
        if (!$spm) $this->db->get_show_msg('volunteer.php', '参数错误！');
        $id = $spm[id];
        $hasF = false;
        if ($this->db->get_one('form__bjhh_volunteermanage_volunteerextendinfo', " rid=$id")) {
            $hasF = true;
            $where = "a.rid=b.recordid and b.recordid='$id' ";
            $info = $this->db->get_relations_one("form__bjhh_volunteermanage_volunteerextendinfo", "form__bjhh_volunteermanage_volunteerbasicinfo", $where);
        } else {
            $info = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$id");
        }
        if (!$info) $this->db->get_show_msg('volunteer.php', '参数错误！');
        $info = $this->_addExtInfo($info, "民族", "race", "race");
        $info = $this->_addExtInfo($info, "政治面貌", "politicalstatus", "politicalstatus");
        $info = $this->_addExtInfo($info, "证件类型", "idtype", "idtype");
        $info = $this->_addExtInfo($info, "技能特长", "features", "features");
        $info = $this->_addExtInfo($info, "服务项目", "serveitem", "serveitem");
        $info = $this->_addExtInfo($info, "学历", "lasteducation", "lasteducation");
        $info = $this->_addExtInfo($info, "国籍", "nationality", "nationality");
        $info = $this->_setAreaName($info, "province");
        $info = $this->_setAreaName($info, "city");
        $info = $this->_setAreaName($info, "area");
        $info = $this->_setAreaName($info, "serveprovince");
        $info = $this->_setAreaName($info, "servecity");
        $info = $this->_setAreaName($info, "servearea");
        $files = explode("/", substr($info['moduleName'], 1));
        $info['filename'] = array_pop($files);
        return $info;
    }

    private function _addExtInfo($arr, $tagname, $colname, $valname)
    {
        $types = $this->getTypes($tagname);
        $skills = split(",", $arr[$colname]);
        $skillnames = "";
        foreach ($skills as $p) {
            foreach ($types as $type)
                if ($p == $type['id'])
                    $skillnames .= $type['name'] . ",";
        }
        $arr[$valname] = substr($skillnames, 0, -1) ? substr($skillnames, 0, -1) : "无";
        return $arr;
    }

    public function _setAreaName($arr, $colname)
    {
        $area = $this->db->get_one("pubmodule_area_tbl", " areaId='" . $arr[$colname] . "'");
        $arr[$colname] = $area['areaName'];
        return $arr;
    }

    /**
     *
     * 批量通过操作
     */
    public function yes()
    {
        $all = $_POST['all'];
        $ads = $_POST['aid'];
        $old = $_POST['old'];
        $naids = $_POST['naids'];

        //全选处理-批量处理
        if ($all == 1) {
            global $sign;

            $where = " (status =1 or status = 3) and (ocity = '$sign' or ncity='$sign')";
            if ($naids) {
                $naids_str = implode(',', $naids);
                $where .= " and id not in (" . $naids_str . ")";
            }

            $list = $this->db->getAll('form__bjhh_joinrecord', $where, array('limit' => '9999999'), 'id,ocity');
            $ads = array();
            $old = array();
            foreach ($list as $lk => $lv) {
                $ads[$lk] = $lv['id'];
                if ($lv['ocity'] == $sign) {
                    $old[$lk] = 1;
                } else {
                    $old[$lk] = 0;
                }
            }
        }

        $remark = $_POST['statusremark'];
        $backurl = $this->getBackUrl('joinManage.php');
        if (!$ads) $this->db->get_show_msg($backurl, '请选择！');
        foreach ($ads as $k => $v) {
            $datas = array();
            if ($old[$k] == 1) {
                $datas['status'] = 3;
                $datas['oremark'] = $remark;
                $datas['oedittime'] = time();
            } else {
                $datas['status'] = 5;
                $datas['nremark'] = $remark;
                $datas['nedittime'] = time();
                $this->eidtsign($v);//修改标志
                //$this->pcode($one);//修改个人编码
            }
            $conditions = "id=$v";
            $result = $this->db->edit('form__bjhh_joinrecord', $datas, $conditions);
        }
    }

    /**
     * 修改标志
     */
    public function eidtsign($aid)
    {
        if (!$aid) return false;
        $one = $this->db->get_one("form__bjhh_joinrecord", "id=$aid");
        if (!$one) return false;
        $narea = $this->db->get_one("form__bjhh_area", "sign='$one[ncity]'");
        $datas[parentid] = $narea[parentid];
        $datas[sign] = $narea[sign];
        $conditions = "recordid=$one[uid]";
        $this->db->edit("form__bjhh_volunteermanage_volunteerbasicinfo", $datas, $conditions);
        return $one[uid];
    }

    /**
     *
     * 批量拒绝操作
     */
    public function no()
    {
        $ads = $_POST['aid'];
        $old = $_POST['old'];
        $all = $_POST['all'];
        $naids = $_POST['naids'];

        //全选处理-批量处理
        if ($all == 1) {
            global $sign;
            $where = " (status =1 or status = 3) and (ocity = '$sign' or ncity='$sign')";
            if ($naids) {
                $naids_str = implode(',', $naids);
                $where .= " and id not in (" . $naids_str . ")";
            }

            $list = $this->db->getAll('form__bjhh_joinrecord', $where, array('limit' => '9999999'), 'id,ocity');
            $ads = array();
            $old = array();
            foreach ($list as $lk => $lv) {
                $ads[$lk] = $lv['id'];
                if ($lv['ocity'] == $sign) {
                    $old[$lk] = 1;
                } else {
                    $old[$lk] = 0;
                }
            }
        }

        $remark = $_POST['statusremark'];
        $backurl = $this->getBackUrl('joinManage.php');
        if (!$ads) $this->db->get_show_msg($backurl, '请选择！');
        foreach ($ads as $k => $v) {
            $datas = array();
            if ($old[$k] == 1) {
                $datas['status'] = 2;
                $datas['oremark'] = $remark;
                $datas['oedittime'] = time();
            } else {
                $datas['status'] = 4;
                $datas['nremark'] = $remark;
                $datas['nedittime'] = time();
            }
            $conditions = "id=$v";
            $result = $this->db->edit('form__bjhh_joinrecord', $datas, $conditions);
        }
        $this->db->get_show_msg($backurl, '批量拒绝操作成功！');
    }

    public function getTypes($typename)
    {
        return $this->db->get_relations_info("form__bjhh_dictype", "form__bjhh_dictbl", " a.dicTypeName='" . $typename . "' and  a.typeCode=b.tCode  and b.state='1' ", array(limit => '0,9999999'), ' order by b.listorder desc');
    }

    private function changeType2Text($arr, $typename, $colname, $valname)
    {
        $types = $this->getTypes($typename);
        foreach ($types as $type)
            if ($arr[$colname] == $type['id'])
                $arr[$valname] = $type['name'];
        return $arr;
    }

}

?>