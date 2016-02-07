<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('database');
	}

	public function get($eventid)
	{
		$query = $this->db->select('teamid,ename, status_name AS status, status_code', FALSE)
		->from('teams')
		->join('event_status', 'teams.status = event_status.status_code')
		->where('eventid', $eventid)
		->order_by('time', 'desc')
		->get();
		if($query->num_rows() > 0)
			return $query->result('array');
		else
			return FALSE;
	}

	public function get_user_details($userid)
	{
		$this->db->select('')
		->from('userdata')
		->where(array('userid' => $userid))
		->order_by('creation')
		->limit(1);

		$query = $this->db->get();
		if ($query->num_rows() === 1) {
			return $query->first_row('array');
		} else {
			return false;
		}
	}

	public function status()
	{
		$query = $this->db->select('')
		->from('event_status')
		->get();

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		} else {
			return false;
		}
	}

	public function changestatus($teamid, $newstatus, $eventid)
	{
		$query = $this->db->update('teams', array('status'=> $newstatus), array("teamid" => $teamid, "eventid" => $eventid));
		if($this->db->affected_rows() === 1)
			return TRUE;
		else
			return FALSE;
	}

	public function get_details($teamid, $arr = '')
	{
		$this->db->select()
				 ->from('teams')
				 ->where('teamid', $teamid)
				 ->order_by('time')
				 ->limit(1);
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

}

/* End of file event.php */
/* Location: ./application/modules/managers/models/event.php */