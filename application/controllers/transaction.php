<?php
class Transaction extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	    $this->load->model('transaction_model');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
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
		$this->productTransaction();
	}
	public function milestoneTransaction(){
		
	    		
		$transaction= $this->transaction_model->getMilestoneTransaction();
		
		$data['transactions']=$transaction;
		
		
		$this->load->view('header');
		$this->load->view('milestone_transaction_list',$data);
		$this->load->view('footer');
		
		
	}	
	public function releaseMilestonePayment($transaction_id)
	{
		$user_id=$this->session->userdata['user_id'];
		$transaction= $this->transaction_model->releaseMilestonePayment($transaction_id,$user_id);
		redirect('transaction/milestoneTransaction');
	}
	public function productTransaction(){
		
		$filter='';
		if(isset($_GET['status']) )
		$filter=$_GET['status'];
		
		$data['filter']=$filter;
	    $this->transaction_model->expireOrder();
		$transaction= $this->transaction_model->getProductTransaction($filter);
		
		$data['transactions']=$transaction;
		
		
		$this->load->view('header');
		$this->load->view('product_transaction_list',$data);
		$this->load->view('footer');
		
		
	}	
	public function releaseProductPayment($transaction_id)
	{
		$user_id=$this->session->userdata['user_id'];
		$transaction= $this->transaction_model->releaseProductPayment($transaction_id,$user_id);
		redirect('transaction');
	}
}
?>