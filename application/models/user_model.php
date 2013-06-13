<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	function __construct() {
	
		parent::__construct();
		$this->load->database();
	}
	
	function add_user ($user_data) {
		$this->db->set($user_data);
		$query = $this->db->insert('users');
		
		if($query) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	function get_users() {
		$this->db->order_by('date_registered', 'desc'); 
		$query = $this->db->get('users');
		return $query->result();
	}
	
	function get_user_by_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		return $query->result();
	}
	
	function delete_user($id) {
		
		$this->db->where_in('id', $id);
		
		$query = $this->db->delete('users');
		
		if($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function search_user($user) {
		$this->db->like('username', $user);
		$query = $this->db->get('users');
		
		return $query->result();
	}
	
	function check_email_by_id($id, $email) {
		
		$this->db->where('id', $id);
		$this->db->where('email', $email);
		
		$query = $this->db->get('users');
		
		return $query->result();
	}
	
	function check_username_by_id($id, $username) {
		
		$this->db->where('id', $id);
		$this->db->where('username', $username);
		
		$query = $this->db->get('users');
		
		return $query->result();
	}
	
	function update_user($id, $data) {
	
		$this->db->where('id', $id);
		$query = $this->db->update('users', $data); 
		
		if($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}




