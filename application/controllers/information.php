<?php
class Information extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	    $this->load->model('information_model');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if(!isset($this->session->userdata['is_logged_in'])) { 
				redirect('login');
		}

	}
	public function index() {
		//$this->manageProductForm();
		$this->showInformation();
	}
	
	public function showInformation(){
		
	    $this->load->model('information_model');		
		$informations= $this->information_model->getInformations();
		
		foreach($informations as $information){
			
		$this->data['informations'][] = array(
				'information_id' => $information['information_id'],
				'title'          => $information['title'],
				'information_type'          => $information['type'],				
				'status'     => $information['status'],
			);	
			
		}
		
		
		$this->load->view('header');
		$this->load->view('information_list',$this->data);
		$this->load->view('footer');
		
		
	}
	
	public function insert(){
		
			$this->load->view('header');
			$this->load->view('information_form',$data);
			$this->load->view('footer');
	}

	public function delete($information_id){
		
		$info_id=explode('--',$information_id);
		foreach($info_id as $id)
		{
			$this->information_model->deleteInformation($id);
		}
		redirect('information');
	}
	
	public function page($page,$filters='') {
		$this->manageProductForm($page);
	}

	public function posting($information_id='') {
			
		if($this->input->server('REQUEST_METHOD')=='POST')
		{	
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('membership_type[]', 'Membership Type', 'required');		
		$this->form_validation->set_rules('information_type', 'Information Type', 'required');		
		$this->form_validation->set_rules('status', 'Status', 'required');		
		$this->form_validation->set_rules('message', 'Description', 'required');		
		
			if ($this->form_validation->run() == FALSE)
			{  
			
			$data='';
			$data['information_id']='';
			$data['title']='';
			$data['description']='';
			$data['status']='';
			$data['information_type']='';
			$data['membership_type']='';			
				$this->load->view('header',$data);
				$this->load->view('information_form',$data);
				$this->load->view('footer',$data);
				
			}
			else
			{ 
			
				if($information_id!='')
				{
					$this->information_model->editInformation($information_id,$this->input->post());
				}
				else{
					$this->information_model->addInformation($this->input->post());
				}
				
								redirect('information');

			} }
		else {
		
			$data='';
			$data['information_id']='';
			$data['title']='';
			$data['description']='';
			$data['status']='';
			$data['information_type']='';
			$data['membership_type']='';			
			
			
			$this->load->model('information_model');
			$results=$this->information_model->getInformation($information_id);
		
			foreach($results as $result) { 
			$data['information_id']=$result['information_id'];
			$data['title']= $result['title'];
			$data['membership_type']= unserialize($result['membership_type']);			
			$data['description']= $result['description'];
			$data['information_type']= $result['type'];							
			$data['status']= $result['status'];
			}
			
			
/*		echo '<pre>';
		print_r($data['membership_type']);
		exit;
*/			
			$this->load->view('header',$data);
			$this->load->view('information_form',$data);
			$this->load->view('footer',$data);
		}
	}
}
?>