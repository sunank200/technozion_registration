<?php

class User extends CI_Model {

    private $salt;

    public function __construct ()
    {
        parent::__construct();
        $this->salt = '$6$rounds=5000$usingashitstringfornidhipasmundra$';
    }

    public function add_tshirt($userid, $size)
    {
        $query = $this->db->insert('tshirts', array('userid' => $userid, 'size' => $size));
        return TRUE;
    }
    public function get_cities(){
        $this->db->select('city')->from('city_lookup');
        $query=$this->db->get();
        if($query->num_rows>0){
            return $query->result();
        }else{
            return false;
        }
    }
    public function get_cityname_mobile($city){
        $this->db->select('city_id')->from('city_lookup')->where(array('city' => $city));
        $query=$this->db->get();
        if($query->num_rows>0){
            return $query->result();
        }else{
            return false;
        }
    }
    public function get_college($cid){
        $sql="select college_id,college from college_lookup where college_id in(select college_id from city_college_new where city_id=$cid);";
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result();
        }return false;
    }

    public function get_college_mobile(){
        $cid = $this->input->post('city');
        $sql="select college_id,college from college_lookup where college_id in(select college_id from city_college_new where city_id=$cid);";
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            echo json_encode($query->result());
        }return false;
    }


    public function check_credentials($credentials)
    {
        $this->db->select('userid, email, password')->from('userauth')->where(array('email' => $credentials['email'], 'password' => crypt($credentials['password'], $this->salt), 'activated' => '0'))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function create($data)
    {
        $userdata = $data;
        unset($userdata['password']);
        $userid = mt_rand(1000000, 9999999);
        $userdata['userid'] = $userid;
        $count = 20;
        // Inserting in userdata
        $this->db->select();
        $this->db->from('userdata');
        $this->db->where(array('email'=>$data['email']));
        $query = $this->db->get();
        if($query->num_rows()>0){
            return false;
        }
        while (!$this->db->insert('userdata', $userdata) && $count>0) {
            $userid = mt_rand(1000000, 9999999);
            $userdata['userid'] = $userid;
            $count--;
        }
        if ($count == 0) {
            return false;
        }
        // inserting in userauth
        $userdata = array();
        $userdata['userid'] = $userid;
        $userdata['email'] = $data['email'];
        $userdata['ipaddress'] = $data['ipaddress'];
        $userdata['password'] = crypt($data['password'], $this->salt);
        return $this->db->insert('userauth', $userdata);
    }

     public function update_password($new, $code, $userid, $email)
     {
        $data = array(
            "ipaddress" => $this->input->ip_address(),
            "password" =>crypt($new, $this->salt),
            "forgot_password" =>'0'
            );

        $where_data = array(
            'forgot_password' => $code,
            'userid' => $userid,
            'email' => $email
            );

      $query = $this->db->update('userauth', $data, $where_data);
      if($this->db->affected_rows() === 1)
        return TRUE;
      else
        return FALSE;

     }

    public function get_details($userid)
    {
        $this->db->select('')->from('userdata')->where(array('userid' => $userid))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() === 1) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function get_team_details($userids =array())
    {
        $this->db->select('')->from('userdata')->where_in('userid', $userids);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result('array');
        } else {
            return false;
        }
    }

    public function get_name($userid)
    {
        $this->db->select('name')->from('userdata')->where('userid', $userid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->first_row()->name;
        } else {
            return false;
        }
    }

    public function get_teams_events($userid)
    {
        $this->db->select('teamid')->from('userevents')->where('userid', $userid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_teams_workshops($userid)
    {
        $this->db->select('teamid')->where('userid', $userid);
        $query = $this->db->get('userworkshops',1);
        return $query->result_array();
    }

    public function in_event($userid, $eventid)
    {
        $query = $this->db->get_where('userevents', array('userid' => $userid, 'eventid' => $eventid));
        return $query->num_rows();
    }

    public function in_workshop($userid, $workshopid)
    {
        $query = $this->db->get_where('userworkshops', array('userid' => $userid, 'workshopid' => $workshopid));
        return $query->num_rows();
    }

    public function add_team_events($userid, $eventid, $teamid)
    {
        return $this->db->insert('userevents',
                            array("userid" => $userid,
                                "teamid" => $teamid,
                                "eventid" => $eventid));
    }

    public function add_team_workshops($userid, $workshopid, $teamid)
    {
        return $this->db->insert('userworkshops',
                                array("userid" => $userid,
                                    "teamid" => $teamid,
                                    "workshopid" => $workshopid));
    }

    public function remove_team_events($userid, $teamid, $eventid)
    {
         return $this->db->delete('userevents',
                            array("userid" => $userid,
                                "teamid" => $teamid,
                                "eventid" => $eventid));
    }

    public function remove_team_workshops($userid, $teamid, $workshopid)
    {
         return $this->db->delete('userworkshops',
                            array("userid" => $userid,
                                "teamid" => $teamid,
                                "workshopid" => $workshopid));
    }

    public function add_hospitality($userid)
    {
        $data['hospitality'] = 1;
        return $this->db->update('userdata', $data, array('userid' => $userid));
    }

    public function get_registration($userid)
    {
        $this->db->select('registration')->from('userdata')->where(array('userid' => $userid))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() === 1) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function add_registration($userid)
    {
        $data['registration'] = 1;
        return $this->db->update('userdata', $data, array('userid' => $userid));
    }

    public function remove_hospitality($userid)
    {
        $data['hospitality'] = 0;
        return $this->db->update('userdata', $data, array('userid' => $userid));
    }

    public function remove_registration($userid)
    {
        $data['registration'] = 0;
        return $this->db->update('userdata', $data, array('userid' => $userid));
    }

    public function num_registration($userids = array())
    {        
        $this->db->select()->from('userdata')->where('registration', '1')->where_in('userid', $userids);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function num_hospitality($userids = array())
    {
        $this->db->select()->from('userdata')->where('hospitality', '1')->where_in('userid', $userids);
        $query = $this->db->get();
        return $query->num_rows();
    }
    

    public function get_userid($email)
    {
        $this->db->select('userid')->from('userdata')->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() <= 0) {
            return FALSE;
        }
        return $query->first_row()->userid;
    }
    
    public function exists($userid)
    {
        $this->db->select('userid')->from('userdata')->where('userid', $userid);
        $query = $this->db->get();
        if ($query->num_rows() !== 1) {
            return false;
        } else {
            return true;
        }
    }
    public function update_user_profile($data,$userid){
        $this->db->where(array('userid'=>$userid));
        $query = $this->db->update('userdata',$data);
        if($this->db->affected_rows()<=0){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function profile_fill_check($userid){
        $this->db->select();
        $this->db->where("(`phone` = '0' OR `college` = '0' OR `collegeid` = '0' OR `city` = '0' OR `state` = '0' OR `sex`= 0) AND `userid` = ".$userid);
        $this->db->from('userdata');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /*
    public function create_old($data)
    {
        $userdata = $data;
        unset($userdata['password']);
        $userid = mt_rand(1000000, 9999999);
        $userdata['userid'] = $userid;
        $count = 20;
        // Inserting in userdata
        while (!$this->db->insert('userdata', $userdata) && $count>0) {
            $userid = mt_rand(1000000, 9999999);
            $userdata['userid'] = $userid;
            $count--;
        }
        if ($count == 0) {
            return false;
        }
        // inserting in userauth
        $userdata = array();
        $userdata['userid'] = $userid;
        $userdata['email'] = $data['email'];
        $userdata['ipaddress'] = $data['ipaddress'];
        $userdata['password'] = crypt($data['password'], $this->salt);
        if (!$this->db->insert('userauth', $userdata)) {
            return false;
        }
        // inserting in userevents
        $userdata = array();
        $userdata['userid'] = $userid;
        return $this->db->insert('userevents', $userdata);
    }

    public function get_teams_events_old($userid)
    {
        $this->db->select('teamids')->from('userevents')->where('userid', $userid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return json_decode($query->first_row()->teamids, true);
        } else {
            return false;
        }
    }

    public function in_event_old($userid, $eventid)
    {
        $this->db->select()->from('userevents')->where('userid', $userid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $details = $query->first_row();
            $eids = json_decode($details->eventids, true);
            if (is_null($eids)) {
                return 0;
            }
            if (array_search($eventid, $eids) !== false) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }

    public function add_team_old($userid, $teamid, $eventid)
    {
        $this->db->select()->from('userevents')->where('userid', $userid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $details = $query->first_row();
            $tids = json_decode($details->teamids, true);
            $eids = json_decode($details->eventids, true);
            if (in_array($teamid, $tids) || in_array($eventid, $eids)) {
                return false;
            }
            array_push($tids, $teamid);
            array_push($eids, $eventid);
            $tidsJson = json_encode($tids);
            $eidsJson = json_encode($eids);
            $newDetails["teamids"] = $tidsJson;
            $newDetails["eventids"] = $eidsJson;

            if ($this->db->update('userevents', $newDetails, array('userid' => $userid))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function remove_team_old($userid, $teamid, $eventid)
    {
        $this->db->select()->from('userevents')->where('userid', $userid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $details = $query->first_row();
            $tids = json_decode($details->teamids, true);
            $eids = json_decode($details->eventids, true);
            if (in_array($teamid, $tids) || in_array($eventid, $eids)) {
                return false;
            }
            if (($key = array_search($teamid, $tids)) !== false) {
                unset($tids[$key]);
            }
            if (($key = array_search($eventid, $eids)) !== false) {
                unset($eids[$key]);
            }
            $tidsJson = json_encode($tids);
            $eidsJson = json_encode($eids);
            $newDetails["teamids"] = $tidsJson;
            $newDetails["eventids"] = $eidsJson;

            if ($this->db->update('userevents', $newDetails, array('userid' => $userid))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // */

}