<?php
class Transaction_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	 public function getProductTransaction(){

		$query = $this->db->query("SELECT op.order_product_id,o.order_id,op.transaction_id,payer_id,payee_id,op.name as product_name,op.quantity,op.total as product_price,o.total_amount as order_total,op.order_product_status_id,company_id,op.payer_code as product_payer_code,op.payee_code as product_payee_code,date_added,date_modified,shipping_firstname,shipping_lastname,shipping_address_1 FROM `order_product` op,`order` o where o.order_id=op.order_id and is_milestone=0");
		
        return $query->result_array();
    }
	 public function getMilestoneTransaction(){

		$query = $this->db->query("select ordr.*,trns.*,om.milestone_id,om.amount as milestone_amount,om.description as milestone_description,om.milestone_key,status as milestone_status from `order` ordr,`customer_transaction` trns,order_milestone om where trns.transaction_id=om.transaction_id and ordr.order_id = om.order_id and trns.transaction_id and is_milestone=1");
		
        return $query->result_array();
    }
	public function releaseProductPayment($transaction_id,$user_id)
	{
		$query=$this->db->query("SELECT op.total as total_amount,payee_id,payer_id from `order` ordr,`order_product` op where op.order_id= op.order_id and op.transaction_id =".$transaction_id);
		$order=$query->result_array();
		
		$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$order[0]['total_amount']."), balance_in_process = ( balance_in_process + ".$order[0]['total_amount'].") where customer_id = ".$order[0]['payer_id']);
		$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".$order[0]['total_amount'].") where customer_id = ".$order[0]['payee_id']);
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['payee_id'].", amount = ".$order[0]['total_amount'].", description ='Order Amount Recived', date_added = NOW()");
		
		$this->db->query("UPDATE `order_product` SET order_product_status_id =2,released_by = ".$user_id." where transaction_id = ".$transaction_id);
			
		
	}
	public function releaseMilestonePayment($transaction_id,$user_id)
	{
		$query=$this->db->query("SELECT ordr.total_amount as order_total_amount, om.amount as total_amount,payee_id,payer_id,om.order_id from `order` ordr,`order_milestone` om where ordr.order_id=om.order_id and  om.transaction_id =".$transaction_id);
		$milestone=$query->result_array();
		
			$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$milestone[0]['total_amount']."), balance_in_process = ( balance_in_process + ".$milestone[0]['total_amount'].") where customer_id = ".$milestone[0]['payer_id']);
			$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".$milestone[0]['total_amount'].") where customer_id = ".$milestone[0]['payee_id']);
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$milestone[0]['payee_id'].", amount = ".$milestone[0]['total_amount'].", description ='Milestone Amount Recived', date_added = NOW()");
			
			$query=$this->db->query("SELECT IFNULL(sum(amount),0) as total_amount from `order_milestone` where status=6 and order_id =".$milestone[0]['order_id']);
			$milstn=$query->row();
			if($milestone[0]['order_total_amount']<=$milstn->total_amount)
			{
			
				$this->db->query("UPDATE `order` SET order_status_id =2 where order_id = ".$milestone[0]['order_id']);
			}
			$this->db->query("UPDATE `order_milestone` SET status =2,released_by = ".$user_id." where transaction_id = ".$transaction_id);
		
		
	}
}
?>