<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transactions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('nativesession');
        $this->load->model('transaction','',TRUE);
        $this->load->model('wteam','',TRUE);
        $this->load->model('user','',TRUE);

        $this->clean_post();
    }

    private function clean_post()
    {
        if(!empty($_POST)) {
            foreach($_POST as $key => $value) {
                $_POST[$key] = htmlentities($value, ENT_QUOTES);
            }
        }
    }

    private function get_response()
    {
        $txnRs = array();
        if(!empty($_POST)) {
            foreach($_POST as $key => $value) {
                $txnRs[$key] = $value;
            }
        }
        return $txnRs;
    }

    private function verify_response($txnRs)
    {
        $merc_hash_vars_seq = explode('|', "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10");
            //generation of hash after transaction is = salt + status + reverse order of variables
        $merc_hash_vars_seq = array_reverse($merc_hash_vars_seq);
        $merc_hash_string = SALT . '|' . $txnRs['status'];
        foreach ($merc_hash_vars_seq as $merc_hash_var) {
            $merc_hash_string .= '|';
            $merc_hash_string .= isset($txnRs[$merc_hash_var]) ? $txnRs[$merc_hash_var] : '';
        }
        $merc_hash =strtolower(hash('sha512', $merc_hash_string));
        if($merc_hash!=$txnRs['hash']) {
            return false;
        }
        return true;
    }

    public function success()
    {
        if (!(($txnRs = $this->get_response()) && $this->verify_response($txnRs))) {
            $data['status'] = 'Transaction failed';
        } else {
            $txnDetails = $this->transaction->get($this->input->post('txnid'));
            $txnDetails->returnparams = json_encode($_POST);

            if (isset($txnDetails->teamid)) {
                $this->wteam->confirm($txnDetails->teamid);
                $teamDetails = $this->wteam->get_details($txnDetails->teamid, 'array');
                $tsize = $teamDetails['tsize'];
                for ($i=1; $i <= $tsize; $i++) {
                    $this->user->add_team_workshops($teamDetails['user'.$i.'id'], $txnDetails->workshopid, $txnDetails->teamid);
                }
            }

            if (isset($txnDetails->registrationids)) {
                $ids = json_decode($txnDetails->registrationids);
                foreach ($ids as $index => $id) {
                    $this->user->add_registration($id);
                }
            }

            if (isset($txnDetails->hospitalityids)) {
                $ids = json_decode($txnDetails->hospitalityids);
                foreach ($ids as $index => $id) {
                    $this->user->add_hospitality($id);
                }
            }

            $txnDetails->status = 5;
            $txnDetails->returnparams = json_encode($_POST);
            if ($this->transaction->update($txnDetails) === false) {
                $flag = false;
            }

            $data['status'] = 'You have successfully registered. ';
        }

        $data["main_heading"] = "Transaction";
        $data["side_heading"] = "transaction status";
        $data['current_page'] = 'transactions';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        //echo json_encode($data);

        $this->load->view('base/header', $data);
        $this->load->view('payu/result', $data);
        $this->load->view('base/footer', $data);
    }

    public function success_mobile()
    {
        if (!(($txnRs = $this->get_response()) && $this->verify_response($txnRs))) {
            $data['status'] = 'Transaction failed';
        } else {
            $txnDetails = $this->transaction->get($this->input->post('txnid'));
            $txnDetails->returnparams = json_encode($_POST);

            if (isset($txnDetails->teamid)) {
                $this->wteam->confirm($txnDetails->teamid);
                $teamDetails = $this->wteam->get_details($txnDetails->teamid, 'array');
                $tsize = $teamDetails['tsize'];
                for ($i=1; $i <= $tsize; $i++) {
                    $this->user->add_team_workshops($teamDetails['user'.$i.'id'], $txnDetails->workshopid, $txnDetails->teamid);
                }
            }

            if (isset($txnDetails->registrationids)) {
                $ids = json_decode($txnDetails->registrationids);
                foreach ($ids as $index => $id) {
                    $this->user->add_registration($id);
                }
            }

            if (isset($txnDetails->hospitalityids)) {
                $ids = json_decode($txnDetails->hospitalityids);
                foreach ($ids as $index => $id) {
                    $this->user->add_hospitality($id);
                }
            }

            $txnDetails->status = 5;
            $txnDetails->returnparams = json_encode($_POST);
            if ($this->transaction->update($txnDetails) === false) {
                $flag = false;
            }

            $data['status'] = 'You have successfully registered. ';


        }

        //$data["main_heading"] = "Transaction";
        //$data["side_heading"] = "transaction status";
        //$data['current_page'] = 'transactions';
     //   $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid_mobile'));
     //   $this->nativesession->delete('userid_mobile');


        echo json_encode($data);
        return ;
        /*$this->load->view('base/header', $data);
        $this->load->view('payu/result', $data);
        $this->load->view('base/footer', $data);*/
    }

    public function successtshirt()
    {
        if (!(($txnRs = $this->get_response()) && $this->verify_response($txnRs))) {
            $data['status'] = 'Transaction failed';
        } else {
            $txnDetails = $this->transaction->get($this->input->post('txnid'));
            $txnDetails->returnparams = json_encode($_POST);
            $sizes = json_decode($txnDetails->tshirtssizes, true);
            if ($txnDetails->tshirts > 0) {
             foreach ($sizes as $key => $size) {
                $this->user->add_tshirt($txnDetails->userid, $size);
            }
        }

        $txnDetails->status = 5;
        $txnDetails->returnparams = json_encode($_POST);
        if ($this->transaction->update($txnDetails) === false)
        {
            $flag = false;
        }

        $data['status'] = 'You have successfully Bought T-shirt :) ';
    }

    $data["main_heading"] = "Transaction";
    $data["side_heading"] = "transaction status";
    $data['current_page'] = 'transactions';
    $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
    $this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);
}

