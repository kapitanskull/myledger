<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Array debug
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if(!function_exists("ad")) {
	function ad($data, $write = false){
		//Array Debug. 
		if($write) {
			ob_start();
			print_r($data);
			$output = ob_get_contents();
			ob_end_clean();

			$myFile = "C:/testFile.txt";
			$fh = fopen($myFile, 'a') or die("can't open file");
			
			$date = date("d-m-Y H:i:s") . "\n";
			fwrite($fh, $date);
			fwrite($fh, $output);
			fclose($fh);
		}
		else {
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Set message for display to browser. Useful for confirming certain process.
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if(!function_exists("set_message")) {
	 function set_message($feedback, $type = 'info')
	{
		#save notice.
		#Message Type: error, info
		
		$obj =& get_instance();
		$obj->session->set_userdata('system-message', $feedback);
		$obj->session->set_userdata('message-type', $type);
	}
}


// ------------------------------------------------------------------------

/**
 * Display message to browser.
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if(!function_exists("get_message")) {
	function get_message()
	{
		$obj =& get_instance();
		
		//Display notice.
		if($obj->session->userdata('system-message') != '')
		{ 
			$message_type = $obj->session->userdata('message-type');
			
			#For backward compatiblity. 
			if($message_type == 'error')
				$message_type = 'danger';
			
			echo '<div class="alert alert-' . $message_type . ' alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>' . 
					$obj->session->userdata('system-message') .
				'</div>';
				
			$obj->session->unset_userdata('system-message');
			$obj->session->unset_userdata('message-type');
		}
	}
}


/*
 * Security Checking.
 *
 * @access	public
 * @param	string
 * @return	true or false
 * group 1 => admin
 * group 2 => user
 */	

if(!function_exists("security_checking")) {
	function security_checking($group = false) {
		$obj =& get_instance();
		
		#If group is being specified
		if($group !== false) {
			if(is_array($group)) {
				$found = FALSE;
				foreach($group AS $key => $value) {
					if($obj->session->userdata('user_type') == $value)
						$found = TRUE;
				}
			}
			else
				$found = ($obj->session->userdata('user_type') == $group) ? TRUE : FALSE;
				
			if($found == TRUE AND $obj->session->userdata('logged_in') == TRUE)
				return true;
			else  {
				// if($found == FALSE)
					// $obj->session->userdata('redirect_login', 'home');
				// else 
					// $obj->session->userdata('redirect_login', $_SERVER['REQUEST_URI']);
				
				if($obj->session->userdata('logged_in') == TRUE){
					redirect('dashboard/');
				}
				else
					redirect('login/errorLogout');
				
				exit();
			}
		}
		#General checking for already logged in without specifying group type
		else {
			if($obj->session->userdata('logged_in') == TRUE AND $obj->session->userdata('user_type') != '')
				return true;
			else {
				redirect('login/errorLogout');
				exit();
			}
		}
	}
}

/**
 * Privilages Checking.
 *
 * @access	public
 * @param	string
 * @return	nothings
 * group_id ==> function id 
 * user_id ==> user table id
 */	
/* if(!function_exists("privileges_checking")) {
	function privileges_checking($group_id = '') {
		$obj =& get_instance();
		
		$obj->db->where('group_id', $group_id);
		$obj->db->where('user_id', $obj->session->userdata('user_id'));
		if($obj->db->get('pbx_privileges')->num_rows() == 0) {
			$obj->load->view('admin/access_denied');
		}
	}
}  */

if(!function_exists("sendmail")) {
	function sendmail($subject = null, $body = null, $to = null, $cc = array())
	{
		
		// echo ADMIN_EMAIL_SMTP_SECURE . "=====" . ADMIN_EMAIL_HOST . "====" . ADMIN_EMAIL_PORT . "====" . ADMIN_SMTP_EMAIL . "=====". ADMIN_EMAIL_PASS; exit;
		//require 'phpmailer/class.phpmailer.php';
		require_once 'phpmailer/PHPMailerAutoload.php';
		
		$mail             = new PHPMailer();
		
	// 	$body             = $mail->getFile('contents.html');
	// 	$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = ADMIN_EMAIL_SMTP_SECURE;                 // sets the prefix to the server
		$mail->Host       = ADMIN_EMAIL_HOST;      // sets GMAIL as the SMTP server
		$mail->Port       = ADMIN_EMAIL_PORT;                   // set the SMTP port for the GMAIL server
		$mail->SMTPDebug  = 0;                   // set the SMTP port for the GMAIL server

	
		$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
		);
		
		$mail->Username   = ADMIN_SMTP_EMAIL;  // GMAIL username
		$mail->Password   = ADMIN_EMAIL_PASS;            // GMAIL password
		
		$mail->From       = ADMIN_SMTP_EMAIL;
		$mail->FromName   = "OSM system";
		
		$mail->Subject    = $subject;
		
		$mail->Body       = "" . $body; //HTML Body
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->WordWrap   = 50; // set word wrap
		
		$mail->MsgHTML($mail->Body);
		
		$mail->AddAddress($to);
		
		// $bcc = array(
			// 'fendy@logicwise.com.my' => 'Affendy Iskandar', 
			// 'bhaihaqi@logicwise.com.my' => 'Bhaihaqi Saadon',
		// );
		// if(count($cc) > 0){
			// foreach($cc as $email => $name){
				// if($email != '');
					// $mail->AddCC($email, $name);
			// }
		// }
		// if(count($bcc) > 0){
			// foreach($bcc as $email => $name){
			   // $mail->AddBCC($email, $name);
			// }
		// }
		// $mail->AddAttachment("images/phpmailer.gif");             // attachment
		
		$mail->IsHTML(true); // send as HTML
		
		if(!$mail->Send())
			return $mail->ErrorInfo;
		else 
			return true;
			
		return false;
	}
}




/**
 * Use for Audit Trail
 */
if(!function_exists("audit_trail")) {
	function audit_trail($sql = null, $filename = null, $function = null, $comment = null) 
	{
		$CI =& get_instance();
		
		$sql = $CI->db->escape($sql);
		$filename = $CI->db->escape($filename);
		$function = $CI->db->escape($function);
		$comment = $CI->db->escape($comment);
		$ip_address = $CI->db->escape($_SERVER['REMOTE_ADDR']);
		$username = $CI->db->escape($CI->session->userdata('username'));
		
		$sql = "INSERT INTO ci_audit_trail SET `sql_str` = $sql, `filename` = $filename, `function` = $function, `comment` = $comment, `ip_address` = $ip_address, `username` = $username, insert_date = NOW()";
		$query = $CI->db->query($sql);
		
		return false;
	}
}

if(!function_exists("jquerydate2mysql")) {
	function jquerydate2mysql($jquerydate)
	{
		$jquerydate_arr = explode(' ', trim($jquerydate));
		if(sizeof($jquerydate_arr) == 3) {
			#Due to the fact that jquery calendar passes month in short annotation, we then need to translate it for DB.
			$date_arr = array(
				'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04', 'May' => '05', 'Jun' => '06',
				'Jul' => '07', 'Aug' => '08', 'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
			);
			
			return $jquerydate_arr[2] . '-' . $date_arr[$jquerydate_arr[1]] . '-' . str_pad($jquerydate_arr[0], 2, "0", STR_PAD_LEFT);
		}
		
		return $jquerydate;
	}
}

if(!function_exists("datepicker2mysql")) {
	//dd/mm/yyyy -> yyyy-mm-dd
	function datepicker2mysql($js_date){
		$CI =& get_instance();
		$tmp_date = explode("/", $js_date);
		if(sizeof($tmp_date) != 3){
			return "";
		}
		$sql_date = $tmp_date[2] . "-" . $tmp_date[1] . "-" . $tmp_date[0];
		return $sql_date;
	}
}

if(!function_exists("mysql2datepicker")) {
	//yyyy-mm-dd-->dd/mm/yyyy -> 
	function mysql2datepicker($mysql_date){
		$CI =& get_instance();
		$tmp_date = explode("-", $mysql_date);
		if(sizeof($tmp_date) != 3){
			return "";
		}
		$js_date = $tmp_date[2] . "/" . $tmp_date[1] . "/" . $tmp_date[0];
		return $js_date;
	}
}

if(!function_exists("encrypt_base64")) {
	function encrypt_base64($data = ""){
		if($data != ""){
			return trim(base64_encode($data), '=.');
		}
	}
	
}

if(!function_exists("decrypt_base64")) {
	function decrypt_base64($encrypted_data = ""){
		if($encrypted_data != ""){
			return base64_decode($encrypted_data);
		}
	}
}

//credit to kha hoo about this logic
if(!function_exists('xml_ddex_time_convert')){
	function xml_ddex_time_convert($time = ""){
		if($time != ""){
			$time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);
			sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
			$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
			
			$date = time();
			
			$start = new DateTime(date("Y-m-d H:i:s", $date)); 
			$end = new DateTime(date("Y-m-d H:i:s", $date + $time_seconds));
			
			$interval = $start->diff($end);
			
			list($date,$time) = explode("T",$interval->format("P%yY%mM%dDT%hH%iM%sS"));
			$res = str_replace([ 'M0D', 'Y0M', 'P0Y' ], [ 'M', 'Y', 'P' ], $date) . rtrim(str_replace([], [], "T$time"),"T");
			
			return $res;
		}
	}
}

if(!function_exists('count_pending_song')){
	function count_pending_song(){
		$CI =& get_instance();
		
		if($CI->session->userdata('logged_in') == TRUE AND $CI->session->userdata('user_type') == 'member' AND $CI->session->userdata('user_id') > 0)
		{
			$sql_count = "SELECT COUNT(`upc`.`id`) AS total FROM `" . DB_PREFIX . "metadata_song_upc` AS `upc` WHERE `upc`.`song_status_approval` = 'pending' AND  `upc`.`label_id` = " . $CI->db->escape($CI->session->userdata('user_id'));
		}
		else
		{
			$sql_count = "SELECT COUNT(`upc`.`id`) AS total FROM `" . DB_PREFIX . "metadata_song_upc` AS `upc` WHERE `upc`.`song_status_approval` = 'pending' ";
		}
		
		$query = $CI->db->query($sql_count)->row();
		
		return $query->total;
	}
}

if(!function_exists('count_pending_telco_song')){
	function count_pending_telco_song(){
		$CI =& get_instance();
		
		if($CI->session->userdata('logged_in') == TRUE AND $CI->session->userdata('user_type') == 'member' AND $CI->session->userdata('user_id') > 0)
		{
			$sql_count = "SELECT COUNT(`telco_song`.`id`) AS total FROM `" . DB_PREFIX . "metadata_song_telco` AS `telco_song` WHERE `telco_song`.`song_status_approval` = 'pending' AND  `telco_song`.`create_by` = " . $CI->db->escape($CI->session->userdata('user_id'));
		}
		else
		{
			$sql_count = "SELECT COUNT(`telco_song`.`id`) AS total FROM `" . DB_PREFIX . "metadata_song_telco` AS `telco_song` WHERE `telco_song`.`song_status_approval` = 'pending' ";
		}
		
		$query = $CI->db->query($sql_count)->row();
		
		return $query->total;
	}
}

if(!function_exists('insert_mail_in_db')){
	function insert_mail_in_db($recipient_email = "", $recipient_name = "", $subject = "", $body = "")
	{
		$CI =& get_instance();
		
		if($recipient_email != "" AND $recipient_name != "" AND $subject != "" AND $body != "")
		{
			$DBemail['recipient_email'] = trim($recipient_email);
			$DBemail['sender_email'] = trim(ADMIN_SMTP_EMAIL);
			$DBemail['subject_email'] = trim($subject);
			$DBemail['content_email'] = trim($body);
			$DBemail['mail_status'] = 1;
			$DBemail['create_date'] = trim(date("Y-m-d H:i:s"));
			$DBemail['create_by'] = trim($CI->session->userdata('user_id'));
			
			$rs = $CI->db->insert(DB_PREFIX . 'mail_send_audit_trail', $DBemail);
			$id = $CI->db->insert_id();
			audit_trail($CI->db->last_query(), 'general_helper.php', 'insert_mail_in_db', 'insert mail data');
			
			// $rs = sendmail($subject, $body, $recipient_email);
			
			// #kalau email berjaya send rs == 1 
			// if(isset($rs) && $rs == 1 && $id != "")
			// {
				// $sql = ("UPDATE `".DB_PREFIX . "mail_send_audit_trail` SET `mail_status` = 0  , `update_date` = " . $CI->db->escape(trim(date("Y-m-d H:i:s"))) . ", `update_by` = " . $CI->db->escape(trim($CI->session->userdata('user_id'))) . " WHERE `id` =" . $CI->db->escape($id) . " LIMIT 1");
				// $CI->db->query($sql);
			// }
			// else
			// {	
				// #tak berjaya send email.
				// $sql = ("UPDATE `".DB_PREFIX . "mail_send_audit_trail` SET `remark` = 'error occurred'  , `update_date` = " . $CI->db->escape(trim(date("Y-m-d H:i:s"))) . ", `update_by` = " . $CI->db->escape(trim($CI->session->userdata('user_id'))) . " WHERE `id` =" . $CI->db->escape($id) . " LIMIT 1");
				// $CI->db->query($sql);
			// }
			
			return $rs;
		}
		else
			return false;
		
	}
}


		
#ikhwan part####
function encrypt_data($data = "")
{
	return encrypt_base64(serialize($data));
	
}

function filter_data($data = ""){
	
	return encrypt_base64(serialize($data));
	
}

function decrypt_data($data = ""){
	return unserialize(decrypt_base64($data));
}

?>
