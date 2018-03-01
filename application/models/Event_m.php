<?php
 
class Event_m extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function event_list()
	{
		$where_sql = " WHERE `user_id` = " . $this->db->escape($this->session->userdata('id'));
		
		$query_count = "SELECT COUNT(`id`) AS total FROM `event`" . $where_sql;
		$query = $this->db->query($query_count)->row();
		$data['total_rows'] = $query->total;

		$config['base_url'] = site_url() . '/event/listing/';
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
		
		$query_data = "SELECT * FROM `event` " . $where_sql . " ORDER BY `event_start_datetime` ASC " . $limit_sql;
		
		$data['query'] = $this->db->query($query_data);

		return $data;
	}
	
	function search_event($keyword64)
	{
		$where_sql = "WHERE `user_id` = " . $this->session->userdata('id');
		
		#as object
		$post = json_decode(decrypt_base64($keyword64));
		
		$order_sql = " ORDER BY `event_start_datetime` ASC"; //by default sorting
		$per_page_data = PAGING_DEFAULT_LIMIT;
		
		if(isset($post->transaction_date_range) && $post->transaction_date_range != '')
		{
			$date_range = explode("-", $post->transaction_date_range);
			
			if(is_array($date_range) AND sizeof($date_range) == 2)
			{
				$arr_start_date = explode(' ', trim($date_range[0]));
				
				if(is_array($arr_start_date) AND sizeof($arr_start_date) == 2)
				{
					$start_date = datepicker2mysql($arr_start_date[0]);
					$arr_start_date[0] = $start_date;
					$arr_start_date[1] = $arr_start_date[1] . ":00";
					
					$startDate = implode(' ', $arr_start_date);
				}
				
				$arr_end_date = explode(' ', trim($date_range[1]));
				if(is_array($arr_end_date) AND sizeof($arr_end_date) == 2)
				{
					$end_date = datepicker2mysql($arr_end_date[0]);
					$arr_end_date[0] = $end_date;
					$arr_end_date[1] = $arr_end_date[1] . ":00";
					
					$endDate = implode(' ', $arr_end_date);
				}
				
				#refer this list about this sql condition (http://wiki.lessthandot.com/index.php/Date_Range_WHERE_Clause_Simplification)
				if(isset($startDate) AND isset($endDate))
					$where_sql .= ($where_sql == '' ? " WHERE " : " AND ") . " (`event_start_datetime` < " . $this->db->escape(trim($endDate)) . " AND `event_end_datetime` >= " . $this->db->escape(trim($startDate)) . ")";
			}
		}
		
		//searching
	    if(isset($post->column_name) && $post->keyword_search != '') {
		    $where_sql = " WHERE `event_title` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `event_description` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `event_start_datetime` LIKE " . $this->db->escape('%' . $post->keyword_search . '%') . " OR `event_end_datetime` LIKE " . $this->db->escape('%' . $post->keyword_search . '%');
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
		
		$sql_count = "SELECT COUNT(id) AS total FROM `event` " . $where_sql;
		$query = $this->db->query($sql_count)->row();
		
		#for pagination button we link to ajax function so next content will generate using ajax
		$config['base_url'] = site_url() . '/event/search/' . $keyword64 . '/';
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
		
		$sql_query = "SELECT * FROM `event` " . $where_sql . $order_sql . $sql_limit;
		
		$data['query'] = $this->db->query($sql_query);
		
		return $data;
	}
	
	function save_event($data = array()){
		$arr_start_date = array();
		$arr_end_date = array();
		
		if(sizeof($data) > 0)
		{
			$DBdata = array(
				'event_title' => trim($data['event_title']),
				'event_description' => trim($data['event_description']),
				'event_start_datetime' => trim($data['event_start_datetime']),
				'event_end_datetime' => trim($data['event_end_datetime']),
				'user_id' => trim($this->session->userdata('id')),
				'create_by' => trim($this->session->userdata('id')),
				'create_date' => trim(date('Y-m-d H:i:s')),
			);
			
			$id = isset($data['id']) ? $data['id'] : 0;
			$DBdata['all_day'] = isset($data['all_day']) ? $data['all_day'] : 0;
			
			if($DBdata['event_title'] == '') {
				set_message("Please enter event title.", "danger");
				return false;
			}
			
			if($DBdata['event_start_datetime'] == '') {
				set_message("Please set event start datetime", "danger");
				return false;
			}
			
			if($DBdata['event_end_datetime'] != '') 
			{
				$arr_end_date = explode(' ', $DBdata['event_end_datetime']);
				
				if(is_array($arr_end_date) AND sizeof($arr_end_date) == 2)
				{
					$end_date = datepicker2mysql(trim($arr_end_date[0]));
					$arr_end_date[0] = $end_date;
					$arr_end_date[1] = $arr_end_date[1] . ":00";
					$DBdata['event_end_datetime'] = implode(' ', $arr_end_date);
				}
			}
			
			#explode to separate date and time and need to convert date into mysql datetime
			$arr_start_date = explode(' ', $DBdata['event_start_datetime']);
			if(is_array($arr_start_date) AND sizeof($arr_start_date) == 2)
			{
				$start_date = datepicker2mysql(trim($arr_start_date[0]));
				$arr_start_date[0] = $start_date;
				$arr_start_date[1] = $arr_start_date[1] . ":00";
				$DBdata['event_start_datetime'] = implode(' ', $arr_start_date);
				
				
				#if end date time empty will set date as start date and time will be 23:59:59
				if($DBdata['event_end_datetime'] == '')
				{
					echo "masuk2";
					$arr_end_date[0] = $start_date;
					$arr_end_date[1] = "23:59:59";
					$DBdata['event_end_datetime'] = implode(' ', $arr_end_date);
				}
			}
			
			if($DBdata['event_end_datetime'] != '')
			{
				#check date end must bigger thant start date
				if(strtotime($DBdata['event_end_datetime']) < strtotime($DBdata['event_start_datetime']))
				{
					set_message("End date time must more than start date time", "danger");
					return false;
				}
			}
			
			if(isset($id) && $id > 0){
				
				$DBdata['update_by'] = trim($this->session->userdata('id'));
				$DBdata['update_date'] = trim($this->session->userdata('id'));
				$this->db->where('id', $id);
				$rs = $this->db->update('event', $DBdata); 
				set_message("Update success.");
				audit_trail($this->db->last_query(), 'event_m.php', 'save_event()', 'Update event Details');
			}
			else{
				$rs = $this->db->insert('event', $DBdata);
				set_message("Event recorded.");
				audit_trail($this->db->last_query(), 'event_m.php', 'save_event()', 'Create New event');
			}
				
			return $rs;
		}
		else
		{
			set_message('No data been post');
			return false;
		}
	}
	
	function get_event($id = 0){
		if($id > 0){
			$sql = "SELECT * FROM `event` WHERE `id` = " . $this->db->escape($id) . " AND `user_id` = " . $this->db->escape($this->session->userdata('id')) . " LIMIT 1";
			$q = $this->db->query($sql);
			
			return $q->num_rows() > 0 ? $q->row() : false;
		}
		else
			return false;
		
	}
	
	function delete_event(){
		$id = $this->input->post('remove_data_id');
		
		$sql = "DELETE FROM `event` WHERE `id` = " . $this->db->escape($id) . " AND `user_id` = " .  $this->db->escape($this->session->userdata('id')) . " LIMIT 1";
		$query = $this->db->query($sql);
		
		if($this->db->affected_rows() > 0) {
			set_message("Successfully delete data.");
			audit_trail($this->db->last_query(), 'event_m.php', 'delete_event()', 'Delete event');
			
			return true;
		} 
		
		set_message("Invalid Requested Please Try Again", "danger");
		
		return false;
	}
	
	
	function get_event_for_dashboard()
	{
		$sql_data = "SELECT * FROM `event` WHERE `user_id` = " . $this->db->escape(trim($this->session->userdata('id')));
		$q = $this->db->query($sql_data);
		
		return $q->num_rows() > 0 ? $q : false;
	}
}