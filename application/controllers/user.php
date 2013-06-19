<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once (dirname(__FILE__) . "/login.php");

class User extends Login {

	function __construct() {
		parent::__construct();
		
		if($this->is_logged_in() == FALSE) {
			redirect('login', 'refresh');
		} 
	}
	
	function index() {
		
		$data['main_content'] = 'user';
		
		$this->load->view('template/content', $data);
	}

	function add_user() {
		
		$first_name = $this->input->post('first_name');
		
		if(!isset($first_name) or $first_name == NULL) {
			$this->index();
		} else {
			$this->load->database();
		
			$this->load->helper('security');
			
			$data = array(
				"first_name" => strtolower($this->input->post('first_name')),
				"last_name" => strtolower($this->input->post('last_name')),
				"middle_name" => strtolower($this->input->post('middle_name')),
				"gender" => strtolower($this->input->post('gender')),
				"email" => $this->input->post('email'),
				"role" => strtolower($this->input->post('role')),
				"username" => strtolower($this->input->post('username')),
				"password" => do_hash($this->input->post('password')),
				"date_registered" => date("Y-m-d H:i:s")
			);
			
			$this->load->library('form_validation');
			$this->form_validation->set_message('is_unique', '%s already exists');
			$this->form_validation->set_rules('email', 'Email Address', 'is_unique[users.email]');
			$this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]');

			if ($this->form_validation->run() == FALSE) {
				$data['status'] = false;
				$data['error'] = validation_errors();
			} else {
				$this->load->model('user_model');
			
				$add_user = $this->user_model->add_user($data);
				
				if($add_user) {
					$data['status'] = true;
				}
			}
			
			echo json_encode($data);
		}
	
	}//end add user
	
	function delete_user() {
		
		$id = $this->input->post('id');
		
		if(!isset($id) or $id == NULL) {
			
			$this->index();
			
		} else {
			if($id != NULL) {
			
				$this->load->model('user_model');
				$delete = $this->user_model->delete_user($id);
				$data['status'] = true;
				
			} else {
			
				$data['status'] = false;
				
			}
			
			echo json_encode($data);
		}
	} // end delete user
	
	function search_user() {
		
		$do_search = $this->input->post('do_search');
		
		if(!isset($do_search) or $do_search == NULL) {
		
			$this->index();
		
		} else {
			
			$this->load->helper('url');
		
			$user = $this->input->post('user_search');
			
			$this->load->model('user_model');
		
			if($user == NULL) {
				
				$users = $this->user_model->get_users();
				
				if($users != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Email Address</th>
							<th>Username</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>Gender</th> 
							<th>Role</th>
							<th>Date Registered</th>
						</tr>
					";
					
					foreach($users as $row) {
		
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/user/select_update_user?id={$row->id}&&value=user' class='update_link'>{$row->email}</a></abbr></td>
								<td>{$row->username}</td>
								<td>{$row->first_name}</td>
								<td>{$row->last_name}</td>
								<td>{$row->middle_name}</td>
								<td>{$row->gender}</td>
								<td>{$row->role}</td>
								<td>{$row->date_registered}</td>
							</tr>
						";
					}
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Email Address</th>
							<th>Username</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>Gender</th> 
							<th>Role</th>
							<th>Date Registered</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No user exists</td>
						</tr>
					";
				}
				
			} else {
				$users = $this->user_model->search_user($user);
		
				if($users != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Email Address</th>
							<th>Username</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>Gender</th> 
							<th>Role</th>
							<th>Date Registered</th>
						</tr>
					";
					
					foreach($users as $row) {
						
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/user/select_update_user?id={$row->id}}&&value=user' class='update_link'>{$row->email}</a></abbr></td>
								<td>{$row->username}</td>
								<td>{$row->first_name}</td>
								<td>{$row->last_name}</td>
								<td>{$row->middle_name}</td>
								<td>{$row->gender}</td>
								<td>{$row->role}</td>
								<td>{$row->date_registered}</td>
							</tr>
						";
					}
					
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Email Address</th>
							<th>Username</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>Gender</th> 
							<th>Role</th>
							<th>Date Registered</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No user exists</td>
						</tr>
					";
				}
				
			}
			
			echo json_encode($data);
		
		} 
	} // end search user
	
	function select_update_user() {
	
		$id = $this->input->get('id');
		$value = $this->input->get('value');
		
		if(!isset($id) or $id == NULL) {
			$this->index();
		} else {
			$this->load->model('user_model');
		
			$user = $this->user_model->get_user_by_id($id);
			
			if($user != NULL) {
				
				foreach($user as $row) {
					
					$data = array(
						'id' => $row->id,
						'first_name' => $row->first_name,
						'last_name' => $row->last_name,
						'middle_name' => $row->middle_name,
						'gender' => $row->gender,
						'email' => $row->email,
						'role' => $row->role,
						'username' => $row->username,
						'password' => $row->password,
						'value' => $value
					);

				}
			
			}
			
			echo json_encode($data);
		} // end else statement
	
	} // end select update user
	
	private function exist_self_email($id, $email) {
		$this->load->model('user_model');
		$check_email = $this->user_model->check_email_by_id($id, $email);
		
		if($check_email != NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	private function exist_self_username($id, $username) {
		$this->load->model('user_model');
		$check_username = $this->user_model->check_username_by_id($id, $username);
		
		if($check_username != NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	function update_user() {
		
		$this->load->helper('security');
		
		$password = $this->input->post('password');
		
		if($password != NULL) {
			
			$data = array(
				"first_name" => strtolower($this->input->post('first_name')),
				"last_name" => strtolower($this->input->post('last_name')),
				"middle_name" => strtolower($this->input->post('middle_name')),
				"gender" => strtolower($this->input->post('gender')),
				"email" => strtolower($this->input->post('email')),
				"role" => strtolower($this->input->post('role')),
				"username" => strtolower($this->input->post('username')),
				"password" => do_hash($this->input->post('password'))
			);
			
		} else {
		
			$data = array(
				"first_name" => strtolower($this->input->post('first_name')),
				"last_name" => strtolower($this->input->post('last_name')),
				"middle_name" => strtolower($this->input->post('middle_name')),
				"gender" => strtolower($this->input->post('gender')),
				"email" => strtolower($this->input->post('email')),
				"role" => strtolower($this->input->post('role')),
				"username" => strtolower($this->input->post('username'))
			);
			
		}
		
		$id = $this->input->post('id');
		
		$email = $this->input->post('email');
		
		$username = $this->input->post('username');
		
		if(!isset($id) or $id == NULL) {
			$this->index();
		} else {
			$this->load->database();
		
			if($this->exist_self_email($id, $email) && $this->exist_self_username($id, $username)) {
				
				$this->load->model('user_model');
				$update_user = $this->user_model->update_user($id, $data);
				
				if($update_user) {
					$data['status'] = true;
				}
			
			} else if($this->exist_self_email($id, $email) && !$this->exist_self_username($id, $username)) {
				$this->load->library('form_validation');
				$this->form_validation->set_message('is_unique', '%s already exists');
				$this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]');

				if($this->form_validation->run() == FALSE) {
					$data['status'] = false;
					$data['error'] = validation_errors();
				} else {
					$this->load->model('user_model');
					$update_user = $this->user_model->update_user($id, $data);
					
					if($update_user) {
						$data['status'] = true;
					}
				}
				
			} else if(!$this->exist_self_email($id, $email) && $this->exist_self_username($id, $username)) {
				
				$this->load->library('form_validation');
				$this->form_validation->set_message('is_unique', '%s already exists');
				$this->form_validation->set_rules('email', 'Email Address', 'is_unique[users.email]');
				
				if($this->form_validation->run() == FALSE) {
					$data['status'] = false;
					$data['error'] = validation_errors();
				} else {
					$this->load->model('user_model');
					$update_user = $this->user_model->update_user($id, $data);
					
					if($update_user) {
						$data['status'] = true;
					}
				}
		
			} else {
			
				$this->load->library('form_validation');
				$this->form_validation->set_message('is_unique', '%s already exists');
				$this->form_validation->set_rules('email', 'Email Address', 'is_unique[users.email]');
				$this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]');
				
				if($this->form_validation->run() == FALSE) {
					$data['status'] = false;
					$data['error'] = validation_errors();
				} else {
					$this->load->model('user_model');
					$update_user = $this->user_model->update_user($id, $data);
					
					if($update_user) {
						$data['status'] = true;
					}
				}
			}
		
			echo json_encode($data);
		} 
		
	} // end update user
	
}



