<?php

class Event extends CI_Model {

    public function __construct ()
    {
        parent::__construct();
    }

    public function get_details($eventid)
    {
        $this->db->select()->from('events')->where('eventid', $eventid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function get_name($eventid)
    {
        $temp = $this->get_details($eventid);
        if ($temp == false) {
            return false;
        } else {
            return $temp.name;
        }
    }
}
