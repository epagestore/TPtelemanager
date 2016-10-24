<?php
class Login_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	 public function validate(){
        
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        
        
		$query = $this->db->query("SELECT * from user");
		
        return $query->result_array();
    }
}

 ?>