<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->library('nativesession');
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
        // redirect(base_url("events"), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }

        // User Details
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['main_heading'] = "TECHNOZION PROFILE";
        $data['side_heading'] = "Annual Technical festival of NIT, Warangal - 17<sup>th</sup>-19<sup>th</sup> Oct, 2014";
        $data['current_page'] = "profile";
        $this->load->view('base/header', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('base/footer');
    }

    public function index_mobile()
    {
      
     // $userid=$this->input->post('userid');
      $userid = "9346472";

      $data['userDetails'] = $this->user->get_details($userid);
      if($data['userDetails']== false)
      {
        echo "Not Registered" ;
        return ;
      }
      $store = array();
     
      foreach ($data['userDetails'] as $row => $value)
        {
             $store[$row]  = $value;
        }
      echo json_encode($store);    
      return ;    
    }
}