public function failure()
{
    $txnDetails = $this->transaction->get($this->input->post('txnid'));
    if (isset($txnDetails->teamid)) {
        $this->wteam->cancel($txnDetails->teamid);
    }
    if (isset($txnDetails->registrationids)) {
        $ids = json_decode($txnDetails->registrationids);
        foreach ($ids as $index => $id) {
            $this->user->remove_registration($id);
        }
    }
    if (isset($txnDetails->hospitalityids)) {
        $ids = json_decode($txnDetails->hospitalityids);
        foreach ($ids as $index => $id) {
            $this->user->remove_hospitality($id);
        }
    }

    $txnDetails->status = -1;
    $txnDetails->returnparams = json_encode($_POST);
    if ($this->transaction->update($txnDetails) === false) {
        $flag = false;
    }

    $data['status'] = 'Transaction Failure. ';

    $data["main_heading"] = "Transaction";
    $data["side_heading"] = "transaction status";
    $data['current_page'] = 'transactions';
    $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
    echo json_encode($data);
    $this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);
}


public function failure_mobile()
{
    $txnDetails = $this->transaction->get($this->input->post('txnid'));
    if (isset($txnDetails->teamid)) {
        $this->wteam->cancel($txnDetails->teamid);
    }
    if (isset($txnDetails->registrationids)) {
        $ids = json_decode($txnDetails->registrationids);
        foreach ($ids as $index => $id) {
            $this->user->remove_registration($id);
        }
    }
    if (isset($txnDetails->hospitalityids)) {
        $ids = json_decode($txnDetails->hospitalityids);
        foreach ($ids as $index => $id) {
            $this->user->remove_hospitality($id);
        }
    }

    $txnDetails->status = -1;
    $txnDetails->returnparams = json_encode($_POST);
    if ($this->transaction->update($txnDetails) === false) {
        $flag = false;
    }

    $data['status'] = 'Transaction Failure. ';

   // $data["main_heading"] = "Transaction";
   // $data["side_heading"] = "transaction status";
   // $data['current_page'] = 'transactions';
   // $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid_mobile'));
    
   // $this->nativesession->delete('userid_mobile');

    echo json_encode($data);
    return ;
   /* $this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);*/
}


