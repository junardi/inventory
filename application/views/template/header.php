<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >
	<title>Inventory System</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/style.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/crud.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/grid.css" />
</head>
<body>
	<?php 
		$active_url = current_url();
		$home_url = site_url('home');
		
		if($active_url == $home_url) {
			$home_class = 'active';
		}
	?>
	<div class="container clearfix">
		<div class="grid_12">
			<div id="header">
				<?php if(isset($interface) AND $interface == "login") { ?>
					<h1 class="left">Business Inventory</h1>
					<ul class="right">
						<li><a class="active" href="<?php echo base_url(); ?>index.php/login">Sign in</a></li>
					</ul>
					<div class="clear"></div>
				<?php } else { ?>
					<h1 class="left">Business Inventory</h1>
					<ul class="right">
						<li>
							<a class="<?php if(isset($home_class)){echo $home_class;} ?> intact" href="<?php echo $home_url; ?>">Home</a>
						</li>
						<li>
							<a class="maintenance_intact" href="#">Maintenance</a>
							<div class="nav_sub_wrap">
								<div class="nav_sub_arrow">
								</div>
								<div class="nav_sub">
									<ul>
										<li><a href="<?php echo site_url('quantity_type'); ?>">Quantity Types</a></li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<a class="account_intact" href="#">Account</a>
							<div class="nav_sub_wrap">
								<div class="nav_sub_arrow">
								</div>
								<div class="nav_sub">
									<ul>
										<li><a href="#">Account Settings</a></li>
										<li><a href="<?php echo site_url('login/logout'); ?>">Log Out</a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
					<div class="clear"></div>
				<?php } ?>
			</div>
		</div>
	</div>