<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managers_old extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/ion_auth');
		$this->load->library('form_validation');
		$this->load->model('managers_old/event_old');
		$this->load->helper(array('url'));
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif ($this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			redirect('auth/index', 'refresh');
		}

	}

	public function index()
	{
		  // Getting teams a user is reg in
		$data['details'] = $this->event_old->get('1');
		$data['status'] = $this->event_old->status();
		//list of all the teamids who are in a particular event
		$eventids =  $this->event_old->get($this->session->userdata('user_id'));
		//if($eventids === FALSE)
			//show_error('Invalid Event Manager');
		//$teams contains all the teamdetails who are in particular events
		$teams = array();
       
       if($eventids !=FALSE)
		  foreach ($eventids as $index => $eventid) 
		  {
			//get one team id among the list of teamids in $events variable
			$teamid = $eventid["teamid"];

			//get all the details of the team including team member userids
			$teamDetails = $this->event_old->get_details($teamid, 'array');

			//preapare array whose content is the actual output of this index funtion and the one which we want
			$teams[$teamid] = array("teamid"=>$teamDetails['teamid'], "status" => $eventid["status"],"status_code" => $eventid["status_code"], "timestamp" => $teamDetails['time']);

			//create user list array i.e. from each userid get all user details and store it in our require array hooooooooooo :)

			//create empty array list of user i.e. initialize bhai :)
			$teams[$teamid]["users"] = array();

			//tsize is not t-shirt size but teamsize :p			
			for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
				// array_push($teams[$teamid]["users"], $teamDetails['user'.$i.'id']);
				array_push($teams[$teamid]["users"], $this->event_old->get_user_details($teamDetails["user".$i."id"]));
			}
		}


        $data['teams'] = $teams;
        $data['eventids'] = $eventids;
       // $this->load->view('base/header', $data);
		$this->load->view('myevent', $data);
       // $this->load->view('base/footer', $data);
	}

	public function changestatus($teamid = '')
	{
		if(empty($teamid))
			show_error('Invalid User ID');
		$this->form_validation->set_rules('changestatus', 'New Status', 'trim|required');

		if($this->form_validation->run() === TRUE){
			if($this->event_old->changestatus($teamid,$this->input->post('changestatus') ,$this->session->userdata('user_id')) === TRUE)
				{echo "1"; return;}
			else
				{echo "0"; return;}
		}
		else
		{
			echo "0";
			return;
		}
	}

}

/* End of file managers.php */
/* Location: ./application/modules/managers/controllers/managers.php */