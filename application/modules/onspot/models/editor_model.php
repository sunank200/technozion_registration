<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

  public function get_transaction($userid)
  {
    $query = $this->db->select()
                      ->from('transactions')
                      ->join('workshops', 'transactions.workshopid = workshops.workshopid', 'left')
                      ->or_like(array('transactions.registrationids' => $userid, 'transactions.hospitalityids'=> $userid, "userid" => $userid))
                      ->get();

    if ($query->num_rows() <1)
    {
        return false;
    }
    return $query->result();
}

 public function get_receipt_details($userid)
  {
    $query = $this->db->select()
                      ->from('campus_registrations')
                      ->where('userid', $userid)
                      ->get();

    if ($query->num_rows() <1)
    {
        return false;
    }
    return $query->first_row();
}

public function save_verified_data($receipt, $userid, $roomno, $goodies, $extra_amount, $remark, $verify, $registration, $hospitality, $registered_by)
{
    $data= array(
        "receiptid" =>$receipt,
        "userid" => $userid,
        "roomalloted" => $roomno,
        "goodies" => $goodies,
        "extra_amount" => $extra_amount,
        "remark" => $remark,
            //"hospitality" => $hospitality_registered_by,
           // "registration" => $registration_registered_by,
        "verify" => $verify,
        "verified_by" => $registered_by,
        "ipaddress" => $this->input->ip_address()
        );
    $query = $this->db->insert('campus_transactions', $data);
    if($this->db->affected_rows() === 1)
        return TRUE;
    else
        return FALSE;
}

public function verify($data)
{
  $temp['registration'] = $data['registration'];
  $temp['hospitality'] = $data['hospitality'];
  $temp['goodies'] = $data['goodies'];
  if (isset($data['roomalloted'])) {
    $temp['roomalloted'] = $data['roomalloted'];
  }
  if ($data['registration'] === 1 || $data['hospitality'] === 1) {
    $this->db->update('userdata', $temp, array('userid' => $data['userid']));
  }
  $query = $this->db->insert('campus_transactions', $data);
  if($this->db->affected_rows() === 1)
      return TRUE;
  else
      return FALSE;
}

public function check_verified($userid, $counter)
{
  $this->db->select()->from('campus_transactions')->where(array('userid' => $userid, 'counter' => $counter));
  $query = $this->db->get();
  return ($query->num_rows() > 0)? true: false;
}

public function change_hospitality($userid, $new)
{
    $data['hospitality'] = $new;
    $query = $this->db->update('userdata', $data, array('userid' => $userid));
    if($this->db->affected_rows() === 1)
        return TRUE;
    else
        return FALSE;
}

public function change_registration($userid, $new)
{
    $data['registration'] = $new;
    $query = $this->db->update('userdata', $data, array('userid' => $userid));
    if($this->db->affected_rows() === 1)
      return TRUE;
  else
    return FALSE;
}

}

/* End of file onspot_model.php */
/* Location: ./application/models/onspot_model.php */