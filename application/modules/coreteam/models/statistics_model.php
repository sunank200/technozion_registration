<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics_model extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_all_workshops()
    {
    	$query = $this->db->get('workshops');
    	$res = array();
	foreach ($query->result_array() as $row) {
	    $res[] = $row;
	}
	return $res;
    }
    
    public function get_all_users($cols)
    {
    	$this->db->select($cols)->from('userdata');
    	$query = $this->db->get();
    	$res = array();
	foreach ($query->result_array() as $row) {
         if($row['sex']==1)
            $row['sex']="Male";
         else if($row['sex']==2)
            $row['sex']="Female";
         else 
            $row['sex']="Not specified";
	    $res[] = $row;
	}
	return $res;
    }
    
    public function get_user($id)
    {
    	$query = $this->db->select()->from('userdata')->where(array('id' => $id));
    	return $query->first_row('array');
    }	
    
    public function get_headings($table)
    {
	return $this->db->list_fields($table);
    }
    
    public function get_headings_workshops()
    {
    	return $this->get_headings('workshops');
    }
    
    public function get_headings_users()
    {
    	return $this->get_headings('userdata');
    }
    
    public function get_reg_count()
    {
    	$this->db->select()->from('userdata')->where('registration', '1');
    	$query = $this->db->get();
    	return $query->num_rows();
    }
    
    public function get_hosp_count($params = array())
    {
    	$params['hospitality'] = '1';
    	$this->db->select()->from('userdata')->where('hospitality', '1');
    	$query = $this->db->get();
    	return $query->num_rows();
    }
    
    public function get_events_count_query()
    {
    	$query = $this->db->query("
    	SELECT 	a.eventid eventid, 
    		a.ename ename, 
    		(SELECT COUNT(*) FROM teams WHERE eventid = a.eventid) total, 
    		(SELECT COUNT(*) FROM teams WHERE eventid = a.eventid AND status = '1') confirmed, 
    		(SELECT COUNT(*) FROM teams WHERE eventid = a.eventid AND NOT status = '1') waiting
    	 FROM events a");
    	return $query;
    }
    
     public function get_workshop_list()
    {
    	$query = $this->db->query("
    	SELECT 	a.eventid eventid, 
    		a.ename ename, 
    		(SELECT COUNT(*) FROM teams WHERE eventid = a.eventid) total, 
    		(SELECT COUNT(*) FROM teams WHERE eventid = a.eventid AND status = '1') confirmed, 
    		(SELECT COUNT(*) FROM teams WHERE eventid = a.eventid AND NOT status = '1') waiting
    	 FROM events a");
    	return $query;
    }
    
    public function get_wteamids()
    {
        $query = $this->db->get('wteams');
        return $query->result('array');
    }
    
}

/* End of file statistics_model.php */
/* Location: ./application/models/statistics_model.php */