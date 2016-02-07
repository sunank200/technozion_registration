<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->model('forgot','',TRUE);
        $this->load->library(array('nativesession', 'session'));
        // $this->nativesession->set('userid','4092059');
    }

	public function request()
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
			if($this->forgot->is_email_exists($this->input->post('email')) === TRUE)
			{
				$email = $this->input->post('email');
			}
			else
			{
				$this->session->set_flashdata('danger', 'Email Id does not exists');
				redirect(base_url() , 'refresh');
			}
			if($this->forgot->save_forgot_code($forgot_code, $email) === TRUE)
			{
                $this->load->library('email');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                //send mail with for_got_code
				$message = "Technozion 14 <br> <br>Reset Password <br><br>Please click on the following link to reset your password <br>";
				$message = $message."<a href='".base_url('forgot_password/reset/'.$this->input->post('email')."/".$forgot_code)."' target='_blank'>".base_url('accounts/reset/'.$this->input->post('email')."/".$forgot_code)."</a>";
				$this->email->from('no-reply@register.technozion.org', 'Technozion 14');
				$this->email->to($this->input->post('email'));
				$this->email->subject('Reset Password | Technozion 14');
				$this->email->message($message);
				//$this->session->set_flashdata('danger', $message);

				if($this->email->send() === TRUE)

				$this->session->set_flashdata('info', 'An email containing reset link is sent to registered email Id');
			else
				$this->session->set_flashdata('danger', 'Error while sending email. Please try again');

				redirect(base_url(), 'refresh');
			}   
			else
			{
				$this->session->set_flashdata('danger', 'Error send reset password link. please try again.');
				redirect(base_url(), 'refresh');
			}         
		}
	}


	public function reset ($email , $code) {
		if(empty($email) || empty($code)){
			$this->session->set_flashdata('danger', 'Invalid Link');
			redirect(base_url(), 'refresh');
		}
		//validate the user forgot code
		$user = $this->forgot->get_forgot_user($email, $code);
		if($user === FALSE)
		{
			$this->session->set_flashdata('danger', 'Invalid Link.');
			redirect(base_url(), 'refresh');
		}
		else
		{
			$data['user'] = $user;
			$this->load->view('signup/reset_password', $data, FALSE);
		}
	}

	public function newpassword()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[6]|xss_clean');
		$this->form_validation->set_rules('confirmnewpassword', 'Confirm New Password', 'trim|required|matches[newpassword]|min_length[6]|xss_clean');
		$this->form_validation->set_rules('code', 'Code', 'trim|required||xss_clean');
		$this->form_validation->set_rules('userid', 'User ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			//validation failed.
			//restore userid and forgot code.
			$this->session->set_flashdata('danger', validation_errors());
			$url = base_url('forgot_password/reset/'.$this->input->post('email')."/".$this->input->post('code'));
			redirect($url, 'refresh');
			//display the reset_form again.
		}
		else
		{
			//validation success
			if($this->user->update_password($this->input->post('newpassword'), $this->input->post('code'), $this->input->post('userid'), $this->input->post('email')) === TRUE)
			{
				$this->session->set_flashdata('success', 'Password succesfully changed. Please relogin');
			}
			else
			{
				$this->session->set_flashdata('danger', 'Error resetting the password.');
			}
			redirect(base_url(), 'refresh');
			//set new password and forgot password code to 0
			//done message and relogin link.
		}

	}

}

/* End of file forgot_password.php */
/* Location: ./application/controllers/forgot_password.php */