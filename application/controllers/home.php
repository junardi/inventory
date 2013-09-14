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
					
					$data['stock_status'] = array();
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th>
							<th>Stock Status</th>
							<th>Selling Type</th>
							<th>Selling Quantity</th>
							<th>Add to Cart</th>
						</tr>
					";
					
					foreach($products as $row) {
		
						$product_data = array(
							'product_id' => $row->product_id,
							'product_name' => $row->product_name,
							'capital' => $row->capital,
							'product_quantity' => $row->product_quantity,
							'total_profit' => $row->total_profit,
							'date_added' => $row->date_added,
							'date_updated' => $row->date_updated,
							'user_id' => $row->user_id,
							'quantity_type_id' => $row->quantity_type_id,
							'quantity_type' => $row->quantity_type,
							'quantity_no' => $row->quantity_no,
							'quantity_price' => $row->quantity_price
						);
						
					
						$get_selling_types = $this->home_model->get_selling_types_by_product_id($product_data['product_id']);
					
						$product_data['selling_types'] = array();
						
						if($get_selling_types != NULL) {
							
							foreach($get_selling_types as $row) {
								$product_data['selling_types'][] = array(
									"selling_type" => $row->selling_type,
									"selling_price" => $row->selling_price,
									"selling_profit" => $row->profit
								);
							}
						}
						
						$base = base_url();
						
						$product_id = $product_data['product_id'];
						$product_name = $product_data['product_name'];
						$capital = $product_data['capital'];
						$product_quantity = $product_data['product_quantity'];
						$total_profit = $product_data['total_profit'];
						$date_added = $product_data['date_added'];
						$date_updated = $product_data['date_updated'];
						$user_id = $product_data['user_id'];
						$quantity_type_id = $product_data['quantity_type_id'];
						$quantity_type = $product_data['quantity_type'];
						$quantity_no = $product_data['quantity_no'];
						$quantity_price = $product_data['quantity_price'];
					
						$get_breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($product_data['product_id']);
			
						$product_data['breakdown_quantity_types']= array();
					
						if($get_breakdown_quantity_types != NULL) {
							foreach($get_breakdown_quantity_types as $row) {
								$product_data['breakdown_quantity_types'][] = array(
									"breakdown_quantity_type" => $row->breakdown_quantity_type,
									"breakdown_quantity_no" => $row->breakdown_quantity_no,
									"breakdown_quantity_price" => $row->breakdown_quantity_price,
									"exist_breakdown_quantity_no" => $row->exist_breakdown_quantity_no
								);
								
								$data['stock_status'][] = array(
									"current_stock" => $product_quantity,
									"remaining_stock" => $quantity_no,
									"breakdown_current_stock" => $product_data['breakdown_quantity_types'][0]['breakdown_quantity_no'],
									"breakdown_remaining_stock" => $product_data['breakdown_quantity_types'][0]['exist_breakdown_quantity_no']
								); 
							
							}
						} else {
							$data['stock_status'][] = array(
								"current_stock" => $product_quantity,
								"remaining_stock" => $quantity_no,
								"breakdown_current_stock" => 0,
								"breakdown_remaining_stock" => 0
							); 
						}
						
						if($total_profit == "") {
							$total_profit = 0;
						}
					
						if($date_updated == "0000-00-00 00:00:00") {
							$date_updated = "No updates";
						}
						
						$add_to_cart = site_url("home/add_cart?product_id={$product_id}&&product_name={$product_name}");
						$loading_stock_status = base_url() . "images/cart_loading.gif";
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$product_id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$product_id}&&value=product' class='main_update_link'>{$product_name}</a></abbr></td>
								<td>{$capital}</td>
								<td>{$total_profit}</td>
								<td>{$date_added}</td>
								<td>
									<div class='progress_bar'>
										<div class='progress_status'></div>
										<span class='progress_label'></span>
										<img src='{$loading_stock_status}' alt='loading stock status' />
									</div>
								</td>
								<td>
									<select name='selling_type' class='selling_type'>
										<option value=''></option>
						";
					
						for($i = 0; $i < count($product_data['selling_types']); $i++) {
						
							$data['content'] .= "	
										<option>{$product_data['selling_types'][$i]['selling_type']}</option>											
							";
						}
						
						$data['content'] .= "
									</select>
								</td>
								<td><input type='text' name='selling_quantity' class='selling_quantity' /></td>
								<td><abbr title='Add to Cart'><a class='cart_link' href='{$add_to_cart}'><img src='{$base}images/cart.png' class='cart_image' alt='Add to Cart' /></a></abbr> <img src='{$base}images/cart_loading.gif' class='cart_loading' alt='Cart Loading' /></td>
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
							<th>Stock Status</th>
							<th>Selling Type</th>
							<th>Selling Quantity</th>
							<th>Add to Cart</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No product exists</td>
						</tr>
					";
				}
				
				// below is for the else for typing in the search
				
			} else {
			
				$products = $this->home_model->search_product($product);
		
				if($products != NULL) {
					
					$data['stock_status'] = array();
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th>
							<th>Stock Status</th>
							<th>Selling Type</th>
							<th>Selling Quantity</th>
							<th>Add to Cart</th>
						</tr>
					";
					
					foreach($products as $row) {
		
						$product_data = array(
							'product_id' => $row->product_id,
							'product_name' => $row->product_name,
							'capital' => $row->capital,
							'product_quantity' => $row->product_quantity,
							'total_profit' => $row->total_profit,
							'date_added' => $row->date_added,
							'date_updated' => $row->date_updated,
							'user_id' => $row->user_id,
							'quantity_type_id' => $row->quantity_type_id,
							'quantity_type' => $row->quantity_type,
							'quantity_no' => $row->quantity_no,
							'quantity_price' => $row->quantity_price
						);
						
						$get_selling_types = $this->home_model->get_selling_types_by_product_id($product_data['product_id']);
					
						$product_data['selling_types'] = array();
						
						if($get_selling_types != NULL) {
							
							foreach($get_selling_types as $row) {
								$product_data['selling_types'][] = array(
									"selling_type" => $row->selling_type,
									"selling_price" => $row->selling_price,
									"selling_profit" => $row->profit
								);
							}
						}
						
						$base = base_url();
						
						$product_id = $product_data['product_id'];
						$product_name = $product_data['product_name'];
						$capital = $product_data['capital'];
						$product_quantity = $product_data['product_quantity'];
						$total_profit = $product_data['total_profit'];
						$date_added = $product_data['date_added'];
						$date_updated = $product_data['date_updated'];
						$user_id = $product_data['user_id'];
						$quantity_type_id = $product_data['quantity_type_id'];
						$quantity_type = $product_data['quantity_type'];
						$quantity_no = $product_data['quantity_no'];
						$quantity_price = $product_data['quantity_price'];
					
						$get_breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($product_data['product_id']);
			
						$product_data['breakdown_quantity_types']= array();
					
						if($get_breakdown_quantity_types != NULL) {
							foreach($get_breakdown_quantity_types as $row) {
								$product_data['breakdown_quantity_types'][] = array(
									"breakdown_quantity_type" => $row->breakdown_quantity_type,
									"breakdown_quantity_no" => $row->breakdown_quantity_no,
									"breakdown_quantity_price" => $row->breakdown_quantity_price,
									"exist_breakdown_quantity_no" => $row->exist_breakdown_quantity_no
								);
								
								$data['stock_status'][] = array(
									"current_stock" => $product_quantity,
									"remaining_stock" => $quantity_no,
									"breakdown_current_stock" => $product_data['breakdown_quantity_types'][0]['breakdown_quantity_no'],
									"breakdown_remaining_stock" => $product_data['breakdown_quantity_types'][0]['exist_breakdown_quantity_no']
								); 
							}
						} else {
							$data['stock_status'][] = array(
								"current_stock" => $product_quantity,
								"remaining_stock" => $quantity_no,
								"breakdown_current_stock" => 0,
								"breakdown_remaining_stock" => 0
							); 
						}
						
						if($total_profit == "") {
							$total_profit = 0;
						}
					
						if($date_updated == "0000-00-00 00:00:00") {
							$date_updated = "No updates";
						}
						
						$add_to_cart = site_url("home/add_cart?product_id={$product_id}&&product_name={$product_name}");
						$loading_stock_status = base_url() . "images/cart_loading.gif";
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$product_id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$product_id}&&value=product' class='main_update_link'>{$product_name}</a></abbr></td>
								<td>{$capital}</td>
								<td>{$total_profit}</td>
								<td>{$date_added}</td>
								<td>
									<div class='progress_bar'>
										<div class='progress_status'></div>
										<span class='progress_label'></span>
										<img src='{$loading_stock_status}' alt='loading stock status' />
									</div>
								</td>
								<td>
									<select name='selling_type' class='selling_type'>
										<option value=''></option>
						";
					
						for($i = 0; $i < count($product_data['selling_types']); $i++) {
						
							$data['content'] .= "	
										<option>{$product_data['selling_types'][$i]['selling_type']}</option>											
							";
						}
						
						$data['content'] .= "
									</select>
								</td>
								<td><input type='text' name='selling_quantity' class='selling_quantity' /></td>
								<td><abbr title='Add to Cart'><a class='cart_link' href='{$add_to_cart}'><img src='{$base}images/cart.png' class='cart_image' alt='Add to Cart' /></a></abbr><img src='{$base}images/cart_loading.gif' class='cart_loading' alt='Cart Loading' /></td>
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
							<th>Stock Status</th>
							<th>Selling Type</th>
							<th>Selling Quantity</th>
							<th>Add to Cart</th>
						</tr>
						<tr>
							<td colspan='9' class='empty'>No product exists</td>
						</tr>
					";
				}	
			}
			
			echo json_encode($data);
		} 
		
	} // end search product
	
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
				"product_quantity" => $this->input->post('quantity_no'),
				"date_added" => $date_added,
				"user_id" => $this->session->userdata('id') 
			);
		
			$product_insert = $this->home_model->add_product($product_data);
			
			if($product_insert) {
				
				$get_product_id = $this->home_model->get_product_id($product_data['product_name']);
				
				if($get_product_id != NULL) {	
					
					foreach($get_product_id as $row) {
						$product_id = $row->product_id;
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
								$quantity_type_id = $row->quantity_type_id;
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
										"exist_breakdown_quantity_no" => "",
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
		
		if(!isset($id) or $id == NULL) {
			$this->index();
		} else {
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
		}
	
	} // end main delete

	function select_update_product() {
		
		$id = $this->input->get('id'); 
		$value = $this->input->get('value');
		
		$this->load->model('home_model');
		
		$product = $this->home_model->get_product_by_id($id);
		
		if($product != NULL) {
			foreach($product as $row) {
			
				$data = array(
					"product_id" => $row->product_id, 
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
		
		} // end product not equal null
	
		echo json_encode($data);
	}
	
	function update_product() {
		
		$product_id = $this->input->post('product_id');
		
		$this->load->model('home_model');
		
		$timestamp = now();
		$timezone = 'UP8';
		$date_time_convert = gmt_to_local($timestamp, $timezone);
		$date_updated = unix_to_human($date_time_convert, TRUE, 'us');
	
		$product_data = array(
			"product_name" => $this->input->post('product_name'),
			"capital" => $this->input->post('capital'),
			"date_updated" => $date_updated 
		);
		
		$update_product_by_product_id_and_data = $this->home_model->update_product_by_product_id_and_data($product_id, $product_data);
		
		if($update_product_by_product_id_and_data) {
			$data['product_update'] = true;
		}
		
		$delete_product_quantity_type = $this->home_model->delete_product_quantity_types($product_id);
	
		if($delete_product_quantity_type) {
			$quantity_type_data = array(
				"quantity_type" => $this->input->post('quantity_type'),
				"quantity_no" => $this->input->post('quantity_no'),
				"quantity_price" => $this->input->post('quantity_price'),
				"product_id" => $product_id,
				"user_id" => $this->session->userdata('id')
			);
			
			$add_quantity_type = $this->home_model->add_quantity_type($quantity_type_data);
			
			if($add_quantity_type) {
				$data['quantity_type_inserted'] = true;
			}	
		}
		
		$delete_product_breakdown_quantity_types = $this->home_model->delete_product_breakdown_quantity_types($product_id);
		
		if($delete_product_breakdown_quantity_types) {
			
			$get_quantity_type_id = $this->home_model->get_quantity_type_id($quantity_type_data['quantity_type']);
			
			if($get_quantity_type_id != NULL) {	
				foreach($get_quantity_type_id as $row) {
					$quantity_type_id = $row->quantity_type_id;
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

					$add_breakdown_quantity_type = $this->home_model->add_breakdown_quantity_type($breakdown_quantity_types_data);
				}
				
				if($add_breakdown_quantity_type) {
					$data['breakdown_quantity_type_inserted'] = true;
				}
				
			}  // end if
		}
		
		$delete_product_selling_types = $this->home_model->delete_product_selling_types($product_id);
		
		if($delete_product_selling_types) {
			
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
				
				$add_selling_type = $this->home_model->add_selling_type($selling_types_data);
			}
			
			if($add_selling_type) {
				$data['selling_type_inserted'] = true;
			}
			
		}
		
		if($data['product_update'] && $data['quantity_type_inserted'] && $data['selling_type_inserted']) {
			$data['status'] = true;
		}
	
		echo json_encode($data);
		
	} // end update_product
	
	function add_cart() {
	
		$this->load->library('session');
		$this->load->library('cart');
		
		$this->load->model('home_model');
		
		$automatic = trim($this->input->get('automatic'));
		$product_id = trim($this->input->get('product_id'));
		$product_name = trim($this->input->get('product_name'));
		$selling_type = trim($this->input->get('selling_type'));
		$selling_quantity = trim($this->input->get('selling_quantity'));
		
		$check_name_and_type = $product_name . $selling_type;
		
		if($product_id != "" || $product_name != "" || $selling_type != "" || $selling_quantity != "" || $automatic != "") {
			
			$get_selling_price = $this->home_model->get_selling_price_by_product_id_and_selling_type($product_id, $selling_type);
	
			if($get_selling_price != NULL) {
				foreach($get_selling_price as $row) {
					$selling_price = $row->selling_price;
				}
			}
			
			if(isset($selling_price) && $selling_price != NULL) {
				
				$cart_values = $this->cart->contents();
				
				$cart_values_get = array();
			
				foreach($this->cart->contents() as $get) {
					$cart_values_get[] = array(
						"rowid" => $get["rowid"],
						"id" => $get["id"],
						"qty" => $get["qty"],
						"price" => $get["price"],
						"name" => $get["name"],
						"type" => $get["options"]["type"],
						"subtotal" => $get["subtotal"],
						"name_type" => $get["name"] . $get["options"]["type"]
					);
				}
				
				for($i = 0; $i < count($cart_values_get); $i++) {
					if($cart_values_get[$i]['name_type'] == $check_name_and_type) {
						$update_cart_rowid = $cart_values_get[$i]['rowid'];
						$update_cart_selling_quantity = $cart_values_get[$i]['qty'] + $selling_quantity;
					}
				}
			
				if(isset($update_cart_rowid) && $update_cart_rowid != NULL) {
					$cart_data = array(
						"rowid" => $update_cart_rowid,
						"qty" => $update_cart_selling_quantity
					);
					
					$this->cart->update($cart_data);
					
				} else {
					$cart_data = array(
						"id" => $product_id,
						"qty" => $selling_quantity,
						"price" => $selling_price,
						"name" => $product_name,
						"options" => array("type" => $selling_type)
					);
					
					$this->cart->insert($cart_data);
				}
			} 
			
			
			$data = array(
				"cart_total" => $this->cart->total(),
				"total_items" => $this->cart->total_items()
			);
			
			$data['list_cart_item'] = array();
			$data['display_cart_item'] = "
				<tr>
					<th>Product Name</th>
					<th>Selling Type</th>
					<th>Quantity</th>
					<th>Selling Price</th>
					<th>Subtotal</th>
					<th>Delete</th>
				</tr>
			";
			
			if($this->cart->contents() != NULL) {
				foreach($this->cart->contents() as $items) {
	
					$data['list_cart_item'][] = array(
						"rowid" => $items["rowid"],
						"id" => $items["id"],
						"qty" => $items["qty"],
						"price" => $items["price"],
						"name" => $items["name"],
						"type" => $items["options"]["type"],
						"subtotal" => $items["subtotal"]
					);
					
					$rowid = $items["rowid"];
					$id = $items["id"];
					$qty = $items["qty"];
					$price = $items["price"];
					$name = $items["name"];
					$type = $items["options"]["type"]; 
					$subtotal = $items["subtotal"];
				
					$delete_cart_item = site_url("home/delete_cart_item?id={$rowid}");

					$data['display_cart_item'] .= "
						<tr>
							<input type='hidden' name='product_name[]' value='{$name}'/>
							<input type='hidden' name='selling_type[]' value='{$type}' />
							<input type='hidden' name='quantity_number[]' value ='{$qty}'>
							<input type='hidden' name='selling_price[]' value='{$price}' />
							<input type='hidden' name='subtotal[]' value='{$subtotal}' />
							<td>{$name}</td>
							<td>{$type}</td>
							<td>{$qty}</td>
							<td>{$price}</td>
							<td>{$subtotal}</td>
							<td><a class='delete_cart_item' href='{$delete_cart_item}'>Delete</a></td>
						</tr>
					";
				
				} // end foreach
			} else {
				$data['display_cart_item'] .= "
					<tr>
						<td class='empty_cart' colspan='6'>Cart is empty.</td>
					</tr>
				";
			}
			
			$total = $this->cart->total();
			$checkout_loading = base_url() . "images/waiting.gif";
			
			if($total != 0) {
				$data['display_cart_item'] .= "
					<tr id='cart_total_container'>
						<input type='hidden' name='cart_total' value='{$total}' />
						<td></td>
						<td></td>
						<td></td>
						<td class='cart_desc'>Total:</td>
						<td id='total_cart_price'>{$total}</td>
						<td></td>
					</tr>
					<tr id='checkout_container'>
						<td class='cart_desc'>Enter Amount</td>
						<td colspan='2'><input type='text' name='customer_amount' id='customer_amount' /></td>
						<td colspan='3'><input id='checkout' type='submit' value='Checkout'/><img id='checkout_loading' src='{$checkout_loading}' alt='checkout loading' /></td>
					</tr>
				";
			}
			
			echo json_encode($data);
		} else {
			$this->index();
		} // end main else
	} // end function
	
	function delete_cart_item() {
	
		$this->load->library('cart');
		
		$rowid = $this->input->get('id');
		
		$cart_data = array(
			"rowid" => $rowid,
			"qty" => 0
		);	
		
		$update_cart = $this->cart->update($cart_data);
		
		if($update_cart) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		echo json_encode($data);
	}
	
	function clear_cart() {
		$this->load->library('cart');
		$this->cart->destroy();
		$this->session->unset_userdata('cart_values');
		
		$main = site_url('home');
		echo "<p><a href='{$main}'>Back</a></p>";
	}
	
	function checkout_cart() {
		
		// set the products variables
		
		$product_names = $this->input->post('product_name');
		$selling_types = $this->input->post('selling_type');
		$quantity_numbers = $this->input->post('quantity_number');
		$selling_prices = $this->input->post('selling_price');
		$subtotals = $this->input->post('subtotal');
	
		$this->load->model('home_model');
		
		// select the products to be bought
		
		$stocks_data = array();
		
		// for loop for the general product datas
		
		for($a = 0; $a < count($product_names); $a++) {
			
			$products_data = $this->home_model->get_product_data_by_product_name($product_names[$a]);
		
			foreach($products_data as $row) {
				$stocks_data[] = array(
					"product_id" => $row->product_id,
					"product_name" => $row->product_name,
					"capital" => $row->capital,
					"product_quantity" => $row->product_quantity,
					"quantity_type_id" => $row->quantity_type_id,
					"quantity_type" => $row->quantity_type,
					"quantity_no" => $row->quantity_no,
					"quantity_price" => $row->quantity_price
				);
			}
		}
		
	
		// get all the datas tro be sold and push in an array
		
		$sold_product_id = array();
		$sold_product_name = array();
		
		$sold_type = array();
		$sold_id = array();
	
		$sold_type_name = array();
		$profits = array();
		
		$current_quantity_number = array();
		$current_quantity_type = array();
		
		for($c = 0; $c < count($stocks_data); $c++) {
			
			array_push($sold_product_id, $stocks_data[$c]['product_id']);
			array_push($sold_product_name, $stocks_data[$c]['product_name']);
			array_push($current_quantity_number, $stocks_data[$c]['quantity_no']);
			array_push($current_quantity_type, $stocks_data[$c]['quantity_type']);
			
			if($selling_types[$c] == $stocks_data[$c]['quantity_type']) {
				
				array_push($sold_type, 'quantity_type');
				array_push($sold_id, $stocks_data[$c]['quantity_type_id']);
				array_push($sold_type_name, $stocks_data[$c]['quantity_type']);
				
				$profit = $this->home_model->get_selling_profit_by_selling_type_and_product_id($selling_types[$c], $stocks_data[$c]['product_id']);
				
				foreach($profit as $prof) {
					array_push($profits, $prof->profit * $quantity_numbers[$c]);
				}
			
			} else {
				
				$breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($stocks_data[$c]['product_id']);
				
				foreach($breakdown_quantity_types as $row) {
					if($selling_types[$c] == $row->breakdown_quantity_type) {
						
						array_push($sold_type, "breakdown_quantity_type");
						array_push($sold_id, $row->breakdown_quantity_type_id);
						array_push($sold_type_name, $row->breakdown_quantity_type);
						
					}
				}
				
				$profit = $this->home_model->get_selling_profit_by_selling_type_and_product_id($selling_types[$c], $stocks_data[$c]['product_id']);
				
				foreach($profit as $prof) {
					array_push($profits, $prof->profit * $quantity_numbers[$c]);
				}
				
			}			

		} // end for loop for pushing data's in an array
		
		// for loop for accessing and updating the database
		
		for($p = 0; $p < count($sold_type); $p++) {
		
			if($sold_type[$p] == "quantity_type") {
				
				// call private function for updating the quantity type
				
				$updating_quantity_type = $this->update_quantity_no($quantity_numbers[$p], $profits[$p], $stocks_data[$p]['product_id'], $sold_type_name[$p]);
				
			} // end if quantity type
			
			if($sold_type[$p] == "breakdown_quantity_type") {
				
				// get standard breakdown quantity no and exist breakdown quantity no
				$get_breakdown_quantity_no_and_exist_breakdown_quantity_no = $this->home_model->get_stock_breakdown_quantity_no_and_exist_breakdown_quantity_no_by_product_id_and_breakdown_quantity_type($stocks_data[$p]['product_id'], $sold_type_name[$p]); 
			
				foreach($get_breakdown_quantity_no_and_exist_breakdown_quantity_no as $break_down) {
					$breakdown_quantity_no = $break_down->breakdown_quantity_no;
					$exist_breakdown_quantity_no = $break_down->exist_breakdown_quantity_no;
				}
				
				$quantity_value = 0;
				$breakdown_quantity_value = 0;
				
				if($exist_breakdown_quantity_no == 0) {
					if($quantity_numbers[$p] == $breakdown_quantity_no) {
					
						$quantity_value += 1;
						$breakdown_quantity_value = 0;
						
					} elseif($quantity_numbers[$p] > $breakdown_quantity_no) {
					
						$quantity_value +=  floor($quantity_numbers[$p] / $breakdown_quantity_no);
					
						$breakdown_quantity_value += $quantity_numbers[$p] % $breakdown_quantity_no;
						
						if($breakdown_quantity_value != 0) {
							$quantity_value += 1;
						}
						
					} else {
						
						$breakdown_quantity_value += $breakdown_quantity_no - $quantity_numbers[$p];
						
						if($breakdown_quantity_value != 0) {
							$quantity_value += 1;
						}
					}
				} else {
					
					if($quantity_numbers[$p] <= $exist_breakdown_quantity_no) {
						
						$exist_breakdown_quantity_no -= $quantity_numbers[$p];
						
						if($exist_breakdown_quantity_no == 0) {
							$quantity_value += 1;
							$breakdown_quantity_value = 0;
						} else {
							$quantity_value = 0;
							$breakdown_quantity_value = $exist_breakdown_quantity_no;
						}
					} elseif($quantity_numbers[$p] > $exist_breakdown_quantity_no && $quantity_numbers[$p] <= $breakdown_quantity_no) {
						$quantity_numbers[$p] -= $exist_breakdown_quantity_no;
						
						$quantity_value += 1;
						$breakdown_quantity_value = $quantity_numbers[$p];
						
					} elseif($quantity_numbers[$p] > $exist_breakdown_quantity_no && $quantity_numbers[$p] > $breakdown_quantity_no) {
					
						$quantity_value +=  floor($quantity_numbers[$p] / $breakdown_quantity_no);
						
						$remainder = $quantity_numbers[$p] % $breakdown_quantity_no;
						
						if($remainder <= $exist_breakdown_quantity_no) {
							$temporary_breakdown_quantity_value = $exist_breakdown_quantity_no - $remainder;
							if($temporary_breakdown_quantity_value == 0) {
								$quantity_value += 1;
								$breakdown_quantity_value = 0;
							} else {
								$breakdown_quantity_value = $temporary_breakdown_quantity_value;
							}
						} elseif($remainder > $exist_breakdown_quantity_no && $breakdown_quantity_value <= $breakdown_quantity_no) {
							$remainder -= $exist_breakdown_quantity_no;
							
							$quantity_value += 1;
							$breakdown_quantity_value = $remainder;
						}							
					}
				} // end main else
				
				/*echo "<p>Quantity value is ". $quantity_value ."</p>";
				echo "<p>Breakdown quantity value is ". $breakdown_quantity_value ."</p>";*/
				
				// update the database for the quantity type no and breakdown quantity type no
			
				if($quantity_value != 0) {
					$current_quantity_number[$p] -= $quantity_value;
					$update_quantity_no = $this->home_model->update_quantity_no_by_product_id_quantity_type_and_quantity_no($stocks_data[$p]['product_id'], $current_quantity_type[$p], $current_quantity_number[$p]);
				}
				
				$updating_breakdown_quantity_type = $this->home_model->update_exist_breakdown_quantity_no_by_product_id_breakdown_quantity_type_and_exist_breakdown_quantity_type($stocks_data[$p]['product_id'], $sold_type_name[$p], $breakdown_quantity_value);
				
				$get_product_total_profit = $this->home_model->get_product_total_profit_by_product_id($stocks_data[$p]['product_id']);
				
				foreach($get_product_total_profit as $total_profit) {
					$current_profit = $total_profit->total_profit;
				}
				
				$current_profit += $profits[$p];
				
				$update_total_profit = $this->home_model->update_product_total_profit_by_product_id_and_total_profit($stocks_data[$p]['product_id'], $current_profit);
			
				// get the current breakdown type then apply the formula for converting the value to other breakdown types
			
				if($breakdown_quantity_value != 0) {
					
					$breakdown_types_name = array();
					$breakdown_types_no = array();
					$breakdown_types_exist_no = array();
					$breakdown_types_product_id = array();
					
					// get all breakdown types then push to specific arrays
					$get_breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($stocks_data[$p]['product_id']);
					
					foreach($get_breakdown_quantity_types as $types ) {
						if($sold_type_name[$p] != $types->breakdown_quantity_type) {
							array_push($breakdown_types_name, $types->breakdown_quantity_type);
							array_push($breakdown_types_no, $types->breakdown_quantity_no);
							array_push($breakdown_types_exist_no, $types->exist_breakdown_quantity_no);
							array_push($breakdown_types_product_id, $types->product_id);
						}
					}
					
					$no_breakdown_types = count($breakdown_types_name);
				
					$current_exist_breakdown_quantity_no = $breakdown_quantity_value;
					
					for($b = 0; $b < $no_breakdown_types; $b++) {
						$value = $breakdown_types_no[$b] / $breakdown_quantity_no;
						$final_value = $value * $current_exist_breakdown_quantity_no;
						
						$updating_other_breakdown_quantity_type = $this->home_model->update_exist_breakdown_quantity_no_by_product_id_breakdown_quantity_type_and_exist_breakdown_quantity_type($breakdown_types_product_id[$b], $breakdown_types_name[$b], $final_value);
					}
				} // end if for callculating other values of breakdown quantity types if not zero
				
			} // end if breakdown quantity type
			
		} // end for loop for accessing and updating the database
		
		$cart_total = $this->input->post('cart_total');
		
		$customer_amount = $this->input->post('customer_amount');
		
		$this->load->library('cart');
		
		$this->cart->destroy();
		
		$data = array(
			"status" => true,
			"change" => $customer_amount - $cart_total
		);
		
		echo json_encode($data);
		
	}
	
	private function update_quantity_no($quantity_number, $profit, $product_id, $sold_type_name) {	
		
		$this->load->model('home_model');
		
		$get_quantity_no = $this->home_model->get_stock_quantity_no_by_product_id_and_quantity_type($product_id, $sold_type_name);
	
		foreach($get_quantity_no as $quan) {
			$quantity_no = $quan->quantity_no;
		}
		
		$quantity_no -= $quantity_number;
		
		$update_quantity_no = $this->home_model->update_quantity_no_by_product_id_quantity_type_and_quantity_no($product_id, $sold_type_name, $quantity_no);
		
		$get_product_total_profit = $this->home_model->get_product_total_profit_by_product_id($product_id);
		
		foreach($get_product_total_profit as $tot) {
			$total_profit = $tot->total_profit;
		}
		
		$total_profit += $profit;
		
		$update_total_profit = $this->home_model->update_product_total_profit_by_product_id_and_total_profit($product_id, $total_profit);
	
		if($update_quantity_no && $update_total_profit) {
			return true;
		} else {
			return false;
		}
	
	}

} // end class















