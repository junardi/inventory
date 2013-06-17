<?php
	
	/* Below is for the header */
	
	if(isset($interface)) {
	
		$data_header['interface'] = $interface;
		$this->load->view('template/header', $data_header);
		
	} else {
	
		$this->load->view('template/header');
	}
	
	/* Below is for the body*/
	
	if(isset($users)) {
		
		$data['users'] = $users;
		$this->load->view($main_content, $users);
		
	} else if (isset($quantity_types)) {
		
		$data['quantity_types'] = $quantity_types;
		$this->load->view($main_content, $data);
		
	} else {
	
		$this->load->view($main_content);
	}
	
	/* Below is for the footer */
	
	$this->load->view('template/footer');
	
	
?>

