<?php
/**
 * Created by PhpStorm.
 * User: anikdas
 * Date: 10/2/14
 * Time: 12:50 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_profile extends CI_Controller {
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
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        if($this->input->post()){
            $details['state'] = $this->input->post('InputState');
            $details['phone'] = $this->input->post('InputPhone');
            $details['college'] = $this->input->post('InputCollege');
            $details['collegeid'] = $this->input->post('InputCollegeid');
            $details['city'] = $this->input->post('InputCity');
            $details['sex'] = $this->input->post('InputGender');

            // User Details
            $userid = $this->nativesession->get('userid');
            if($this->user->update_user_profile($details,$userid)){
                $data['message'] = "Successfully Updated";
            }
        }
        $data['citylist'] = $this->user->get_cities();
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['main_heading'] = "My TZ Profile";
        $data['side_heading'] = "Technozion - Annual extravaganza of NITW";
        $data['current_page'] = "profile";
        $data['scripts'] = array('assets/js/college_city.js','assets/js/update_college_city.js');
        $this->load->view('base/header', $data);
        $this->load->view('profile/update_profile', $data);
        $this->load->view('base/footer',$data);
    }

}
