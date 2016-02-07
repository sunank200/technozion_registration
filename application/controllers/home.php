<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->library('nativesession');
    }

    public function index()
    {
        if ($this->nativesession->get('userid') != null) {
            if($this->user->profile_fill_check($this->nativesession->get('userid')))
                redirect(base_url("update_profile"), "location", 301);
            else
                redirect(base_url("profile"), "location", 301);
            return;
        }
        $data['cities']=$this->user->get_cities();
        $this->load->view('signup/code_closed',$data);
    }

    public function get_college(){

        //$cid = $this->input->post('city');
        $city="Agra";
        $result = $this->user->get_cityname_mobile($city);
        
        echo json_encode($result);
        //echo json_encode($this->user->get_college($cid));
    }

}