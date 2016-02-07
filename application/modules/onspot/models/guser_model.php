<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guser_model extends CI_Model {

    private $salt;

    public function __construct()
    {
        parent::__construct();
        $this->salt = '$6$rounds=5000$usingashitstringfornidhipasmundra$';
    }

    public function get_tzid($type, $value)
    {
        $this->db->select('userid')->from('userdata')->where($type, $value);
        $query = $this->db->get();
        if ($query->num_rows() !== 1) {
            return false;
        } else {
            return $query->first_row()->userid;
        }
    }

    public function create($data)
    {
        $stat['status'] = FALSE;
        $stat['userid'] = -1;

        // Checking email duplicate
        $this->db->select()->from('userdata')->where('email', $data['email']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $stat['message'] = "email ".$data['email']." already exists";
            return $stat;
        }
        // Checking phone duplicate
        $this->db->select('')->from('userdata')->where('phone', $data['phone']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $stat['message'] = "phone ".$data['phone']." already exists";
            return $stat;
        }

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
            $stat['message'] = 'Technozion ID error. Please try again.';
            return $stat;
        }
	
        // inserting in userauth table
        $userdata = array();
        $userdata['userid'] = $userid;
        $userdata['email'] = $data['email'];
        $userdata['ipaddress'] = $data['ipaddress'];
        $userdata['password'] = crypt($data['password'], $this->salt);
        $query =  $this->db->insert('userauth', $userdata);

        if($this->db->affected_rows() === 1) {
            $stat['userid'] = $userid;
            $stat['status'] = TRUE;
            $stat['message'] = 'Successfully created account. Userid: '.$userid;
        } else {
            $stat['message'] = 'Error inserting in userauth table. Try again';
        }
        return $stat;

    }
    
    public function edit($userid, $name)
    {
        $this->db->update('userdata', array('name' => $name), array('userid' => $userid));
        if ($this->db->affected_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function set_nitw($userid)
    {
    	$this->db->update('userdata', array('registration' => '1', 'nitw' => '1'), array('userid' => $userid));
        if ($this->db->affected_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

}