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
	
	#for searching it will refresh page
	public function search($keyword64 = null)
	{
		$this->data["breadcrumb"]["Transaction search"] = base_url() . "ledger/search";
		$this->data['meta_title'] = 'Transaction Search';
		$this->data['meta_description'] = "Transaction Search";
		$this->data['page_title'] = 'Transaction Search';
		
		#Process the posted data, then redirect back to this function
		if($_POST){
			
		  #We Base64 Encode the search String, it's for safe url passing.
		  $keyword = encrypt_base64(json_encode($this->input->post()));
			
		  #Search button pressed with empty search string 
		  if($keyword == '')
			   redirect("ledger/search");
		  else
			 redirect("ledger/search/" . $keyword);	
		  
			exit();
		}
		
		if($keyword64 != null) {
		  #Get the data from DB
			$this->data['arr_data'] = $this->ledger_m->search_transaction($keyword64);
		}
		
		$this->load->view('ledger/transaction_listing_v', $this->data);
	}
	
	#for sorting, change numbber_page, it will generate by ajax
	public function ajax_sorting($keyword64 = null)
	{
		$this->data["breadcrumb"]["Transcation Search"] = base_url() . "ledger/search";
		$this->data['meta_title'] = 'Transaction Search';
		$this->data['meta_description'] = "Transaction Search";
		$this->data['page_title'] = 'Transaction Search';
		
		#Process the posted data, then redirect back to this function
		if($_POST){
			
		  #We Base64 Encode the search String, it's for safe url passing.
		  $keyword = encrypt_base64(json_encode($this->input->post()));
			
		  #Search button pressed with empty search string 
		  if($keyword == '')
			   redirect("ledger/ajax_sorting");
		  else
			 redirect("ledger/ajax_sorting/" . $keyword);	
		  
			exit();
		}
		
		if($keyword64 == null) {
		  #Get the data from DB
		  $keyword64 = encrypt_base64(json_encode(array('keyword_search' => "")));
		}
		
		$this->data['arr_data'] = $this->ledger_m->search_transaction($keyword64);
	
		$this->load->view("ledger/ajax_transaction_listing_v", $this->data);
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
	
	function del_data()
	{
		$rs = $this->ledger_m->delete_transaction();
		
		if($rs === false) 
			set_message("Delete failed. Data has not changed", "error");
		else 
			set_message("user has been deleted.", "success");

		redirect('ledger/listing/');
	}
	
}
