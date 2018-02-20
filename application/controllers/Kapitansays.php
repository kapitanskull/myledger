<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapitansays extends CI_Controller {
	
	public function __construct()
   	{
        parent::__construct();
	}

	public function index()
	{
		$this->load->view('custome_error_v');
	}
	
}
