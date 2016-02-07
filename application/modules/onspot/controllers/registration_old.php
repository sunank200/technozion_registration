<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/ion_auth');
		$this->load->library('form_validation');
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		if (!$this->ion_auth->in_group('registration', $this->ion_auth->get_user_id()))
		{
			redirect('auth/index', 'refresh');
		}

	}

	public function index()
	{
	redirect('onspot/accounts/test', 'refresh');
	//		$this->_render_page('onspot/onspot_registration');
		
			}

	/*public function register()
	{

		$this->form_validation->set_rules('Name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email|xss_clean|is_unique[userdata.email]');
		$this->form_validation->set_rules('Phone', 'Phone Number', 'trim|required|min_length[10]|xss_clean');
		$this->form_validation->set_rules('College', 'College', 'trim|required|xss_clean');
		$this->form_validation->set_rules('CollegeId', 'College Id', 'trim|required|xss_clean');
		$this->form_validation->set_rules('City', 'City', 'trim|required|xss_clean');
		$this->form_validation->set_rules('State', 'State', 'trim|required|xss_clean');

		if($this->form_validation->run() === TRUE)
		{
			$details['name'] = $this->input->post('Name');
			$details['email'] = $this->input->post('Email');
			$details['phone'] = $this->input->post('Phone');
			$details['college'] = $this->input->post('College');
			$details['collegeid'] = $this->input->post('CollegeId');
			$details['city'] = $this->input->post('City');
			$details['state'] = $this->input->post('State');
			$details['password'] = $this->input->post('Password');
			$details['ipaddress'] = $this->input->ip_address();
			$details['registered_by'] = $this->ion_auth->get_user_id();
			$registration  = ($this->input->post('registration') ? "1" : "0");
			$details['registration'] = $registration;
			$details['onspot'] = '1';
			$this->load->model('onspot/onspot_model');
			//echo print_r($details);
			//echo $this->onspot_model->create($details);
			$result = $this->onspot_model->create($details);
			if ( $result === FALSE) {
				$stat['status']='0';
				$stat['userid'] = "Invalid Technozion ID";
				
			} else {
				$stat['status']='1';
				$stat['userid'] = $result;
			}
			$this->_render_page('onspot/onspot_registration', $stat);
		}
		else
		{
			$this->_render_page('onspot/onspot_registration');
		}
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
	}*/
}

/* End of file managers.php */
/* Location: ./application/modules/managers/controllers/managers.php */