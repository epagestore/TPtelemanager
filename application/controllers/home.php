<?php
class Home extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('url');	
		if(!isset($this->session->userdata['is_logged_in'])) { 
				redirect('login');
		}	
	}
	
	public function index() {
		
		$active_user_id = $this->session->userdata('user_id');
		
		$this->load->model('home_model');
        // The user Info
        $result = $this->home_model->getUserInfo($active_user_id);
/*		$data['firstname'] = $result[0]['firstname'];
		$data['lastname'] = $result[0]['lastname'];
*/		
		
		$userInfo = array(
			       'firstname' => $result[0]['firstname'],
                   'lastname'  => $result[0]['lastname'],
                   'logged_in' => TRUE
               );
			   			   
		$this->session->set_userdata($userInfo);
		
		$data = '';
		$this->load->view('header',$data);
		$this->load->view('home',$data);
		$this->load->view('footer',$data);		
	}
	
	
	public function change_password() {
		
		$data = '';
		$this->load->view('header',$data);
		$this->load->view('change_password_form',$data);
		$this->load->view('footer',$data);		
	}
	
	public function save_change_password() {
		
		$active_user_id = $this->session->userdata('user_id');
		$pw = $this->input->post('password');
		
		$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			$data = '';
			$this->load->view('header',$data);
			$this->load->view('change_password_form',$data);
			$this->load->view('footer',$data);		
		}
		else
		{
			$this->load->model('home_model');
            $result = $this->home_model->updatePassword($pw,$active_user_id);
	
			$data = '';
			$this->load->view('header',$data);
			$this->load->view('home',$data);
			$this->load->view('footer',$data);		
		}
		
	}
	
	public function logout() {
		
		$user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		$this->session->unset_userdata('is_logged_in');
		
		$this->session->sess_destroy();

				redirect('');	
	
	}
}?>