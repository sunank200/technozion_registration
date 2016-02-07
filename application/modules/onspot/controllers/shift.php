<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workshops extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth/ion_auth');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group('admin', $this->ion_auth->get_user_id()))
        {
            redirect('auth/index', 'refresh');
        }
    }

}