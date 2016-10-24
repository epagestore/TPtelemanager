<?php
class Despute_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function releaseDesputePayment($despute_id,$user_id,$in_favour='',$milestone_id=0)
	{		
		$query=$this->db->query("SELECT ordr.* , op.order_product_id,op.total as total_amount,dp.payer_amount,dp.payee_amount,dp.payee_id,dp.payer_id from `order` ordr,`order_product` op, `order_despute` dp where ordr.order_id= op.order_id and op.order_product_id =dp.order_product_id and dp.despute_id=".$despute_id);
		$order=$query->result_array();
		
		$commission = $order[0]['commission'];
		$marchent_plan = ($commission)/100;
		
		// tp plan
		$tp_plan=$this->db->query("select plan from customer_company where customer_id=".$order[0]['company_id'])->row();
		$tp_plan_pre=($tp_plan->plan)/100;
		
		if($in_favour=='payer')
		{
			$total_amount=$order[0]['payer_amount'];
		}
		else if($in_favour=='payee')
		{
			$total_amount=$order[0]['payee_amount'];
		}
		else
		{
			$total_amount=$in_favour;
		}
		
		$this->db->query("UPDATE `order_despute` SET  status = 4,final_amount =".$total_amount." where despute_id = ".$despute_id);$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$total_amount."), balance_in_process = ( balance_in_process + ".$order[0]['total_amount'].") where customer_id = ".$order[0]['payer_id']);	
		
		$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".($total_amount-($order[0]['total_amount'])*($marchent_plan+$tp_plan_pre)).") where customer_id = ".$order[0]['payee_id']);
		
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['payee_id'].", amount = ".($total_amount-($order[0]['total_amount'])*($marchent_plan+$tp_plan_pre)).", description =' Order ID ".$order[0]['order_id']."/".(100-($commission+$tp_plan->plan))." % Order Amount Received',`read`='0',date_added = NOW()");
		
		//merchant commission
		if($marchent_plan>0)
		{	
			$no = $this->db->query("select * from customer_account_balance where customer_id = ".$order[0]['company_id'])->num_rows();
			if($no>0)
			$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".($order[0]['total_amount'])*$marchent_plan.") where customer_id = ".$order[0]['company_id']);
			else{
			$this->db->query("INSERT INTO `customer_account_balance`  SET  total_balance = (".($order[0]['total_amount'])*$marchent_plan."), customer_id = ".$order[0]['company_id']);	
			//echo $this->db->last_query();
			}
		}
		
		if($marchent_plan>0)
		{	
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['company_id'].", amount = ".($order[0]['total_amount'])*$marchent_plan.", description =' Order ID ".$order[0]['order_id']."/".$commission." %  Order Commission Amount Received',`read`='0', date_added = NOW()");
		}
		
		if($tp_plan_pre>0)
		{
			if($milestone_id)
			{
				$p=" milestone_id = ".$order[0]['order_product_id'].",is_milestone=1, ";	
				 $desc="Order ID ".$order[0]['order_id']."/".$despute_id."/".($tp_plan->plan)." % Milestone Dispute Amount Received";
			}else{				
				$p=" order_product_id = ".$order[0]['order_product_id'].", ";
				$desc="Order ID ".$order[0]['order_id']."/".$despute_id."/".($tp_plan->plan)." % Order Dispute Amount Received";
			}	
			
			$this->db->query("INSERT INTO `trusted_commission`  SET despute_id='".$despute_id."',".$p." transaction_id='".$transaction_id."', released_by = ".$user_id.", order_id = ".$order[0]['order_id'].", amount = ".(($order[0]['total_amount'])*($tp_plan_pre)).", description ='".$desc."',ip_address='".$this->input->ip_address()."', date_added = NOW()");
		}
		
		if($milestone_id)
		$this->db->query("UPDATE `order_milestone` SET status =2,released_by = ".$user_id." where milestone_id = ".$order[0]['order_product_id']);
		else{
			$this->db->query("UPDATE `order_product` SET order_product_status_id =2,released_by = ".$user_id." where order_product_id = ".$order[0]['order_product_id']);
		}
	}
	public function insertDespute($data,$attachment,$payer_id,$payee_id,$generate_by)
	{
		if($payee_id==$generate_by)
		$amount=",payee_amount =".$data['claim_amount'];
		if($payer_id==$generate_by)
		$amount=",payer_amount =".$data['claim_amount'];
		
		if($payee_id!='')
		$payee_id=", payee_id =".$payee_id;
		if($payer_id!='')
		$payer_id=", payer_id =".$payer_id;
		if($generate_by!='')
		$generate_by =", generate_by =".$generate_by;
		
		
		
		$this->db->query("INSERT INTO `order_despute` SET order_id =".$data['order_id'].", order_product_id = ".$data['order_product_id'].$amount.",description = '".$data['despute_desc']."',attachment='".$attachment."',date_added=NOW(),status=1 ".$payer_id.$payee_id.$generate_by);
		$despute_id=$this->db->insert_id();
		$query=$this->db->query("UPDATE `order_product` SET order_product_status_id = 8 where order_product_id = ".$data['order_product_id']);
		return $despute_id;
	}
	public function updateDesputePayer($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payer_amount=".$data['pay_amount'].", status = 2 where despute_id = ".$despute_id);
	}
	public function updateDesputePayee($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payee_amount=".$data['receive_amount'].", status = 2 where despute_id = ".$despute_id);
	}
	
	public function finalDesputePayer($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payer_amount=".$data['pay_amount'].",final_amount =".$data['pay_amount'].", status = 3 where despute_id = ".$despute_id);
	}
	public function finalDesputePayee($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payee_amount=".$data['receive_amount'].",final_amount =".$data['receive_amount'].", status = 3 where despute_id = ".$despute_id);
	}
	public function getDespute($despute_id='',$order_product_id='')
	{
		if($despute_id!='')
		$despute_id=" and despute_id=".$despute_id;
		if($order_product_id!='')
		$order_product_id=" and op.order_product_id=".$order_product_id;
		$query=$this->db->query("SELECT NOW() as now,od.despute_id,od.milestone_id,od.date_added,od.payer_id,od.payee_id,od.status as despute_status,od.payer_amount,od.payee_amount,od.description as despute_description,od.generate_by,date_added as despute_date_added,op.* from `order_despute` od,`order_product` op where op.order_product_id=od.order_product_id ".$order_product_id.$despute_id." order by od.despute_id desc");
		return $query->result_array();
	}
	public function getDesputeReceiveList($customer_id)
	{
		$query=$this->db->query("SELECT cus.first_name as generate_by_name,od.* from (SELECT * from `order_despute` od where (payer_id=".$customer_id." OR payee_id =".$customer_id.") AND generate_by !=".$customer_id.") od LEFT join customer cus on cus.customer_id=od.generate_by");
		return $query->result_array();
	}
	public function getDesputeGenerateList($customer_id)
	{
		$query=$this->db->query("SELECT cus.first_name as generate_by_name,od.* from (SELECT * from `order_despute` od where (payer_id=".$customer_id." OR payee_id =".$customer_id.") AND generate_by =".$customer_id.") od LEFT join customer cus on cus.customer_id=od.generate_by");
		return $query->result_array();
	}
}?>