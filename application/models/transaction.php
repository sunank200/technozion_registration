<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Model {

    public function __construct ()
    {
        parent::__construct();
    }

    public function add($txnid, $userid, $workshopid, $teamid, $registrationIds = array(), $hospitalityIds = array(), $amount = 0, $status = 0)
    {
        $input['transactionid'] = $txnid;
        $input['userid'] = $userid;
        $input['workshopid'] = $workshopid;
        $input['teamid'] = $teamid;
        $input['registrationids'] = json_encode($registrationIds);
        $input['hospitalityids'] = json_encode($hospitalityIds);
        $input['ipaddressinitial'] = $this->input->ip_address();
        $input['status'] = $status;
        $input['amount'] = $amount;
        return $this->db->insert('transactions', $input);
    }

    public function addtshirt($txnid, $userid, $numoftshirts, $sizeoftshirts = array(), $amount = 0, $status = 0)
    {
        $input['transactionid'] = $txnid;
        $input['userid'] = $userid;
        $input['tshirts'] = $numoftshirts;
        $input['tshirtssizes'] = json_encode($sizeoftshirts);
        $input['ipaddressinitial'] = $this->input->ip_address();
        $input['status'] = $status;
        $input['amount'] = $amount;
        return $this->db->insert('transactions', $input);
    }

    public function update($data)
    {
        return $this->db->update('transactions', $data, array('transactionid' => $data->transactionid));
    }

    public function get($txnid) {
        $this->db->select()->from('transactions')->where('transactionid', $txnid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() !== 1) {
            return false;
        }
        return $query->first_row();
    }

}

/* End of file transaction.php */
/* Location: ./application/models/transaction.php */