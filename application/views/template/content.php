<?php
	if(isset($users)) {
		$data['users'] = $users;
		
		$this->load->view('template/header');
		$this->load->view($main_content, $users);
		$this->load->view('template/footer');
		
	} else {	
	
		$this->load->view('template/header');
		$this->load->view($main_content);
		$this->load->view('template/footer');
		
	}
?>

