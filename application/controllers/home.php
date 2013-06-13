<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function index() {
		$data['main_content'] = 'main';
		
		$this->load->view('template/content', $data);
	}
	

	
}



