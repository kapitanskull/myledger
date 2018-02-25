<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
	public $data;
	
	public function __construct()
   	{
        parent::__construct();
        
        security_checking();
        
		// #Auto load the required model
 		$this->load->model('event_m');
	
		$this->data["breadcrumb"] = array(
			"Event" => base_url() . "event/"
		);
		
		$this->data['controller'] = 'event';
		$this->data['function'] = $this->uri->segment(2);
		
		// echo strtotime('2018-02-25 14:34') . "=====" . strtotime('2018-02-25 14:31') . "====" . strtotime('2018-02-02T00:00:00') . "===" . strtotime('2018-02-02');
		// echo date('Y-m-d H:i', strtotime('2018-02-02T00:00:00'));
		// echo date('Y-m-d H:i', strtotime('2018-02-02'));
		// ad(explode(" ", '2018-02-25 14:34'));
		// if(strtotime('25/02/2018 14:34') > strtotime('25/02/2018 14:31') )
		// {
			// echo "true";exit;
		// }
		// echo 'false';exit;
	}
	

	public function index()
	{
		redirect('event/add');
	}
	
	public function listing()
	{
		$this->data["breadcrumb"]["Event Listing"] = base_url() . "event/listing";
		$this->data['meta_title'] = 'Event Listing';
		$this->data['meta_description'] = "Event Listing";
		$this->data['page_title'] = 'Event Listing';
		
		$this->data['arr_data'] =  $this->event_m->event_list();
		
		$this->load->view('event/event_listing_v', $this->data);
	}
	
	#for searching it will refresh page
	public function search($keyword64 = null)
	{
		$this->data["breadcrumb"]["Event search"] = base_url() . "event/search";
		$this->data['meta_title'] = 'Event Search';
		$this->data['meta_description'] = "Event Search";
		$this->data['page_title'] = 'Event Search';
		
		#Process the posted data, then redirect back to this function
		if($_POST){
			
		  #We Base64 Encode the search String, it's for safe url passing.
		  $keyword = encrypt_base64(json_encode($this->input->post()));
			
		  #Search button pressed with empty search string 
		  if($keyword == '')
			   redirect("event/search");
		  else
			 redirect("event/search/" . $keyword);	
		  
			exit();
		}
		
		if($keyword64 != null) {
		  #Get the data from DB
			$this->data['arr_data'] = $this->event_m->search_event($keyword64);
		}
		
		$this->load->view('event/event_listing_v', $this->data);
	}
	
	#for sorting, change numbber_page, it will generate by ajax
	public function ajax_sorting($keyword64 = null)
	{
		$this->data["breadcrumb"]["Event Search"] = base_url() . "event/search";
		$this->data['meta_title'] = 'Event Search';
		$this->data['meta_description'] = "Event Search";
		$this->data['page_title'] = 'Event Search';
		
		#Process the posted data, then redirect back to this function
		if($_POST){
			
		  #We Base64 Encode the search String, it's for safe url passing.
		  $keyword = encrypt_base64(json_encode($this->input->post()));
			
		  #Search button pressed with empty search string 
		  if($keyword == '')
			   redirect("event/ajax_sorting");
		  else
			 redirect("event/ajax_sorting/" . $keyword);	
		  
			exit();
		}
		
		if($keyword64 == null) {
		  #Get the data from DB
		  $keyword64 = encrypt_base64(json_encode(array('keyword_search' => "")));
		}
		
		$this->data['arr_data'] = $this->event_m->search_event($keyword64);
	
		$this->load->view("event/ajax_transaction_listing_v", $this->data);
	}
	
	public function add()
	{
		if($_POST) 
		{
			$post_data = $_POST;
			
			$rs = $this->event_m->save_event($post_data);
			
			#Return with validation error
			if($rs === false) {
				if(is_array($post_data)) {
					$this->data["row"] = new stdClass();
					foreach ($post_data as $key => $value)
					{
						$this->data["row"]->$key = $value;
					}
				}
				
				if(isset($this->data["row"]->id) AND $this->data["row"]->id > 0)
				{
					redirect('event/edit/' . $this->data["row"]->id);
				}
			}
			
			// #Successfully saved and redirect back to this function without $_POST
			else {
				redirect('event/listing/');
			}
		}
		
		$this->data["breadcrumb"]["Add New Event"] = base_url() . "event/add";
		$this->data['meta_title'] = 'Add new event';
		$this->data['page_title'] = 'Add new event';
		$this->data['meta_description'] = "Add new event";
		
		$this->load->view('event/event_form_v', $this->data);
	}
	
	public function edit($id = null)
	{
		if($id > 0)
		{
			$this->data["breadcrumb"]["Update event"] = base_url() . "event/edit/" . $id;
			$this->data['meta_title'] = 'Update event';
			$this->data['meta_description'] = "Update event details";
			$this->data['page_title'] = 'Update event details';
			$this->data['menu_name'] = "Edit event";
			$this->data['row'] = $this->event_m->get_event($id);
			
			if($this->data['row'] !== false)
			{
				if($this->data['row']->event_start_datetime != "")
				{
					if($this->data['row']->event_start_datetime != "0000-00-00 00:00:00")
					{
						$startdate = date('d/m/Y H:i', strtotime($this->data['row']->event_start_datetime));
						$this->data['row']->event_start_datetime = $startdate;
					}
					else
					{
						$this->data['row']->event_start_datetime = "";
					}
				}
				
				if($this->data['row']->event_end_datetime != "")
				{
					#to make sure if data store in db valid date time
					if($this->data['row']->event_end_datetime != "0000-00-00 00:00:00")
					{
						#only convert valid date time into datetime js for display back
						$enddate = date('d/m/Y H:i', strtotime($this->data['row']->event_end_datetime));
						$this->data['row']->event_end_datetime = $enddate;
					}
					else
					{
						$this->data['row']->event_end_datetime = "";
					}
				}
				
				$this->load->view('event/event_form_v', $this->data);
			}
			else{
				set_message('Data not available', 'danger');
				redirect('ledger/listing');
			}
		}
		else
		{
			set_message('Data not available','danger');
			redirect('ledger/listing');
		}
	} 
	
	function del_data()
	{
		$rs = $this->event_m->delete_event();
		
		if($rs === false) 
			set_message("Delete failed. Data has not changed", "error");
		else 
			set_message("user has been deleted.", "success");

		redirect('event/listing/');
	}
	
}
