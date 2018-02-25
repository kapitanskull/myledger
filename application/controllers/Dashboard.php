<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public $data;
	
	public function __construct()
   	{
        parent::__construct();
        
        security_checking();
       
		$this->data["breadcrumb"] = array(
			"Dashboard" => base_url() . "dasboard/"
		);
		
		$this->data['controller'] = 'dashboard';
		$this->data['function'] = $this->uri->segment(2);
		
		// echo date('Y-m-d H:i:s', strtotime('2018-02-23T12:00:00'));exit;
	}

	public function index()
	{
		redirect('dashboard/home');
	}
	
	public function home()
	{
		$this->load->model('ledger_m');
		
		
		$this->data['meta_title'] = 'Dashboard';
		$this->data['meta_description'] = "Dashboard transaction";
		$total_income = $this->ledger_m->calculate_income();
		$total_expenses = $this->ledger_m->calculate_expenses();
		
		$this->data['total_income'] = $total_income;
		$this->data['total_expenses'] = $total_expenses;
		$this->data['net_income'] = $total_income - $total_expenses;
		
		$this->load->view('home_page_v', $this->data);
	}
}
