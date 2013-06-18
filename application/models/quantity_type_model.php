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
	
	function get_quantity_type($type) {
		$this->db->where('quantity_type', $type);
		
		$query = $this->db->get('quantity_types');
		
		if($query->result() != NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	function search_quantity_type($quantity_type){
	
		$this->db->like('quantity_type', $quantity_type);
		
		$query = $this->db->get('quantity_types');
		
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
	
	function delete_quantity_type($id) {
		
		$this->db->where_in('id', $id);
		
		$query = $this->db->delete('quantity_types');
		
		if($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function get_quantity_type_by_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('quantity_types');
		return $query->result();
	}
	
}





































