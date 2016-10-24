<?php
class Login extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('url');	
		
	}
	public function index() {
		
		
		$data['err_msg'] = '';
		$this->load->view('login_view',$data);
	}
	
	public function process(){
		
        // Load the model

		
		$this->load->model('login_model');
        // Validate the user can login
        $result = $this->login_model->validate();
		
		if($result[0]['username']== $this->input->post('username') && $result[0]['password']== $this->input->post('password')){
			
			$userInfo = array(
			       'user_id'     => $result[0]['user_id'],
                   'username'  => $this->input->post('username'),
                   'is_logged_in' => TRUE
               );
			   			   
			$this->session->set_userdata($userInfo);
			
			redirect('transaction');	
		}
		else{
			$data['err_msg'] = 'Invalid Username/Password';
			$this->load->view('login_view',$data);

		}
		
            
    }
		
}?>