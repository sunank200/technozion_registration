<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onspot extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		 $this->load->library('auth/ion_auth');
		$this->load->library('form_validation');
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

	}

	public function index()
	{
	if($this->ion_auth->in_group('registration',$this->ion_auth->get_user_id()))
		redirect('onspot/counter2', 'refresh');
	if($this->ion_auth->in_group('verification',$this->ion_auth->get_user_id()))
		redirect('onspot/counter2', 'refresh');
		if($this->ion_auth->in_group('workshop',$this->ion_auth->get_user_id()))
		redirect('onspot/workshop', 'refresh');
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
}

/* End of file managers.php */
/* Location: ./application/modules/managers/controllers/managers.php */