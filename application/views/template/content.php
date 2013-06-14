<?php
	
	if(isset($interface)) {
		$data_header['interface'] = $interface;
		$this->load->view('template/header', $data_header);
	} else {
		$this->load->view('template/header');
	}
	
	if(isset($users)) {
		$data['users'] = $users;
		$this->load->view($main_content, $users);
	} else {	
		$this->load->view($main_content);
	}
	
	$this->load->view('template/footer');
?>

