<?php
/*
 * HUANGCHUNHAI
 */
include_once("user.php");

class UserTimeUpdate extends user
{
    public function __construct($ajax = false)
    {
        parent::__construct();
        if (!$ajax) {
            $_user = $this->checkCaptain();
            if (!$_user) {
                $this->db->get_show_msg($this->getBackUrl("userIndex.php"), "不是队长不能访问！");
            }
        }
    }

    public function updateTime($t_ttime, $r_reason, $hidden_time)
    {
        foreach ($t_ttime as $key => $val) {
            $status = (int)$val - (int)$hidden_time[$key];
            if ($status != "0") {
                $person1 = $this->db->get_one('form__bjhh_activity_personadd', "recordID=" . $key);
                if ($person1[pid]) {
                    $person2 = $this->db->get_one('form__bjhh_volunteermanage_volunteerbasicinfo', "recordid=" . $person1['pid']);
                    $servertime = $person2[allservertime] + $status;
                    $this->db->edit('form__bjhh_volunteermanage_volunteerbasicinfo', "allservertime=" . $servertime, "recordid=" . $person1['pid']);
                }
            }
            $this->db->edit('form__bjhh_activity_personadd', "time=" . $val . ",reason='" . $r_reason[$key] . "'", "recordID=" . $key);
        }


        return true;

    }
}

?>