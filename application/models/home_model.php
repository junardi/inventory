<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
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
		$this->db->select('id');
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
		$this->db->select('id');
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
	
}







