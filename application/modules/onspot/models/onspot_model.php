<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onspot_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->salt = '$6$rounds=5000$usingashitstringfornidhipasmundra$';
	}

	public function create($data)
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
			return FALSE;
		}
        // inserting in userauth table
		$userdata = array();
		$userdata['userid'] = $userid;
		$userdata['email'] = $data['email'];
		$userdata['ipaddress'] = $data['ipaddress'];
		$userdata['password'] = crypt($data['password'], $this->salt);
		$query =  $this->db->insert('userauth', $userdata);
		if($this->db->affected_rows() === 1)
			return $userid;
		else
			return FALSE;
	}
	

}

/* End of file onspot_model.php */
/* Location: ./application/models/onspot_model.php */