<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once (dirname(__FILE__) . "/login.php");

class Quantity_type extends Login {

	function __construct() {
		parent::__construct();
		
		if($this->is_logged_in() == FALSE) {
			redirect('login', 'refresh');
		} 
	}
	
	function index() {
		
		$data['main_content'] = 'quantity_type';
		
		$this->load->view('template/content', $data);
	}
	
	function search_quantity_type() {
		
		$do_search = $this->input->post('do_search');
		
		if(!isset($do_search) or $do_search == NULL) {
		
			$this->index();
		
		} else {
			
			$this->load->helper('url');
		
			$quantity_type = $this->input->post('quantity_type_search');
			
			$this->load->model('quantity_type_model');
		
			if($quantity_type == NULL) {
			
				$quantity_types = $this->quantity_type_model->get_quantity_types();
				
				if($quantity_types != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th colspan='8'>Quantity Type</th>
						</tr>
					";
					
					foreach($quantity_types as $row) {
		
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td colspan='8'><a href='{$base}index.php/quantity_type/select_update_quantity_type?id={$row->id}' class='update_link'>{$row->quantity_type}</a></td>
							</tr>
						";
					}
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Quantity Type</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No quantity type exists</td>
						</tr>
					";
				}
				
			} else {
			
				$quantity_types = $this->quantity_type_model->search_quantity_type($quantity_type);
		
				if($quantity_types != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th colspan='8'>Quantity Type</th>
						</tr>
					";
					
					foreach($users as $row) {
						
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td colspan='8'><a href='{$base}index.php/quantity_type/select_update_quantity_type?id={$row->id}' class='update_link'>{$row->quantity_type}</a></td>
							</tr>
						";
					}
					
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th colspan='8'>Quantity Type</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No quantity type exists</td>
						</tr>
					";
				}
				
			}
			
			echo json_encode($data);
		
		} 
	} // end search user

	function add_quantity_type() {
		
		$quantity_type = trim($this->input->post('quantity_type'));
		
		$quantity_type_data = array(
			'quantity_type' => strtolower($quantity_type),
			'user_id' => $this->session->userdata('id')
		);
	
		$this->load->database();
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', '%s already exists');
		$this->form_validation->set_rules('quantity_type', 'Quantity Type', 'is_unique[quantity_types.quantity_type]');
		
		if($this->form_validation->run() == FALSE) {
			$data['status'] = false;
			$data['error'] = validation_errors();
		} else {
			$this->load->model('quantity_type_model');
			
			$add_quantity_type = $this->quantity_type_model->add_quantity_type($quantity_type_data);
			
			if($add_quantity_type) {
				$data['status'] = true;
			}
		}
		
		echo json_encode($data);
	
	} // end adid quantity type

	function delete_quantity_type() {
		
		$id = $this->input->post('id');
		
		if(!isset($id) or $id == NULL) {
			
			$this->index();
			
		} else {
			if($id != NULL) {
			
				$this->load->model('quantity_type_model');
				$delete = $this->quantity_type_model->delete_quantity_type($id);
				$data['status'] = true;
				
			} else {
			
				$data['status'] = false;
				
			}
			
			echo json_encode($data);
		}
	} // end delete user

	function select_update_quantity_type() {
		
		$id = $this->input->get('id');
		
		if(!isset($id) or $id == NULL) {
			$this->index();
		} else {
			$this->load->model('quantity_type_model');
		
			$quantity_type = $this->quantity_type_model->get_quantity_type_by_id($id);
			
			if($quantity_type != NULL) {
				
				foreach($quantity_type as $row) {
					
					$data = array(
						'id' => $row->id,
						'first_name' => $row->first_name,
						'last_name' => $row->last_name,
						'middle_name' => $row->middle_name,
						'gender' => $row->gender,
						'email' => $row->email,
						'role' => $row->role,
						'username' => $row->username,
						'password' => $row->password
						
					);

				}
			
			}
			
			echo json_encode($data);
		} // end else statement
	}

}

























