<div class="container clearfix">
	<div class="grid_12">
		<div id="main">
			<?php 
				var_dump($this->session->all_userdata());
				echo "<br />";
				
				echo site_url('home');
			?>
		</div>
	</div>
</div>
