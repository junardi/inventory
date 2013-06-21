<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {
	
	function __construct() {
	
		parent::__construct();
		$this->load->database();
	}
	
	function get_products() {
		$this->db->order_by('id', 'desc'); 
		$query = $this->db->get('products');
		return $query->result();
	}
	
	
	function search_product($product) {
		$this->db->like('product_name', $product);
		$query = $this->db->get('products');
		
		return $query->result();
	}
	
	function get_product($product) {
		$this->db->where('product_name', $product);
		
		$query = $this->db->get('products');
		
		if($query->result() != NULL) {
			return true;
		} else {
			return false;
		}
	}
	
}