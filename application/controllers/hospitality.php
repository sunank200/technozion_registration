<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospitality extends CI_Controller {
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

    public function index2()
    {
        // redirect(base_url("events"), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }

        $stat = $this->user->get_details($this->nativesession->get('userid'));
        
        $data['registration'] = intval($stat->registration);
        $data['hospitality'] = intval($stat->hospitality);

        $data['main_heading'] = "Hospitality Registrations";
        $data['side_heading'] = "";
        $data['current_page'] = "hospitality";
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('hospitality/index', $data);
        $this->load->view('base/footer', $data);
    }
    
    public function index()
    {
        redirect(base_url("home"), "location", 301);
        // redirect(base_url("events"), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }

        $stat = $this->user->get_details($this->nativesession->get('userid'));
        
        $data['registration'] = intval($stat->registration);
        $data['hospitality'] = intval($stat->hospitality);

        $data['main_heading'] = "Hospitality Registrations";
        $data['side_heading'] = "Food plus accomodation (stay)";
        $data['current_page'] = "hospitality";
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('hospitality/index2', $data);
        $this->load->view('base/footer', $data);
    }   
    
    
    public function register() {
    
        $stat["status"] = "failure";
        $stat["message"] = "";

        $requestData = array();
        $requestData["hospitality"] = array();
        $requestData["registration"] = array();
        if ($this->input->post('hospitality') !== FALSE) {
            $requestData["hospitality"] = array($this->nativesession->get('userid'));
        }
        if ($this->input->post('registration') !== FALSE) {
            $requestData["registration"] = array($this->nativesession->get('userid'));
        }
        


        // ipaddress
        $details["ipaddress"] = $this->input->ip_address();

        $data['payu'] = array();
        // finding amount
        $data['payu']['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $data['payu']['amount'] = 0;
        if ($this->input->post('hospitality') !== FALSE) {
            $data['payu']['amount'] += HOSPITALITY_COST*count($requestData["hospitality"]);
        }
        if ($this->input->post('registration') !== FALSE) {
            $data['payu']['amount'] += REGISTRATION_COST*count($requestData["registration"]);
        }
        $data['payu']['amount'] = ceil(($data['payu']['amount'] * 100.0) / 97.0);
        $this->load->model('transaction', '', TRUE);
        // Add transaction
        $this->transaction->add($data['payu']['txnid'], $this->nativesession->get('userid'),
            NULL, NULL, $requestData['registration'], $requestData['hospitality'], $data['payu']['amount']);
        // Merchant Salt as provided by Payu
        $data['payu']['salt'] = SALT;
        // Product Info
        $data['payu']['productinfo'] = "Technozion Registration";
        $mainUserDetails = $this->user->get_details($this->nativesession->get('userid'));
        // Email
        $data['payu']['email'] = $mainUserDetails->email;
        // Phone
        $data['payu']['phone'] = $mainUserDetails->phone;
        $data['payu']['firstname'] = $mainUserDetails->name;
        // Success URL
        $data['payu']['surl'] = base_url("transactions/success");
        $data['payu']['curl'] = base_url("transactions/cancel");
        $data['payu']['furl'] = base_url("transactions/failure");
        $data['payu']['tourl'] = base_url("transactions/timeout");
        // drop category
        $data['payu']['drop_category'] = "EMI,COD";
        // Merchant key here as provided by Payu
        $data['payu']['key'] = PAYU_MERCHANT_KEY;
        // End point - change to https://secure.payu.in for LIVE mode
        $data['payu']['PAYU_BASE_URL'] = PAYU_BASE_URL;
        // ..
        $data['payu']['action'] = $data['payu']['PAYU_BASE_URL'] . '/_payment';

        $this->load->view('payu/forward', $data);
    }

    public function register_mobile() {
    
        $stat["status"] = "failure";
        $stat["message"] = "";
        $data = json_decode($data);

        $requestData = array();
        $requestData["hospitality"] = array();
        $requestData["registration"] = array();
        if ($data['hospitality'] !== FALSE) {
            $requestData["hospitality"] = array($data['userid']);
        }
        if ($data['registration'] !== FALSE) {
            $requestData["registration"] = array($data['userid']);
        }
        


        // ipaddress
        $details["ipaddress"] = $this->input->ip_address();

        $data['payu'] = array();
        // finding amount
        $data['payu']['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $data['payu']['amount'] = 0;
        if ($data['hospitality'] !== FALSE) {
            $data['payu']['amount'] += HOSPITALITY_COST*count($requestData["hospitality"]);
        }
        if ($data['registration'] !== FALSE) {
            $data['payu']['amount'] += REGISTRATION_COST*count($requestData["registration"]);
        }
        $data['payu']['amount'] = ceil(($data['payu']['amount'] * 100.0) / 97.0);
        $this->load->model('transaction', '', TRUE);
        // Add transaction
        $this->transaction->add($data['payu']['txnid'], $data['userid'],
            NULL, NULL, $requestData['registration'], $requestData['hospitality'], $data['payu']['amount']);
        // Merchant Salt as provided by Payu
        $data['payu']['salt'] = SALT;
        // Product Info
        $data['payu']['productinfo'] = "Technozion Registration";
        $mainUserDetails = $this->user->get_details($data['userid']);
        // Email
        $data['payu']['email'] = $mainUserDetails->email;
        // Phone
        $data['payu']['phone'] = $mainUserDetails->phone;
        $data['payu']['firstname'] = $mainUserDetails->name;
        // Success URL
        $data['payu']['surl'] = base_url("transactions/success_mobile");
        $data['payu']['curl'] = base_url("transactions/cancel_mobile");
        $data['payu']['furl'] = base_url("transactions/failure_mobile");
        $data['payu']['tourl'] = base_url("transactions/timeout_mobile");
        // drop category
        $data['payu']['drop_category'] = "EMI,COD";
        // Merchant key here as provided by Payu
        $data['payu']['key'] = PAYU_MERCHANT_KEY;
        // End point - change to https://secure.payu.in for LIVE mode
        $data['payu']['PAYU_BASE_URL'] = PAYU_BASE_URL;
        // ..
        $data['payu']['action'] = $data['payu']['PAYU_BASE_URL'] . '/_payment';

        $this->load->view('payu/forward_mobile', $data);
    }
  
};