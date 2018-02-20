<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public $data;
	
	public function __construct()
   	{
        parent::__construct();
        
        security_checking();
        
		// #Auto load the required model
 		// $this->load->model('access_m');
	
		$this->data["breadcrumb"] = array(
			"Dashboard" => base_url() . "dasboard/"
		);
		
		$this->data['controller'] = 'dashboard';
		$this->data['function'] = $this->uri->segment(2);
	}
	

	public function index()
	{
		redirect('dashboard/home');
	}
	
	public function add()
	{
		$this->data["breadcrumb"]["Add User"] = base_url() . "dashboard/add";
		$this->data['meta_title'] = 'Add record';
		$this->data['meta_description'] = "Add new record transaction";
		// ad($this->data);exit;
		$this->load->view('base_page_v', $this->data);
	}
	
	public function home()
	{
		$this->data['meta_title'] = 'Dashboard';
		$this->data['meta_description'] = "Dashboard transaction";
		$this->load->view('home_page_v', $this->data);
	}
}
