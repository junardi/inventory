<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_products() {
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('quantity_types', 'quantity_types.product_id = products.product_id', 'left');
		$this->db->order_by('products.product_id', 'desc'); 
		$this->db->where('products.user_id', $this->session->userdata('id'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function search_product($product) {
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('quantity_types', 'quantity_types.product_id = products.product_id', 'left');
		$this->db->like('products.product_name', $product);
		$this->db->where('products.user_id', $this->session->userdata('id'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function existing_product_name($product_name) {
		$this->db->where('product_name', $product_name);
		$query = $this->db->get('products');
		
		$product = $query->result();
		
		if($product != NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	function add_product($product_data) {
		$this->db->set($product_data);
		$query = $this->db->insert('products');
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_product_id($product_name) {
		$this->db->select('product_id');
		$this->db->where('product_name', $product_name);
		$query = $this->db->get('products');
		return $query->result();
	}
	
	function add_quantity_type($quantity_type_data) {
		$this->db->set($quantity_type_data);
		$query = $this->db->insert('quantity_types');
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}	
	
	function get_quantity_type_id($quantity_type) {
		$this->db->select('quantity_type_id');
		$this->db->where('quantity_type', $quantity_type);
		$query = $this->db->get('quantity_types');
		return $query->result();
	}
	
	function add_breakdown_quantity_type($breakdown_quantity_type_data) {
		$query = $this->db->insert_batch('breakdown_quantity_types', $breakdown_quantity_type_data);   
		if($query) {	
			return true;
		} else {
			return false;
		}
	}
	
	function add_selling_type($selling_type_data) {
		$query = $this->db->insert_batch('selling_types', $selling_type_data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete_product($id) {
		$this->db->where_in('product_id', $id);
		$query = $this->db->delete('products');
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete_product_quantity_types($id) {
		$this->db->where_in('product_id', $id);
		$query = $this->db->delete('quantity_types');
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete_product_breakdown_quantity_types($id) {
		$this->db->where_in('product_id', $id);
		$query = $this->db->delete('breakdown_quantity_types');
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete_product_selling_types($id) {
		$this->db->where_in('product_id', $id);
		$query = $this->db->delete('selling_types');
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}

	function get_product_by_id($id) {
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('quantity_types', 'quantity_types.product_id = products.product_id', 'left');	
		$this->db->where('products.product_id', $id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_breakdown_quantity_types_by_product_id($product_id) {
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('breakdown_quantity_types');
		return $query->result();
	}
	
	function get_selling_types_by_product_id($product_id) {
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('selling_types');
		return $query->result();
	}
	
	function update_product_by_product_id_and_data($product_id, $product_data) {
		
		//$this->db->where('product_id', $product_id);
		$query = $this->db->update('products', $product_data, array('product_id' => $product_id));
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_selling_price_by_product_id_and_selling_type($product_id, $selling_type) {
		$this->db->select('selling_price');
		$this->db->where('product_id', $product_id);
		$this->db->where('selling_type', $selling_type);
		$query = $this->db->get('selling_types');
		return $query->result();
	}
	
	function get_selling_profit_by_selling_type_and_product_id($selling_type, $product_id) {
		$this->db->select('profit');
		$this->db->where('selling_type', $selling_type);
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('selling_types');
		return $query->result();
	}
	
	function get_product_data_by_product_name($product_name) {
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('quantity_types', 'quantity_types.product_id = products.product_id', 'left');
		$this->db->order_by('products.product_id', 'desc'); 
		$this->db->where('product_name', $product_name);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_stock_quantity_no_by_product_id_and_quantity_type($product_id, $quantity_type) {
		$this->db->select('quantity_no');
		$this->db->where('product_id', $product_id);
		$this->db->where('quantity_type', $quantity_type);
		$query = $this->db->get('quantity_types');
		return $query->result();
	}
	
	function get_stock_breakdown_quantity_no_and_exist_breakdown_quantity_no_by_product_id_and_breakdown_quantity_type($product_id, $breakdown_quantity_type) {
		$this->db->select('breakdown_quantity_no');
		$this->db->select('exist_breakdown_quantity_no');
		$this->db->where('product_id', $product_id);
		$this->db->where('breakdown_quantity_type', $breakdown_quantity_type);
		$query = $this->db->get('breakdown_quantity_types');
		return $query->result();
	}
	
	function get_product_total_profit_by_product_id($product_id) {
		$this->db->select('total_profit');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('products');
		return $query->result();
	}
	
	function update_quantity_no_by_product_id_quantity_type_and_quantity_no($product_id, $quantity_type, $quantity_no) {
		$data = array(
			'quantity_no' => $quantity_no
		);
		
		//$this->db->select('quantity_no');
		//$this->db->where('product_id', $product_id);
		//$this->db->where('quantity_type', $quantity_type);
		$query = $this->db->update('quantity_types', $data, array('product_id' => $product_id, 'quantity_type' => $quantity_type));
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function update_product_total_profit_by_product_id_and_total_profit($product_id, $total_profit) {
		
		$data = array(
			'total_profit' => $total_profit
		);
		
		//$this->db->select('total_profit');
		//$this->db->where('product_id', $product_id);
		$query = $this->db->update('products', $data, array('product_id' => $product_id));
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	
	
}





















