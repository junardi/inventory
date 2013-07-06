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
	
	function add_product() {
		
		$product_name = $this->input->post('product_name');
		
		$product_data = array(
			"product_name" => $this->input->post('product_name'),
			"capital" => $this->input->post('capital'),
			"user_id" => $this->session->userdata('id') 
		);
		
		$this->load->model('home_model');
		
		$product_insert = $this->home_model->add_product($product_data);
		
		if($product_insert) {
			
			$get_product_id = $this->home_model->get_product_id($product_data['product_name']);
			
			if($get_product_id != NULL) {	
				
				foreach($get_product_id as $row) {
					$product_id = $row->id;
				}
				
				$quantity_type_data = array(
					"quantity_type" => $this->input->post('quantity_type'),
					"quantity_no" => $this->input->post('quantity_no'),
					"quantity_price" => $this->input->post('quantity_price'),
					"product_id" => $product_id,
					"user_id" => $this->session->userdata('id')
				);

			
				$quantity_type_insert = $this->home_model->add_quantity_type($quantity_type_data);
				
				if($quantity_type_insert) {
					
					$get_quantity_type_id = $this->home_model->get_quantity_type_id($quantity_type_data['quantity_type']);
					
					if($get_quantity_type_id != NULL) {
						foreach($get_quantity_type_id as $row) {
							$quantity_type_id = $row->id;
						}
					}
					
					$breakdown_type = $this->input->post('breakdown_type');
					$breakdown_no = $this->input->post('breakdown_no');
					$breakdown_price = $this->input->post('breakdown_price');
					
					if(isset($breakdown_type) && $breakdown_type != NULL) {
						for($i = 0; $i < count($breakdown_type); $i++) {
							$breakdown_quantity_types_data = array(
								array(
									"breakdown_quantity_type" => $breakdown_type[$i],
									"breakdown_quantity_no" => $breakdown_no[$i],
									"breakdown_quantity_price" => $breakdown_price[$i],
									"quantity_type_id" => $quantity_type_id,
									"user_id" => $this->session->userdata('id')
								)
								
							);
							
							$breakdown_quantity_type_insert = $this->home_model->add_breakdown_quantity_type($breakdown_quantity_types_data);  
						}
						
						if($breakdown_quantity_type_insert) {
							$data['breakdown_quantity_type_inserted'] = true;
						} else {
							$data['breakdown_quantity_type_inserted'] = false;
						}						
					}
					
					$selling_type = $this->input->post('selling_type');
					$selling_price = $this->input->post('selling_price');
					$selling_profit = $this->input->post('selling_profit');
					
					for($i = 0; $i < count($selling_type); $i++) {
						$selling_types_data = array(
							array(
								"selling_type" => $selling_type[$i],
								"selling_price" => $selling_price[$i],
								"profit" => $selling_profit[$i],
								"product_id" => $product_id
							)
						);
					
						$selling_type_insert = $this->home_model->add_selling_type($selling_types_data);
					}
					
					if($selling_type_insert) {
						$data['selling_type_inserted'] = true;
					} else {
						$data['selling_type_inserted'] = false;
					}						
				
					echo json_encode($data);
					
				}
				
			}
		
		} 	
	
	} // end add product
	
}



