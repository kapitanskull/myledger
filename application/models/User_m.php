<?php
 
class User_m extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }
	
	function user_list()
	{
		$query = $this->db->query("SELECT COUNT(`id`) AS total FROM `users`")->row();
		$data['total_rows'] = $query->total;

		$config['base_url'] = site_url() . '/user/listing/';
		$config['uri_segment'] = 3;
		$config['total_rows'] = $data['total_rows'];#num row data in the db
		$config['per_page'] = PAGING_DEFAULT_LIMIT;#number of data be display
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['num_per_page'] = $config['per_page'];
		
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
	
	function search_users($keyword64)
	{
		$where_sql = "";
		$post = json_decode(decrypt_base64($keyword64));
		
		$order_sql = "ORDER BY `id` DESC"; //by default sorting
		$per_page_data = PAGING_DEFAULT_LIMIT;
		
		//searching
	    if(isset($post->column_name) && $post->keyword_search != '') {
		    $where_sql = " WHERE `first_name` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `last_name` LIKE " . $this->db->escape('%' . $post->keyword_search . '%');
	    }
		
		//for sorting
		if(isset($post->column_name) && $post->column_name != '' && $post->sort_type != ''){
			$order_sql = " ORDER BY `" . $post->column_name . "` " . $post->sort_type;
		}
		
		//limitation data to display
		if(isset($post->num_per_page) && $post->num_per_page != '' && is_numeric($post->num_per_page) && $post->num_per_page > 0){
			$per_page_data = $post->num_per_page;
		}
	    
	    $data = json_decode(decrypt_base64($keyword64), true); // Get as Arrays
		
		$sql_count = "SELECT COUNT(id) AS total FROM `users` " . $where_sql;
		$query = $this->db->query($sql_count)->row();
		
		#for pagination button we link to ajax function so next content will generate using ajax
		$config['base_url'] = site_url() . '/user/search/' . $keyword64 . '/';
		$data['total_rows'] = $query->total;		
		$config['uri_segment'] = 4;
		$config['total_rows'] = $data['total_rows'];
		$config['per_page'] = $per_page_data;

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['num_per_page'] = $per_page_data;

		$sql_limit = '';
		if($data['total_rows'] > 0) {
			if($this->uri->segment($config['uri_segment']) AND is_numeric($this->uri->segment($config['uri_segment'])))
			{
				$sql_limit = ' LIMIT ' . $this->uri->segment($config['uri_segment']) . ', ' . $config['per_page'];
			}
			else
			{
				$sql_limit = ' LIMIT 0, ' . $config['per_page'];
			}
		}
		
		$sql_query = "SELECT * FROM `users` " . $where_sql . $order_sql . $sql_limit;
	
		$data['query'] = $this->db->query($sql_query);
		
		return $data;
	}
	
	function save_user($data = array()){
		$DBdata = array(
	    	'first_name' => trim($data['first_name']),
			'last_name' => trim($data['last_name']),
			'username' => trim($data['username']),
			'password' => trim($data['password']),
	    	'create_by' => trim('1'),
	    	'create_date' => date('Y-m-d H:i:s')
	    );
		
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
		
		if($DBdata['password'] == '')
		{
			set_message("Please enter password.", "danger");
	    	return false;
		}
	
		if(!preg_match("/[A-Za-z0-9]+/", $DBdata['password']))
		{
			set_message('Please enter a valid password. Only a-z, A-Z or 0-9 are allowed.', 'danger');
			return false;
		}
			
		if($confirm_password == '' || $confirm_password != $DBdata['password'] ||!preg_match("/[A-Za-z0-9]+/", $confirm_password))
		{
			set_message('Your Passwords do not match each other, please try again', 'danger');
			return false;
		}
		
		// if($ori_password == $DBdata['password'])
			$DBdata['password'] = md5($DBdata['password']);
			
		if(!isset($data['status'])) {
	    	set_message("Please select status .", "danger");
	    	return false;
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
		$id = $this->input->post('remove_data_id');
		
		$sql = "DELETE FROM `users` WHERE `id` = " . $this->db->escape($id) . " LIMIT 1";
		$query = $this->db->query($sql);
		
		if($this->db->affected_rows() > 0) {
			set_message("Successfully delete data.");
			audit_trail($this->db->last_query(), 'user_m.php', 'delete_user()', 'Delete User');
			
			return true;
		} 
		
		set_message("Invalid Requested Please Try Again", "danger");
		
		return false;
	}
	
}