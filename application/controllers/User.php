<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public $data;
	
	public function __construct()
   	{
        parent::__construct();
        
        security_checking();
		
		if($this->session->has_userdata('user_type') AND $this->session->userdata('user_type') != 'admin')
		{
			redirect('dashboard/');
		}
        
		// #Auto load the required model
 		$this->load->model('user_m');
	
		$this->data["breadcrumb"] = array(
			"User" => base_url() . "user/"
		);
		
		$this->data['controller'] = 'user';
		$this->data['function'] = $this->uri->segment(2);
	}
	

	public function index()
	{
		redirect('user/listing');
	}
	
	public function listing()
	{
		$this->data["breadcrumb"]["User List"] = base_url() . "user/listing";
		$this->data['meta_title'] = 'User Listing';
		$this->data['meta_description'] = "User Listing";
		$this->data['page_title'] = 'User Listing';
		
		$this->data['arr_data'] =  $this->user_m->user_list();
		
		$this->load->view('user/user_listing_v', $this->data);
	}
	
	public function add()
	{
		if($_POST) 
		{
			$post_data = $_POST;
			
			$rs = $this->user_m->save_user($post_data);
			
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
				redirect('user/listing/');
			}
		}
		
		$this->data["breadcrumb"]["Add User"] = base_url() . "user/add";
		$this->data['meta_title'] = 'Add user';
		$this->data['page_title'] = 'Add new user';
		$this->data['meta_description'] = "Add new user";
		
		$this->load->view('user/user_form_v', $this->data);
	}
	
	public function edit($id = null)
	{
		if($id > 0 AND $id != '1')
		{
			$this->data["breadcrumb"]["Update User"] = base_url() . "user/edit/" . $id;
			$this->data['meta_title'] = 'Update user';
			$this->data['meta_description'] = "Update user details";
			$this->data['page_title'] = 'Update details';
			$this->data['row'] = $this->user_m->get_user($id);
			
			$this->load->view('user/user_form_v', $this->data);
		}
		else
		{
			set_message('Data not available','danger');
			redirect('user/listing');
		}
	} 
}