public function cancel()
{
    $txnDetails = $this->transaction->get($this->input->post('txnid'));
    if (isset($txnDetails->teamid)) {
        $this->wteam->cancel($txnDetails->teamid);
    }
    if (isset($txnDetails->registrationids)) {
        $ids = json_decode($txnDetails->registrationids);
        foreach ($ids as $index => $id) {
            $this->user->remove_registration($id);
        }
    }
    if (isset($txnDetails->hospitalityids)) {
        $ids = json_decode($txnDetails->hospitalityids);
        foreach ($ids as $index => $id) {
            $this->user->remove_hospitality($id);
        }
    }
    $txnDetails->status = -2;
    $txnDetails->returnparams = json_encode($_POST);
    if ($this->transaction->update($txnDetails) === false) {
        $flag = false;
    }

    $data['status'] = 'You have cancelled the transaction';

    $data["main_heading"] = "Transaction";
    $data["side_heading"] = "transaction status";
    $data['current_page'] = 'transactions';
    $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
    echo json_encode($data);

    $this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);
}

public function cancel_mobile()
{
    $txnDetails = $this->transaction->get($this->input->post('txnid'));
    if (isset($txnDetails->teamid)) {
        $this->wteam->cancel($txnDetails->teamid);
    }
    if (isset($txnDetails->registrationids)) {
        $ids = json_decode($txnDetails->registrationids);
        foreach ($ids as $index => $id) {
            $this->user->remove_registration($id);
        }
    }
    if (isset($txnDetails->hospitalityids)) {
        $ids = json_decode($txnDetails->hospitalityids);
        foreach ($ids as $index => $id) {
            $this->user->remove_hospitality($id);
        }
    }
    $txnDetails->status = -2;
    $txnDetails->returnparams = json_encode($_POST);
    if ($this->transaction->update($txnDetails) === false) {
        $flag = false;
    }

    $data['status'] = 'You have cancelled the transaction';
    echo json_encode($data);

   // $data["main_heading"] = "Transaction";
    //$data["side_heading"] = "transaction status";
    //$data['current_page'] = 'transactions';
   // $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
   // echo json_encode($data);

    /*$this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);*/
}


public function timeout()
{
    $txnDetails = $this->transaction->get($this->input->post('txnid'));
    if (isset($txnDetails->teamid)) {
        $this->wteam->cancel($txnDetails->teamid);
    }
    if (isset($txnDetails->registrationids)) {
        $ids = json_decode($txnDetails->registrationids);
        foreach ($ids as $index => $id) {
            $this->user->remove_registration($id);
        }
    }
    if (isset($txnDetails->hospitalityids)) {
        $ids = json_decode($txnDetails->hospitalityids);
        foreach ($ids as $index => $id) {
            $this->user->remove_hospitality($id);
        }
    }
    $txnDetails->status = -3;
    if ($this->transaction->update($txnDetails) === false) {
        $flag = false;
    }

    $data['status'] = 'The transaction timed out..';
    $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
    echo json_encode($data);

    $this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);
}

public function timeout_mobile()
{
    $txnDetails = $this->transaction->get($this->input->post('txnid'));
    if (isset($txnDetails->teamid)) {
        $this->wteam->cancel($txnDetails->teamid);
    }
    if (isset($txnDetails->registrationids)) {
        $ids = json_decode($txnDetails->registrationids);
        foreach ($ids as $index => $id) {
            $this->user->remove_registration($id);
        }
    }
    if (isset($txnDetails->hospitalityids)) {
        $ids = json_decode($txnDetails->hospitalityids);
        foreach ($ids as $index => $id) {
            $this->user->remove_hospitality($id);
        }
    }
    $txnDetails->status = -3;
    if ($this->transaction->update($txnDetails) === false) {
        $flag = false;
    }

   $data['status'] = 'The transaction timed out..';
   // $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));

    echo json_encode($data);

    /*$this->load->view('base/header', $data);
    $this->load->view('payu/result', $data);
    $this->load->view('base/footer', $data);*/
}

}

/* End of file Transactions.php */
/* Location: ./application/controllers/Transactions.php */