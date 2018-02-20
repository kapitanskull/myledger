<?php
 
class User_m extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function user_list()
	{
		$query = $this->db->query("SELECT COUNT(`id`) AS total FROM `users`")->row();
		$data['total_rows'] = $query->total;

		$config['base_url'] = base_url() . 'index.php/user/listing/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = $data['total_rows'];#num row data in the db
		$config['per_page'] = 10;#number of data be display
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$sql = '';
		if($data['total_rows'] > 0){
			if($this->uri->segment($config['uri_segment']) && is_numeric($this->uri->segment($config['uri_segment'])))
			{
				$sql = ' LIMIT ' . $this->uri->segment($config['uri_segment']) . ', ' . $config['per_page'];
			}
			else
			{
				$sql = ' LIMIT 0, ' . $config['per_page'];
			}
		}

		$data['query'] = $this->db->query("SELECT * FROM `users` ORDER BY `id` DESC $sql");

		return $data;
	}
	
	function save_user($data = array()){
		$DBdata = array(
	    	'first_name' => trim($data['first_name']),
			'last_name' => trim($data['last_name']),
			'username' => trim($data['username']),
	    	'create_by' => trim('1'),
	    	'create_date' => date('Y-m-d H:i:s')
	    );
		
		$password = trim($data['password']);
		$ori_password = trim($data['ori_password']);
		$confirm_password = trim($data['confirm_password']);
		$id = trim($data['id']);
		
		if($DBdata['first_name'] == '') {
	    	set_message("Please enter first name.", "danger");
	    	return false;
	    }
		
		if($DBdata['last_name'] == '') {
	    	set_message("Please enter last name.", "danger");
	    	return false;
	    }
		
		if($DBdata['username'] == '') {
	    	set_message("Please enter username.", "danger");
	    	return false;
	    }
		
		if($password == '')
		{
			set_message("Please enter password.", "danger");
	    	return false;
		}
		
		if(strlen($password) < 6)
		{
			set_message("Minimum password is 6 character.", "danger");
	    	return false;
		}
		
		if($confirm_password == '')
		{
			set_message("Please enter confirm password.", "danger");
	    	return false;
		}
		
		if($password !== $confirm_password)
		{
			set_message("Your password and confirmation password not same.", "danger");
	    	return false;
		}
	
		if(!isset($data['status'])) {
	    	set_message("Please select status .", "danger");
	    	return false;
	    }
		
		if(isset($ori_password) AND $ori_password != md5($password))
		{
			$DBdata['password'] = md5($password);
		}
		
		
		$DBdata['status'] = trim($data['status']);
		
		#Check if the System ID is already existed in the db.
		$sql = "SELECT * FROM `users` WHERE `username` LIKE " . $this->db->escape($DBdata['username']);
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
			$row = $query->row();
			
			if(isset($id) && $id > 0){
				if($row->id != $id){
					set_message("The username is already taken. Please use a different one.", "danger");
					return false;
				}
			}
			else{
				set_message("The usrname is already taken. Please use a different one.", "danger");
				return false;
			}
		}
		
		if(isset($id) && $id > 0){
			$DBdata['modify_by'] = trim('1');
	    	$DBdata['modify_date'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			$rs = $this->db->update('users', $DBdata); 
			set_message("Update success. Thank you");
			audit_trail($this->db->last_query(), 'access_m.php', 'save_user()', 'Update User Details');
		}
		else{
			$rs = $this->db->insert('users', $DBdata);
			set_message("Register success . Thank you");
			audit_trail($this->db->last_query(), 'access_m.php', 'save_user()', 'Create New User');
		}
			
		return $rs;
	}
	
	
	function get_user($id = 0){
		if($id > 0){
			$sql = "SELECT * FROM `users` WHERE `id` = " . $this->db->escape($id) . " LIMIT 1";
			$q = $this->db->query($sql);
			
			return $q->num_rows() > 0 ? $q->row() : false;
		}
		else
			return false;
		
	}
	
	
	
	function delete_user(){
		$id = $this->input->post('remove_id');
		
		$sql2 = "SELECT * FROM `ci_user` WHERE `create_by` =" . $this->db->escape($id);
		$query2 = $this->db->query($sql2);
		
		if($query2->num_rows() > 0){
			$sql3 = "DELETE FROM `ci_user` WHERE `create_by` = " . $this->db->escape($id) ." AND `user_type` = 'sub insurer'";
			$query3 = $this->db->query($sql3);
		}
		
		$sql = "DELETE FROM `ci_user` WHERE `id` = " . $this->db->escape($id) ." AND `user_type` != 'superadmin' LIMIT 1";
		$query = $this->db->query($sql);
		
		if($this->db->affected_rows() > 0) {
			set_message("Successfully delete User Requested.");
			audit_trail($this->db->last_query(), 'Access_m.php', 'remove_user()', 'Delete User');
			
			return true;
		} 
		
		set_message("Invalid Requested Please Try Again", "danger");
		
		return false;
	}
	
	function delete_admin(){
		$id = $this->input->post('remove_id');
		
		$query = "DELETE FROM `ci_user` WHERE `id` = " . $this->db->escape($id) ." AND `user_type` = 'superadmin' LIMIT 1";
		$sql = $this->db->query($query);
		
		if($this->db->affected_rows() > 0) {
			set_message("Successfully delete Admin Requested.");
			audit_trail($this->db->last_query(), 'Access_m.php', 'remove_user()', 'Delete Admin');
			
			return true;
		} 
		
		set_message("Invalid Requested Please Try Again", "danger");
		
		return false;
	}
}