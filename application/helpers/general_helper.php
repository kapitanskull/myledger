<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Array debug
 *
 * @access	public
 * @param	string
 * @return	string
 */	
function array_debug($data)
{
	//Array Debug. 
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function ad($data, $write = false)
{
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

// ------------------------------------------------------------------------

/**
 * Set message for display to browser. Useful for confirming certain process.
 *
 * @access	public
 * @param	string
 * @return	string
 */	
function set_message($feedback, $type = 'info')
{
	#save notice.
	#Message Type: error, info
	
	$obj =& get_instance();
	$obj->session->set_userdata('system-message', $feedback);
	$obj->session->set_userdata('message-type', $type);
}

// ------------------------------------------------------------------------

/**
 * Display message to browser.
 *
 * @access	public
 * @param	string
 * @return	string
 */	
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
			
		echo '<div class="alert alert-' .  $message_type  . ' alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>' .
				$obj->session->userdata('system-message') .
				'</div>';
			
		$obj->session->unset_userdata('system-message');
		$obj->session->unset_userdata('message-type');
											
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
			if($found == FALSE)
				$obj->session->userdata('redirect_login', 'home');
			else 
				$obj->session->userdata('redirect_login', $_SERVER['REQUEST_URI']);
		
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


/**
 * Privilages Checking.
 *
 * @access	public
 * @param	string
 * @return	nothings
 * group_id ==> function id 
 * user_id ==> user table id
 */	
 
function privileges_checking($group_id = '') {
	$obj =& get_instance();
	
	$obj->db->where('group_id', $group_id);
	$obj->db->where('user_id', $obj->session->userdata('user_id'));
	if($obj->db->get('pbx_privileges')->num_rows() == 0) {
		$obj->load->view('admin/access_denied');
	}
}

function usertype($user_type = false, $var = false)
{
	$obj =& get_instance();
	
	if($var == true)
		return $obj->session->userdata("user_type");
	else if($user_type == $obj->session->userdata("user_type"))
		return true;
		
	return false;
}

function sendmail($subject = null, $body = null, $to = null, $cc = array())
{
	//require 'phpmailer/class.phpmailer.php';
	require 'phpmailer/PHPMailerAutoload.php';
	
	$mail             = new PHPMailer();
	
// 	$body             = $mail->getFile('contents.html');
// 	$body             = eregi_replace("[\]",'',$body);
	
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.office365.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server

	$mail->SMTPOptions = array(
    		'ssl' => array(
        		'verify_peer' => false,
        		'verify_peer_name' => false,
        		'allow_self_signed' => true
    		)
	);
	
	$mail->Username   = "icap.info@mrc.com.my";  // GMAIL username
	$mail->Password   = "icapinfo@12345678";            // GMAIL password
	
	$mail->From       = "icap.info@mrc.com.my";
	$mail->FromName   = "iCAP PPC";
	
	$mail->Subject    = $subject;
	
	$mail->Body       = "" . $body; //HTML Body
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 50; // set word wrap
	
	$mail->MsgHTML($mail->Body);
	
	$mail->AddAddress($to);
	
	$bcc = array(
		'fendy@logicwise.com.my' => 'Affendy Iskandar', 
		'bhaihaqi@logicwise.com.my' => 'Bhaihaqi Saadon',
	);
	if(count($cc) > 0){
		foreach($cc as $email => $name){
			if($email != '');
				$mail->AddCC($email, $name);
		}
	}
	if(count($bcc) > 0){
		foreach($bcc as $email => $name){
		   $mail->AddBCC($email, $name);
		}
	}
	// $mail->AddAttachment("images/phpmailer.gif");             // attachment
	
	$mail->IsHTML(true); // send as HTML
	if(!$mail->Send())
		return $mail->ErrorInfo;
	else 
		return true;
		
	return false;
}

/**
 * Use for Audit Trail
 */
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

function api_security_check()
{
	$headers = getallheaders();
	$auth_token  = '';
	$valid = false;
	
	foreach ($headers as $name => $value) {
		if($name == "Authorization") {
			$exp = explode("MRC-authtoken ", $value);
			if(sizeof($exp) == 2) {
				$auth_token = $exp[1];
			}
		}
	}
	
	if($auth_token != '') {
		$obj =& get_instance();
		
		$mvd_db = $obj->load->database('mvd', TRUE);
		
		$sql = "SELECT * FROM api_users WHERE auth_token = " . $obj->db->escape($auth_token);
		$query = $mvd_db->query($sql);
		
		if($query->num_rows() > 0) {
			$valid = true;
		}
		
	}
	
	if($valid === false) {
		$json = array("message" => "Authorization Failed.", "result" => "false");
		header("HTTP/1.1 401 Unathorized");
		
		echo json_encode($json);
		
		exit();
	}
	
	return true;
}

function get_systemid_from_header()
{
	$headers = getallheaders();
	$auth_token  = '';
	
	foreach ($headers as $name => $value) {
		if($name == "Authorization") {
			$exp = explode("MRC-authtoken ", $value);
			if(sizeof($exp) == 2) {
				$auth_token = $exp[1];
			}
		}
	}
	
	if($auth_token != '') {
		$obj =& get_instance();
		
		$mvd_db = $obj->load->database('mvd', TRUE);
		
		$sql = "SELECT * FROM api_users WHERE auth_token = " . $obj->db->escape($auth_token);
		$query = $mvd_db->query($sql);
		
		if($query->num_rows() > 0) {
			$row = $query->row();
			
			return $row->systemid;
		}
	}
	
	return false;
}

function get_fields($table_name) #Parameters can be passed either by single table or nested in array
{
	$obj =& get_instance();
		
	$mvd_db = $obj->load->database('mvd', TRUE);
	
	if(is_array($table_name)) {
		$fields = array();
		foreach($table_name as $table) {
			$fld = $mvd_db->list_fields($table);
			$fields = array_merge($fields, $fld);
		}
	}
	else
		$fields = $mvd_db->list_fields($table_name);
	
	return $fields;
}

function convert_mvd_date($date, $mysql_format = false)
{
	if($mysql_format == true) {
		$explode = explode("-", $date);
		
		#The format is wrong, we just sent back the exact value.
		if(sizeof($explode) == 1)
			return $date;
		
		return $explode[2] . "/" . $explode[1] . "/" . $explode[0];
	}
	else {
		$explode = explode("/", $date);
		
		#The format is wrong, we just sent back the exact value.
		if(sizeof($explode) == 1)
			return $date;
		
		return $explode[2] . "-" . $explode[1] . "-" . $explode[0];
	}
}

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

 function number_string($number = 1234){
		$CI =& get_instance();
		$arrnumber = explode(".", $number);
		if(COUNT($arrnumber) == 2 && strlen($arrnumber[1]) == 2 && $arrnumber[1] != 0){
			echo "Ringgit Malaysia: " . str_replace(array("-"," and "), " ", convert_number_to_words($arrnumber[0]));
			echo " And " . str_replace(array("-"," and "), " ", convert_number_to_words(intval($arrnumber[1]))). " Cent ";
		}
		else if(COUNT($arrnumber) == 1 || (COUNT($arrnumber) == 2 && $arrnumber[1] == 0)){
			echo "Ringgit Malaysia: " . str_replace(array("-"," and "), " ", convert_number_to_words($arrnumber[0])) . " and Sen Zero only  ";
		}
	}
	
	 function convert_number_to_words($number){
		$CI =& get_instance();
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'Negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'Zero',
			1                   => 'One',
			2                   => 'Two',
			3                   => 'Three',
			4                   => 'Four',
			5                   => 'Five',
			6                   => 'Six',
			7                   => 'Seven',
			8                   => 'Eight',
			9                   => 'Nine',
			10                  => 'Ten',
			11                  => 'Eleven',
			12                  => 'Twelve',
			13                  => 'Thirteen',
			14                  => 'Fourteen',
			15                  => 'Fifteen',
			16                  => 'Sixteen',
			17                  => 'Seventeen',
			18                  => 'Eighteen',
			19                  => 'Nineteen',
			20                  => 'Twenty',
			30                  => 'Thirty',
			40                  => 'Fourty',
			50                  => 'Fifty',
			60                  => 'Sixty',
			70                  => 'Seventy',
			80                  => 'Eighty',
			90                  => 'Ninety',
			100                 => 'Hundred',
			1000                => 'Thousand',
			1000000             => 'Million',
			1000000000          => 'Billion',
			1000000000000       => 'Trillion',
			1000000000000000    => 'Quadrillion',
			1000000000000000000 => 'Quintillion'
		);

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}

		return $string;
	}

?>
