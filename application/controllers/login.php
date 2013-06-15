<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('username') != NULL) {
			redirect('home', 'refresh');
		}
	}
	
	public function index() {
		$data['main_content'] = 'login';
		$data['interface'] = "login";
	
		$this->load->view('template/content', $data);
	}
	
	public function validate() {
		
		$this->load->helper('security');
		
		$username = $this->input->post('username');
		$password = do_hash($this->input->post('password'));
		
		$this->load->model('user_model');
		
		$exist_user = $this->user_model->validate_user($username, $password);
		
		if($exist_user != NULL) {
			$data['home'] = base_url() . "index.php/home";
			$data['status'] = true;
			
			foreach($exist_user as $row) {
				$user_info = array(
					'email' => $row->email,
					'username' => $row->username
				);
			}
			
			$this->session->set_userdata($user_info);
		
		} else {
			$data['status'] = false;
		}
		
		echo json_encode($data);
	}
	
	public function logout() {
		
	}
	
}