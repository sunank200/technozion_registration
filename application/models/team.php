<?php

class Team extends CI_Model {

    public function __construct ()
    {
        parent::__construct();
    }

    public function get_details($teamid, $arr = '')
    {
       $this->db->select()
                 ->from('teams')
                 ->where('teamid', $teamid)
                 ->limit(1)
                 ->join('event_status', 'teams.status = event_status.status_code');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            if ($arr === 'array') {
                return $query->first_row('array');
            } else {
                return $query->first_row();
            }
        } else {
            return false;
        }
    }

    public function create($teamDetails)
    {
        $this->db->insert("teams", $teamDetails);
        return $this->db->insert_id();
    }

    public function update_status($teamid, $status)
    {
        $this->db->update('teams', array('status' => $status), array('teamid' => $teamid));
    }
}