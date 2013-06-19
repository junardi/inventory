<?php
	
	/* Below is for the header */
	
	if(isset($interface)) {
	
		$data_header['interface'] = $interface;
		$this->load->view('template/header', $data_header);
		
	} else {
	
		$this->load->view('template/header');
	}
	
	/* Below is for the body*/
	
	$this->load->view($main_content);
	
	/* Below is for the footer */
	
	$this->load->view('template/footer');
	
	
?>

