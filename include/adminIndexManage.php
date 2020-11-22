<?php
include_once('adminBase.php');
include(INCLUDE_PATH . "search.php");

/**
 *
 * 主页管理
 */
class adminIndexManage extends adminbase
{
    private $search;

    public function __construct()
    {
        parent::__construct();
        $this->search = new Search ();
    }

    public function init()
    {

        return $this->db->getall('form__bjhh_column', "category=1");

    }

    public function initDisaster()
    {
        return $this->db->getall('form__bjhh_column', "category=3");
    }

    public function initVolunteerService()
    {

        return $this->db->getall('form__bjhh_column', "category=2");

    }

    public function news($rid, $limit)
    {
        $where = "fid=$rid and sign='{$_SESSION['sign']}'";
        $this->count = $this->db->get_count('form__bjhh_news', $where);
        return $this->db->getall('form__bjhh_news', $where, array('limit' => $limit), '*', " order by recordid DESC ");
    }

    public function getCount()
    {
        return $this->count;
    }

    public function fTitle($rid)
    {

        return $this->db->get_one('form__bjhh_column', "recordid=" . $rid);

    }

    public function zTitle($rid)
    {

        return $this->db->get_one('form__bjhh_news', "recordid=" . $rid);

    }

    public function editTitle($rid, $name)
    {
        $datas ['name'] = $name;
        $this->db->edit('form__bjhh_column', $datas, "recordid=" . $rid);
        return true;
    }

    public function editNews($post)
    {
        $datas ['title'] = $post ['title'];
        $datas ['pictures'] = $post ['thumb_url'];
        $datas ['editTime'] = time();
        $datas ['content'] = jsformat($post ['content']);
        $datas ['status'] = isset($post ['status']) ? $post ['status'] : 0;
        $datas ['flag'] = isset($post ['flag']) ? $post ['flag'] : 0;
        $res = $this->db->edit('form__bjhh_news', $datas, "recordid=" . $post ['rid']);
        $this->search->updateInfo('3', $post ['rid']);
        return $res;
    }

    public function deleteNews($id)
    {
        $this->search->delInfo('3', $id);
        return $this->db->drop('form__bjhh_news', "recordid=" . $id);
    }

    public function addNews($post)
    {
        //获取当前登录用户 总会/省/市 信息
        $arr = array();
        $arr = $this->getCityInfo();

        $datas ['fid'] = $post ['rid'];
        $datas ['pictures'] = $post ['thumb_url'];
        $datas ['content'] = jsformat($post ['content']);
        $datas ['title'] = $post ['title'];
        $datas ['createTime'] = time();
        $datas ['editTime'] = time();
        $user = $this->getUser();
        $datas ['creator'] = $user ['1'];
        $datas ['sign'] = $arr ['sign'];
        $datas ['status'] = isset($post ['status']) ? $post ['status'] : 0;
        $datas ['flag'] = isset($post ['flag']) ? $post ['flag'] : 0;
        $insert_id = $this->db->add('form__bjhh_news', $datas);
        $this->search->addInfo('3', $insert_id);
        return $insert_id;
    }

    public function deleteColumn($id)
    {
        $this->db->drop('form__bjhh_news', "fid=" . $id);
        return $this->db->drop('form__bjhh_column', "recordid=" . $id);
    }

}

?>