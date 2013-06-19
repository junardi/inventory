<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once (dirname(__FILE__) . "/login.php");

class Home extends Login{
	
	function __construct() {
		parent::__construct();
		if($this->is_logged_in() == FALSE) {
			redirect('login', 'refresh');
		} 
	}
	
	function index() {
		$data['main_content'] = 'main';
		$this->load->view('template/content', $data);
	}
	
	function search_product() {
		
		$do_search = $this->input->post('do_search');
		
		if(!isset($do_search) or $do_search == NULL) {
		
			$this->index();
		
		} else {
			
			$this->load->helper('url');
		
			$product = $this->input->post('product_search');
			
			$this->load->model('product_model');
		
			if($product == NULL) {
			
				$products = $this->product_model->get_products();
				
				if($products != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
						</tr>
					";
					
					foreach($products as $row) {
		
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$row->id}&&value=product' class='update_link'>{$row->product_name}</a></abbr></td>
								<td>{$row->capital}</td>
							</tr>
						";
					}
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No product exists</td>
						</tr>
					";
				}
				
			} else {
			
				
				$products = $this->product_model->search_product($product);
		
				if($products != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
						</tr>
					";
					
					foreach($products as $row) {
						
						$base = base_url();
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$row->id}&&value=product' class='update_link'>{$row->product_name}</a></abbr></td>
								<td>{$row->capital}</td>
							</tr>
						";
					}
					
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No product exists</td>
						</tr>
					";
				}
				
			}
			
			echo json_encode($data);
		
		} 
	} // end search user
	

}



