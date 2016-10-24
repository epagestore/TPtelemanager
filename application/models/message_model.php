<?php
class Message_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function sendMessage($sender_id,$despute_id,$message)
	{
		$query=$this->db->query("INSERT INTO `message` SET despute_id = ".$despute_id.",sender_id = ".$sender_id.",message_body = '".$message."', added_on = NOW(), message_type ='Admin',`read` = 0");
		//return $query->result_array();
	}
	public function getMessages($despute_id)
	{
		$query=$this->db->query("select q1.*,sender.first_name as sender_name,sender.photo from(SELECT * from `message` where despute_id =".$despute_id.") q1 left join `customer` sender on q1.sender_id=sender.customer_id");
		return $query->result_array();
	}
}?>