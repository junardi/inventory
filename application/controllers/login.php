<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index() {
		
		$data['main_content'] = 'login';
		$this->load->view('template/content', $data);

	}
	
}