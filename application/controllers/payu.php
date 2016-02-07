<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->library('nativesession');
    }

    public function index() {
        $this->load->view('payu/form.php');
    }

    public function success() {
        echo "success" ;
    }

    public function failure() {
        echo "failure" ;
    }

}