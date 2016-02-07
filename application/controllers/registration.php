<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {
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
            if($this->user->profile_fill_check($this->nativesession->get('userid')))
                redirect(base_url("update_profile"), "location", 301);
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

        $stat = $this->user->get_details($this->nativesession->get('userid'));
        
        $data['registration'] = intval($stat->registration);
        $data['hospitality'] = intval($stat->hospitality);

        $data['main_heading'] = "TZ Registration";
        $data['side_heading'] = "One time registration fees to participate in Technozion 14";
        $data['current_page'] = "registration";
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('registration/index_closed', $data);
        $this->load->view('base/footer', $data);
    }
    
    public function index_mobile()
    {
         //$userid = $this->input->post('userid');
         $userid = "9346472";
         $stat = $this->user->get_details($userid);
         if($stat == false)
         {
            echo "INVALID USERID";
            return ;
         }
         $data['registration'] = intval($stat->registration);
         $data['hospitality'] = intval($stat->hospitality);
         $data['userDetails'] = $this->user->get_details($userid);

         echo json_encode($data);
         return ;

    }

    public function index4()
    {
        // redirect(base_url("events"), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }

        $stat = $this->user->get_details($this->nativesession->get('userid'));
        
        $data['registration'] = intval($stat->registration);
        $data['hospitality'] = intval($stat->hospitality);

        $data['main_heading'] = "TZ Registration";
        $data['side_heading'] = "One time registration fees to participate in Technozion 14";
        $data['current_page'] = "registration";
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('registration/index', $data);
        $this->load->view('base/footer', $data);
    }
    
}
