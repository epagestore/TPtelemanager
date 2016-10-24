<?php
class Transaction_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	 public function getProductTransaction($filter=''){
		if($filter!='')
		$filter=" and op.order_product_status_id = ".$filter;
		//$query = $this->db->query("SELECT op.order_product_id,o.order_id,op.transaction_id,payer_id,payee_id,op.name as product_name,op.quantity,op.total as product_price,o.total_amount as order_total,op.order_product_status_id,company_id,op.payer_code as product_payer_code,op.payee_code as product_payee_code,date_added,date_modified,shipping_firstname,shipping_lastname,shipping_address_1 FROM `order_product` op,`order` o where o.order_id=op.order_id and is_milestone=0");
		$query = $this->db->query("SELECT q.*,p.date_added,adddate(p.date_added,q.complete_order_time) as expire_time,NOW() as now from (SELECT op.order_product_id,op.complete_order_unit,o.order_id,op.transaction_id,payer_id,payee_id,op.name as product_name,op.quantity,op.total as product_price,op.complete_order_time,o.total_amount as order_total,op.order_product_status_id,company_id,op.payer_code as product_payer_code,op.payee_code as product_payee_code,date_added,date_modified,shipping_firstname,shipping_lastname,shipping_address_1 FROM `order_product` op,`order` o where o.order_id=op.order_id and is_milestone=0  ".$filter.") as q LEFT JOIN `payee` p on q.order_product_id=p.order_product_id order by transaction_id desc");
        return $query->result_array();
    }
	 public function getMilestoneTransaction(){

		$query = $this->db->query("select ordr.*,trns.*,om.milestone_id,om.amount as milestone_amount,om.description as milestone_description,om.milestone_key,status as milestone_status from `order` ordr,`customer_transaction` trns,order_milestone om where trns.transaction_id=om.transaction_id and ordr.order_id = om.order_id and trns.transaction_id and is_milestone=1");
		
        return $query->result_array();
    }
	public function releaseProductPayment($transaction_id,$user_id)
	{
		$query=$this->db->query("SELECT ordr.*,op.order_product_status_id,op.total as total_amount,payee_id,payer_id from `order` ordr,`order_product` op where ordr.order_id= op.order_id and op.transaction_id =".$transaction_id);
		$order=$query->result_array();
		$commission = $order[0]['commission'];
		$marchent_plan = ($commission)/100;
		
		// tp plan
		$tp_plan=$this->db->query("select plan from customer_company where customer_id=".$order[0]['company_id'])->row();
		$tp_plan_pre=($tp_plan->plan)/100;
		
		$org_amount=$order[0]['total_amount'];
		if($order[0]['order_product_status_id']==9)
		{
			$query=$this->db->query("SELECT final_amount from `order_despute` dp,`order_product` op where dp.order_product_id= op.order_product_id and op.transaction_id =".$transaction_id);
			$despute=$query->result_array();
			
			$order[0]['total_amount']=$despute[0]['final_amount'];
			if($org_amount-$order[0]['total_amount']!=0)
			{	
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['payer_id'].", amount = ".($org_amount-$order[0]['total_amount']).", description ='Dispute Order Amount Refund', `read`='0',date_added = NOW()");
			}
		}
		//$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".$order[0]['total_amount'].") where customer_id = ".$order[0]['payee_id']);
		//echo  $this->db->affected_rows();
		//echo $order[0]['total_amount'];
		//die();
		
		$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$order[0]['total_amount']."), balance_in_process = ( balance_in_process + ".$org_amount.") where customer_id = ".$order[0]['payer_id']);		
		
		
		$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".($order[0]['total_amount']-($order[0]['total_amount'])*($marchent_plan+$tp_plan_pre)).") where customer_id = ".$order[0]['payee_id']);
		
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
		if($tp_plan_pre>0)
		{
			$this->db->query("INSERT INTO `trusted_commission`  SET transaction_id='".$transaction_id."', released_by = ".$user_id.", order_id = ".$order[0]['order_id'].", amount = ".(($order[0]['total_amount'])*($tp_plan_pre)).", description =' Order ID ".$order[0]['order_id']."/".$transaction_id."/".($tp_plan->plan)." % Order Amount Received',ip_address='".$this->input->ip_address()."', date_added = NOW()");
		}	
		//merchant commission		
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['payee_id'].", amount = ".($order[0]['total_amount']-($order[0]['total_amount'])*($marchent_plan+$tp_plan_pre)).", description =' Order ID ".$order[0]['order_id']."/".(100-($commission+$tp_plan->plan))." % Order Amount Received',`read`='0', date_added = NOW()");
		if($marchent_plan>0)
		{	
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['company_id'].", amount = ".($order[0]['total_amount'])*$marchent_plan.", description =' Order ID ".$order[0]['order_id']."/".$commission." %  Order Commission Amount Received',`read`='0', date_added = NOW()");
		}
		$this->db->query("UPDATE `order_product` SET total = ".$order[0]['total_amount'].",order_product_status_id =9,released_by = ".$user_id." where transaction_id = ".$transaction_id);
	}
	public function releaseMilestonePayment($transaction_id,$user_id)
	{
		$query=$this->db->query("SELECT ordr.*, ordr.total_amount as order_total_amount, om.amount as total_amount,payee_id,payer_id,om.order_id from `order` ordr,`order_milestone` om where ordr.order_id=om.order_id and  om.transaction_id =".$transaction_id);
		$milestone=$query->result_array();
		$commission = $milestone[0]['commission'];
		$marchent_plan = ($commission)/100;
		
		// tp plan
		$tp_plan=$this->db->query("select plan from customer_company where customer_id=".$milestone[0]['company_id'])->row();
		$tp_plan_pre=($tp_plan->plan)/100;
		
			$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$milestone[0]['total_amount']."), balance_in_process = ( balance_in_process + ".$milestone[0]['total_amount'].") where customer_id = ".$milestone[0]['payer_id']);
			
			$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".($milestone[0]['total_amount']-($milestone[0]['total_amount'])*($marchent_plan+$tp_plan_pre)).") where customer_id = ".$milestone[0]['payee_id']);
			
			//merchant commission
			if($marchent_plan>0)
			{	
				$no = $this->db->query("select * from customer_account_balance where customer_id = ".$milestone[0]['company_id'])->num_rows();
				if($no>0)
				$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".($milestone[0]['total_amount'])*$marchent_plan.") where customer_id = ".$milestone[0]['company_id']);
				else{
				$this->db->query("INSERT INTO `customer_account_balance`  SET  total_balance = (".($milestone[0]['total_amount'])*$marchent_plan."), customer_id = ".$milestone[0]['company_id']);	
				//echo $this->db->last_query();
				}
			}
			
			
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$milestone[0]['payee_id'].", amount = ".($milestone[0]['total_amount']-($milestone[0]['total_amount'])*($marchent_plan+$tp_plan_pre)).", description =' Order ID ".$milestone[0]['order_id']."/".(100-($commission+$tp_plan->plan))." % Milestone Amount Received',`read`='0', date_added = NOW()");
			
			if($marchent_plan>0)
			{	
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$milestone[0]['company_id'].", amount = ".($milestone[0]['total_amount'])*$marchent_plan.", description =' Order ID ".$milestone[0]['order_id']."/".$commission." % Milestone Commission Amount Received', `read`='0', date_added = NOW()");
			}
			
			if($tp_plan_pre>0)
			{
				$this->db->query("INSERT INTO `trusted_commission`  SET is_milestone=1,transaction_id='".$transaction_id."', released_by = ".$user_id.", order_id = ".$order[0]['order_id'].", amount = ".(($order[0]['total_amount'])*($tp_plan_pre)).", description =' Order ID ".$order[0]['order_id']."/".$transaction_id."/".($tp_plan->plan)." % Order Amount Received',ip_address='".$this->input->ip_address()."', date_added = NOW()");
			}	
			
			$query=$this->db->query("SELECT IFNULL(sum(amount),0) as total_amount from `order_milestone` where status=6 and order_id =".$milestone[0]['order_id']);
			$milstn=$query->row();
			if($milestone[0]['order_total_amount']<=$milstn->total_amount)
			{
			
				$this->db->query("UPDATE `order` SET order_status_id =2 where order_id = ".$milestone[0]['order_id']);
			}			
			
			$this->db->query("UPDATE `order_milestone` SET status =2,released_by = ".$user_id." where transaction_id = ".$transaction_id);
		
		
	}
	public function expireOrder()
	{
		//$query=$this->db->query("SELECT complete_order_time,datediff(ADDDATE(p.date_added,op.complete_order_time),NOW()) sd FROM `order_product` op, `payee` p where op.order_product_id=p.order_product_id and order_product_status_id =5");
		//$query=$this->db->query("SELECT op.complete_order_unit from FROM `order_product` order_product_status_id =5");
		$query=$this->db->query("SELECT op.order_id,op.order_product_id,op.complete_order_time,op.complete_order_unit,p.date_added,adddate(p.date_added,INTERVAL op.complete_order_time hour) as expire_time,NOW() as now FROM `order_product` op, `payee` p where op.order_product_id=p.order_product_id and order_product_status_id =5");
		//$query=$this->db->query("SELECT order_product_status_id,complete_order_time,complete_order_unit from order_product where order_id=5");
		$result=$query->result_array();
		//print_r($result);
		//$this->db->query("UPDATE `order_product` SET order_product_status_id = 5 where order_product_status_id =7");
		foreach($result as $order)
		{
			$future_datetime = date('Y-m-d H:i:s',strtotime("+".$order['complete_order_time']." ".$order['complete_order_unit']." ", strtotime($order['date_added'])));
			$future = strtotime($future_datetime); //future datetime in seconds
			$now_datetime = $order['now'];
			$now = strtotime($now_datetime); //now datetime in seconds

			//The math for calculating the difference in hours, minutes and seconds
			$difference = $future - $now;
			$second = 1;
			$minute = 60 * $second;
			$hour = 60 * $minute;
			$difference_hours = floor($difference/$hour);
			$remainder = $difference - ($difference_hours * $hour);
			$difference_minutes = floor($remainder/$minute);
			$remainder = $remainder - ($difference_minutes * $minute);
			$difference_seconds = $remainder;
			//echo "The difference between $future_datetime and $now_datetime is $difference_hours hours, $difference_minutes minutes and $difference_seconds seconds".$order['order_id'];
			//echo $difference_hours." ".$difference_minutes." ".$difference_seconds."<br>";
			
			if($difference_hours<0)
			{
				$query=$this->db->query("UPDATE `order_product` SET order_product_status_id = 7 where order_product_id =".$order['order_product_id']);
			}
		}
	}
}
?>