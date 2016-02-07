<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
        $this->load->library("nativesession");
        $this->load->model('user','',TRUE);
	}
	public function index()
	{
		$data["main_heading"] = "Help & Support";
        $data["side_heading"] = "FAQs";
        $data['current_page'] = 'help';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('help/faq');
        $this->load->view('base/footer', $data);
	}

    public function terms()
    {
        $data["main_heading"] = "Terms &amp; Conditions";
        $data["side_heading"] = "read the below terms carefully";
        $data['current_page'] = 'help';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('help/terms', $data);
        $this->load->view('base/footer', $data);
    }

}

/* End of file help2.php */
/* Location: .//D/Downloads/help.php */