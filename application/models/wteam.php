<?php

class Wteam extends CI_Model {

    public function __construct ()
    {
        parent::__construct();
    }

    public function get_details($teamid, $arr = '')
    {
        $this->db->select()->from('wteams')->where('teamid', $teamid)->limit(1);
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
        $this->db->insert("wteams", $teamDetails);
        return $this->db->insert_id();
    }

    public function cancel($teamid)
    {
        return $this->db->delete('wteams', array('teamid' => $teamid));
    }

    public function confirm($teamid) {
        $data['status'] = "5";
        return $this->db->update('wteams', $data, array('teamid' => $teamid));
    }
    
    public function update_count() {
    	$this->db->query('UPDATE workshops b SET b.ccurrent = 
        (SELECT COUNT(*)
        FROM wteams a
        WHERE a.workshopid = b.workshopid 
        AND (a.status = 5 OR (a.status = 4 AND (a.time > DATE_SUB(NOW(), INTERVAL 31 MINUTE)))))');

    }
        
}