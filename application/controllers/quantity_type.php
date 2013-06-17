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
							<th>Quantity Type</th>
						</tr>
					";
					
					foreach($quantity_types as $row) {
		
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><a href='{$base}index.php/user/select_update_quantity_type?id={$row->id}' class='update_link'>{$row->type}</a></td>
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
							<th>Quantity Type</th>
						</tr>
					";
					
					foreach($users as $row) {
						
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><a href='{$base}index.php/user/select_update_user?id={$row->id}' class='update_link'>{$row->type}</a></td>
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
				
			}
			
			echo json_encode($data);
		
		} 
	} // end search user
}

























