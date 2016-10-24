<?php
class Home_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	 public function getUserInfo($user_id){
        
		$query = $this->db->query("SELECT firstname, lastname from user WHERE user_id = ".$user_id);
		
        return $query->result_array();
    }
	
	public function updatePassword($pw,$user_id){
        
		$query = $this->db->query("Update user set password = '".$pw."'WHERE user_id = ".$user_id);
		
    }
}

 ?>