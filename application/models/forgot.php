<?php

class Forgot extends CI_Model {

    public function __construct ()
    {
        parent::__construct();
    }

   public function is_email_exists($email)
   {
       $query = $this->db->select('email')
                         ->where('email', $email)
                         ->limit(1)
                         ->get('userauth');
        if($query->num_rows() === 1)
            return TRUE;
        else
            return FALSE;

   }

   public function save_forgot_code($code, $email)
   {
       $query = $this->db->update('userauth', array('forgot_password' => $code), array('email' => $email));
       if($this->db->affected_rows() === 1 )
        return TRUE;
       else
        return FALSE;
   }

   public function get_forgot_user($email, $code)
   {
       $query = $this->db->select('userid, email, forgot_password')
                         ->where(array('email' =>$email, 'forgot_password' => $code))
                         ->limit(1)
                         ->get('userauth');
        if($query->num_rows() === 1)
            return $query->first_row();
        else
            return FALSE;
   }

  
}
