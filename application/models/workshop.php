<?php

class Workshop extends CI_Model {

    public function __construct ()
    {
        parent::__construct();
    }

    public function get_details($workshopid)
    {
        $this->db->select()->from('workshops')->where('workshopid', $workshopid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function get_name($workshopid)
    {
        $temp = $this->get_details($workshopid);
        if ($temp == false) {
            return false;
        } else {
            return $temp->name;
        }
    }

    public function reserve_seat($workshopid)
    {
        $query = $this->db->query("UPDATE `workshops` SET `ccurrent` = `ccurrent`+1 WHERE `workshopid` = ? AND `ccurrent` < `ccapacity`", array($workshopid));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_confirm_capacity($workshopid)
    {
        $temp = $this->get_details($workshopid);
        if ($temp == false) {
            return false;
        } else {
            return $temp->ccapacity;
        }
    }

    public function get_wait_capacity($workshopid)
    {
        $temp = $this->get_details($workshopid);
        if ($temp == false) {
            return false;
        } else {
            return $temp->wcapacity;
        }
    }

    public function remove_zombie_registrations($workshopid) {
        $this->db->delete('wteams', array(''));
    }
    
    public function add_transaction($data) {
        $this->db->insert('campus_transactions', $data);
    }
}