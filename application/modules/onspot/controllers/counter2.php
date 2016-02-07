<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Counter2 extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth/ion_auth');
        $this->load->library('form_validation');

        $this->load->model('team');
        $this->load->model('editor_model');

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group('verification', $this->ion_auth->get_user_id()))
        {
            redirect('auth/index', 'refresh');
        }

    }

    public function index()
    {
        // $data['scripts'] = array(asset_url()."js/counter2.js");
        $data = array();
        $this->_render_page('onspot/counter2', $data);
    }

    public function find()
    {
        $userid = $this->input->post('userid');
        redirect('onspot/editor/userid/'.$userid);
    }


    public function userid($userid = '')
    {
        $this->load->model('user');
        if(empty($userid) || !is_numeric($userid))
        {
            $result = array("status" => FALSE, "message" => "Invalid User Id. Please check the userid.");
            echo json_encode($result);
            return;
        }
        //get user details
        $user = $this->user->get_details($userid);
        if($user === FALSE)
        {
            $result = array("status" => FALSE, "message" => "Participant does not exist. Please add the participant");
            echo json_encode($result);
            return;
        }
        $result = array("status" => TRUE, "message" => "One Participant found.");
        $result['user'] = $user;
        echo json_encode($result);
        return;

    }

    public function verify()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userid', 'User Id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('receiptid', 'Receipt Id', 'trim|required|xss_clean|is_unique[campus_transactions.receiptid');
        $this->form_validation->set_rules('amount', 'Extra Amount', 'trim|required|ctype_digit|xss_clean');

        if($this->form_validation->run() === FALSE)
        {
            echo json_encode(array("status" => false, "message" => validation_errors()));
            return;
        }
        else
        {
            $data['userid'] = $this->input->post('userid');
            if ($this->editor_model->check_verified($data['userid'], 2) == true) {
                echo json_encode(array("status" => false, "message" => "User is already verified at this counter"));
                return;
            }

            $data['receiptid'] = $this->input->post('receiptid');
            $data['amount'] = intval($this->input->post('amount'));
            $data['registration'] = intval($this->input->post('registration'));
            $data['hospitality'] = intval($this->input->post('hospitality'));
            if ($this->input->post('roomalloted')) $data['roomalloted'] = $this->input->post('roomalloted');
            $data['goodies'] = intval($this->input->post('goodies'));
            $data['remarks'] = $this->input->post('remarks');
            $data['counter'] = 2;
            $data['verifiedid'] = $this->ion_auth->get_user_id();
            $data['ipaddress'] = $this->input->ip_address();
            if ($this->editor_model->verify($data))
            {
                echo json_encode(array("status" => true, "message" => "User is verified"));
                return;
            }
            else
            {
                echo json_encode(array("status" => false, "message" => "Ops server error"));
                return;
            }
        }
    }

    function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $data: $data;
        $data['current_page'] = "registration";
        $view_html = array(
            $this->load->view('onspot/menu/header', $data, $render),
            $this->load->view('onspot/sidebar/sidebar', $data, $render),
            $this->load->view($view, $this->viewdata, $render),  //main content view
            $this->load->view('onspot/menu/footer', $data, $render)
            );
        if (!$render) return $view_html;
    }

    public function test($userid) {
        echo ($this->editor_model->check_verified($userid, 2) == true)? "true":"false";
    }
}

/* End of file managers.php */
/* Location: ./application/modules/managers/controllers/managers.php */