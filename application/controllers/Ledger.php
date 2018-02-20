<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends CI_Controller {
	public $data;
	
	public function __construct()
   	{
        parent::__construct();
        
        security_checking();
        
		// #Auto load the required model
 		$this->load->model('ledger_m');
	
		$this->data["breadcrumb"] = array(
			"Ledger" => base_url() . "ledger/"
		);
		
		$this->data['controller'] = 'ledger';
		$this->data['function'] = $this->uri->segment(2);
		
	}
	

	public function index()
	{
		redirect('ledger/add');
	}
	
	public function listing()
	{
		$this->data["breadcrumb"]["Transaction List"] = base_url() . "ledger/listing";
		$this->data['meta_title'] = 'Transaction Listing';
		$this->data['meta_description'] = "Transaction Listing";
		$this->data['page_title'] = 'Transaction Listing';
		
		$this->data['arr_data'] =  $this->ledger_m->transaction_list();
		
		$this->load->view('ledger/transaction_listing_v', $this->data);
	}
	
	public function add()
	{
		if($_POST) 
		{
			$post_data = $_POST;
			
			$rs = $this->ledger_m->save_transaction($post_data);
			
			#Return with validation error
			if($rs === false) {
				if(is_array($post_data)) {
					$this->data["row"] = new stdClass();
					foreach ($post_data as $key => $value)
					{
						$this->data["row"]->$key = $value;
					}
				}
			}
			
			// #Successfully saved and redirect back to this function without $_POST
			else {
				redirect('ledger/listing/');
			}
		}
		
		$this->data["breadcrumb"]["Add New Transaction"] = base_url() . "ledger/add";
		$this->data['meta_title'] = 'Add new transaction';
		$this->data['page_title'] = 'Add new transaction';
		$this->data['meta_description'] = "Add new transaction";
		// ad($this->data);exit;
		$this->load->view('ledger/transaction_form_v', $this->data);
	}
	
	public function edit($id = null)
	{
		if($id > 0)
		{
			$this->data["breadcrumb"]["Update transaction"] = base_url() . "ledger/edit/" . $id;
			$this->data['meta_title'] = 'Update transaction';
			$this->data['meta_description'] = "Update transaction details";
			$this->data['page_title'] = 'Update transaction details';
			$this->data['menu_name'] = "Edit Transaction";
			$this->data['row'] = $this->ledger_m->get_transaction($id);
			
			if($this->data['row'] !== false)
			{
				$date = date('d/m/Y', strtotime($this->data['row']->date));
				$this->data['row']->date = $date;
			}
			
			$this->load->view('ledger/transaction_form_v', $this->data);
		}
		else
		{
			set_message('Data not available','danger');
			redirect('ledger/listing');
		}
	} 
}
