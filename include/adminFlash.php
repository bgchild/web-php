<?php
include_once('adminBase.php');

/**
 *
 * 主页flash管理
 */
class adminFlash extends adminbase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * 添加flash图片
     */
    public function addImg()
    {
        $thumb_url = substr($_POST['thumb_url'], 3);
        $datas['url'] = trim($_POST['url']);
        $datas['name'] = trim($_POST['name']);
        $arr = $this->getCityInfo();
        $datas['sign'] = $arr['sign'];
        if ($_POST['order']) $datas['orderlist'] = $_POST['order'];
        $rid = $_POST['rid'];
        if ($rid) {
            if ($thumb_url) $datas['img'] = $thumb_url;
            $result = $this->db->edit('form__bjhh_flash', $datas, "id=$rid");
            return true;
        } else {
            if (!$thumb_url) return false;
            $datas['img'] = $thumb_url;
            $result = $this->db->add('form__bjhh_flash', $datas);
            if ($result) return $result;
            else return false;
        }
    }

    /**
     * 获取一条修改信息
     */
    public function getOneInfo()
    {
        $rid = get_url($_GET['rid']);
        $where = "id=$rid";
        $one = $this->db->get_one('form__bjhh_flash', $where);
        if ($one) return $one; else return false;
    }

    /**
     *
     *  生成xml文件
     */
    public function makexml($num)
    {
        //打开 写入 关闭xml文件
        $arr = $this->getCityInfo();
        $fp = fopen("../xml/" . $arr['sign'] . ".xml", w);
        $aa = "<?xml version=\"1.0\" encoding=\"utf-8\"?><root imageWidth='500' imageHeight='265'>";
        $arr = $this->getflash($num);
        foreach ($arr as $val) {
            $bb .= "<menu url=\"$val[url]\" frame=\"_parent\" imageUrl=\"$val[img]\"/>";
        }
        $cc = "</root>";
        $content = $aa . $bb . $cc;
        fwrite($fp, $content);
    }

    /**
     *
     * 获取数据
     */
    public function getflash($limit)
    {
        $where = "sign='$_SESSION[sign]'";
        $flashinfo = $this->db->getall('form__bjhh_flash', $where, array(limit => $limit), $fields = '*', ' order by orderlist ASC');
        return $flashinfo;
    }

    /**
     *排序
     */
    public function orderInfo()
    {
        $datas = array();
        $list = $_POST['order'];
        $pid = $_POST['pid'];
        foreach ($list as $key => $val) {
            foreach ($pid as $k => $v) {
                if ($k == $key) {
                    $datas['orderlist'] = $val;
                    $where = "id=$v";
                    $afferd = $this->db->edit('form__bjhh_flash', $datas, $where);
                }
            }
        }
        return true;

    }

    /**
     * 删除一条记录
     */
    public function deleteOneRecord($recordid)
    {
        $a = "form__bjhh_flash";
        $where = "id=$recordid";
        return $this->db->drop($a, $where);
    }
}

?>