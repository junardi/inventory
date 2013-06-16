<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once (dirname(__FILE__) . "/login.php");

class Home extends Login{
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {

		if($this->is_logged_in() == FALSE) {
			parent::index();
		} else {
			$data['main_content'] = 'main';
			$this->load->view('template/content', $data);
		}
	}
	
	
}



