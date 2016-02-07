<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("nativesession");
        $this->load->model('user','',TRUE);
        $this->load->model('team','',TRUE);
        $this->load->model('event','',TRUE);
    }

    private function is_logged_in()
    {
        if ($this->nativesession->get('userid') === null) {
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }
       
        $data['current_page'] = "query";
        $data['main_heading'] = "QUERIES";
        $data['side_heading'] = "Technozion 13";
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('query/index', $data);
        $this->load->view('base/footer', $data);
    }
};