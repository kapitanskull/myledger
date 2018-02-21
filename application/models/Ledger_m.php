<?php
 
class Ledger_m extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function transaction_list()
	{
		$total_income = 0;
		$total_expense = 0;
		
		$where_sql = " WHERE `user_id` = " . $this->db->escape($this->session->userdata('id'));
		
		$query_count = "SELECT COUNT(`id`) AS total FROM `transaction_records`" . $where_sql;
		$query = $this->db->query($query_count)->row();
		$data['total_rows'] = $query->total;

		$config['base_url'] = site_url() . '/ledger/listing/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = $data['total_rows'];#num row data in the db
		$config['per_page'] = PAGING_DEFAULT_LIMIT;#number of data be display
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$limit_sql = '';
		if($data['total_rows'] > 0){
			if($this->uri->segment($config['uri_segment']) && is_numeric($this->uri->segment($config['uri_segment'])))
			{
				$limit_sql = ' LIMIT ' . $this->uri->segment($config['uri_segment']) . ', ' . $config['per_page'];
			}
			else
			{
				$limit_sql = ' LIMIT 0, ' . $config['per_page'];
			}
		}
		
		$query_data = "SELECT * FROM `transaction_records` " . $where_sql . " ORDER BY `date` ASC " . $limit_sql;
		
		$data['query'] = $this->db->query($query_data);
		
		#calculate total income from db
		$sql_income = "SELECT SUM(`amount`) as 'total_income' FROM `transaction_records` WHERE `amount_type` = 'income' AND `user_id` = " . $this->db->escape($this->session->userdata('id'));
		$query_income = $this->db->query($sql_income);
		if($query_income->num_rows() > 0)
		{
			$total_income = $query_income->row()->total_income;
		}
		
		$sql_expenses = "SELECT SUM(`amount`) as 'total_expenses' FROM `transaction_records` WHERE `amount_type` = 'expenses' AND `user_id` = " . $this->db->escape($this->session->userdata('id'));
		$query_expenses = $this->db->query($sql_expenses);
		if($query_expenses->num_rows() > 0)
		{
			$total_expenses = $query_expenses->row()->total_expenses;
		}
		
		$data['total_income'] = $total_income;
		$data['total_expenses'] = $total_expenses;
		$data['net_income'] = $total_income - $total_expenses;

		return $data;
	}
	
	function save_transaction($data = array()){
		
		$DBdata = array(
	    	'description' => trim($data['description']),
			'amount_type' => trim($data['amount_type']),
			'amount' => trim($data['amount']),
	    	'user_id' => trim($this->session->userdata('id')),
	    );
		
		$id = isset($data['id']) ? $data['id'] : 0;
		$date = $data['date'];
		
		if($date == '') {
	    	set_message("Please select date.", "danger");
	    	return false;
	    }
		
		if($DBdata['description'] == '') {
	    	set_message("Please enter description.", "danger");
	    	return false;
	    }
		
		if($DBdata['amount_type'] == '') {
	    	set_message("Please select transaction type.", "danger");
	    	return false;
	    }
		
		if($DBdata['amount'] == '') {
	    	set_message("Please enter amount.", "danger");
	    	return false;
	    }
		
		if(!is_numeric($DBdata['amount'])) {
	    	set_message("Contain number only", "danger");
	    	return false;
	    }
		
		if($DBdata['amount'] <= 0) {
	    	set_message("Amount at least RM 1.00", "danger");
	    	return false;
	    }
		
		if($DBdata['description'] == '') {
	    	set_message("Please enter description.", "danger");
	    	return false;
	    }
		
		$arr_date = explode('/', $date);
		
		$DBdata['date'] = $arr_date[2] . '-' . $arr_date[1] . '-' . $arr_date[0];
		
		if(isset($id) && $id > 0){
			
			$this->db->where('id', $id);
			$rs = $this->db->update('transaction_records', $DBdata); 
			set_message("Update success. Thank you");
			audit_trail($this->db->last_query(), 'access_m.php', 'save_user()', 'Update transaction Details');
		}
		else{
			$rs = $this->db->insert('transaction_records', $DBdata);
			set_message("Register success . Thank you");
			audit_trail($this->db->last_query(), 'access_m.php', 'save_user()', 'Create New transaction');
		}
			
		return $rs;
	}
	
	
	function get_transaction($id = 0){
		if($id > 0){
			$sql = "SELECT * FROM `transaction_records` WHERE `id` = " . $this->db->escape($id) . " AND `user_id` = " . $this->db->escape($this->session->userdata('id')) . " LIMIT 1";
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