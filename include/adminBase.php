<?php
/**
 *
 * 管理员基础类
 */
include_once('Xxtea.php');

class adminBase
{

    public $db;
    public $xxtea;

    public function __construct()
    {
        global $db;
        $this->db = $db;
        $this->xxtea = new Xxtea ();
		
        /*$_SESSION ['sign']="www";
        $_SESSION ['areaid']="100001";
        $_SESSION ['fid']="1";
        $_SESSION ['cityname']="北京";
        $_SESSION ['admin_identify']="Izv6uWkg0h5e10XNQQ6Pqsu9AMZCYSuR";*/
        if (!$this->checkAdminLogin()) {
            $db->get_show_msg("adminlogin.php", "没有登录！！！");
        }
        $action = substr($_SERVER[PHP_SELF], strrpos($_SERVER[PHP_SELF], "/") + 1, -4);
        $arrurl = array(adminDownload, dic, adminLogs, fastChannel);
        if ($this->getUserName() != 'admin') {
            if (in_array($action, $arrurl)) {
                $db->get_show_msg("javascript:history.back(0);", "操作有误！");
            }
        }
    }

    /**
     *
     *判断用户是否登录
     */
    public function checkAdminLogin()
    {
        if (isset ($_SESSION ['admin_identify']) && $_SESSION ['admin_identify']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得当前登录用户名
     */
    public function getUserName()
    {
        $uinfo = $this->xxtea->parseLoginIdentify($_SESSION ['admin_identify']);
        return $uinfo [1];
    }

    /**
     * 获得当前登录用户信息
     */
    public function getUser()
    {
        $uinfo = $this->xxtea->parseLoginIdentify($_SESSION ['admin_identify']);
        return $uinfo;
    }

    /**
     * 获取当前登录用户 总会/省/市 信息
     * @return array $arr 例:Array([sign]=>www,[parentid]=>0,[areaid]=>1)
     */
    public function getCityInfo()
    {
        $useInfo = array();
        $adminInfo = array();
        $arr = array();
        $useInfo = $this->xxtea->parseLoginIdentify($_SESSION ['admin_identify']);
        //超级管理员查看各省数据
        if ($useInfo[1] == 'admin') {
            $arr ['sign'] = 'www';
            $arr ['parentid'] = 0;
            $arr ['areaid'] = 1;
            $arr ['def'] = 1;
        } else {
            $adminInfo = $this->db->get_one('form__bjhh_admin', "u_name='{$useInfo[1]}'");
            $arr ['sign'] = $adminInfo ['sign'];
            $arr ['parentid'] = $adminInfo ['parentid'];
            $arr ['areaid'] = $adminInfo ['areaid'];
            $arr ['def'] = $adminInfo ['def'];
        }
        return $arr;
    }

    /**
     * 获取当前登录用户权限
     * @return boolean true|false 用户权限标识
     */
    public function getUserAuthority()
    {
        /*
         * 地区分级：总会、省、市
         * 需求：总会可以查看所有 省可以查看市 市只能查看市
         * 注意：不可以越级查看
         * */
        /*********初始化数据 开始********************/

        $userCity = array(); //当前登录用户 总会/省/市 信息
        $sysCity = array(); //当前网站 总会/省/市 信息
        $sysCity ['sign'] = $_SESSION ['sign'];
        $sysCity ['areaid'] = $_SESSION ['areaid'];
        $sysCity ['parentid'] = $_SESSION ['fid'];
        $sysCity ['cityname'] = $_SESSION ['cityname'];
        $userCity = $this->getCityInfo();

        /*********初始化数据 结束********************/

        if (($userCity ['sign'] === $sysCity ['sign']) && ($userCity ['areaid'] === $sysCity ['areaid']) && ($userCity ['parentid'] === $sysCity ['parentid'])) {
            return true;  //修改
        } else {
            return false; //只能查看
        }

    }


    /**
     * 获取当前组织
     * $areaid
     */
    public function getcurorganization($areaid)
    {
        if (!$areaid) return false;
        $data = $this->db->get_one(form__bjhh_area, "areaid={$areaid}", 'areaid,name,sign,parentid,stt');
        return $data;
    }

    /**
     * 获取当前组织和 下级组织机构
     * $areaid
     */
    public function getorganization($areaid)
    {
        if (!$areaid) return false;
        $level[] = $this->db->get_one(form__bjhh_area, "areaid={$areaid}", 'areaid,name,sign,parentid');
        $nlevel = $this->db->getall(form__bjhh_area, "parentid={$areaid}", $limit = array(limit => '0,9999999'), 'areaid,name,sign,parentid', ' order by listorder asc');
        if ($nlevel) $level = array_merge($level, $nlevel);
        return $level;
    }


    public function _getOrganization($areaid)
    {
        if (!$areaid) return false;
        $nlevel = $this->db->getall(form__bjhh_area, "parentid={$areaid}", $limit = array(limit => '0,9999999'), 'areaid,sign,name,parentid', '');
        return $nlevel;
    }

    public function _getOrganizationBySign($sign)
    {
        if (!$sign) return false;
        $area_info = $this->db->get_one(form__bjhh_area, "sign='{$sign}'", 'areaid,name,sign,parentid');
        if(empty($area_info)){
            return false;
        }
        $nlevel = $this->db->getall(form__bjhh_area, "parentid={$area_info['areaid']}", $limit = array(limit => '0,9999999'), 'areaid,sign,name,parentid', '');
        return $nlevel;
    }

    /**
     * 无限极获取当前组织 和 下级组织机构,返回sign数组
     */
    public function getOrganizationSigns(&$signs, $areaid, $sign)
    {
        if (empty($sign)) {
            $data = $this->db->get_one(form__bjhh_area, "areaid={$areaid}", 'sign');
            if (!empty($data)) {
                $sign = $data['sign'];
            }
        }
        if ($sign) {
            $signs[] = $sign;
        }
        $areas = $this->_getOrganization($areaid);

        if ($areas) {
            $len = count($areas);
            for ($i = 0; $i < $len; $i++) {
                $area = $areas[$i];
                if ($area['stt'] < 3) {
                    $this->getOrganizationSigns($signs, $area['areaid'], $area['sign']);
                } else {
                    $signs[] = $area['sign'];
                }
            }
        }

    }

    /**
     * 人员编码
     */
    public function pcode($uid)
    {
        if (!$uid) return false;
        $cinfo = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=$uid", "applytime,sex,birthday,sign,sdomain");
        if (!$cinfo) return false;
        $porder = $this->db->get_one('form__bjhh_porder', "sign='$cinfo[sign]'", "max(porder) as a");
        $acode = $this->db->get_one("form__bjhh_area", "sign='$cinfo[sign]'", 'listorder');
        if (!$acode) return false;
        $pdatas = array();
        $pdatas[uid] = $uid;
        $pdatas[sign] = $cinfo[sign];
        $pdatas[porder] = sprintf("%05d", $porder[a] + 1);
        $precord = $this->db->add('form__bjhh_porder', $pdatas);
        if (!$precord) return false;
        //6+4+4+1+2+5
        $hnumber = $acode[listorder] . date("Y", $cinfo['applytime']) . date("Y", $cinfo['birthday']) . $cinfo[sex] . $cinfo[sdomain] . $pdatas[porder];
        $res = $this->db->edit("form__bjhh_volunteermanage_volunteerbasicinfo", "hnumber=$hnumber", "recordid=$uid");
        if ($res) return true;
    }

    /**
     *
     * 获得返回地址
     * @param  $url 如果没有$_SERVER['HTTP_REFERER']就返回$url;
     */
    public function getBackUrl($url)
    {
        return $_SERVER ['HTTP_REFERER'] ? $_SERVER ['HTTP_REFERER'] : $url;
    }

    /**
     * 操作日志
     * $data=>array('module'=>1,'type'=>10,'name'=>'操作对象');
     * 志愿者初审->初审通过
     */
    public function doLog($data)
    {
        if (!$data) return false;
        //动作操作日志
        $tag = array();
        //志愿者初审
        $tag[1] = '志愿者初审';
        $tag[10] = '初审通过';
        $tag[11] = '初审拒绝';
        //志愿者管理
        $tag[2] = '志愿者管理';
        $tag[20] = '批量导出志愿者';
        $tag[21] = '批量导入志愿者';
        $tag[22] = '添加志愿者';
        $tag[23] = '通过终审';
        $tag[24] = '工时调整';
        $tag[25] = '注销志愿者';
        $tag[26] = '激活志愿者';
        $tag[27] = '删除志愿者';
        //队长管理
        $tag[3] = '队长管理';
        $tag[30] = '设置为队长';
        $tag[31] = '取消队长职务';
        //活动审核
        $tag[4] = '活动审核';
        $tag[40] = '活动批量通过';
        $tag[41] = '活动批量拒绝';
        //服务队管理
        $tag[5] = '服务队管理';
        $tag[50] = '服务队批量通过';
        $tag[51] = '服务队批量拒绝';
        $tag[52] = '添加服务队';
        $tag[53] = '修改服务队';
        $tag[54] = '注销服务队';
        //评优管理
        $tag[6] = '评优管理';
        $tag[60] = '添加评优';
        $tag[61] = '修改评优';
        //管理员管理
        $tag[7] = '管理员管理';
        $tag[70] = '添加管理员';
        $tag[71] = '删除管理员';
        $tag[72] = '修改管理员密码';
        //联系方式
        $tag[8] = '联系方式';
        $tag[80] = '修改联系方式';
        //关于我们
        $tag[9] = '关于我们';
        $tag[90] = '修改关于我们';
        $userinfo = $this->getUser();
        $cityinfo = $this->getCityInfo();
        $logs = array();
        $logs['logintime'] = date("Y-m-d H:i:s", time());
        $logs['sign'] = $cityinfo['sign'];
        $logs['loginip'] = get_ip();
        $logs['username'] = $userinfo['1'];
        $logs['type'] = $tag[$data[type]];
        $logs['module'] = $tag[$data[module]];
        $logs['remark'] = $logs['username'] . "于" . $logs['logintime'] . "操作:" . $logs['module'] . "<br/>结果：";
        if ($data[name]) $logs['remark'] .= $data[name] . "->";
        $logs['remark'] .= $logs['type'];
        $this->db->add("form__bjhh_loginlog", $logs);
    }
}

?>