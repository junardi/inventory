<div class="container clearfix">
	<div class="grid_12">
		<div id="main">
			<?php 
				
				echo "<pre>";
					print_r($this->session->all_userdata());
				echo "</pre>";
				
				echo "<br />";
				
				echo site_url('home');
			?>
		</div>
	</div>
</div>
