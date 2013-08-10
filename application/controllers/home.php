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
							<th>Date Updated</th>
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
							'total_profit' => $row->total_profit,
							'date_added' => $row->date_added,
							'date_updated' => $row->date_updated,
							'user_id' => $row->user_id,
							'quantity_type_id' => $row->quantity_type_id,
							'quantity_type' => $row->quantity_type,
							'quantity_no' => $row->quantity_no,
							'quantity_price' => $row->quantity_price
						);
						
						$get_breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($product_data['product_id']);
			
						$product_data['breakdown_quantity_types']= array();
					
						if($get_breakdown_quantity_types != NULL) {
							foreach($get_breakdown_quantity_types as $row) {
								$product_data['breakdown_quantity_types'][] = array(
									"breakdown_quantity_type" => $row->breakdown_quantity_type,
									"breakdown_quantity_no" => $row->breakdown_quantity_no,
									"breakdown_quantity_price" => $row->breakdown_quantity_price	
								);
							}
						}
						
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
						$total_profit = $product_data['total_profit'];
						$date_added = $product_data['date_added'];
						$date_updated = $product_data['date_updated'];
						$user_id = $product_data['user_id'];
						$quantity_type_id = $product_data['quantity_type_id'];
						$quantity_type = $product_data['quantity_type'];
						$quantity_no = $product_data['quantity_no'];
						$quantity_price = $product_data['quantity_price'];
							
						if($total_profit == "") {
							$total_profit = 0;
						}
					
						if($date_updated == "0000-00-00 00:00:00") {
							$date_updated = "No updates";
						}
					
						$add_to_cart = site_url("home/add_cart?product_id={$product_id}&&product_name={$product_name}");
						
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$product_id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$product_id}&&value=product' class='main_update_link'>{$product_name}</a></abbr></td>
								<td>{$capital}</td>
								<td>{$total_profit}</td>
								<td>{$date_added}</td>
								<td>{$date_updated}</td>
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
							<th>Date Updated</th> 
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
					
					$data['content'] = "
						<tr>
							<th><input type='checkbox' name='head_check' class='head_check'  /></th>
							<th>Product</th>
							<th>Capital</th>
							<th>Profit</th>
							<th>Date Added</th>
							<th>Date Updated</th>
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
							'total_profit' => $row->total_profit,
							'date_added' => $row->date_added,
							'date_updated' => $row->date_updated,
							'user_id' => $row->user_id,
							'quantity_type_id' => $row->quantity_type_id,
							'quantity_type' => $row->quantity_type,
							'quantity_no' => $row->quantity_no,
							'quantity_price' => $row->quantity_price
						);
						
						$get_breakdown_quantity_types = $this->home_model->get_breakdown_quantity_types_by_product_id($product_data['product_id']);
			
						$product_data['breakdown_quantity_types']= array();
					
						if($get_breakdown_quantity_types != NULL) {
							foreach($get_breakdown_quantity_types as $row) {
								$product_data['breakdown_quantity_types'][] = array(
									"breakdown_quantity_type" => $row->breakdown_quantity_type,
									"breakdown_quantity_no" => $row->breakdown_quantity_no,
									"breakdown_quantity_price" => $row->breakdown_quantity_price	
								);
							}
						}
						
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
						$total_profit = $product_data['total_profit'];
						$date_added = $product_data['date_added'];
						$date_updated = $product_data['date_updated'];
						$user_id = $product_data['user_id'];
						$quantity_type_id = $product_data['quantity_type_id'];
						$quantity_type = $product_data['quantity_type'];
						$quantity_no = $product_data['quantity_no'];
						$quantity_price = $product_data['quantity_price'];
							
						if($total_profit == "") {
							$total_profit = 0;
						}
					
						if($date_updated == "0000-00-00 00:00:00") {
							$date_updated = "No updates";
						}
						
						$add_to_cart = site_url("home/add_cart?product_id={$product_id}&&product_name={$product_name}");
					
						$data['content'] .= "
							<tr>
								<td><input type='checkbox' name='id[]' class='sub_check' value='{$product_id}' /></td>
								<td><abbr title='Click to update'><a href='{$base}index.php/home/select_update_product?id={$product_id}&&value=product' class='main_update_link'>{$product_name}</a></abbr></td>
								<td>{$capital}</td>
								<td>{$total_profit}</td>
								<td>{$date_added}</td>
								<td>{$date_updated}</td>
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
							<th>Date Updated</th>
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
		
		$this->load->library('cart');
		$this->load->model('home_model');
		
		$product_id = $this->input->get('product_id');
		$product_name = $this->input->get('product_name');
		$selling_type = $this->input->get('selling_type');
		$selling_quantity = trim($this->input->get('selling_quantity'));
		
		$get_selling_price = $this->home_model->get_selling_price_by_product_id_and_selling_type($product_id, $selling_type);
	
		if($get_selling_price != NULL) {
			foreach($get_selling_price as $row) {
				$selling_price = $row->selling_price;
			}
		}
		
		if(isset($selling_price) && $selling_price != NULL) {
			
			if($this->cart->contents() == NULL) {
				
				$cart_data = array(
					"id" => $product_id,
					"qty" => $selling_quantity,
					"price" => $selling_price,
					"name" => $product_name,
					"options" => array("type" => $selling_type)
				);
				
				$this->cart->insert($cart_data);
			
			} else {
				foreach($this->cart->contents() as $data_items) {
					if($product_name == $data_items['name'] && $selling_type == $data_items['options']['type']) {
					
						$cart_data = array(
							"rowid" => $data_items['rowid'],
							"qty" => $selling_quantity + $data_items['qty']
						);
						
						$this->cart->update($cart_data);
						
					} else if($product_name == $data_items['name'] && $selling_type != $data_items['options']['type']) {
						
						$cart_data = array(
							"id" => $product_id,
							"qty" => $selling_quantity,
							"price" => $selling_price,
							"name" => $product_name,
							"options" => array("type" => $selling_type)
						);
						
						$this->cart->insert($cart_data);
						
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
				} // end foreach
			} // end else
		} // end main isset if
		
		/*foreach($this->cart->contents() as $items) {
			echo "<pre>";
				print_r($items);
			echo "</pre>";
		}*/
		
		$data = array(
			"cart_total" => $this->cart->total(),
			"total_items" => $this->cart->total_items()
		);
		
		echo json_encode($data);
		
		/*echo "<p>Total of all items " . $this->cart->total() . "</p>";
		echo "<p>No. of cart items " . $this->cart->total_items() . "</p>";
		
		$main = site_url('home');
		$clear = site_url('home/clear_cart');
		
		echo "<p><a href='{$main}'>Back</a></p>";
		echo "<p><a href='{$clear}'>Clear Cart</a></p>";*/
		
	}
	
	function clear_cart() {
		$this->load->library('cart');
		$this->cart->destroy();
		
		$main = site_url('home');
		echo "<p><a href='{$main}'>Back</a></p>";
	}
	
} // end class



