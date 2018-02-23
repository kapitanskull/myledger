<?php
 
class Ledger_m extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function transaction_list()
	{
		$where_sql = " WHERE `user_id` = " . $this->db->escape($this->session->userdata('id'));
		
		$query_count = "SELECT COUNT(`id`) AS total FROM `transaction_records`" . $where_sql;
		$query = $this->db->query($query_count)->row();
		$data['total_rows'] = $query->total;

		$config['base_url'] = site_url() . '/ledger/listing/';
		$config['uri_segment'] = 3;
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
		
		#calculate total income,net income,expenses from db
		$total_income = $this->calculate_income();
		$total_expenses = $this->calculate_expenses();
		
		$data['total_income'] = $total_income;
		$data['total_expenses'] = $total_expenses;
		$data['net_income'] = $total_income - $total_expenses;

		return $data;
	}
	
	function search_transaction($keyword64)
	{
		$where_sql = "WHERE `user_id` = " . $this->session->userdata('id');
		
		#as object
		$post = json_decode(decrypt_base64($keyword64));
		
		$order_sql = " ORDER BY `date` ASC"; //by default sorting
		$per_page_data = PAGING_DEFAULT_LIMIT;
		
		if(isset($post->transaction_date_range) && $post->transaction_date_range != '')
		{
			$date_range = explode("-", $post->transaction_date_range);
			if(is_array($date_range) AND sizeof($date_range) > 0)
			{
				$start_date = datepicker2mysql(trim($date_range[0]));	
				$end_date = datepicker2mysql(trim($date_range[1]));
				
				$where_sql .= ($where_sql == '' ? " WHERE " : " AND ") . " (`date` >= " . $this->db->escape($start_date) . " AND `date` <= " . $this->db->escape($end_date) . ")";
			}
		}
		
		//searching
	    if(isset($post->column_name) && $post->keyword_search != '') {
		    $where_sql = " WHERE `description` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `amount_type` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `income` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `expenses` LIKE " . $this->db->escape('%' . $post->keyword_search . '%');
	    }
		
		//for sorting
		if(isset($post->column_name) && $post->column_name != '' && $post->sort_type != ''){
			$order_sql = " ORDER BY `" . $post->column_name . "` " . $post->sort_type;
		}
		
		//limitation data to display
		if(isset($post->num_per_page) && $post->num_per_page != '' && is_numeric($post->num_per_page) && $post->num_per_page > 0){
			$per_page_data = $post->num_per_page;
		}
	    
		#for display what data been post in array form
		$data = json_decode(decrypt_base64($keyword64), true); // Get as Arrays
		
		if(isset($date_range) AND is_array($date_range) AND sizeof($date_range) > 0)
		{
			#this variable will be use in javasript at the bottom of page transaction listing
			$data['forjquery_startdate'] = trim($date_range[0]);
			$data['forjquery_enddate'] = trim($date_range[1]);
		}
		
		$sql_count = "SELECT COUNT(id) AS total FROM `transaction_records` " . $where_sql;
		$query = $this->db->query($sql_count)->row();
		
		#for pagination button we link to ajax function so next content will generate using ajax
		$config['base_url'] = site_url() . '/ledger/search/' . $keyword64 . '/';
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
		
		$sql_query = "SELECT * FROM `transaction_records` " . $where_sql . $order_sql . $sql_limit;
		$data['query'] = $this->db->query($sql_query);
		
		#calculate total income,net income,expenses from db
		$total_income = $this->calculate_income();
		$total_expenses = $this->calculate_expenses();
		
		$data['total_income'] = $total_income;
		$data['total_expenses'] = $total_expenses;
		$data['net_income'] = $total_income - $total_expenses;
		
		return $data;
	}
	
	function save_transaction($data = array()){
		
		$DBdata = array(
	    	'description' => trim($data['description']),
			'amount_type' => trim($data['amount_type']),
	    	'user_id' => trim($this->session->userdata('id')),
	    );
		
		$id = isset($data['id']) ? $data['id'] : 0;
		$date = $data['date'];
		$amount = $data['amount'];
		
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
		
		if($amount == '') {
	    	set_message("Please enter amount.", "danger");
	    	return false;
	    }
		
		if(!is_numeric($amount)) {
	    	set_message("Contain number only", "danger");
	    	return false;
	    }
		
		if($amount <= 0) {
	    	set_message("Amount at least RM 1.00", "danger");
	    	return false;
	    }
		
		if($DBdata['description'] == '') {
	    	set_message("Please enter description.", "danger");
	    	return false;
	    }
		
		if($DBdata['amount_type'] == 'income')
		{
			$DBdata['income'] = trim($amount);
			$DBdata['expenses'] = "";
		}
		elseif($DBdata['amount_type'] == 'expenses')
		{
			$DBdata['income'] = "";
			$DBdata['expenses'] = trim($amount);
		}
		
		$arr_date = explode('/', $date);
		
		$DBdata['date'] = $arr_date[2] . '-' . $arr_date[1] . '-' . $arr_date[0];
		
		if(isset($id) && $id > 0){
			
			$this->db->where('id', $id);
			$rs = $this->db->update('transaction_records', $DBdata); 
			set_message("Update success.");
			audit_trail($this->db->last_query(), 'access_m.php', 'save_user()', 'Update transaction Details');
		}
		else{
			$rs = $this->db->insert('transaction_records', $DBdata);
			set_message("Transaction recorded .");
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
	
	function delete_transaction(){
		$id = $this->input->post('remove_data_id');
		
		$sql = "DELETE FROM `transaction_records` WHERE `id` = " . $this->db->escape($id) . " AND `user_id` = " .  $this->db->escape($this->session->userdata('id')) . " LIMIT 1";
		$query = $this->db->query($sql);
		
		if($this->db->affected_rows() > 0) {
			set_message("Successfully delete data.");
			audit_trail($this->db->last_query(), 'ledger_m.php', 'delete_transaction()', 'Delete transaction');
			
			return true;
		} 
		
		set_message("Invalid Requested Please Try Again", "danger");
		
		return false;
	}
	
	function calculate_income()
	{
		$sql_income = "SELECT SUM(`income`) as 'total_income' FROM `transaction_records` WHERE `amount_type` = 'income' AND `user_id` = " . $this->db->escape($this->session->userdata('id'));
		$query_income = $this->db->query($sql_income);
		if($query_income->num_rows() > 0)
		{
			return $query_income->row()->total_income;
		}
		else
			return 0;
	}
	
	function calculate_expenses()
	{
		$sql_expenses = "SELECT SUM(`expenses`) as 'total_expenses' FROM `transaction_records` WHERE `amount_type` = 'expenses' AND `user_id` = " . $this->db->escape($this->session->userdata('id'));
		$query_expenses = $this->db->query($sql_expenses);
		if($query_expenses->num_rows() > 0)
		{
			return $query_expenses->row()->total_expenses;
		}	
		else
			return 0;
	}
	
	
}