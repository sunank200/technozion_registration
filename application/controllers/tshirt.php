<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tshirt extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("nativesession");
        $this->load->model('user');
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
        //redirect(base_url(), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }
        $data['current_page'] = "tshirt";
        $data['main_heading'] = "TECHNOZION Merchandize store";
        $data['side_heading'] = "Limited Edition";
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['scripts'] = array(base_url('assets/js/tshirt.js'));
        $this->load->view('base/header', $data);
        $this->load->view('tshirt/index', $data);
        $this->load->view('base/footer', $data);
    }

    public function add_tshirt()
    {
        $this->load->model('user','',TRUE);
        $this->load->model('transaction','',TRUE);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }
        $userid = $this->nativesession->get('userid');
        $number_of_tshirt = $this->input->post('numtshirt');
        $size_of_tsirt = $this->input->post('tshirt_size');

        // if($number_of_tshirt !== count($size_of_tsirt))
        // {
        //     echo 'Some Error occured!!';
        //     return;
        // }
       //echo  print_r($this->input->post('tshirt_size'));
        //echo print_r($size_of_tsirt);
        // $data['current_page'] = "tshirt";
        // $data['main_heading'] = "T-Shirt";
        // $data['side_heading'] = "Technozion 13";
        // $this->load->view('base/header', $data);
        // $this->load->view('tshirt/index', $data);
        // $this->load->view('base/footer', $data);
        $data['payu'] = array();
        // finding amount
        $data['payu']['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $data['payu']['amount'] = 0;
        $data['payu']['amount'] += TSHIRT_COST*$number_of_tshirt;
        $data['payu']['amount'] = ceil(($data['payu']['amount'] * 100.0) / 97.0);
        // If seat available
        // Add transaction
        $this->transaction->addtshirt($data['payu']['txnid'], $this->nativesession->get('userid'),
            $number_of_tshirt, $size_of_tsirt, $data['payu']['amount']);
        // Merchant Salt as provided by Payu
        $data['payu']['salt'] = SALT;
        // Product Info
        $data['payu']['productinfo'] = "Technozion T-Shirt";
        $mainUserDetails = $this->user->get_details($this->nativesession->get('userid'));
        // Email
        $data['payu']['email'] = $mainUserDetails->email;
        // Phone
        $data['payu']['phone'] = $mainUserDetails->phone;
        $data['payu']['firstname'] = $mainUserDetails->name;
        // Success URL
        $data['payu']['surl'] = base_url("transactions/successtshirt");
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
        
       // $this->wteam->update_count();
        
        $this->load->view('payu/forward', $data);
    }
};