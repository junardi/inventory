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
			
			$this->load->model('home_model');
		
			if($product == NULL) {
			
				$products = $this->home_model->get_products();
				
				if($products != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th>
						</tr>
					";
					
					foreach($products as $row) {
		
						$base = base_url();
						$profit = $row->total_profit;
						
						if($profit == "") {
							$profit = 0;
						}
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$row->id}&&value=product' class='main_update_link'>{$row->product_name}</a></abbr></td>
								<td>{$row->capital}</td>
								<td>{$profit}</td>
								<td>{$row->date_added}</td>
							</tr>
						";
					}
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th> 
						</tr>
						<tr>
							<td colspan='9' class='empty'>No product exists</td>
						</tr>
					";
				}
				
			} else {
			
				$products = $this->home_model->search_product($product);
		
				if($products != NULL) {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th>
						</tr>
					";
					
					foreach($products as $row) {
						
						$base = base_url();
						$profit = $row->total_profit;
						
						if($profit == "") {
							$profit = 0;
						}
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$row->id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$row->id}&&value=product' class='main_update_link'>{$row->product_name}</a></abbr></td>
								<td>{$row->capital}</td>
								<td>{$profit}</td>
								<td>{$row->date_added}</td>
							</tr>
						";
					}
					
				} else {
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th>
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
		
		$this->load->model('home_model');
		
		$is_product_exist = $this->home_model->existing_product_name($product_name);
		
		if($is_product_exist) {
			$data['status'] = false;
		} else {
			
			$timestamp = now();
			$timezone = 'UP8';
			$date_time_convert = gmt_to_local($timestamp, $timezone);
			$date_added = unix_to_human($date_time_convert, TRUE, 'us');
			
			$product_data = array(
				"product_name" => $this->input->post('product_name'),
				"capital" => $this->input->post('capital'),
				"date_added" => $date_added,
				"user_id" => $this->session->userdata('id') 
			);
		
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
										"product_id" => $product_id,
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
							$data['status'] = true;
						} else {
							$data['selling_type_inserted'] = false;
							$data['status'] = false;
						}						
					}
					
				}
			
			} 	
			
		} //end else
		
		echo json_encode($data);
	
	} // end add product
	
	function delete_product() {
		
		$id = $this->input->post('id');
		
		$this->load->model('home_model');
		
		$delete_product = $this->home_model->delete_product($id);
		
		if($delete_product) {
			
			$data['delete_product'] = true;
			
			$delete_product_quantity_types = $this->home_model->delete_product_quantity_types($id);
		
			if($delete_product_quantity_types) {
				
				$data['delete_product_quantity_types'] = true;
				
				$delete_product_breakdown_quantity_types = $this->home_model->delete_product_breakdown_quantity_types($id);
				
				if($delete_product_breakdown_quantity_types) {
				
					$data['delete_product_breakdown_quantity_types'] = true;
				
				} 
				
				$delete_product_selling_types = $this->home_model->delete_product_selling_types($id);
				
				if($delete_product_selling_types) {
					
					$data['delete_product_selling_types'] = true;
					
				}
				
			} // end delete_product_quantity_types
		} // end delete product
		
		if($delete_product && $delete_product_quantity_types && $delete_product_breakdown_quantity_types && $delete_product_selling_types) {
			$data['status'] = true;
		}
		
		echo json_encode($data);
	
	
	} // end main delete

	function select_update_product() {
		
		$id = $this->input->get('id'); 
		$value = $this->input->get('value');
		
		$this->load->model('home_model');
		
		$product = $this->home_model->get_product_by_id($id);
		
		if($product != NULL) {
			foreach($product as $row) {
			
				$data = array(
					"id" => $row->id, 
					"product_name" => $row->product_name,
					"capital" => $row->capital,
					"date_added" => $row->date_added,
					"quantity_type" => $row->quantity_type,
					"quantity_no" => $row->quantity_no,
					"quantity_price" => $row->quantity_price
				);
			
			}
		
			$get_breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($id);
			
			$data['breakdown_quantity_types']= array();
			
			if($get_breakdown_quantity_types != NULL) {
				foreach($get_breakdown_quantity_types as $row) {
					$data['breakdown_quantity_types'][] = array(
						"breakdown_quantity_type" => $row->breakdown_quantity_type,
						"breakdown_quantity_no" => $row->breakdown_quantity_no,
						"breakdown_quantity_price" => $row->breakdown_quantity_price	
					);
				}
			}
			
			$get_selling_types = $this->home_model->get_selling_types_by_product_id($id);
			
			$data['selling_types'] = array();
			
			if($get_selling_types != NULL) {
				
				foreach($get_selling_types as $row) {
					$data['selling_types'][] = array(
						"selling_type" => $row->selling_type,
						"selling_price" => $row->selling_price,
						"selling_profit" => $row->profit
					);
				}
			}
		
		}
	
		echo json_encode($data);
	}
	
	function update_product() {
		
		$id = $this->input->post('id');
		
		$timestamp = now();
		$timezone = 'UP8';
		$date_time_convert = gmt_to_local($timestamp, $timezone);
		$date_updated = unix_to_human($date_time_convert, TRUE, 'us');
		
		// products data below
		
		$product_data = array(
			"product_name" => $this->input->post('product_name'),
			"capital" => $this->input->post('capital'),
			"date_updated" => $date_updated
		);
		
		// quantity_types data below
		
		$quantity_type_data = array(
			"quantity_type" => $this->input->post('quantity_type'),
			"quantity_no" => $this->input->post('quantity_no'),
			"quantity_price" => $this->input->post('quantity_price'),
			"product_id" => $product_id,
			"user_id" => $this->session->userdata('id')
		);
		
		// breakdown_types data below
		
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
						"product_id" => $product_id,
						"user_id" => $this->session->userdata('id')
					)
					
				);

			}
			
		}  // end if
		
		// selling types data below
		
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
		}
		
	} // end update_product
	
} // end class



