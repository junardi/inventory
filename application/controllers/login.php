<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
	
		if($this->session->userdata('username') != NULL) {
			redirect('home');
		} else {
			$data['main_content'] = 'login';
			$data['interface'] = "login";
			
			$this->load->view('template/content', $data);
		}
	}
	
	public function validate() {
		
		$this->load->helper('security');
	
		$username = trim($this->input->post('username'));
		$password = do_hash(trim($this->input->post('password')));
		
		if(!isset($username) or $username == NULL) {
			$this->index();
		} else {
			$this->load->model('user_model');
		
			$exist_user = $this->user_model->validate_user($username, $password);
			
			if($exist_user != NULL) {
				$data['home'] = site_url('home');
				$data['status'] = true;
				
				foreach($exist_user as $row) {
					$user_info = array(
						'id' => $row->id,
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
	
	} // end validate

	public function logout() {
		$this->session->sess_destroy();
		
		redirect('login');
	}
	
	protected function is_logged_in() {
		if($this->session->userdata('username') != NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	
}






