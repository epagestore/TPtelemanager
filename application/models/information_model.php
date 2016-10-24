<?php
class Information_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function addInformation($data) {
		$this->db->query("INSERT INTO information SET title = '" . $data['title']  . "', type = '" . $data['information_type']. "', membership_type = '" . serialize($data['membership_type']). "', description = '" . $data['message']. "', status = '" . (int)$data['status'] . "'");
	
	}
	
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT * from information WHERE information_id = '" . (int)$information_id . "'");
		
		return $query->result_array();
	}
	
	public function getInformations() {

		$query = $this->db->query("SELECT * from information");
		
		return $query->result_array();
		
	}

	public function deleteInformation($information_id) {	
			$this->db->query("DELETE FROM information WHERE information_id = '" . (int)$information_id . "'");

	}
	
	public function editInformation($information_id, $data) {
	
/*	$desc = str_replace("'","'",$data['message']);
	echo $desc;
*/	
		$this->db->query("UPDATE information SET title = '" . $data['title']  . "', type = '" . $data['information_type'] . "', membership_type = '" . serialize($data['membership_type']). "', description = '" . addslashes($data['message']) . "', status = '" . $data['status'] . "' WHERE information_id = '" . (int)$information_id . "'");
		
	}
	
}?>