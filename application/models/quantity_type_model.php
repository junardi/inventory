<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quantity_type_model extends CI_Model {
	
	function __construct() {
	
		parent::__construct();
		$this->load->database();
	}
	
	function get_quantity_types() {
		$this->db->order_by('id', 'desc'); 
		$query = $this->db->get('quantity_types');
		return $query->result();
	}
	
	function search_quantity_type($quantity_type){
	
		$this->db->like('type', $quantity_type);
		$query = $this->db->get('quantity_types');
		
		return $query->result();
	}
	
}