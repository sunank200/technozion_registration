<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->library('nativesession');
        // $this->nativesession->set('userid','4092059');
    }

    private function is_logged_in()
    {
        if ($this->nativesession->get('userid') === null) {
            return false;
        } else {
            return true;
        }
    }

    public function login($social = FALSE,$email ="")
    {
        if ($this->is_logged_in()) {
            return;
        }
        if($social){
            if($this->user->get_userid($email)){
                $userid = $this->user->get_userid($email);
                $this->nativesession->set('userid', $userid);
                $this->nativesession->set('queries', '0');
                $stat['status'] = "success";
            }else {
                $stat['message'] = "user does not exist! Please Sign Up With your social account first";
            }
            echo json_encode($stat);
            return FALSE;
        }
        $stat['status'] = "failure";
        $creds['email']     = $this->input->post('inputEmail');
        $creds['password']  = $this->input->post('inputPassword');
        $status = $this->user->check_credentials($creds);
        if ($status != false) {
            $this->nativesession->set('userid', $status->userid);
            $this->nativesession->set('queries', '0');
            $stat['status'] = "success";
        } else {
            $stat['message'] = "username/password do not match";
        }
        echo json_encode($stat);
    }

    public function login_mobile()
    {
        $stat['status'] = "failure";
       // $data = $this->input->post('data');
       // $data = json_decode($data, true);
        $creds['email']     = $this->input->post('email');
        $creds['password']  = $this->input->post('password');
        $status = $this->user->check_credentials($creds);
        if ($status != false) {
            $stat['status'] = "success";
            $stat['userid'] = $status->userid;//1014551;
            $stat['email'] = $status->email;//"kavyasrimanukonda@gmail.com";
            $value = $this->user->get_details($stat['userid']);
            $stat['name'] = $value->name;
            $stat['phone'] = $value->phone;
            $stat['college'] = $value->college;
            $stat['collegeid'] = $value->collegeid;
        } else {
            $stat['message'] = "username/password do not match";
        }
        echo json_encode($stat);
    }

    public function signup()
    {
        if ($this->is_logged_in()) {
            return;
        }

        $stat['status'] = "failure";
        $details['name'] = $this->input->post('inputName');
        $details['email'] = $this->input->post('inputEmail');
        // $details['address'] = $this->input->post('inputAddress');
        $details['phone'] = $this->input->post('inputPhone');
        $details['college'] = $this->input->post('inputCollege');
        $details['sex']=$this->input->post('inputGender');
        // $details['year'] = $this->input->post('inputYear');
        // $details['department'] = $this->input->post('inputDepartment');
        $details['collegeid'] = $this->input->post('inputCollegeId');
        $details['city'] = $this->input->post('inputCity');
        $details['state'] = $this->input->post('inputState');
        $details['password'] = $this->input->post('inputPassword');
        $details['ipaddress'] = $this->input->ip_address();
        if($this->input->post('inputFb')){
            $details['password'] = 'random';
            $details['medium'] = 'facebook';
        }elseif($this->input->post('inputGp')){
            $details['medium'] = 'gplus';
        }else{
            foreach ($details as $key => $value) {
                if ($value == false) {
                    $stat['message'] = 'Missing fields. Enter all fields';
                    echo json_encode($stat);
                    return;
                }
            }
        }
        $stat['email'] = $details['email'];
        if ($this->user->create($details)) {
            $stat['status'] = "success";
            $stat['message'] = 'Account successfully created. Login now.';
            $this->login(TRUE,$details['email']);
            return TRUE;
        } else {
            if(isset($details['medium'])){
                $this->login(TRUE,$details['email']);
                return TRUE;
            }
            $stat['message'] = 'Incorrect input or email id already register. Please enter correct values or try to login/signin.';
        }
        echo json_encode($stat);
    }


    public function signup_mobile()
    {   
        $stat['status'] = "failure";
        $data = $this->input->post('data');
        $data = json_decode($data, true);
        $details['name'] = $data['inputName'];
        $details['email'] = $data['inputEmail'];
        // $details['address'] = $this->input->post('inputAddress');
        $details['phone'] = $data['inputPhone'];
        $details['college'] = $data['inputCollege'];
        $details['sex'] = $data['inputGender'];
        // $details['year'] = $this->input->post('inputYear');
        // $details['department'] = $this->input->post('inputDepartment');
        $details['collegeid'] = $data['inputCollegeId'];
        $details['city'] = $data['inputCity'];
        $details['state'] = $data['inputState'];
        $details['password'] = $data['inputPassword'];
        $details['ipaddress'] = $this->input->ip_address();
           foreach ($details as $key => $value) {
                if ($value == false) {
                    $stat['message'] = 'Missing fields. Enter all fields';
                    echo json_encode($stat);
                    return;
                }
            }
        $stat['email'] = $details['email'];
        if ($this->user->create($details)) {
            $stat['status'] = "success";
            $stat['message'] = 'Account successfully created. Login now.';
            return TRUE;
        } else {
            $stat['message'] = 'Incorrect input or email id already register. Please enter correct values or try to login/signin.';
        }
        echo json_encode($stat);
    }


    public function reset($email , $code) {
        if(empty($email) || empty($code)){
            redirect(base_url(), 'refresh');
        }
        $user = $this->user->get_forgot_user($email, $code);
        if($user === FALSE)
        {
            $this->session->set_flashdata('danger', 'Invalid Link.');
            redirect(base_url(), 'refresh');
        }
        else
        {
            $data['user'] = $user;
            $this->load->view('reset_password', $data, FALSE);
        }
    }

    public function activate($id) {
        ;
    }

    public function forgot_password()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Registered Email', 'trim|required|valid_email|xss_clean');
        if($this->form_validation->run() === FALSE)
        {
            $this->session->set_flashdata('danger', validation_errors());
            redirect(base_url(), 'refresh');
        }
        else
        {
            //add the forgot code and send email to the user with password reset link :)
            //generate a randdome number and add it in userauth table 
            $forgot_code = rand(1, 1000000);
            $forgot_code = md5($forgot_code);
            if($this->user->save_forgot_code($forgot_code) === TRUE)
            {
                //send mail with for_got_code
                $message = "Technozion 13 <br> <h2> Reset Password</h2>Please click on the following link to reset your password <br>";
                $message = $message."<a href='".base_url('accounts/reset/'.$this->input->post('email')."/".$forgot_code)."' target='_blank'>".base_url('accounts/reset/'.$this->input->post('email')."/".$forgot_code)."</a>";
                $this->load->library('email');
                
                $this->email->from('no-reply@technozion.in', 'Technozion 13');
                $this->email->to($this->input->post('email'));
                $this->email->subject('Reset Password | Technozion 13');
                $this->email->message($message);
                
                $this->email->send();
                
                $this->session->set_flashdata('info', 'An email containing reset link is sent to registered email Id');
                redirect(base_url(), 'refresh');
            }   
            else
            {
                $this->session->set_flashdata('danger', 'Error send reset password link. please try again.');
                redirect(base_url(), 'refresh');
            }         
        }
    }

    public function logout() {
        $this->nativesession->destroy();
        redirect(base_url(), "location", 301);
        return;
    }

    public function user($id = '0') {

        //if (!$this->is_logged_in()) {
            //return;
        //}

        $stat['status'] = 'failure';
        $fullData = $this->user->get_details($id);
        if ($fullData === false) {
            $stat['message'] = 'user-id does not exist';
        } else {
            $stat['status'] = 'success';
            $stat['data'] = array();
            $stat['data']['college'] = $fullData->college;
            $stat['data']['name'] = $fullData->name;
            $stat['data']['collegeid'] = $fullData->collegeid;
            $stat['data']['registration'] = $fullData->registration;
            $stat['data']['hospitality'] = $fullData->hospitality;
        }
        echo json_encode($stat);
    }

}