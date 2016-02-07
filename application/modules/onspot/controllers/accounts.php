<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('onspot/guser_model', 'guser', TRUE);
    }

    public function gettzid($type, $id)
    {
        $stat['status'] = FALSE;
        if ($type !== 'email' && $type !== 'phone') {
            $stat['message'] = 'Invalid link: '.base_url('onspot/accounts/gettzid/'.$type.'/'.$id);
        } else {
            $tzid = $this->guser->get_tzid($type, $id);
            if ($tzid === FALSE) {
                $stat['message'] = 'User '.$id.' does not exist';
            } else {
                $stat['message'] = $tzid;
                $stat['userid'] = $tzid;
                $stat['status'] = TRUE;
            }
        }
        echo json_encode($stat);
    }

    public function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('Phone', 'Phone Number', 'trim|required|min_length[10]|xss_clean');
        $this->form_validation->set_rules('College', 'College', 'trim|required|xss_clean');
        $this->form_validation->set_rules('CollegeId', 'College Id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('City', 'City', 'trim|required|xss_clean');
        $this->form_validation->set_rules('State', 'State', 'trim|required|xss_clean');

        $stat['status'] = FALSE;

        if($this->form_validation->run() === TRUE) {
            $details['name'] = $this->input->post('Name');
            $details['email'] = $this->input->post('Email');
            $details['phone'] = $this->input->post('Phone');
            $details['college'] = $this->input->post('College');
            $details['collegeid'] = $this->input->post('CollegeId');
            $details['city'] = $this->input->post('City');
            $details['state'] = $this->input->post('State');
            $details['password'] = $this->input->post('Password');
            $details['ipaddress'] = $this->input->ip_address();
            // $details['registered_by'] = $this->ion_auth->get_user_id();
            // $registration  = ($this->input->post('registration') ? "1" : "0");
            // $details['registration'] = $registration;
            // $details['onspot'] = '1';
            $this->load->model('onspot/onspot_model');
            
            $result = $this->guser->create($details);
            $stat['status'] = $result['status'];
            $stat['userid'] = $result['userid'];
            $stat['message'] = $result['message'];
            if ($stat['status'] === true) {
	        if ( $this->input->post('Nitw') !== false) {
                    $this->guser->set_nitw($stat['userid']);
                }
            }
        }
        else
        {
            $stat['status'] = FALSE;
            $stat['userid'] = -1;
            $stat['message'] = "Error creating account.";
        }

        echo json_encode($stat);
    }

    public function edit($userid)
    {
    $name=$this->input->post('name');
        $stat['status'] = FALSE;

        if (!$this->guser->edit($userid, $name)) {
            $stat['message'] = 'Invalid Userid';
            echo json_encode($stat);
            return ;
        }

        $stat['message'] = 'Name edited successfully';
        $stat['status'] = TRUE;
        echo json_encode($stat);
    }
    
    public function test()
    {
        $data['scripts'] = array();
        $data['current_page'] = "registrationa";
        $this->load->view('onspot/menu/header', $data, FALSE);
         $this->load->view('onspot/sidebar/sidebar', $data, FALSE);
    }

}

/* End of file accounts.php */
/* Location: ./application/controllers/accounts.php */