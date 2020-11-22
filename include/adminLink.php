<?php
include_once('adminBase.php');
class adminLink extends adminbase {

    public function __construct() {
        parent::__construct ();
    }

    /**
     *
     * 添加flash图片
     */
    public function addImg(){
        $thumb_url = substr($_POST['thumb_url'], 3);
        $datas['url'] = trim($_POST['url']);
        $datas['name'] = trim($_POST['name']);
        $arr = $this->getCityInfo();
        $datas['sign'] = $arr['sign'];
        if($_POST['order']) $datas['orderlist'] = $_POST['order'];
        $rid = $_POST['rid'];
        if($rid){
            if($thumb_url) $datas['img']=$thumb_url;
            $result = $this->db->edit('form__bjhh_link', $datas,"id=$rid" );
            return true;
        } else {
            if(!$thumb_url) return false;
            $datas['img'] = $thumb_url;
            $result = $this->db->add('form__bjhh_link', $datas);
            if($result) return $result;
            else return false;
        }
    }

    /**
     * 获取一条修改信息
     */
    public function getOneInfo(){
        $rid = get_url($_GET['rid']);
        $where = "id=$rid";
        $one = $this->db->get_one('form__bjhh_link',$where);
        if($one) return $one;else return false;
    }

    /**
     *
     * 获取数据
     */
    public function getList($limit){
        $where = "sign='$_SESSION[sign]'";
        $list = $this->db->getall('form__bjhh_link',$where,array(limit=>$limit), $fields = '*',' order by orderlist ASC');
        return $list;
    }

    /**
     * 记录数目
     */
    public function getCount() {
        $where = "sign='$_SESSION[sign]'";
        return $this->db->get_count('form__bjhh_link', $where);
    }

    /**
     *排序
     */
    public function orderInfo(){
        $datas = array();
        $list = $_POST['order'];
        $pid = $_POST['pid'];
        foreach ($list as $key => $val ){
            foreach ($pid as $k=>$v){
                if($k==$key){
                    $datas['orderlist'] = $val;
                    $where = "id=$v";
                    $afferd = $this->db->edit('form__bjhh_link', $datas, $where);
                }
            }
        }
        return true;
    }

    /**
     * 删除一条记录
     */
    public function deleteOneRecord($recordid) {
        $a = "form__bjhh_link";
        $where = "id=$recordid";
        return $this->db->drop($a, $where);
    }
}
