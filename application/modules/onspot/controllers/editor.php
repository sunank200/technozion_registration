<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/ion_auth');
		$this->load->library('form_validation');
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->in_group('verification', $this->ion_auth->get_user_id()))
		{
			redirect('auth/index', 'refresh');
		}

	}

	public function index()
	{
		$this->_render_page('onspot/verification/index');
	}

	public function find()
	{
		$userid = $this->input->post('userid');
		redirect('onspot/verification/userid/'.$userid);
	}


	public function userid($userid = '')
	{
		$this->load->model('user');
		$this->load->model('team');
		$this->load->model('wteam');
		if(empty($userid) || !is_numeric($userid))
			show_error("Invalid Technozion ID");
		$user = $this->user->get_details($userid);
		$data['user'] = $user;
		$receipt = $this->editor_model->get_receipt_details($userid);
		if($receipt !== FALSE)
			if($receipt->verify === '1')
			{
				$this->session->set_flashdata('danger', 'The user is already verified. You are not authorize to get his details');
				redirect('onspot/editor', 'refresh');
				return;
			}
		//no neeed of event registration status
        //workshop team
			$wteamids = $this->user->get_teams_workshops($userid);
			$wteams = array();
			$count = 0;
			foreach ($wteamids as $index => $teamid) {
				$teamid = $teamid["teamid"];
				$teamDetails = $this->wteam->get_details($teamid, 'array');
				$wteams[$teamid] = array("workshopName" => $teamDetails["wname"],
					"status" => $teamDetails["status"]);
				if ($teamDetails["status"] === "5") {
					$count++;
				}
				$wteams[$teamid]["users"] = array();
				for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
					array_push($wteams[$teamid]["users"], $teamDetails["user".$i."name"]);
				}
			}
			$data['wteams'] = $wteams;
			$data['workshops'] = $this->user->get_teams_workshops($userid);
			$data['transactions'] = $this->editor_model->get_transaction($userid);
			$this->_render_page('onspot/editor/index', $data);
		}

		function _render_page($view, $data=null, $render=false)
		{
			$this->viewdata = (empty($data)) ? $data: $data;
			$view_html = array( 
				$this->load->view('onspot/menu/header', $data, $render),
			$this->load->view($view, $this->viewdata, $render),  //main content view
			$this->load->view('onspot/menu/footer', $data, $render)
			);
			if (!$render) return $view_html;
		}


		public function verify()
		{
			$this->form_validation->set_rules('userid', 'User Id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('receipt', 'Receipt Id', 'trim|required|xss_clean|is_unique[campus_registration.receiptid');
			$this->form_validation->set_rules('roomno', 'Room Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('extra_amount', 'Extra Amount', 'trim|required|ctype_digit|xss_clean');
			$this->form_validation->set_rules('remark', 'remark', 'trim|required|xss_clean');
			$this->form_validation->set_rules('verify', 'Verification', 'trim|required|xss_clean');

			if($this->form_validation->run() === FALSE)
			{
			//repopulate
				$this->session->set_flashdata('danger', validation_errors());
				redirect('onspot/verification/userid/'.$userid, 'refresh');
			}
			else
			{
				$goodies = ($this->input->post("goodies") ? "1" : "0");
				$hospitality = ($this->input->post("hospitality") ? "1" : "0");
				$registration = ($this->input->post("registration") ? "1" : "0");
				$current_registration = $this->input->post("cregistration");
				$current_hospitality = $this->input->post("chospitality");
				$userid = $this->input->post('userid');
			//update user registation details on website
				$this->load->model('editor_model');
				if($current_registration  !== $registration)
				{
					$this->editor_model->change_registration($userid, $registration);
				}
			//update user hospitality details on website
				if($current_hospitality !== $hospitality)
				{
					$this->editor_model->change_hospitality($userid, $hospitality);
				}
			//make verification count 1;
				$verify = "1";

				if($this->editor_model->save_verified_data($this->input->post('receipt'), $this->input->post('userid'), $this->input->post('roomno'), $goodies, $this->input->post('extra_amount'), $this->input->post('remark'), $verify, $hospitality, $registration, $this->ion_auth->get_user_id() ) === TRUE)
				{
					$this->session->set_flashdata('success', 'The User Profile is verified');
					redirect('onspot/verification/userid/'.$userid);
				}
				else
				{
					$this->session->set_flashdata('danger', 'ops some error occured try again');
					redirect('onspot/verification/userid/'.$userid);
				}
			}
		}
	}

	/* End of file managers.php */
/* Location: ./application/modules/managers/controllers/managers.php */